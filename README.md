# 3rd Year Elevator Project

This project focused on implementing a full stack infastructure to have a webpage control the operation of a remote elevator.

This project was completed virtually from the college due to the ongoing pandemic and local restrictions.

This code was written and tested on our local machines.
Once verified, the code was pushed to the mechanical system using PuTTY.

Hardware:
A NucleoF303 microcontroller with an ARM64 processor was used to communicate through CAN protocols to move an elevator up or down, based on user input from a webpage.

Front End:
A website was used and deployed using xampp, being hosted on a remote, Linux based device.
The website consists of HTML, CSS and Javascript to give functional components to the user
These components include navigation betweem pages, login services, as well as multiple device and mobile integration.

Back End:
The back end of the project was built on a MySQL database.
This database was used for both website and hardware functionality.

	For the webiste, the database house user login information, only giving approved users access to control the elevator
	Also allowed new users to submit login requests and password changes to be maintained by the admin (project group)

	For the hardware, the database kept toll of the elevator location, elevator calls from the user, and peripheral buttons.
	Peripheral buttons include "homing" the elevator, playing elevator music (fun addition), and playing an emergey alert.

Unfortunately becuase this project was completed virtually, it wasn't possible to make a recording of the functioning elevator with the deployed website.
Work was verified using remotely controlled cameras, connected on campus by an on-campus lab technician. 