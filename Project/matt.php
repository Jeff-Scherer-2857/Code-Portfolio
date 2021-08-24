<?php

	include('php/pagesetupuni.php');

?>
<!DOCTYPE html>
<html lang="en">
        <head>

			<link rel="stylesheet" type="text/css" href="css/style.css">
			<link rel="stylesheet" type="text/css" href="css/userheader.css">
			
            <title>Weekly Log Book - Matt Hengeveld</title>
			<meta name="description" content="This is the log book Matt Hengeveld"/>
			<meta name="robots" content="noindex nofollow" />
			<meta http-eqiv="author" content="Matt H" />
			<meta http-equiv="pragma" content="no-cache" />
        </head>
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
			
			<header  name="top">
				<p class="headertitle">Matthew Hengeveld</p>
			</header>
			
			<nav>
				<a class="navbttn" href="index.php">HOME</a>
				<a class="navbttn" href="about.php">ABOUT</a>
				<a class="navbttn" href="designs.php">DESIGN FILES</a>
				<a class="navbttn" href="control.php">ELEVATOR CONTROL</a>
			</nav>
			
			<main>

				<div class="controlcolumn">
					<p class="controltitle">ABOUT ME</p>
					<img class="aboutimg" src="images/matt.png" alt="ol' Me">
					<div class="abouttext">
						<p>Honors Degree in Computer Science and Physics from Wilfrid Laurier University</p>
						<p>3rd year Electonics Engineering Systems student at Conestoga College</p>
						<p>Courses this semester:</p>
						<ul>
							<li>Software Engineering - SENG73000</li>
							<li>Advanced Topics in Mathematics - MATH73235</li>
							<li>Data Communications and Network - INFO73180</li>
							<li>Thermodynamics - MECH73115</li>
							<li>Engineering Project VI - EECE73125</li>
						</ul>
					</div>
				</div>
			  
				<div class="statuscolumn">
					<p class="statustitle">LOG BOOK</p>
					<div class="log">
						<p class="logheader">Week 1</p>
						<ul>
							<li><div class="logdate">May 23:</div> Created Excel version of Gantt Chart</li>
							<li><div class="logdate">May 24:</div> Reviewed HTML pages & structure</li>
						</ul>
					</div>
					
					<div class="log">
						<p class="logheader">Week 2</p>
						<ul>
							<li><div class="logdate">May 25:</div> Progress report presented; Team meeting about tasks for next week.</li>
							<li><div class="logdate">May 28:</div> Started first draft of virtual controls and indicators design.</li>
							<li><div class="logdate">May 30:</div> Completed first draft of virtual controls and indicators design.</li>
							<li><div class="logdate">May 31:</div> Commented draft of virtual controls and indicators design. Asked for group review.</li>
							<li><div class="logdate">May 31:</div> Edited draft of virtual controls and indicators design after feedback from group.</li>
						</ul>
					</div>
					
					<div class="log">
						<p class="logheader">Week 3</p>
						<ul>
							<li><div class="logdate">June 1:</div> Progress report presented. Team meeting about feedback from progress report and next steps.</li>
							<li><div class="logdate">June 4:</div> Team meeting about current tasks. Started moving virtual controls and indicators design to control.html page. Started CSS style.</li>
							<li><div class="logdate">June 5:</div> Continued work on control.html file and associated CSS. Modified personal log book page to use CSS and theme.</li>
							<li><div class="logdate">June 6:</div> Finished work on control.html CSS. Had group meeting to see where everyone is and what still needs to be done. Started implementing CSS on remaining pages.</li>
							<li><div class="logdate">June 7:</div> Finished implementing CSS on remaining pages, including gantt chart.</li>
						</ul>
					</div>
					
					<div class="log">
						<p class="logheader">Week 4</p>
						<ul>
							<li><div class="logdate">June 11:</div> Attended meeting with Michael and group for STM32 and CAN filters.</li>
							<li><div class="logdate">June 13:</div> Updated all pages to use HTML5 tags. Started implementing more JavaScript features.</li>
						</ul>
					</div>
					
					<div class="log">
						<p class="logheader">Week 5</p>
						<ul>
							<li><div class="logdate">June 15:</div> Group meeting about weekly goals. Continued implementing javascript for form validation to login and request access pages.</li>
							<li><div class="logdate">June 16:</div> Finished implementing javascript for form validation to login and request access pages.</li>
							<li><div class="logdate">June 17:</div> Made basic PHP pages for submitted form data on login and request access pages. Tested login and request access pages' form validation and their respective PHP pages.</li>
							<li><div class="logdate">June 20:</div> Started implementing sessions.</li>
							<li><div class="logdate">June 21:</div> Showed my father what I'm doing in school. Made father proud.</li>
						</ul>
					</div>
					
					<div class="log">
						<p class="logheader">Week 6</p>
						<ul>
							<li><div class="logdate">June 22:</div> Group meeting about weekly goals.</li>
							<li><div class="logdate">June 22-27:</div> Worked on other coursework that was a higher priority.</li>
							li><div class="logdate">June 28:</div> Started to implement PHP Sessions and username/password login code on Login page. Updated database.</li>
						</ul>
					</div>
					
					<div class="log">
						<p class="logheader">Week 7</p>
						<ul>
							<li><div class="logdate">June 29:</div> Continued work on Sessions on login page. </li>
							<li><div class="logdate">June 30:</div> Finished Sessions and username/password login on login page. Started to implement sessions on remaining pages. Finished changes to database. </li>
							<li><div class="logdate">July 1:</div> Finished Sessions across entire site. </li>
							<li><div class="logdate">July 2:</div> Started modifications on Request Access page. </li>
							<li><div class="logdate">July 3:</div> Finsihed Request Access page. </li>
							<li><div class="logdate">July 4:</div> Started Request Access Admin page. </li>
							<li><div class="logdate">July 5:</div> Finished Request Access Admin page. </li>
						</ul>
					</div>
					
					<div class="log">
						<p class="logheader">Week 8</p>
						<ul>
							<li><div class="logdate">July 6:</div> Researched SSL. </li>
							<li><div class="logdate">July 7:</div> Concluded that SSL is not feasible without paying money. Implemented SHA1 encryption for all passwords. </li>
							<li><div class="logdate">July 8:</div> Studied for midterms. </li>
						</ul>
					</div>
					
					<div class="log">
						<p class="logheader">Week 9</p>
						<ul>
							<li><div class="logdate">July 14:</div> Started work on C++ server program: researched websocket, mysql and JSON libraries. </li>
							<li><div class="logdate">July 15:</div> Successfully installed libraries. Tested basic functionality of libraries </li>
							<li><div class="logdate">July 16:</div> Implemented bi-directional communication with server and control page using websockets (on home server) </li>
							<li><div class="logdate">July 17:</div> Implemented JSON for websockets (on home server) </li>
							<li><div class="logdate">July 18:</div> Implemented database updates when sent updates from control page (on home server). Implemented control page changes based on server status </li>
							<li><div class="logdate">July 19:</div> Fleshed out server code (on home server). Assisted on stats page </li>
						</ul>
					</div>
					
					<div class="log">
						<p class="logheader">Week 10</p>
						<ul>
							<li><div class="logdate">July 20-22:</div> Studied for math midterm. </li>
							<li><div class="logdate">July 25:</div> Implemented state machine for elevator.  </li>
						</ul>
					</div>
	
				</div>
				
			</main>
			
			<footer>
				<div style="padding:8px;"><a href="#top">Back to Top</a></div>
				This page is part of Engineering Project VI. &copy Matt H. 2020
			</footer>
			
        </body>
</html>