/*	Embedded Controller Design (ECD) Semester 4 Test Code; Test.c implementation file
*		This file contains the test functions to test each module of the project
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


/******Test Function for Stepper Motor********
*******Input Val 1 = full step****************
*******Input Val 3 = half step****************
*******Input Val 0 = motor stop**************/
void Step_Test(uint8_t val){
	Board_LCDInit();
	Step_Init();
	LimitLeft_Init();
	LimitRight_Init();
	
	LCDclear();
	LCDcmd(LCD_CMD_SET_DDADDR|0x00);
	LCDputs("Stepper Test");
	SET_BITS(GPIOC->ODR,(1UL<<3));
	for(uint32_t x = 0; x<100000; x++){
		output(val);
		Delay_ms(1);
		if((GPIOB->IDR & (1UL<<2)))val = 1;			//Left Limit
		Delay_ms(50);
		output(val);
		Delay_ms(1);
		if((GPIOB->IDR & (1UL<<10)))val = 2;
		Delay_ms(50);
	}
}

/******Test Function for LCD Display********
*************No input required*************/
void LCD_Test(void){
	Board_LCDInit();
	LCDclear();
	LCDcmd(LCD_CMD_SET_DDADDR|0x00);
	LCDputs("LCD Works!! :)");
	//1Delay_ms(30);
}

/******Test Function for Servo Motor********
*************No input required*************/
void Servo_Test(void){
	Board_LCDInit();
	
	LCDclear();
	LCDcmd(LCD_CMD_SET_DDADDR|0x00);
	LCDputs("Servo Test");

	Servo_Init();
	Servo_Tim();
	for(uint32_t x = 0; x<10; x++){
		Mov_Servo(600); 
		Delay_s(10);
		Mov_Servo(2400);
		Delay_s(10);

	}
}

/******Test Function for DC Motors********
*************No input required************
*********Incorporates the Encoder test***/
void DC_Test(void){
	Board_LCDInit();
	extern uint16_t volatile PWML;
	extern uint16_t volatile PWMR;
	Enc_Init();
	
	LCDclear();
	LCDcmd(LCD_CMD_SET_DDADDR|0x00);
	LCDputs("Left");
	
	LCDcmd(LCD_CMD_SET_DDADDR|0x08);
	LCDputs("Right");
	
	
	DCLeft_Init();
	DCRight_Init();
	for(uint32_t x = 0; x<10; x++){
		DCLeft_Mov(1500);
		LCDcmd(LCD_CMD_SET_DDADDR|0x40);
		char Left[16];
		sprintf(Left, "%4d", PWML);
		LCDputs(Left);
		Delay_ms(500);
		
		DCRight_Mov(600);
		LCDcmd(LCD_CMD_SET_DDADDR|0x48);
		char Right[16];
		sprintf(Right, "%4d", PWMR);
		LCDputs(Right);
		Delay_ms(500);
		Delay_s(5);
		DCLeft_Stp();
		DCRight_Stp();
		Delay_s(5);
	}
}

/******Test Function for Encoder********
*************No input required*************/
void Enc_Test(void){
	extern uint16_t volatile PWML;
	extern uint16_t volatile PWMR;
	Enc_Init();
	Board_LCDInit();
	
	LCDclear();
	LCDcmd(LCD_CMD_SET_DDADDR|0x00);
	LCDputs("Left");
	
	LCDcmd(LCD_CMD_SET_DDADDR|0x08);
	LCDputs("Right");
	for(uint32_t x = 0; x<1000000; x++){
		LCDcmd(LCD_CMD_SET_DDADDR|0x40);
		char Left[16];
		sprintf(Left, "%4d", PWML);
		LCDputs(Left);
		Delay_ms(500);
		
		LCDcmd(LCD_CMD_SET_DDADDR|0x48);
		char Right[16];
		sprintf(Right, "%4d", PWMR);
		LCDputs(Right);
		Delay_ms(500);
	}
}

/*	Switch statement for USART communication
*		Runs hardware test based on user input*/
void Func_Test(uint8_t value){
		switch(value){
			case ('1'):
				LCD_Test();
				break;
			case ('2'):
				Step_Test(1);
				break;
			case ('3'):
				Servo_Test();
				break;
			case ('4'):
				DC_Test();
				break;
			case ('5'):
				Enc_Test();
				return;
	}
}
