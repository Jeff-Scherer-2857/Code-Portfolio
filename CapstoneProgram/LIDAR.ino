
#include <Wire.h>
#include <LIDARLite.h>
#include <LIDARLite_v3HP.h>
#include <LIDARLite_v4LED.h>

LIDARLite lidarLite;
int cal_cnt = 0;
int count = 0;
int dist[100];
int Compare = 0;
int Diff = 0;
int Closer = 0;


void LIDARInit(){
  lidarLite.begin(0, true);
  lidarLite.configure(0);
}

//get a new distance measurement from LiDAR
//Compare new distance with last distance
//if new distance is 500cm (5m) closer, increment counter
//increment 5 time, trigger alert
void getDistance(){
  if(count == 0){
    dist[count] = lidarLite.distance();   //every 100 measurements, correct bias
  } else {
    dist[count] = lidarLite.distance(false);
  }
  //compare new distance with last distance
  Compare = dist[count] - dist[count-1];
  //if 1m closer, increment counter
  if(Compare < -250){
    Closer++;
    //if 25m closer, alert cyclist
    if(Closer == 5){
      Car();
      Closer = 0;
    }if(Compare > -200){
      Closer = 0;
    }
  }
  count++;
  count = count % 100;
}
