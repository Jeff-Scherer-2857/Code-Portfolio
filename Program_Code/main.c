/*	Embedded Controller Design (ECD) Semester 4 Test Code; main.c client file
*		Written by: Jeff Scherer
*		Bachelor of Engineering, Electronic Systems Engineering
*		Conestoga College, Cambridge, ON
*		Date: March 29, 2019
*/

#include <stdio.h>
#include <string.h>
#include "stm32f303xe.h"
#include "SysClock.h"
#include "macros.h"
#include "LCDcommands.h"
#include "LCD.h"
#include "stepper.h"
#include "Servo.h"
#include "Wheels.h"
#include "Encoder.h"
#include "RS232.h"
#include "Test.h"

int main(void){
	System_Clock_Init();
	Board_LCDInit();
	UART1_Init();
	Menu_Print();
	extern uint8_t volatile Value;
	LCDclear();
	for(;;){
//		LCD_Test();
		Func_Test(Value);
		Value = 0;
		Delay_ms(30);
//		Servo_Test();
	}
}
