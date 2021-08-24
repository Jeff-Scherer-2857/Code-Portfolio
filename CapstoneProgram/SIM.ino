#include <SoftwareSerial.h>
SoftwareSerial SimSerial(8,5); //RX, TX
String PhoneNumber = "2267970765";

void SimInit(void){
  SimSerial.begin(19200); // the GPRS baud rate
  //delay(15000);//wait for SIM module to boot up
  SimSerial.println("AT+CMGF=1");//Because we want to send the SMS in text mode
  delay(100);
  SimSerial.println("AT+CGPSSSL=0");//no gps certificate
  delay(100);
  //commented out already set up
  //SimSerial.println("AT+CGPSHOT");//start gps in Hot mode
  //delay(5000);
}

//Reads serial data from the SIM5360
char * Receive(void){
  char x[151];
  static char* reply = x;
  int i = 0;
  while(SimSerial.available()){
    delay(2);
    reply[i] = SimSerial.read();
    i++;
  }
  reply[i] = '\0';
  return(reply);
}

//Reads GPS and sends it to user through sms
void sendMessage(void){
  int colon;
  int commas[8];
  int i = 0;
  char Lat[13];
  char Long[13];
  char Date[8];
  char Time[10];
  char Alt[7];
  char Speed[7];
  char Course[7];
  char *reply;
  
  SimSerial.println("AT+CGPSINFO");//Check GPS
  for(int j=0; j<1000;j++){
    delay(1000);
    if(SimSerial.available()){
      break;
    }
  }
  reply = Receive();

 int sizem = strlen(reply); //find the ":"
  for(i = 0; i < sizem; i++){
    if(reply[i] == 58){     //":" ascii
      colon = i;
      break;
    }
  }
  
  if(i>=sizem){//return if no ":"
    return;
  }
  
  i++;
  int a = 0;
  for(i; i < sizem; i++){ //find all the ","
    if(reply[i] == 44){   //"," ascii
      commas[a] = i;
      a++;
    }
  }

  if((commas[1] - colon == 1)||(commas[3] - commas[2] == 1)){
    SimSerial.print("AT+CMGS=\"+");//send sms message
    SimSerial.print(PhoneNumber);//send sms message
    SimSerial.println("\"");//send sms message
    delay(100);
    SimSerial.println("GPS Location Not Found");
    delay(100);
    SimSerial.println((char)26);//the ASCII code of the ctrl+z is 26
    delay(100);
    return;
  }
  
  for(int j = 0; j<14; j++){    //Latitude
    if(reply[colon+1+j]==44){
      Lat[j] = "\0";
      break;
    }
    Lat[j]=reply[colon+1+j];//colon+1
  }

  for(int j = 0; j<14; j++){    //Longitude
    if(reply[commas[1]+1+j]==44){
      Long[j] = "\0";
      break;
    }
    Long[j]=reply[commas[1]+1+j];
  }
  Long[0]= 45;

  for(int j = 0; j<11; j++){    //Date
    if(reply[commas[3]+1+j]==44){
      Date[j] = "\0";
      break;
    }
    Date[j]=reply[commas[3]+1+j];    
  }

  for(int j = 0; j<11; j++){    //Time
    if(reply[commas[4]+1+j]==44){
      Time[j] = "\0";
      break;
    }
    Time[j]=reply[commas[4]+1+j];
  }

  for(int j = 0; j<8; j++){    //Altitute
    if(reply[commas[5]+1+j]==44){
      Alt[j] = "\0";
      break;
    }
    Alt[j]=reply[commas[5]+1+j];
  }

  for(int j = 0; j<8; j++){    //speed
    if(reply[commas[6]+1+j]==44){
      Speed[j] = "\0";
      break;
    }
    Speed[j]=reply[commas[6]+1+j];
  }
  
  for(int j = 0; j<8; j++){    //course
    if(reply[commas[7]+1+j]==46){
      Course[j] = reply[commas[7]+1+j];
      Course[j+1]=reply[commas[7]+2+j];
      Course[j+2] = "\0";
      break;
    }
    Course[j]=reply[commas[7]+1+j];
  }

  SimSerial.println("AT+CMGS=\"+2267970765\"");//send sms message
  delay(100);
  SimSerial.print("Latitude: ");  
  SimSerial.println(Lat);//the content of the message
  SimSerial.print("Longitude: ");
  SimSerial.println(Long);//the content of the message
  SimSerial.print("Date: ");
  SimSerial.println(Date);//the content of the message
  SimSerial.print("Time: ");
  SimSerial.println(Time);//the content of the message
  SimSerial.print("Alt: ");
  SimSerial.println(Alt);//the content of the message
  SimSerial.print("Speed: ");
  SimSerial.println(Speed);//the content of the message
  SimSerial.print("Course: ");
  SimSerial.println(Course);//the content of the message
  
  delay(100);
  SimSerial.println((char)26);//the ASCII code of the ctrl+z is 26
  delay(100);
}

//Check SMS Messages returns 1 if there is a message from the correct number else returns 0
int CheckMessages(void){
  char *reply;
  char number[12];
  Receive();//clear serial
  SimSerial.println("AT+CMGL=\"ALL\"");//check messages//+CMGL=\"ALL\"
  delay(100);
  reply = Receive();
  int sizem = strlen(reply); //find the "+"
  int pluscount = 0;
  int i;
  for(i = 0; i < sizem; i++){
    if(pluscount == 2){
      break;
    }
    if(reply[i] == 43){     //"+" ascii
      pluscount++;
    }
  }
  if(i>=sizem){//return if no "+"//return if no message
    return 0;
  }
  SimSerial.println("AT+CMGD=0,4");//delete messages
  delay(100);
  for(int j = 0; j<13; j++){  //number
    if(reply[i+j] == 34){       //"ascii
      number[j]=char(0); //NULL ascii
      break;
    }
    number[j]=reply[i+j];     
  }
  
  if (strlen(number)== 10){ /////////////normal
    if(strcmp(number,&PhoneNumber[0])){
      return 0;
    }
    //Serial.println("match");
    return 1;
  }

  else if (strlen(number)== 11){/////////////long distance
    char TempNumber[12];
    TempNumber[11] = char(0);
    sprintf(TempNumber, "1%s", &PhoneNumber[0]);
    if(strcmp(number,TempNumber)){
      return 0;
    }
    return 1;
  }
  else{
    return 0;
  }
}
