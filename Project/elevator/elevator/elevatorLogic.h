#pragma once

#ifndef ELEVATOR_LOGIC
#define ELEVATOR_LOGIC

// standard
#include <cstdio>
#include <iostream>
#include <string>

int fifo_add_floor(int*, int);
int fifo_pop(int*);
void add_call(int, int*, std::string);
void remove_call(int, int*, std::string);

#endif