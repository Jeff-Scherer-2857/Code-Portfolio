#include "includes/pcanFunctions.h"
#include "includes/mainFunctions.h"

#include <stdio.h>
#include <stdlib.h>
#include <stdlib.h>
#include <unistd.h> 

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


int menu(){
	
	int usrchoice = 0;
	system("@cls||clear");
	while(1) {
		printf("\n\nMenu - Transmit/Receive CAN Messages\n");
		printf("1. Transmit CAN message using this program\n");
		printf("2. Receive CAN message(s) using this program\n");
		printf("3. Control elevator from website\n");
		printf("4. Exit program\n");
		printf("\nYour choice: ");
		scanf("%d", &usrchoice);

		if (usrchoice >=1 && usrchoice <= 4) {	
			return usrchoice;
		} else {
			printf("\nPLEASE SELECT FROM CHOICES 1-4 ONLY!\n\n");
			sleep(3);
			system("@cls||clear");
		}
	}
	
}


int chooseID(){

	int IdChoice = 0;		// Menu item number
	int IDvalue = 0 ;		// ID value in HEX
	while(1) {
		system("@cls||clear");
		printf("\nChoose sender and receiver for message\n");
		printf("1. Message from Supervisory controller (i.e. this node) to Elecvator Controller\n");
		printf("2. Message from Elevator controller to all other nodes\n");
		printf("3. Message from Car controller to supervisory controller (this node)\n");
		printf("4. Message from floor 1 controller to supervisory controller (this node)\n");
		printf("5. Message from floor 2 controller to supervisory controller (this node)\n");
		printf("6. Message from floor 3 controller to supervisory controller (this node)\n");

		printf("\nYour choice: ");
		scanf("%d", &IdChoice);

		if (IdChoice >=1 && IdChoice <= 6) {	
			switch(IdChoice) {
				case 1:
					IDvalue = ID_SC_TO_EC; 
					return(IDvalue);
				case 2:
					IDvalue = ID_EC_TO_ALL; 
					return(IDvalue);
				case 3:
					IDvalue = ID_CC_TO_SC; 
					return(IDvalue);
				case 4:
					IDvalue = ID_F1_TO_SC; 
					return(IDvalue);
				case 5:
					IDvalue = ID_F2_TO_SC; 
					return(IDvalue);
				case 6:
					IDvalue = ID_F3_TO_SC; 
					return(IDvalue);
			}

		} else {
			printf("\nPLEASE SELECT FROM CHOICES 1-6 ONLY!\n\n");
			sleep(3);
		}

	}
}

int chooseMsg(){
	int messageChoice = 0; 
	int messageValue = 0;
	
	while(1) {
		system("@cls||clear");
		printf("\nChoose Message\n");
		printf("1. Go to floor 1\n");
		printf("2. Go to floor 2\n");
		printf("3. Go to floor 3\n");
		printf("\nYour choice: ");
		scanf("%d", &messageChoice);

		if (messageChoice >=1 && messageChoice <= 3) {	
			switch(messageChoice) {
				case 1:
					messageValue = GO_TO_FLOOR1; 
					return(messageValue);
					break;
				case 2:
					messageValue = GO_TO_FLOOR2; 
					return(messageValue);
					break;
				case 3:
					messageValue = GO_TO_FLOOR3; 
					return(messageValue);
					break;
			}

		} else {
			printf("PLEASE SELECT FROM CHOICES 1-3 ONLY!\n\n");
			sleep(3);
		}
	}
}


int HexFromFloor(int floorVal) {

	switch(floorVal) {
		case 1:
			return(GO_TO_FLOOR1);
			break;
		case 2:
			return(GO_TO_FLOOR2);
			break;
		case 3: 
			return(GO_TO_FLOOR3);
			break;
		default:
			return(GO_TO_FLOOR1);			// Default is to reset to floor 1 on bad input
		}
}

int FloorFromHex(int Hex){
		
	switch(Hex) {
		case GO_TO_FLOOR1:
			return(1);
			break;
		case GO_TO_FLOOR2:
			return(2);
			break;
		case GO_TO_FLOOR3:
			return(3);
			break;
		default:
			return(1);							// Default is to reset to floor 1 on bad input
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

    int prev_floorNumber;

    while(1){	
		int position = pcanRx(1);											//Find out elevator position
        //pcanRX() return 0 --> elevator in motion
        if (position == 0){
            //if prev_floorNumber - 
            //insert logic based on direction

        } else if(prev_floorNumber != floor && position != floor){
            if (floor == 1) {
                pcanTx(ID_SC_TO_EC, HexFromFloor(floor));       //send elevator to 1
            } else if (floor == 2){
                pcanTx(ID_SC_TO_EC, HexFromFloor(floor));       //send elevator to 2
            } else if (floor == 3){
                pcanTx(ID_SC_TO_EC, HexFromFloor(floor));       //send elevator to 3
            } else {
                pcanTx(ID_SC_TO_EC, HexFromFloor(1));           //default in case of bad input go to floor 1
            }

        }
		prev_floorNumber = floor; 
		sleep(1);															// poll database once every second to check for change in floor number
	}
	break;
}