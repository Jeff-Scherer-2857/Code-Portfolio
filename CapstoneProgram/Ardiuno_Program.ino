/*
*   Main file for full Arduino Program
*/
#include <Wire.h>

char BT;
bool Secure = 0;
bool RunningLights = 0;

/*Initialization function
  initialize each module
  set ISR's
*/
void setup() {
  // Open serial communications and wait for port to open:
  //Serial.begin(9600);
 // while (!Serial) {
 //   ; // wait for serial port to connect. Needed for Leonardo only
 // }
  //Keep power ON
  pinMode(A0, OUTPUT);
  digitalWrite(A0, HIGH);
  
  //Initiate Modules
  BluetoothInit();
  LEDInit();
  LIDARInit();
  MicroSDInit();

  //Interrupt on BT Receive
  attachInterrupt(digitalPinToInterrupt(2), BTMessageReceive, CHANGE);
  //Play welcome message
  Welcome();
}

/*Arduino version of a main() function
  currently empty
  most modules will work as an ISR
  Might be used for the LIDAR module to take timed measurements
*/
void loop() {
  delay(500);
  //Check for text message to return coordinates 
  if(CheckMessages()){
    Receive(); //clear Serial
    sendMessage();
  }

 if(RunningLights == 0){
  RunningOff();
 } else if(RunningLights == 1){
  RunningOn();
 }

  //Check Lights, Security and LiDAR each time through loop
  LightCheck();
  getDistance();
  
  //If Security is turned out, switch state and enter Security Mode
  if(BT=='C'){
    Secure = 1;
    SecurityMode();
  } 
}
