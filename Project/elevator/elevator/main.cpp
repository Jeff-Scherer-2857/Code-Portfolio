// standard
#include <cstdio>
#include <stdlib.h>
#include <iostream>
#include <string>
#include <sys/time.h>


// Main loop delay and wait times
#define LOOP_WS_WAIT                50      //ms
#define ELEVATOR_FLOOR_WAIT         4000/LOOP_WS_WAIT   //loop iterations
#define DATABASE_UPDATE_TIME        18000/LOOP_WS_WAIT  //loop iterations    
#define ELEVATOR_FLOOR_TIMEOUT      600/LOOP_WS_WAIT

static void log(FILE log, std::string msg);
static void signal_handler(int);
static void ev_handler(struct ns_connection*, int, void*);

// gloabl variables

// ELEVATOR STATUS VARIABLES
int elevator_prev_floor = 1;
int elevator_current_floor = 1;
bool elevator_travelling = false;
int elevator_req_fifo[3] = {3 , -1, -1 };
int floor_calls[4] = { 0, 0, 0, 0 };

int fifo_count = 2;

// state machine variables
// -----------------------------------------
// States: 0 - idle; 1 - waiting at floor; 2 - travelling to floor; 3 - EMERGENCY (stopped at closest floor)
int state = 0;
int prevState = 0;

// helper functions
#include "database.h"
#include "canBus.h"
#include "elevatorLogic.h"
#include "websockets.h"

// temp CANBus RXmsg
TPCANMsg tempMsg;

// logging function
static void log(FILE *log, std::string msg) {
    struct timeval tstamp;
    gettimeofday(&tstamp, NULL);
    fprintf(log, "%d", msg);
}

