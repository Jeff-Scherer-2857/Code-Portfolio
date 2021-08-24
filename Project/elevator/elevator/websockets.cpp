#include "websockets.h"

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


// websocket send update
void send_update(struct ns_connection* nc, int current_floor, int prev_floor, bool travelling, int* fifo, int* calls) {

    StringBuffer s;
    Writer<StringBuffer> response(s);

    response.StartObject();
    response.Key("cmd");
    response.Uint(WS_UPDATE);
    response.Key("current_floor");
    response.Uint(current_floor);
    response.Key("prev_floor");
    response.Uint(prev_floor);
    response.Key("travelling");
    response.Bool(travelling);
    response.Key("fifo");
    response.StartArray();
    for (int i = 0; i < 3; i++) {
        response.Int(fifo[i]);
    }
    response.EndArray();
    response.Key("calls");
    response.StartArray();
    for (int i = 0; i < 4; i++) {
        response.Int(calls[i]);
    }
    response.EndArray();
    response.EndObject();

    //std::cout << "Response: " << s.GetString() << "\n";

    broadcast(nc, s.GetString(), s.GetSize());
}

