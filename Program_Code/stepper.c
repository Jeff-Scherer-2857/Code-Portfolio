/*	Embedded Controller Design (ECD) Semester 4 Test Code; stepper.c implementation file
*		Functions contained in this file will be responsible for driving the stepper motor
*		connected to the camera module of the robot
*		Written by: Jeff Scherer
*		Bachelor of Engineering, Electronic Systems Engineering
*		Conestoga College, Cambridge, ON
*		Date: March 29, 2019
*/

#include "stm32f303xe.h"
#include "SysClock.h"
#include "stepper.h"
#include "macros.h"

/**Will need to use interrupts for project execution in semester 5***/

void Step_Init(void){
	RCC->AHBENR |= RCC_AHBENR_GPIOCEN;			//Enable clock for Port C

	//clearing top 4 pins
	CLR_BITS(GPIOC->MODER,(3UL<<12));
	CLR_BITS(GPIOC->MODER,(3UL<<14));
	CLR_BITS(GPIOC->MODER,(3UL<<16));
	CLR_BITS(GPIOC->MODER,(3UL<<18));
	
	//Setting top 4 pins as outputs
	SET_BITS(GPIOC->MODER,(1UL<<12));
	SET_BITS(GPIOC->MODER,(1UL<<14));
	SET_BITS(GPIOC->MODER,(1UL<<16));
	SET_BITS(GPIOC->MODER,(1UL<<18));

	//setting push-pull for output
	GPIOC->OTYPER &= ~(1UL<<6);
	GPIOC->OTYPER &= ~(1UL<<7);
	GPIOC->OTYPER &= ~(1UL<<8);
	GPIOC->OTYPER &= ~(1UL<<9);
	
	//Stepper Enable
	CLR_BITS(GPIOC->MODER,(3UL<<6));
	SET_BITS(GPIOC->MODER,(1UL<<6));
	CLR_BITS(GPIOC->ODR,(1UL<<3));
	//SET_BITS(GPIOC->ODR,(1UL<<3));
}

	uint8_t count = 0;
	uint8_t outarray[] = {
		0b1000,0b1010,0b0010,0b0110,0b0100,0b0101,0b0001,0b1001};
void output(uint8_t input){
	switch(input){
		case (1):
			count = count - 2;
			break;
		case (2):
			count = count + 2;
			break;
		case (3):
			count = count - 1;
			break;
		case (4):
			count = count + 1;
			break;
		case (0):
			CLR_BITS(GPIOC->ODR,(0xFUL<<6));
			CLR_BITS(GPIOC->ODR,(1UL<<3));
			return;
	}
	count &= 0x7UL;
	//SET_BITS(GPIOC->ODR,(1UL<<3));
	FORCE_BITS(GPIOC->ODR,(0xF<<6),(outarray[count]<<6));
}

void LimitLeft_Init(void){
	RCC->AHBENR |= RCC_AHBENR_GPIOBEN;
	CLR_BITS(GPIOB->MODER,(3UL<<4));
}

void LimitRight_Init(void){
	RCC->AHBENR |= RCC_AHBENR_GPIOBEN;
	CLR_BITS(GPIOB->MODER,(3UL<<20));
}
