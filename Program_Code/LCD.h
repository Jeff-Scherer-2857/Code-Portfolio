#include "stm32f303xe.h"

void LCDinit(void);
void LCDdata(uint8_t value);
void Delay_us(uint16_t delay);
void Delay_ms(uint32_t delay);
void Delay_s(uint32_t delay);
void LCDputc(uint8_t value);
void LCDputs(char *string);
void LCDprintf(uint8_t *phrase);
void LCDclear(void);
void LCDcmd(uint8_t value);


//Project Functions
void command(char i);
void write(char i);
void Nybble(void);
void Board_LCDInit(void);
