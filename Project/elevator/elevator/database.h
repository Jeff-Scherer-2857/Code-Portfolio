#pragma once

#ifndef DATABASE
#define DATABASE

// MySQL connector
#include <mysql/mysql.h>

// standard
#include <cstdio>
#include <iostream>
#include <string>

// MySQL Database details
#define DATABASE_NAME  "elevator"
#define DATABASE_USERNAME "webuser"
#define DATABASE_PASSWORD "12345678"
#define DATABASE_PORT   3306

static MYSQL* elevatordb;  // MySQL database

void mysql_connect(void);
void mysql_disconnect(void);
void mysql_querydb(char*);

#endif