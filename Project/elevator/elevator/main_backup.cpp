// multi-protocol networking library
#include "fossa.h"

// rapid JSON
#include "rapidjson/document.h"
#include "rapidjson/writer.h"
#include "rapidjson/stringbuffer.h"

// MySQL connector
#include <mysql/mysql.h>

#include <cstdio>
#include <iostream>
#include <string>

#include "includes/pcanFunctions.h"
#include "includes/mainFunctions.h"
#include "includes/pcanFunctions.h"

using namespace rapidjson;

// message definitions
#define         WS_UPDATE       85        // update request/message
#define         WS_CALL         67        // elevator call request
#define         WS_SELECT       83        // elevator floor request
#define         WS_EMERG        69        // elevator emergency

// MySQL Database details
#define DATABASE_NAME  "elevator"
#define DATABASE_USERNAME "webuser"
#define DATABASE_PASSWORD "12345678"
#define DATABASE_PORT   3306

// fossa variables
static sig_atomic_t s_signal_received = 0;
static const char* s_http_port = "61415";
static struct ns_serve_http_opts s_http_server_opts;

// gloabl variables
int conn_num = 0;   // number of connections

// ELEVATOR STATUS VARIABLES
int elevator_prev_floor = 1;
int elevator_current_floor = 2;
bool elevator_travelling = false;
int elevator_req_fifo[3] = { 3, -1, -1 };
int floor_calls[4] = { 0, 0, 0, 0 };

int fifo_count = 0;

// state machine variables
// -----------------------------------------
// States: 0 - idle; 1 - waiting at floor; 2 - travelling to floor; 3 - EMERGENCY (stopped at closest floor)
int state = 0;
int prevState = 0;

MYSQL *mydb;  // MySQL database

// MySQL connect to db
void mysql_connect(void)
{
    //initialize MYSQL object for connections
    mydb = mysql_init(NULL);

    if (mydb == NULL)   // failed if NULL
    {
        std::cout << "Error connecting to database.\n Error: " << mysql_error(mydb) << "\n";
        return;
    }

    //Connect to the database
    if (mysql_real_connect(mydb, "192.168.0.30", DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME, DATABASE_PORT, NULL, 0) == NULL)
    //if (mysql_real_connect(mydb, "127.0.0.1", DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME, DATABASE_PORT, NULL, 0) == NULL)
    {
        std::cout << "Error connecting to database.\n Error: " << mysql_error(mydb) << "\n";
    }
    else
    {
        printf("Database connection successful.\n");
    }
}


// MySQL disconnect from db
void mysql_disconnect(void)
{
    mysql_close(mydb);
    printf("Disconnected from database.\n");
}


// MySQL query
void mysql_querydb(char* query)
{
    if (mydb != NULL)
    {
        // execute query
        if (mysql_query(mydb, query)) {

            std::cout << "Error querying database.\n Query was [" << query << "].\n Error: " << mysql_error(mydb) << "\n";
        }
    }
}

// fossa-req signal handler
static void signal_handler(int sig_num) {
    signal(sig_num, signal_handler);  // Reinstantiate signal handler
    s_signal_received = sig_num;
}

// specify websockets
static int is_websocket(const struct ns_connection* nc) {
    return nc->flags & NSF_IS_WEBSOCKET;
}

// websocket broadcast function
static void broadcast(struct ns_connection* nc, const char* msg, size_t len) {
    struct ns_connection* c;
    char buf[2048];

    snprintf(buf, sizeof(buf), "%p %.*s", nc, (int)len, msg);
    for (c = ns_next(nc->mgr, NULL); c != NULL; c = ns_next(nc->mgr, c)) {
        ns_send_websocket_frame(c, WEBSOCKET_OP_TEXT, buf, strlen(buf));
    }
}


// ---------------------------------------------------------
// FIFO functions
// ---------------------------------------------------------

// add floor to fifo; return -1 if full, -2 if floor is already in fifo
int fifo_add_floor(int* fifo, int floor) {
    int fifo_stat = 1;  // -1 = full; -2 = floor already in fifo

    // seach fifo for requested floor; do NOT include pos 0, as elevator could be travelling from that floor
    int infifo = 0;
    for (int i = 1; i < 4; i++) {
        if (fifo[i] == floor) {
            infifo = 1;
            break;
        }
    }

    if (!infifo) {
        // insert floor into first remaining free position (= -1)
        if (fifo[3] == -1) {    // is there a space at the very end position?
            int space_index = 3; // already determined there is a space at the end
            // loop through remaining positions and find the closest empty space to the front
            for (int i = 0; i < 3; i++) {
                if (fifo[i] == -1) {
                    space_index = i;    // record new empty space
                    break;  // don't continue loop
                }
            }
        }
        else {
            fifo_stat = -1; // no empty space found
        }
    }
    else {
        fifo_stat = -2; // requested floor already in fifo
    }

    return fifo_stat;
}

