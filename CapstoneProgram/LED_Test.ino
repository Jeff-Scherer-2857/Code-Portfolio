/*
 * Test program to turn on LEDs for project
 * Start with just a simple LED connected to a digital pin
 * Note: For project implementation, these will need to be initialized with the internal pullup resistor because of BJT
 * Author: Jeff Scherer
 * Date: July 8, 2021
*/

//LED constants for digital pins
#define RIGHT 6     //Right Signal Connected to Digital Pin 4
#define LEFT 4      //Left Signal Connected to Digital Pin 5
#define Rear_RUN A3  //Rear Running Lights Connected to Digital Pin 6
#define Front_RUN A1  //Front Running Lights Connected to Digital Pin 7
#define BRAKE 7     //Brake Lights connected to Digital Pin 8

int LightLogic = A7;

//Initialize all LED outputs
void LEDInit() {
  pinMode(LEFT, OUTPUT);
  pinMode(RIGHT,OUTPUT);
  pinMode(Rear_RUN,OUTPUT);
  pinMode(Front_RUN,OUTPUT);
  pinMode(BRAKE,OUTPUT);
}

//Turn on Running Lights
void RunningOn(void){
  digitalWrite(Front_RUN,HIGH);
  digitalWrite(Rear_RUN,HIGH);
}

//Turn off Running Lights
void RunningOff(void){
  digitalWrite(Front_RUN,LOW);
  digitalWrite(Rear_RUN,LOW);
}

//Signal Left
void LeftSignal(void){
  digitalWrite(LEFT,HIGH);
  delay(500);
  digitalWrite(LEFT,LOW);
  delay(500); 
}

//Signal Right
void RightSignal(void){
  digitalWrite(RIGHT,HIGH);
  delay(500);
  digitalWrite(RIGHT,LOW);
  delay(500);
}

//Turn on Brake Lights
void AmBraking(void){
  digitalWrite(BRAKE,HIGH);
}

//Turn off Brake Lights
void NotBraking(void){
  digitalWrite(BRAKE,LOW);
}

//Check if brake button is pressed
void LightCheck(void){
  int Logic = analogRead(LightLogic);
  if(Logic < 115){
    AmBraking();
  } else if( Logic > 115 && Logic < 135){
    NotBraking();
  } else if( Logic > 135 && Logic < 155){
    RightSignal();
    AmBraking();
  } else if( Logic > 160 && Logic < 180){
    NotBraking();
    RightSignal();
  } else if( Logic > 230 && Logic < 260){
    LeftSignal();
    AmBraking();
  } else if( Logic > 315){
    NotBraking();
    LeftSignal();
  }
}
