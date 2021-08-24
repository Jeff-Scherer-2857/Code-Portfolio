<?php
	include('php/pagesetup.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>

		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" type="text/css" href="css/userheader.css">
			
        <title>Elevator Control</title>
		<meta name="description" content="This is the design page"/>
        <meta name="robots" content="noindex nofollow" />
        <meta http-eqiv="author" content="Matt H" />
        <meta http-equiv="pragma" content="no-cache" />
	</head>

	<script src="js/control.js"></script>
        
        <body>

			<div id="userheader">
			
				<?php
					if ($_SESSION["status"] == 'active') {
						echo '<div id="userheaderbttn"><a href="php/wipesession.php">LOGOUT</a></div>';
						echo '<div id="userheadername">';
						echo $_SESSION['username'];
						echo '</div>';
						if ($_SESSION["admin"]) {
							echo '<div id="userheaderadmin">ADMIN</div>';
						}
					} else {
						echo '<div id="userheaderbttn"><a href="login.php">LOGIN</a></div>';
					}						
				?>
				
			</div>
            
			<header>
				<p class="headertitle">ELEVATOR CONTROL</p>
			</header>
			
			<nav>
				<a class="navbttn" href="index.php">HOME</a>
				<a class="navbttn" href="about.php">ABOUT</a>
				<a class="navbttn" href="stats.php">STATS</a>
			</nav>
			
			<main>
				
				<div id="websockbanner">
					CONNECTION STATUS: <div id="connstatus"><p style="color: rgb(255, 187, 0)">CONNECTING...</p></div>
				</div>
				
				<div id="siribanner">
					<div id="sirilabel">VOICE CONTROL: </div>
					<div id="siristatus" style="color: rgb(160,160,160)">IDLE</div>
					<img id="start_button" src="images/soundwave.png" alt="Siri" onmouseover="this.src='images/soundwaveOver.png';" onmouseout="this.src='images/soundwave.png';" onmousedown="document.getElementById('siristatus').innerHTML = 'LISTENING';setTimeout(resetSiri, 3000);" onclick="startButton(event)">
				</div>
				
				<div class="controlcolumn">
					<p class="controltitle">CONTROLS</p>
					<div class="controlcolumnleft">
						<div class="controlname">Floor 3</div>
						<div class="controlname">Floor 2</div>
						<div class="controlname">Floor 1</div>
						<div class="controlname">Emergency</div>
						<div class="controlname">Music</div>
					</div>
					<div class="controlcolumnright">
						<div class="controlbttn"><img class="controlbttnimg" id="floor3ind" src="images/floor3bttndark.png" alt="Floor 3" onmouseover="this.src='images/floor3bttn.png'" onmouseout="reqbttn_mouseout(3);" onclick="floorRequest(3); third.play()"></div>
						<div class="controlbttn"><img class="controlbttnimg" id="floor2ind" src="images/floor2bttndark.png" alt="Floor 2" onmouseover="this.src='images/floor2bttn.png'" onmouseout="reqbttn_mouseout(2);" onclick="floorRequest(2); second.play()"></div>
						<div class="controlbttn"><img class="controlbttnimg" id="floor1ind" src="images/floor1bttndark.png" alt="Floor 1" onmouseover="this.src='images/floor1bttn.png'" onmouseout="reqbttn_mouseout(1);" onclick="floorRequest(1); first.play()"></div>
						<div class="controlbttn"><img class="controlbttnimg" src="images/emergbttndark.png" alt="Emergency" onmouseover="this.src='images/emergbttn.png'" onmouseout="this.src='images/emergbttndark.png'" onclick="emergency.play()"></div>
						<div class="controlbttn"><img class="controlbttnimg" src="images/musicbttndark.png" alt="Elevator Music" onmouseover="this.src='images/musicbttn.png'" onmouseout="this.src='images/musicbttndark.png'" onclick="toggleplay()"></div>
					</div>
				</div>
			  
				<div class="statuscolumn">
					<p class="statustitle">STATUS</p>
					<div id="statusdisplaycontainer"><img id="statusdisplay" src="images/elevatorDisplay_1.png" alt="Elevator Display"></div>
					<div class="statuscolumnleft">
						<div class="statusname">3</div>
						<div class="statusname">2</div>
						<div class="statusname">1</div>
					</div>
					<div class="statuscolumncenter">
						<div class="callbttn"></div>
						<div class="callbttn"><img class="callbttnimg" id="call4" src="images/calledbttndarkdown.png" alt="Floor 3 Call" onmouseover="this.src='images/calledbttndown.png'" onmouseout="callbttn_mouseout(4);" onclick="floorCall(3,'down');down.play()"></div>
						<div class="callbttn"></div>
						<div class="callbttn"><img class="callbttnimg" id="call3" src="images/calledbttndarkup.png" alt="Floor 2 Call Up" onmouseover="this.src='images/calledbttnup.png'" onmouseout="callbttn_mouseout(3);" onclick="floorCall(2,'up'); up.play()"></div>
						<div class="callbttn"><img class="callbttnimg" id="call2" src="images/calledbttndarkdown.png" alt="Floor 2 Call Down" onmouseover="this.src='images/calledbttndown.png'" onmouseout="callbttn_mouseout(2);" onclick="floorCall(2,'down'); down.play()"></div>
						<div class="callbttn"></div>
						<div class="callbttn"><img class="callbttnimg" id="call1" src="images/calledbttndarkup.png" alt="Floor 1 Call Up" onmouseover="this.src='images/calledbttnup.png'" onmouseout="callbttn_mouseout(1);" onclick="floorCall(1,'up'); up.play()"></div>
					</div>
					<div class="statuscolumnright">
						<div class="indicator">
							<img class="indicator_large" id="floor3indicator" src="images/indicatorOff.png" alt="Location Indicator">
							
							<div class="indicator_spacer"></div>
							
							<img class="indicator_large" id="floor2indicator" src="images/indicatorOff.png" alt="Location Indicator">
							
							<div class="indicator_spacer"></div>
							
							<img class="indicator_large" id="floor1indicator" src="images/indicatorOff.png" alt="Location Indicator">
						</div>
					</div>
                </div>
            </main>
			
			<footer>
				This page is part of Engineering Project VI. &copy Matt H. 2020
			</footer>
        </body>
</html>