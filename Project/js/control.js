// ---------------------------------------------
		// WEBPAGE AUDIO
		// ---------------------------------------------
			
		//Audio for down button
		var down = new Audio();
		down.src="Audio/control/down.wav";

		//Audio for up button
		var up = new Audio();
		up.src="Audio/control/up.wav";

		//Audio for selecting first floor
		var first = new Audio();
		first.src="Audio/control/first.wav";

		//Audio for selecting second floor
		var second = new Audio();
		second.src="Audio/control/second.wav";

		//Audio for selecting third floor
		var third = new Audio();
		third.src="Audio/control/third.wav";

		//Audio for emergency button
		var emergency = new Audio();
		emergency.src="Audio/control/emergency.wav";
		emergency.volume=0.25;

		//Audio for elevator music
		var elevator = new Audio();
		elevator.src="Audio/control/elevator.wav";
		elevator.volume=0.25;
				
		//Function to play/pause elevator music
		function toggleplay(){
			if(elevator.paused){
				elevator.play();
			} else {
				elevator.pause();
			}
		}

		// ---------------------------------------------
		// WEBSOCKET
		// ---------------------------------------------
		const CMD_CALL = 67;		// ASCII 'C'; CALL floor commmand
		const CMD_SELECT = 83;		// ASCII 'S'; SELECT floor commmand
		const CMD_UPDATE = 85		// ASCII 'R'; UPDATE commmand
		const CMD_EMERG = 69;		// ASCII 'E'; EMERGENCY commmand
		
		//const websock = new WebSocket('ws://192.168.0.31:61415');	// MH local server
		//const websock = new WebSocket('ws://142.156.193.130:50024');	// VPN
		const websock = new WebSocket('ws://68.183.197.89:62054');	// Public
	
		var floor_calls = [0, 0, 0, 0];
		var floor_req = [0, 0, 0];

		function websock_init(websock) {
			
			// Websocket connect event listener
			websock.addEventListener('open', function(event) {
				console.log('WS connected');
				document.getElementById("connstatus").innerHTML = '<p style="color: rgb(0,145,2)"> CONNECTED </p>';
			});
			
			// Websocket message event listener
			websock.addEventListener('message', function(event) {
				console.log('WS Message from server: ', event.data);
			
				// get rid of extra characters out front & parse
				var bracketpos = event.data.indexOf('{');	// parse fails without this!
				var messageobj = JSON.parse(event.data.substr(bracketpos, event.data.length));
				
				switch(messageobj.cmd) {
					case CMD_UPDATE:
						console.log("Update received.\n");
						
						// change floor display img
						var floordisplaystring = '';
						if (messageobj.travelling) {
							if (messageobj.current_floor > messageobj.prev_floor) {
								document.getElementById("statusdisplay").src = 'images/elevatorDisplay_down.png';
							} else if (messageobj.current_floor < messageobj.prev_floor) {
								document.getElementById("statusdisplay").src = 'images/elevatorDisplay_up.png';
							}										
						} else {
							floordisplaystring = 'images/elevatorDisplay_' + messageobj.current_floor + '.png';								
							document.getElementById("statusdisplay").src = floordisplaystring;

							for (var i=0; i<3; i++) {
								document.getElementById('floor' + (i+1) + 'indicator').src = 'images/indicatorOff.png';
							}
							document.getElementById('floor' + messageobj.current_floor + 'indicator').src = 'images/indicatorOn.png';
						}
						
						// change floor call buttons
						for (var i=0; i<4; i++) {
							if (messageobj.calls[i]) {
								if (i == 0) {
									document.getElementById('call1').src = 'images/calledbttnup.png';
									floor_calls[0] = 1;
								} else if (i == 1) {
									document.getElementById('call2').src = 'images/calledbttndown.png';
									floor_calls[1] = 1;
								} else if (i == 2) {
									document.getElementById('call3').src = 'images/calledbttnup.png';
									floor_calls[2] = 1;
								} else if (i == 3) {
									document.getElementById('call4').src = 'images/calledbttndown.png';
									floor_calls[3] = 1;
								}
							} else {
								if (i == 0) {
									document.getElementById('call1').src = 'images/calledbttndarkup.png';
									floor_calls[0] = 0;
								} else if (i == 1) {
									document.getElementById('call2').src = 'images/calledbttndarkdown.png';
									floor_calls[1] = 0;
								} else if (i == 2) {
									document.getElementById('call3').src = 'images/calledbttndarkup.png';
									floor_calls[2] = 0;
								} else if (i == 3) {
									document.getElementById('call4').src = 'images/calledbttndarkdown.png';
									floor_calls[3] = 0;
								}
							}
						}
						
						// change floor request buttons
						if (messageobj.fifo.includes(3)) {
							document.getElementById('floor3ind').src = 'images/floor3bttn.png';
							floor_req[2] = 1;
						} else {
							document.getElementById('floor3ind').src = 'images/floor3bttndark.png';
							floor_req[2] = 0;
						}
						if (messageobj.fifo.includes(2)) {
							document.getElementById('floor2ind').src = 'images/floor2bttn.png';
							floor_req[1] = 1;
						} else {
							document.getElementById('floor2ind').src = 'images/floor2bttndark.png';
							floor_req[1] = 0;
						} 
						if (messageobj.fifo.includes(1)) {
							document.getElementById('floor1ind').src = 'images/floor1bttn.png';
							floor_req[0] = 1;
						} else {
							document.getElementById('floor1ind').src = 'images/floor1bttndark.png';
							floor_req[0] = 0;
						}
					
						break;
					
					case CMD_SELECT:
						//console.log("Floor select received.\n");
						break;
					
					case CMD_CALL:
						//console.log("Floor call received.\n");
						break;
						
					case CMD_EMERG:
						console.log("Emergency!\n");
						break;
						
					default:
						console.log("Uknown command received.\n");
						break;
				}
				
			});
			
			// Websocket message event listener
			websock.addEventListener('close', function(event) {						
				document.getElementById("connstatus").innerHTML = '<p style="color: rgb(212, 53, 0)"> CONNECTION ERROR: PLEASE RELOAD PAGE</p>';
			});
		}
		
		// send floor request function
		function floorRequest(floorNum) {
			var message = {'cmd':CMD_SELECT, 'floor':floorNum};
			console.log(message);
			websock.send(JSON.stringify(message));
		}
		
		// send floor call function
		function floorCall(floorNum,dir) {
			var message = {'cmd':CMD_CALL, 'floor':floorNum, 'dir':dir};
			console.log(message);
			websock.send(JSON.stringify(message));
		}
		
		// call onmoouseout function (keeps lit buttons lit)
		function callbttn_mouseout(callbttn) {
			if (floor_calls[callbttn-1] == 1) {
				if (callbttn == 1 || callbttn == 3) {
					document.getElementById('call' + callbttn).src = 'images/calledbttnup.png';
				} else {
					document.getElementById('call' + callbttn).src = 'images/calledbttndown.png';
				}
			} else {
				if (callbttn == 1 || callbttn == 3) {
					document.getElementById('call' + callbttn).src = 'images/calledbttndarkup.png';
				} else {
					document.getElementById('call' + callbttn).src = 'images/calledbttndarkdown.png';
				}
			}
		}
		
		// request onmouseout function (keeps lit buttons lit)
		function reqbttn_mouseout(reqbttn) {
			if (floor_req[reqbttn-1] == 1) {
				document.getElementById('floor' + reqbttn + 'ind').src = 'images/floor' + reqbttn + 'bttn.png';
			} else {
				document.getElementById('floor' + reqbttn + 'ind').src = 'images/floor' + reqbttn + 'bttndark.png';
			}
		}

		//code soucred from: https://github.com/googlearchive/webplatform-samples/blob/master/webspeechdemo/webspeechdemo.html
		// ---------------------------------------------
		// VOICE CONTROL
		// ---------------------------------------------
					
		// Siri button event listener
		var siribttn = document.getElementById("siribttn");
		var siristatus = document.getElementById("siristatus");
					
		function resetSiri() {
			document.getElementById("siristatus").innerHTML = 'IDLE';
		};
						
		var finalSpeech = '';
		var ignore_onEnd;
					
				
		if (!('webkitSpeechRecognition' in window)) {						//check for web speech API
			alert("Please upgrade your browser for Speech Rocognition.");	//if user does not have web speech API, user should upgrade browser
		} else {
			var recognition = new webkitSpeechRecognition();
						
			recognition.continuous = true;
			var recognizing = false;
			//recognition.interimResults = true;

			recognition.onStart = function(){
				recognizing = true;
			};

			recognition.onError = function(event) {
				if (event.error == 'no-speech') {
					alert("No speech detected.");
					ignore_onEnd = true;
				}
				if (event.error == 'audio-capture') {
					alert("No audio capture device detected.");
					ignore_onEnd = true;
				}
				if (event.error == 'not-allowed') {
					alert("Speech detection not enabled.");
					ignore_onEnd = true;
				}
			};
						  
			recognition.onEnd = function() {
				recognizing = false;
				if(ignore_onEnd){
					return;
				}
				if(!finalSpeech){
					alert("No speech detected.");
					return;
				}
			};
			
			recognition.onresult = function(event) {
								
				for(var i = 0; i < event.results.length; ++i) {
					if(event.results[i].isFinal){
						finalSpeech += event.results[i][0].transcript;
					}
				}

				for(var i = 0; i < finalSpeech.length; ++i) {
					var voicefloor = 0;
					if (finalSpeech.search('1') || finalSpeech.search("one")) {
						voicefloor = 1;
					} else if (finalSpeech.search('2') || finalSpeech.search("two")) {
						voicefloor = 2;
					} else if (finalSpeech.search('3') || finalSpeech.search("three")) {
						voicefloor = 3;
					}
								
					if (finalSpeech.search("up")) {
						floorCall(voicefloor,'up');
					} else if (finalSpeech.search("down")){
						floorCall(voicefloor,'down');
					} else if (finalSpeech.search("request")) {
						floorRequest(voicefloor);
					}
				}
				alert("Floor" + floor + "was selected via voice command.");
			};//end onresult
		} 
					
		function startButton(event){ //something wrong here
			alert("We hear all.");
			if(recognizing){
				recognition.stop();
				alert("Voice on");
				return;
			}
			finalSpeech = '';
			recognition.start();
			ignore_onend = false;
		}
		
					
									
		// WINDOW ONLOAD FUNCTIONS
		window.onload = websock_init(websock);