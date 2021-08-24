//Uses code from Michael Galle
#ifndef PCAN_FUNCTIONS
#define PCAN_FUNCTIONS

/******************Defines********************/
//ARE THESE PREDEFINED??
#define ID_SC  0x100	// Supervisory controller ID (to EC)
#define ID_EC  0x101	// Elevator controller ID (to all nodes)
#define ID_CC  0x200	// Car controller ID (to SC)
#define ID_F1  0x201	// Floor 1 ID (to SC)
#define ID_F2  0x202	// Floor 2 ID (to SC)
#define ID_F3  0x203	// Floor 3 ID (to SC)	

#define GO_TO_FLOOR1 0x05	// Go to floor 1
#define GO_TO_FLOOR2 0x06	// Go to floor 2
#define GO_TO_FLOOR3 0x07	// Go to floor 3

#endif
