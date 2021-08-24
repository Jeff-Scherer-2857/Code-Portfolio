

#include "stm32f303xe.h"
#include "SysClock.h"
#include "servo.h"
#include "macros.h"

/*	Timer Initialization for Encoders
*		Timer connected to PA6 and PA7
*		TIM3, CHAN1 AF[2] and CHAN2[2]
*/
void Enc_Init(void){
	//Configure GPIO Pin - PA.6 Connected to Timer 3, Channel 1
	SET_BITS(RCC->AHBENR,RCC_AHBENR_GPIOAEN);					//Enable clock for GPIO Port A
	FORCE_BITS(GPIOA->MODER, (0x3<<12), (0x2<<12));		//Set Pin PA.6 as Alternate Function
	SET_BITS(GPIOA->AFR[0], (2UL<<24));
	
	//Configure Timer 2 Input Capture
	SET_BITS(RCC->APB1ENR, RCC_APB1ENR_TIM3EN);				//Step 1: Enable the clock of Timer 2
	FORCE_BITS(TIM3->PSC, 0xFFFFFFFF, 30UL);					//Step 2: Set the prescaler to configure freq.
	
	SET_BITS(TIM3->CCMR1,TIM_CCMR1_CC1S_0);												//Select Active input for TIM2_CCR1
	CLR_BITS(TIM3->CCER, TIM_CCER_CC1P);							//Clear CC1P
	CLR_BITS(TIM3->CCER, TIM_CCER_CC1NP);							//Clear CC1NP
	CLR_BITS(TIM3->CCMR1, TIM_CCMR1_IC1PSC);					//Select Active input for CCR2
	SET_BITS(TIM3->CCER, TIM_CCER_CC1E);							//Enable the captures
	
	//Configure GPIO Pin - PA.7 Connected to Timer 3, Channel 2
	//SET_BITS(RCC->AHBENR,RCC_AHBENR_GPIOAEN);					//Enable clock for GPIO Port A
	FORCE_BITS(GPIOA->MODER, (0x3<<14), (0x2<<14));		//Set Pin PA.7 as Alternate Function
	SET_BITS(GPIOA->AFR[0], (2UL<<28));
	
	//Configure Timer 3 Input Capture
	SET_BITS(TIM3->CCMR1, TIM_CCMR1_CC2S_0);					//Select Active input for TIM2_CCR1
	CLR_BITS(TIM3->CCER, TIM_CCER_CC2P);							//Clear CC1P
	CLR_BITS(TIM3->CCER, TIM_CCER_CC2NP);							//Clear CC1NP
	CLR_BITS(TIM3->CCMR1, TIM_CCMR1_IC2PSC);					//Select Active input for CCR2
	SET_BITS(TIM3->CCER, TIM_CCER_CC2E);							//Enable the captures
	
	//Enable Interups
	SET_BITS(TIM3->DIER, TIM_DIER_UIE);		
	SET_BITS(TIM3->DIER, TIM_DIER_CC1IE);
	SET_BITS(TIM3->DIER, TIM_DIER_CC2IE);
	NVIC_EnableIRQ(TIM3_IRQn);
	
	SET_BITS(TIM3->CR1, TIM_CR1_CEN);
}

uint16_t volatile PWML;
uint16_t volatile PWMR;
//uint16_t volatile overflow = 0;
void TIM3_IRQHandler(void){
	static volatile uint16_t lastTimeL;
	static volatile uint16_t lastTimeR;
	if(TIM3->SR & TIM_SR_UIF){
		//overflow++;
		CLR_BITS(TIM3->SR, TIM_SR_UIF);
	}
	if(TIM3->SR & TIM_SR_CC1IF){
		PWML = TIM3->CCR1 - lastTimeL;
		lastTimeL = TIM3->CCR1;
		//overflow = 0;
	}
	if(TIM3->SR & TIM_SR_CC2IF){
		PWMR = TIM3->CCR2 - lastTimeR;
		lastTimeR = TIM3->CCR2;
	}
}