// fossa-req signal handler
static void signal_handler(int sig_num) {
    signal(sig_num, signal_handler);  // Reinstantiate signal handler
    s_signal_received = sig_num;
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
    char jsonchars_short[200];
    char queryBuf[4096];
    int fifo_status = 0;
    int bindex = 0;

    //std::cout << "Event!\n";

    switch (ev) {

    case NS_WEBSOCKET_HANDSHAKE_DONE:   // Client connected via websockets

        std::cout << "New connection.\n";

        send_update(nc, elevator_current_floor, elevator_prev_floor, elevator_travelling, &elevator_req_fifo[0], &floor_calls[0]);    // send updated info to all clients

        break;

    case NS_WEBSOCKET_FRAME:    // client sent a message

        jsonchars = (char*)malloc(wm->size * sizeof(char));
        memset(jsonchars, ' ', wm->size);
        memcpy(jsonchars, wm->data, wm->size);

        for (int i = 0; i < 4096; i++) {
            if (jsonchars[i] == 125) {
                bindex = i + 1;
                break;
            }
        }
        if (bindex != 0 && bindex < 200) {
            memset(jsonchars_short, ' ', 200);
            memcpy(jsonchars_short, jsonchars, bindex);
            memset(jsonchars_short + bindex + 1, '\0', 1);
            //std::cout << "Bracket index: " << bindex << "\n";
        }

        //std::cout << "jsonchars: " << jsonchars_short << std::endl;

        d.Parse(jsonchars_short);

        d.Accept(writer);

        //std::cout << jsonbuf.GetString() << std::endl;
        //std::cout << (char*)wm->data << std::endl;

        if (d.IsObject()) {
            if (d.HasMember("cmd")) {
                if (d["cmd"].GetInt() == WS_UPDATE) {
                    std::cout << "Update requested\n";

                    send_update(nc, elevator_current_floor, elevator_prev_floor, elevator_travelling, &elevator_req_fifo[0], &floor_calls[0]);    // send updated info to all clients
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

                    send_update(nc, elevator_current_floor, elevator_prev_floor, elevator_travelling, &elevator_req_fifo[0], &floor_calls[0]);    // send updated info to all clients
                }
                else if (d["cmd"].GetInt() == WS_SELECT) {
                    std::cout << "Floor " << d["floor"].GetInt() << " requested\n";

                    memset(queryBuf, ' ', 4096);
                    sprintf(queryBuf, "INSERT INTO elevatorInfo (date, time, status, currentFloor, requestedFloor, calledFloor) VALUES (CURDATE(), CURTIME(), %d, %d, %d, NULL);", fifo_count, elevator_current_floor, d["floor"].GetInt());

                    // ---------------------------------------------
                    // CHANGE STATE VARIABLES
                    if (elevator_current_floor != d["floor"].GetInt() || elevator_req_fifo[0] != d["floor"].GetInt()) {
                        fifo_add_floor(&elevator_req_fifo[0], d["floor"].GetInt());
                    }
                    // OTHER ELEVATOR LOGIC
                    // ---------------------------------------------

                    mysql_querydb(&queryBuf[0]);

                    send_update(nc, elevator_current_floor, elevator_prev_floor, elevator_travelling, &elevator_req_fifo[0], &floor_calls[0]);    // send updated info to all clients
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

        std::cout << "Connection closed.\n";
        break;

    default:
        break;
    }
}


// main
int main()
{
    // Clear screen to show received messages
    system("@cls||clear");

    std::cout << "\nELEVATOR SERVER\n";

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

    // logging to file
    FILE* logp;

    logp = fopen("log.txt", "w");
    if (logp == NULL)
    {
        std::cout << "Logging Error!\n";
    }

    int loop_count = DATABASE_UPDATE_TIME;
    int elevator_wait_count = ELEVATOR_FLOOR_WAIT;
    int elevator_floor_timeout = ELEVATOR_FLOOR_TIMEOUT;

    int can_msg;
    int can_floor;

    int called = false;

    // ----------------------------------------------------------------------------------
    // MAIN LOOP - KEEP AS SHORT AS POSSIBLE
    // ----------------------------------------------------------------------------------
    while (s_signal_received == 0) {
        //std::cout << "loop\n";
        ns_mgr_poll(&mgr, LOOP_WS_WAIT);

        // write status to database every 30 minutes
        loop_count--;
        if (loop_count == 0) {
            loop_count = DATABASE_UPDATE_TIME;

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

        // process floor calls
        for (int i = 0; i < 4; i++) {
            if (floor_calls[i] != 0) {
                // add floor with avtive call to the fifo
                switch (i) {
                case 0:
                    if (elevator_current_floor != 1) {
                        fifo_add_floor(&elevator_req_fifo[0], 1);
                        remove_call(1, floor_calls, "up");
                    }
                    break;
                case 1:
                case 2:
                    if (elevator_current_floor != 2) {
                        fifo_add_floor(&elevator_req_fifo[0], 2);
                        remove_call(2, floor_calls, "up");
                        remove_call(2, floor_calls, "down");
                    }
                    break;
                case 3:
                    if (elevator_current_floor != 3) {
                        fifo_add_floor(&elevator_req_fifo[0], 3);
                        remove_call(3, floor_calls, "down");
                    }
                    break;
                }
            }
        }

        int nextIndex = 0;

        switch (state) {
        case 0: // idle state

            if (elevator_req_fifo[0] != -1) {

                elevator_prev_floor = elevator_req_fifo[0];

                // travel to floor
                pcanTx(ID_SC_TO_EC, HexFromFloor(elevator_req_fifo[0]));

                std::cout << "Travelling to floor " << elevator_req_fifo[0] << " \n";

                // change current and prev
                
                //elevator_current_floor = elevator_req_fifo[0];

                prevState = state;
                state = 2; // travelling to floor
            }
            break;

        case 1: // waiting at floor
            // if at a floor in floor_calls[], take it out of floor_calls[] fifo
            elevator_wait_count--;
            //std::wcout << "Elevator wait count: " << elevator_wait_count << "\n";
            if (elevator_wait_count == 0) {
                std::cout << "Doors closed\n";
                elevator_wait_count = ELEVATOR_FLOOR_WAIT;
                prevState = state;
                state = 0;
            }
            break;

        case 2: // travelling

            // get a CANBus message
            tempMsg = pcanRxRaw(1);
            can_floor = FloorFromHex((int)tempMsg.DATA);
            //std::cout << "Floor status: " << can_floor << "\n";

            if (elevator_floor_timeout == ELEVATOR_FLOOR_TIMEOUT) { // travelling
                elevator_travelling = true;
                send_update(nc, elevator_current_floor, elevator_prev_floor, elevator_travelling, &elevator_req_fifo[0], &floor_calls[0]); // send travelling update
            }

            /* THIS DOES NOT WORK BECAUSE CONTROLLER REPORTS WRONG FLOOR
            if ((int)tempMsg.ID == ID_EC_TO_ALL) {  // if msg from controller
                if (can_floor == elevator_req_fifo[0]) {    // and floor equals next in fifo

                    std::cout << "Arrived at floor " << elevator_req_fifo[0] << ". Doors open\n";
                   
                    //elevator_prev_floor = elevator_req_fifo[0];
                    fifo_pop(&elevator_req_fifo[0]);

                    elevator_travelling = false;

                    prevState = state;
                    state = 1; // wait at floor
                }
            }
            */

            // --------------------------------------------------------------------------------
            // Fix for faulty elevator controller not reporting floor correctly
            //   - This is a 'timeout'. After a delay, it will be assumed floor was reached.
            elevator_floor_timeout--;
            if (elevator_floor_timeout == 0) {
                std::cout << "Arrived at floor " << elevator_req_fifo[0] << ". Doors open\n";

                elevator_current_floor = elevator_req_fifo[0];

                fifo_pop(&elevator_req_fifo[0]);

                elevator_travelling = false;

                send_update(nc, elevator_current_floor, elevator_prev_floor, elevator_travelling, &elevator_req_fifo[0], &floor_calls[0]);

                prevState = state;
                state = 1; // wait at floor

                elevator_floor_timeout = ELEVATOR_FLOOR_TIMEOUT;
            }

            break;

        case 3: // emergency
            std::cout << "~~~ EMERGENCY! ~~~\n";
            break;

        default: // default
            prevState = state;
            state = 0; // go to idle state
            std::cout << "OOOOPS! state\n";
            break;
        }
    }

    fclose(logp);

    std::cout << "\nSIGINT received!\n";

    // travel back to floor 1
    std::cout << "Started from the top, now where here (floor 1)...\n";
    pcanTx(ID_SC_TO_EC, HexFromFloor(1));

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