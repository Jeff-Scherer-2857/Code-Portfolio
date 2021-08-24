#pragma once

#ifndef WEBSOCKETS
#define WEBSOCKETS

// multi-protocol networking library
#include "fossa.h"

// rapid JSON
#include "rapidjson/document.h"
#include "rapidjson/writer.h"
#include "rapidjson/stringbuffer.h"

// standard
#include <cstdio>
#include <iostream>
#include <string>

using namespace rapidjson;

// message definitions
#define         WS_UPDATE       85        // update request/message
#define         WS_CALL         67        // elevator call request
#define         WS_SELECT       83        // elevator floor request
#define         WS_EMERG        69        // elevator emergency

// fossa variables
static sig_atomic_t s_signal_received = 0;
static const char* s_http_port = "61415";
static struct ns_serve_http_opts s_http_server_opts;

void send_update(struct ns_connection*, int, int, bool, int*, int*);
static void broadcast(struct ns_connection*, const char*, size_t);
static int is_websocket(const struct ns_connection*);

#endif