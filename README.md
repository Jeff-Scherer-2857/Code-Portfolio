# Code for Capstone Project

This project used an Arduino Nano to integrate multiple hardware devices.

Device List:
HM-10 Bluetooth (BLE) Module
Garmin Lite v3 LiDAR Sensor
MicroSD Adapter
3G SIM5360E SIM Card Module
Vibration Sensor mounted on custom PCB
Custom LED System Integrated through custom PCB

Each Module was tested in a separate program and then integrated together in the main project file.
Module test files became the Arduino equivalent of a header file for each module.
This system made it easier for us to debug modules in the cases of performance or logical issues. 

