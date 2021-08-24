#include "SoftwareSerial.h"

//Set digital input/output pins
//cannot use Rx Tx pins on Arduino because of serial communication complications
SoftwareSerial mySerial(2,3);  //Rx, Tx

void BluetoothInit(){
  mySerial.begin(9600);
}

//Receive message interrupt
//execute functions based on user input on ap
void BTMessageReceive(void){
  //receive message
  BT = char(0);
  BT = mySerial.read();
  //Serial.println("message: ");
  //turn on running lights
  if(BT == 'A'){
    if(RunningLights == 0){
      RunningLights = 1 ;
    } else if(RunningLights == 1){
      RunningLights = 0;
    }
  }
  //ring bell
  if(BT == 'B'){
    Bell();
  }
  //turn off security
  if(BT == 'D'){
    Secure = 0;
    Speaker.stopPlayback();
    Speaker.play("Unlocked.wav");
  }
  //Power off
  if(BT == 'E'){
    digitalWrite(A0, LOW);
  }

}
