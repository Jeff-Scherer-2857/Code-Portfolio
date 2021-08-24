#include <SPI.h>
#include <SD.h>
#include "TMRpcm.h"

//SD Specific constants
File myFile;
const int chipSelect = 10;
TMRpcm Speaker;

//MicroSD Initialization Test
void MicroSDInit(void){
  Speaker.speakerPin=9;
  Speaker.setVolume(5);
  Speaker.stopPlayback();
  Speaker.quality(1);
  Speaker.loop(0);

  if (!SD.begin()) {
    return;
  }
}

void Story(void){
  Speaker.play("FreeHeineken.wav");
}

void Welcome(void){
  Speaker.play("Hey.wav");
}

void Warning(void){
  Speaker.play("warning1.wav");
}

void Alarm(void){
  Speaker.play("5.wav");
}

void Bell(void){
  Speaker.play("bell1.wav");
  delay(1000);
}

void Car(void){
  Speaker.play("App.wav");
}
