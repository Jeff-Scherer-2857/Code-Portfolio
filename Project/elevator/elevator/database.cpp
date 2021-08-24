#include "database.h"

// MySQL connect to db
void mysql_connect(void)
{
    //initialize MYSQL object for connections
    elevatordb = mysql_init(NULL);

    if (elevatordb == NULL)   // failed if NULL
    {
        std::cout << "Error connecting to database.\n Error: " << mysql_error(elevatordb) << "\n";
        return;
    }

    //Connect to the database
    //if (mysql_real_connect(elevatordb, "192.168.0.30", DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME, DATABASE_PORT, NULL, 0) == NULL)
    if (mysql_real_connect(elevatordb, "127.0.0.1", DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME, DATABASE_PORT, NULL, 0) == NULL)
    {
        std::cout << "Error connecting to database.\n Error: " << mysql_error(elevatordb) << "\n";
    }
    else
    {
        printf("Database connection successful.\n");
    }
}


// MySQL disconnect from db
void mysql_disconnect(void)
{
    mysql_close(elevatordb);
    printf("Disconnected from database.\n");
}


// MySQL query
void mysql_querydb(char* query)
{
    if (elevatordb != NULL)
    {
        // execute query
        if (mysql_query(elevatordb, query)) {

            std::cout << "Error querying database.\n Query was [" << query << "].\n Error: " << mysql_error(elevatordb) << "\n";
        }
    }
}