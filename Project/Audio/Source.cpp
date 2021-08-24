#include <iostream>
#include <Windows.h>
using namespace std;

int main() {
	
	while (1) {
		int x;
		
		cout << "\nWhat floor would you like to go to?";
		cin >> x;

		if (x == 1) {
			cout << "\nDoors closing, please stand clear";
			PlaySound(TEXT("dc_1f_do.wav"), NULL, SND_SYNC);
			cout << "\nArriving at floor: " << x;
			PlaySound(TEXT("floor1.wav"), NULL, SND_SYNC);
			Sleep(50);
			PlaySound(TEXT("go_up.wav"), NULL, SND_SYNC);
		}
		else if (x == 2) {
			cout << "\nDoors closing, please stand clear";
			PlaySound(TEXT("dc_1f_do.wav"), NULL, SND_SYNC);
			cout << "\nArriving at floor: " << x;
			PlaySound(TEXT("floor2.wav"), NULL, SND_SYNC);
		}
		else if (x == 3) {
			cout << "\nDoors closing, please stand clear";
			PlaySound(TEXT("dc_1f_do.wav"), NULL, SND_SYNC);
			cout << "\nArriving at floor: " << x;
			PlaySound(TEXT("floor3.wav"), NULL, SND_SYNC);
			Sleep(50);
			PlaySound(TEXT("go_down"), NULL, SND_SYNC);
		}
		else {
			cout << "\nThat was not a valid input, please enter a valid floor #";
			PlaySound(TEXT("invalid.wav"), NULL, SND_SYNC);
		}
	}
	return 0;
}