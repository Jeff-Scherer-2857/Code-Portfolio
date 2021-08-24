/*	Embedded Controller Design (ECD) Semester 4 Test Code; Servo.c implementation file
*		Functions in this file are responsible for initializing the timer (TIM2, CHAN4) 
*		used to operate the servo motor connected to the camera module of the robot
*		Written by: Jeff Scherer
*		Bachelor of Engineering, Electronic Systems Engineering
*		Conestoga College, Cambridge, ON
*		Date: March 29, 2019
*/

#include "stm32f303xe.h"
#include "SysClock.h"
#include "servo.h"
#include "macros.h"

void Servo_Tim(void){
	SET_BITS(RCC->APB1ENR,RCC_APB1ENR_TIM2EN);				//ENABLE CLOCK ON TIMER2
	//INITIALIZATION OF TIMER2
	CLR_BITS(TIM2->CR1,TIM_CR1_DIR);									//timer counts up
	FORCE_BITS(TIM2->PSC,0xFFFF,67UL);								//Count at 1MHz
	FORCE_BITS(TIM2->ARR,0xFFFFFFFF,20000);								//PWM to 440Hz
	FORCE_BITS(TIM2->CCMR2,TIM_CCMR2_OC4M,TIM_CCMR2_OC4M_1|TIM_CCMR2_OC4M_2);
	SET_BITS(TIM2->CCMR2,TIM_CCMR2_OC4PE);
	SET_BITS(TIM2->BDTR,TIM_BDTR_MOE);								//Enable main output
	SET_BITS(TIM2->CCER,TIM_CCER_CC4E);								//enable complementary output
	FORCE_BITS(TIM2->CCR4,0xFFFFFFFF,600UL);				
	SET_BITS(TIM2->CR1,TIM_CR1_CEN);									//enable counter
}

void Servo_Init(void){
	RCC->AHBENR |= RCC_AHBENR_GPIOBEN;
	FORCE_BITS(GPIOB->MODER,0x3<<22,0x2<<22);
	SET_BITS(GPIOB->AFR[1],(1UL<<12));
	GPIOB->OTYPER &= (1UL<<11);
}

void Mov_Servo(uint32_t val){
	FORCE_BITS(TIM2->CCR4,0xFFFFFFFF,val);
	return;
}
