int Security = A6;

//Check vibration sensor
int SecurityCheck() {
  int Check = analogRead(Security);
  if(Check > 100){
    Secure = 1;
    Speaker.stopPlayback();
    return 1;
  }
  return 0;
}

//check vibration, send warning, signal alarm
void SecurityMode(){
  SimInit();
  while(Secure){
    if(SecurityCheck()){
      Warning();
      delay(3000);
      for(int i = 0; i<100000;i++){
        if(SecurityCheck()){
          Alarm();
          sendMessage();
          delay(10000);
          if(!Secure){
            break;
          }
        }
      }
    }
  
  }
}
