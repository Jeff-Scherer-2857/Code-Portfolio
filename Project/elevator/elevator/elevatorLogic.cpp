#include "elevatorLogic.h"


// ---------------------------------------------------------
// FIFO functions
// ---------------------------------------------------------

// add floor to fifo; return -1 if full, -2 if floor is already in fifo
int fifo_add_floor(int* fifo, int floor) {
    int fifo_stat = 1;  // -1 = full; -2 = floor already in fifo

    // seach fifo for requested floor; do NOT include pos 0, as elevator could be travelling from that floor
    int infifo = 0;
    for (int i = 1; i < 3; i++) {
        if (fifo[i] == floor) {
            infifo = 1;
            break;
        }
    }

    if (!infifo) {
        // insert floor into first remaining free position (= -1)
        if (fifo[2] == -1) {    // is there a space at the very end position?
            int space_index = 2; // already determined there is a space at the end
            // loop through remaining positions and find the closest empty space to the front
            for (int i = 0; i < 3; i++) {
                if (fifo[i] == -1) {
                    space_index = i;    // record new empty space
                    //std::cout << "space index: " << space_index << "\n";
                    break;  // don't continue loop
                }
            }
            fifo[space_index] = floor;
        }
        else {
            fifo_stat = -1; // no empty space found
        }
    }
    else {
        fifo_stat = -2; // requested floor already in fifo
    }

    //std::cout << "Adding " << floor << " to FIFO.\n";
    //std::cout << "FIFO status: " << fifo_stat << "\n";
    //std::cout << "FIFO contents: ";
    for (int i = 0; i < 3; i++) {
        //std::cout << fifo[i] << " ";
    }
    //std::cout << "\n";
    

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
        fifo[2] = -1;   // reset last value
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
        }
        else if (dir.compare("down") == 0) {
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
}