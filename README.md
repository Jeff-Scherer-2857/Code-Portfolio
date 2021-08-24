# Robot Development Project

This project consisted of developing a integration between a Nucleof303 microcontroller with a ARM64 processor, a custom built PCB and pre-fabricated robot.

The robot components:
- dual DC motor drivetrain
- Webcam module
- Servo Motor to control camera angle
- Battery-Based Power Supply

The custom PCB included:
- Drivers for DC motors using pulse width modulation (PWM)
- Driver for Servo motor
- Onboard LCD Display for vital information (ex. wheel speed)
- Power control system to integrate with robot power supply
- RS232 communications
- Headers to mount Nucleo to board during operation
- mounting holes to mount on to pre-fab robot.

Software:
For this project, test modules were created for each functional unit of the project.
The program allows a user to select which module they would like to test.
The program then verifies the selection and executes a test for each module.
Depending on the module being tested, the LCD will display important information for the user.

The benchmark for completing this project was to have a fully written test code for the program using the PCB and microcontroller.

The full implementation to the robot was completed in a future project. This project allowed students to work in groups.
Unfortunately, because of this, only one student's project carried forward to the full implementation.
Due to hardware and implementation decisions, students' project varried and the final implementation was not transferrable between boards.
