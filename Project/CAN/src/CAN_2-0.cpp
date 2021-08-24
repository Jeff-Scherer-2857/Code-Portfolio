//CAN Bus for Pi with test messages
#include <libpcan.h> //needs proper path to library

HANDLE h = CAN_Open(HW_PCI, 1);         //open the 2nd CAN 2.0 PCI channel in the system (first is 0)
DWORD status;
TPCANMsg msg;

//Initialize the CAN 2.0 channel with 500 kbps BTR0BTR1, not accepting extended id
status = CAN_Init(h, CAN_BAUD_500, INIT_TYPE_SD);   //init type may not be right. wtf is the man page???

msg.ID = 0x123;
msg.MSGTYPE = MSGTYPE_STANDARD;
msg.LEN = 3;

//Sample messages
msg.DATA[0] = 0x01;
msg.DATA[1] = 0x02;
msg.DATA[2] = 0x03;

/*write the standard msg ID = 0x123 with 3 data bytes 0x01, 0x02, 0x03
 *(the funtion may block)
 */
 status = CAN_Write(h, &msg);       //timeout version available, in case there is no room in the transmit queue

 /*wait for a CAN 2.0 msg received from the CAN channel
  *(the function may block)
  */
 status = CAN_Read(h, &msg);        //timeout version available, in case there is no mesage to read

 /*get the status of a CAN 2.0 channel
  ****May want to use Statistics instead, as it does not clear the status****
  */
 status = CAN_Status(h);            //extended version available, returns number of pending reads and writes

 /*wait for a CAN 2.0 msg received from the CAN channel 
  *(the function may block)
  */
 CAN_Close(h);