// pop off floor at beginning of fifo; return value popped
int fifo_pop(int* fifo) {
    int value = -1;

    if (fifo[0] != -1) {
        value = fifo[0];
        
        // move all values up in line
        for (int i = 0; i < 3; i++) {

            fifo[i] = fifo[i + 1];  // move value from next position into current position
            
        }
        fifo[3] = -1;   // reset last value
    }

    return value;
}

// ---------------------------------------------------------
// floor calls
// ---------------------------------------------------------

// add a floor call; bit odd, cause 2nd floor has 2 call buttons; floor 2 down is call 2, floor 2 up is call 3, etc
void add_call(int floorcall, int* calls, std::string dir) {

    switch (floorcall) {
    case 1:
        calls[0] = 1;
        break;
    case 2:
        if (dir.compare("up") == 0) {   // if up direction
            calls[2] = 1;
        } else if (dir.compare("down") == 0) {
            calls[1] = 1;
        }
        break;
    case 3:
        calls[3] = 1;
        break;
    default:
        break;
    }

    /*
    std::cout << "Floor calls: ";
    for (int i = 0; i < 4; i++) {
        std::cout << calls[i] << " ";
    }
    std::cout << "\n";
    */
}

// remove a floor call; bit odd, cause 2nd floor has 2 call buttons; floor 2 down is call 2, floor 2 up is call 3, etc
void remove_call(int floorcall, int* calls, std::string dir) {

    switch (floorcall) {
    case 1:
        calls[0] = 0;
        break;
    case 2:
        if (dir.compare("up") == 0) {   // if up direction
            calls[2] = 0;
        }
        else if (dir.compare("down") == 0) {
            calls[1] = 0;
        }
        break;
    case 3:
        calls[3] = 0;
        break;
    default:
        break;
    }

    /*
    std::cout << "Floor calls: ";
    for (int i = 0; i < 4; i++) {
        std::cout << calls[i] << " ";
    }
    std::cout << "\n";
    */
}

// websocket send update
void send_update(struct ns_connection* nc) {

    StringBuffer s;
    Writer<StringBuffer> response(s);

    response.StartObject();
    response.Key("cmd");
    response.Uint(WS_UPDATE);
    response.Key("current_floor");
    response.Uint(elevator_current_floor);
    response.Key("prev_floor");
    response.Uint(elevator_prev_floor);
    response.Key("travelling");
    response.Bool(elevator_travelling);
    response.Key("fifo");
    response.StartArray();
    for (int i = 0; i < 3; i++) {
        response.Int(elevator_req_fifo[i]);
    }
    response.EndArray();
    response.Key("calls");
    response.StartArray();
    for (int i = 0; i < 4; i++) {
        response.Int(floor_calls[i]);
    }
    response.EndArray();
    response.EndObject();

    //std::cout << "Response: " << s.GetString() << "\n";

    broadcast(nc, s.GetString(), s.GetSize());
}


// websockets event handler
static void ev_handler(struct ns_connection* nc, int ev, void* ev_data) {
    //struct http_message* hm = (struct http_message*)ev_data;
    struct websocket_message* wm = (struct websocket_message*)ev_data;

    //JSON
    Document d;
    StringBuffer jsonbuf;
    Writer<StringBuffer> writer(jsonbuf);
    char* jsonchars;
    char queryBuf[4096];
    int fifo_status = 0;
    int bindex = 0;

    //std::cout << "Event!\n";

    switch (ev) {

    case NS_WEBSOCKET_HANDSHAKE_DONE:   // Client connected via websockets

        std::cout << "New connection.\n";

        send_update(nc);

        break;

    case NS_WEBSOCKET_FRAME:    // client sent a message

        jsonchars = (char*)malloc(wm->size * sizeof(char));
        memcpy(jsonchars, wm->data, wm->size);
        
        for (int i = 0; i < 4096; i++) {
            if (jsonchars[i] == 125) {
                bindex = i+1;
                break;
            }
        }
        if (bindex != 0) {
            //memset(jsonchars+bindex, ' ', (4096 - bindex));
            //std::cout << "Bracket index: " << bindex << "\n";
        }

        d.Parse(jsonchars);

        d.Accept(writer);

        //std::cout << jsonbuf.GetString() << std::endl;
        //std::cout << (char*)wm->data << std::endl;

        if (d.IsObject()) {
            if (d.HasMember("cmd")) {
                if (d["cmd"].GetInt() == WS_UPDATE) {
                    std::cout << "Update requested\n";

                    send_update(nc);    // send updated info to all clients
                }
                else if (d["cmd"].GetInt() == WS_CALL) {
                    std::cout << "Floor " << d["floor"].GetInt() << " called " << d["dir"].GetString() << "\n";

                    memset(queryBuf, ' ', 4096);
                    sprintf(queryBuf, "INSERT INTO elevatorInfo (date, time, status, currentFloor, requestedFloor, calledFloor) VALUES (CURDATE(), CURTIME(), %d, %d, NULL, %d);", fifo_count, elevator_current_floor, d["floor"].GetInt());

                    // ---------------------------------------------
                    // CHANGE STATE VARIABLES
                    add_call(d["floor"].GetInt(), &floor_calls[0], d["dir"].GetString());
                    // OTHER ELEVATOR LOGIC
                    // ---------------------------------------------

                    mysql_querydb(&queryBuf[0]);

                    send_update(nc);    // send updated info to all clients
                }
                else if (d["cmd"].GetInt() == WS_SELECT) {
                    std::cout << "Floor " << d["floor"].GetInt() << " requested\n";

                    memset(queryBuf, ' ', 4096);
                    sprintf(queryBuf, "INSERT INTO elevatorInfo (date, time, status, currentFloor, requestedFloor, calledFloor) VALUES (CURDATE(), CURTIME(), %d, %d, %d, NULL);", fifo_count, elevator_current_floor, d["floor"].GetInt());

                    // ---------------------------------------------
                    // CHANGE STATE VARIABLES
                    fifo_add_floor(&elevator_req_fifo[0], d["floor"].GetInt());
                    // OTHER ELEVATOR LOGIC
                    // ---------------------------------------------

                    mysql_querydb(&queryBuf[0]);

                    send_update(nc);    // send updated info to all clients
                }
                else if (d["cmd"].GetInt() == WS_EMERG) {
                    std::cout << "EMERGENCY\n";
                }
                else {
                    std::cout << "Command not recognized\n";
                    std::cout << wm->data << "\n";
                }
            }
        }

        break;

    case NS_CLOSE:     // websocket closed

        std::cout << "There are " << conn_num << " number of websockets open.\n";
        break;

    default:
        break;
    }
}

