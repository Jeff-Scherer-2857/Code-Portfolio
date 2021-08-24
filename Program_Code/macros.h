/*	Header file for Macro Definitions
*		Written By: Jeff Scherer
*		Last Modified: 01/30/2019
* 	Conestoga College, Cambridge Campus
*/


//BIT Operation Macros
#define SET_BITS(port, mask) ((port)|=(mask))			//sets a designated bit
#define CLR_BITS(port, mask) ((port)&=~(mask))			//clears a designated bit
#define FLIP_BITS(port,mask) ((port)^=(mask))			//toggles a bit
#define FORCE_BITS(port, mask, value)\
			(port) = (port&~(mask))|(value&mask)

//GPIO Macros
#define PP 0
#define OD 1
#define IN 0
#define OUT 1
#define AF 2
#define ANALOG 3
#define GPIO_PIN_DRV_TYPE(port, pin, type) (FORCE_BITS(GPIOx(port)->OTYPER,(1UL<<(pin)), ((type)<<(pin))))		//Setting Pin to Open-Drain or Push-Pull
#define GPIO_PIN_MODE(port, pin, mode) (FORCE_BITS(GPIOx(port)->MODER,(3UL<<((pin)*2)),((mode)<<((pin)*2))))	//Setting pin type (In, Out, Alternative Function, Analog)
#define GPIO_PORT(port) GPIOx(port))							//Setting the GPIO Register
#define GPIOx(port) GPIO##port										//Merging the register to GPIO

//LCD Macros
#define LCD_PORT(port) GPIOx(port)->ODR											//GPIO Port connected to LCD Screen
#define LCD_E_BIT GPIO_ODR_12
#define LCD_RS_BIT GPIO_ODR_13
#define LCD_BUS_BIT 0x00F0
#define LO_NYBBLE(value) ((value)&0x0F)
#define HI_NYBBLE(value) (((value)>>4)&0x0F)
#define LCD_E_HI(port) SET_BITS(LCD_PORT(port), LCD_E_BIT)

#define LCD_E_LO(port) CLR_BITS(LCD_PORT(port), LCD_E_BIT)
#define LCD_BUS(nybble, port) FORCE_BITS(LCD_PORT(port), LCD_BUS_BIT, ((nybble)<<4))
#define LCD_RS_IR(port) CLR_BITS((LCD_PORT(port)),(LCD_RS_BIT))
#define LCD_RS_DR(port) SET_BITS((LCD_PORT(port)), (LCD_RS_BIT))

//Interrupt Handlers
#define InterruptEN asm("ISB;CPSIEI")
#define InterruptDIS asm("CPSIDI")
