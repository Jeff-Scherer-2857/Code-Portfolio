#ifndef MAIN_FUNCTIONS
#define MAIN_FUNCTIONS

int menu();
int chooseID();
int chooseMsg();
int HexFromFloor(int floorVal);
int FloorFromHex(int Hex);
static void signal_handler(int sig_num);
static int is_websocket(const struct ns_connection* nc);
static void broadcast(struct ns_connection* nc, const char* msg, size_t len);
int fifo_add_floor(int* fifo, int floor);
int fifo_pop(int* fifo);
void add_call(int floorcall, int* calls, std::string dir);
void remove_call(int floorcall, int* calls, std::string dir);
void send_update(struct ns_connection* nc);
static void ev_handler(struct ns_connection* nc, int ev, void* ev_data);
void elevatorControl(int floor);

#endif
