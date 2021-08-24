/*	Embedded Controller Design (ECD) Semester 4 Test Code; Wheels.c file
*		Functions contained within this file will drive the two DC motors conntected to the wheels
*		As well as the two encoders connected to the wheels
*		Written by: Jeff Scherer
*		Bachelor of Engineering, Electronic Systems Engineering
*		Conestoga College, Cambridge, ON
*		Date: April 5, 2019
*/

#include "stm32f303xe.h"
#include "SysClock.h"
#include "Wheels.h"
#include "macros.h"


/*	Timer Initialization for Left motor
*		Timer connected to Enable pin of L6225 driver - PA8
*		TIM1, CHAN1 AF[6]
*/
void DCLeft_Init(void){
	//INITIALIZATION OF TIMER1, Channel 1
	SET_BITS(RCC->APB2ENR,RCC_APB2ENR_TIM1EN);				//ENABLE CLOCK ON TIMER1
	CLR_BITS(TIM1->CR1,TIM_CR1_DIR);									//timer counts up
	FORCE_BITS(TIM1->PSC,0xFFFF,67UL);								//Count at 1MHz
	FORCE_BITS(TIM1->ARR,0xFFFF,20000);								//PWM to 440Hz
	FORCE_BITS(TIM1->CCMR1,TIM_CCMR1_OC1M,TIM_CCMR1_OC1M_1|TIM_CCMR1_OC1M_2);
	SET_BITS(TIM1->CR1,TIM_CR1_ARPE);									//Enable register preload
	SET_BITS(TIM1->BDTR,TIM_BDTR_MOE);								//Enable main output
	SET_BITS(TIM1->CCER,TIM_CCER_CC1NE);							//enable complementary output
	SET_BITS(TIM1->CR1,TIM_CR1_CEN);									//enable counter
	
	//Initialization for EN1 Pin on 6225
	RCC->AHBENR |= RCC_AHBENR_GPIOAEN;
	CLR_BITS(GPIOA->MODER,(3UL<<16));
	SET_BITS(GPIOA->MODER,(1UL<<17));
	SET_BITS(GPIOA->AFR[1],0x6);
	GPIOE->OTYPER &= (1UL<<8);
	
	//Initialization for DC Left DIR1 -> PA0
	CLR_BITS(GPIOA->MODER,3UL);
	SET_BITS(GPIOA->MODER,1UL);
	
	//Initialization for DC Left DIR2-> PA1
	CLR_BITS(GPIOA->MODER,(3UL<<2));
	SET_BITS(GPIOA->MODER,(1UL<<2));
}

void DCLeft_Mov(uint16_t spd){
	FORCE_BITS(TIM1->CCR1,0xFFFFFFFF,spd);
	SET_BITS(GPIOA->ODR,2UL);
	CLR_BITS(GPIOA->ODR,1UL);
}

void DCLeft_Stp(void){
	FORCE_BITS(TIM1->CCR1,0xFFFFFFFF,0);
	CLR_BITS(GPIOA->ODR,3UL);
}

/*	Timer Initialization for Right motor
*		Timer connected to Enable pin of L6225 driver - PA9
*		TIM1, CHAN2 AF[6]
*/
void DCRight_Init(void){
	//INITIALIZATION OF TIMER1, Channel 2
	SET_BITS(RCC->APB2ENR,RCC_APB2ENR_TIM1EN);				//ENABLE CLOCK ON TIMER1
	CLR_BITS(TIM1->CR1,TIM_CR1_DIR);									//timer counts up
	FORCE_BITS(TIM1->PSC,0xFFFF,67UL);								//Count at 1MHz
	FORCE_BITS(TIM1->ARR,0xFFFF,20000);								//PWM to 440Hz
	FORCE_BITS(TIM1->CCMR1,TIM_CCMR1_OC2M,TIM_CCMR1_OC2M_1|TIM_CCMR1_OC2M_2);
	SET_BITS(TIM1->CR1,TIM_CR1_ARPE);									//Enable register preload
	SET_BITS(TIM1->BDTR,TIM_BDTR_MOE);								//Enable main output
	SET_BITS(TIM1->CCER,TIM_CCER_CC2NE);							//enable complementary output
	SET_BITS(TIM1->CR1,TIM_CR1_CEN);									//enable counter
	
	//Initialization for EN2 Pin on 6225-PA9
	RCC->AHBENR |= RCC_AHBENR_GPIOAEN;
	CLR_BITS(GPIOA->MODER,(3UL<<18));
	SET_BITS(GPIOA->MODER,(1UL<<19));
	SET_BITS(GPIOA->AFR[1],0x6);
	GPIOE->OTYPER &= (1UL<<8);
	
	//Initialization for DC Right DIR1 -> PB0
	RCC->AHBENR |= RCC_AHBENR_GPIOBEN;
	CLR_BITS(GPIOB->MODER,3UL);
	SET_BITS(GPIOB->MODER,1UL);
	
	//Initialization for DC Right DIR2-> PB1
	CLR_BITS(GPIOB->MODER,(3UL<<2));
	SET_BITS(GPIOB->MODER,(1UL<<2));
}

void DCRight_Mov(uint16_t spd){
	FORCE_BITS(TIM1->CCR2,0xFFFFFFFF,spd);
	SET_BITS(GPIOB->ODR,2UL);
	CLR_BITS(GPIOB->ODR,1UL);
}

void DCRight_Stp(void){
	FORCE_BITS(TIM1->CCR2,0xFFFFFFFF,0);
	CLR_BITS(GPIOB->ODR,3UL);
}
