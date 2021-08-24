/*	Embedded Controller Design (ECD) Semester 4 Test Code; LCD.c implementation file
*		Functions contained in this file will do the follow:
*		Initialize the LCD screen
*		Write data to the LCD screen
*		Delay functions for us,ms, and sec. used throughout all programs
*		Written by: Jeff Scherer
*		Bachelor of Engineering, Electronic Systems Engineering
*		Conestoga College, Cambridge, ON
*		Date: March 29, 2019
*/

#include "stm32f303xe.h"
#include "SysClock.h"
#include "LCD.h"
#include "macros.h"
#include "LCDcommands.h"
#include <stdio.h>
#include <string.h>


/**************************************************
***************************************************
***************Project Test Code*******************
***************************************************
**************************************************/

void Delay_us(uint16_t delay){
	uint32_t dlay = 0.666*delay;
	for(uint16_t x = 0; x<dlay; x++);
}

void Delay_ms(uint32_t delay){
	uint32_t dlay = 666*delay;
	for(uint32_t x = 0; x<dlay;x++);
}

void Delay_s(uint32_t delay){
	uint32_t dlay = 666000*delay;
	for(uint32_t x = 0; x<dlay;x++);
}

void Board_LCDInit(void){
	
	RCC->AHBENR |= RCC_AHBENR_GPIOBEN;				//Enable clock of Port B
	
	//Push-Pull Pins
	GPIO_PIN_DRV_TYPE(B, 13, PP);
	GPIO_PIN_DRV_TYPE(B, 12, PP);
	GPIO_PIN_DRV_TYPE(B, 7, PP);
	GPIO_PIN_DRV_TYPE(B, 6, PP);
	GPIO_PIN_DRV_TYPE(B, 5, PP);
	GPIO_PIN_DRV_TYPE(B, 4, PP);
	
	//Output pins GPIOE 8, 11-15
	GPIO_PIN_MODE(B, 13, OUT);
	GPIO_PIN_MODE(B, 12, OUT);
	GPIO_PIN_MODE(B, 7, OUT);
	GPIO_PIN_MODE(B, 6, OUT);
	GPIO_PIN_MODE(B, 5, OUT);
	GPIO_PIN_MODE(B, 4, OUT);
	
//	Delay_ms(50);
//	LCD_BUS(0x0,B);									//write 0x0 to data bus
	LCD_E_HI(B);
	LCD_RS_IR(B);
	//Delay_ms(50);										//delay >40ms
	LCD_BUS(0x3,B);								//set 8-bit
	LCD_E_LO(B);
	Delay_ms(5);										//delay >5ms
	
	LCD_E_HI(B);
	LCD_BUS(0x03,B);
	LCD_E_LO(B);
	
	Delay_ms(1);									//delay >160us
	
	LCD_E_HI(B);
	LCD_BUS(0x03, B);
	LCD_E_LO(B);

	Delay_ms(1);
	
	LCD_E_HI(B);
	LCD_BUS(0x02, B);
	LCD_E_LO(B);
	
	Delay_ms(2);
	
	LCDcmd( LCD_CMD_FUNCTION | LCD_FUNCTION_4BIT | LCD_FUNCTION_2LINES | LCD_FUNCTION_5X8FONT );
  LCDcmd( LCD_CMD_DISPLAY | LCD_DISPLAY_OFF );
  LCDclear();
  LCDcmd( LCD_CMD_ENTRY | LCD_ENTRY_MOVE_CURSOR | LCD_ENTRY_INC );
  LCDcmd( LCD_CMD_DISPLAY | LCD_DISPLAY_ON | LCD_DISPLAY_NOCURSOR | LCD_DISPLAY_NOBLINK );
}

void LCDclear(void){
	LCDcmd(LCD_CMD_CLEAR);
	Delay_ms(20);
}

void LCDprintf(uint8_t *phrase){
	uint8_t count = 0;
	while(count < 32){
		if(count == 15)LCDcmd(LCD_CMD_SET_DDADDR|0x40);
		if(*phrase == 0) break;
		LCDdata(*phrase);
		count++;
		phrase++; 
	}
}

void LCDcmd(uint8_t value){
	LCD_E_HI(B);
	LCD_RS_IR(B);
	LCD_BUS(HI_NYBBLE(value),B);
	LCD_E_LO(B);
	Delay_us(2);
	LCD_E_HI(B);
	LCD_BUS(LO_NYBBLE(value),B);
	LCD_E_LO(B);
	Delay_us(300);
}

void LCDdata(uint8_t value){
	LCD_E_HI(B);
	LCD_RS_DR(B);
	LCD_BUS(HI_NYBBLE(value),B);
	LCD_E_LO(B);
	Delay_us(2);
	LCD_E_HI(B);
	LCD_BUS(LO_NYBBLE(value),B);
	LCD_E_LO(B);
	Delay_us(300);
}

void LCDputs(char *string){
	uint8_t count = 0;
	while(count < 16){
		if(*string == 0) break;
		LCDdata(*string);
		count++;
		string++;
	}
}

void LCDputc(uint8_t character){
	LCDdata(character);
}