//Elevator Control Function

void elevatorControl(int floor){

    int floorNumber;
    int prev_floorNumber;

    while(1){	

		int position = pcanRx(1);														//Find out elevator position		
		floorNumber = floor;
		if (prev_floorNumber != floorNumber && position != floorNumber) {								// If floor number changes in database
			pcanTx(ID_SC_TO_EC, HexFromFloor(floorNumber));					// change floor number in elevator - send command over CAN
		}
		prev_floorNumber = floorNumber; 
		sleep(1);															// poll database once every second to check for change in floor number
	}
	break;
}

// dummy events factory
// -------------------------------------------------------

char* eventFactory() {

}

// -------------------------------------------------------

// main
int main()
{
    std::cout << "\nELEVATOR SERVER\n";

    //Start elevator program at Floor 1 to sync the elevator with DB
    pcanTx(ID_SC_TO_EC, GO_TO_FLOOR1);
	db_setFloorNum(1);

    // MySQL
    mysql_connect();

    // Websockets
    struct ns_mgr mgr;
    struct ns_connection* nc;

    signal(SIGTERM, signal_handler);
    signal(SIGINT, signal_handler);

    ns_mgr_init(&mgr, NULL);

    nc = ns_bind(&mgr, s_http_port, ev_handler);
    s_http_server_opts.document_root = ".";
    ns_set_protocol_http_websocket(nc);

    std::cout << "Started on port " << s_http_port << "\n";

    int loop_count = 600;

    // ----------------------------------------------------------------------------------
    // MAIN LOOP - KEEP AS SHORT AS POSSIBLE
    // ----------------------------------------------------------------------------------
    while (s_signal_received == 0) {
        //std::cout << "loop\n";
        ns_mgr_poll(&mgr, 50);

        // write status to database every 30 minutes
        loop_count--;
        if (loop_count == 0) {
            loop_count = 1800;

            fifo_count = 0;
            // count length of fifo
            for (int i = 0; i < 4; i++) {
                if (elevator_req_fifo[i] != -1) {
                    fifo_count++;
                }
            }

            char queryBuf[4096];
            memset(queryBuf, ' ', 4096);
            sprintf(queryBuf, "INSERT INTO elevatorInfo (date, time, status, currentFloor, requestedFloor, calledFloor) VALUES (CURDATE(), CURTIME(), %d, %d, NULL, NULL);", fifo_count, elevator_current_floor);
            mysql_querydb(&queryBuf[0]);
        }

        int nextIndex = 0;

        switch (state) {
        case 0: // idle state
            if (floor_calls[0] != -1) {
                // travel to floor
                prevState = state;
                state = 2; // travelling to floor
            }
            break;
        case 1: // waiting at floor
            // if at a floor in floor_calls[], take it out of floor_calls[] fifo
            break;
        case 2: // travelling
            // if there is a floor in floor_calls[] between current floor & floor_calls[0], go to that floor first
            
            while (elevator_current_floor != floor_calls[nextIndex]) {  // wait for next floor

            }

            prevState = state;
            state = 2; // wait at floor
            break;
        case 3: // emergency

            break;
        default: // default
            prevState = state;
            state = 0; // go to idle state
            break;
        }
    }

    std::cout << "SIGINT received!\n";

    std::cout << "Remaining 6ft away...\n";
    // ----------------------------------------------------------------------------------
    // RECORD CURRENT STATS TO DATABASE!!!

    std::cout << "Disinfecting surfaces...\n";
    ns_mgr_free(&mgr);

    std::cout << "Removing mask...\n";
    mysql_disconnect();

    std::cout << "Returning to the safety of the Linux bubble.\n";

    return 0;
}