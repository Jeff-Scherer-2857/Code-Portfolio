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

void UART1_Init(void) {
	// Enable the clock of USART 1
	RCC->APB2ENR |= RCC_APB2ENR_USART1EN;  // Enable USART 1 clock		
	
	// Enable the peripheral clock of GPIO Port C 
	RCC->AHBENR |=   RCC_AHBENR_GPIOCEN;
	
	/* 	Input(00), Output(01), AlterFunc(10), Analog(11)
	*		Rx and Tx are on adjacent GPIO ports, can clear/set using 4-bit value in 2-bit registers
	*		and 2-bit values in 1-bit registers
	*/
	CLR_BITS(GPIOC->MODER,(0xF<<8));	// pre clear bits
	SET_BITS(GPIOC->MODER,(0xA<<8));	//Set to Alternate Function
	SET_BITS(GPIOC->AFR[0], (0x77<<16));   // Specify AF7 which is UART1 Tx & Rx
	
	// GPIO Speed: Low speed (00), Medium speed (01), Fast speed (10), High speed (11)
	SET_BITS(GPIOC->OSPEEDR,(0xF<<8));			//Set to high-speed 					 	
	// GPIO Push-Pull: No pull-up, pull-down (00), Pull-up (01), Pull-down (10), Reserved (11)
	CLR_BITS(GPIOC->PUPDR,(0xF<<8));
	SET_BITS(GPIOC->PUPDR,(0x5<<8)); //Set as Pull-up registers   				
	// GPIO Output Type: Output push-pull (0, reset), Output open drain (1) 
	CLR_BITS(GPIOC->OTYPER,(0x3<<4));	//Set as push-pull registers  
	
	USART1->CR1 &= ~USART_CR1_UE;  // Disable USART
	
	// Configure word length to 8 bit
	CLR_BITS(USART1->CR1,USART_CR1_M);   // M: 00 = 8 data bits, 01 = 9 data bits, 10 = 7 data bits
	
	// Configure oversampling mode: Oversampling by 16 
	CLR_BITS(USART1->CR1,USART_CR1_OVER8);  // 0 = oversampling by 16, 1 = oversampling by 8
	
	// Configure stop bits to 1 stop bit
	//   00: 1 Stop bit;      01: 0.5 Stop bit
	//   10: 2 Stop bits;     11: 1.5 Stop bit
	CLR_BITS(USART1->CR2,USART_CR2_STOP);   
                         
	// CSet Baudrate to 9600 using APB frequency (80,000,000 Hz)
	// If oversampling by 16, Tx/Rx baud = f_CK / USARTDIV,  
	// If oversampling by 8,  Tx/Rx baud = 2*f_CK / USARTDIV
  // When OVER8 = 0, BRR = USARTDIV
	// USARTDIV = 80MHz/9600 = 8333 = 0x208D
	USART1->BRR  = 7125; // Limited to 16 bits

	SET_BITS(USART1->CR1,(USART_CR1_RE | USART_CR1_TE));  	// Transmitter and Receiver enable
	
	SET_BITS(USART1->CR1,USART_CR1_UE); // USART enable                 
	
	while ( (USART1->ISR & USART_ISR_TEACK) == 0); // Verify that the USART is ready for reception
	while ( (USART1->ISR & USART_ISR_REACK) == 0); // Verify that the USART is ready for transmission
	
	//Enable Sending and Receiving Interrupts
	SET_BITS(USART1->CR1,USART_CR1_RXNEIE);				//receive register not empty interrupt
	CLR_BITS(USART1->CR1, USART_CR1_TXEIE);				//transmit register empty interrupt
	NVIC_SetPriority(USART1_IRQn,0);							//Set to highest priority
	NVIC_EnableIRQ(USART1_IRQn);									//Enable NVIC Interrupt
}


uint8_t volatile Value;
void USART1_IRQHandler(void){
	if(USART1->ISR & USART_ISR_RXNE){										//Check RXNE event
		Value = USART1->RDR;					//Reading RDR clears the RXNE flag
	}
}


void UARTprintf(uint8_t *str){
	//finding the length of str
	uint32_t length = strlen(str);
	
	//for() loop for transmitting my name
	for(uint8_t x = 0; x < length; x++){
		while(!(USART1->ISR & USART_ISR_TXE));			//waiting for TXE flag goes high
		USART1->TDR = (uint8_t)*str++;							//passing in next char
	}
}

void Menu_Print(void){
	uint8_t transmit[] = {
		"\rEnter what test you would like to run;\n\r1 - LCD Test\n\r2 - Stepper Motor Test\n\r3 - Servo Motor Test\n\r4 - DC Motor Test\n\r5 - Encoder Test\n\n\rRun Test #: \n"
	};
	UARTprintf(transmit);
}
