<?php

	include('php/pagesetupuni.php');

?>
<!DOCTYPE html>
<html lang="en">
    <head>
	
        <link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" type="text/css" href="css/userheader.css">
		
        <title>Weekly Log Book - Kevin MacIntosh</title>
        <meta name="description" content="This is the log book Kevin MacIntosh"/>
        <meta http-eqiv="author" content="Kevin M" />
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
            <p class="headertitle">Kevin MacIntosh</p>
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
                <img class="aboutimg" src="images/kevin.jpg" alt="Picture of Kevin MacIntosh" title="Kevin MacIntosh">
                <p class="abouttext"> 3rd year student in the ESE program at Conestoga College. 
                    Still trying to figure out a way to use his degree to make real dinosaurs.
                </p>
            </div>
          
            <div class="statuscolumn">
                <p class="statustitle">LOG BOOK</p>
                <div class="log">
                    <p class="logheader">Week 1</p>
                    <ul>
                        <li><div class="logdate">May 22, 2020:</div> Discussed specifics of team rolls, assigned completing Gantt chart</li>
                        <li><div class="logdate">May 23, 2020:</div> Assigned rolls in Gantt chart to team, completed weekly log book.</li>
                    </ul>
                </div>
                
                <div class="log">
                    <p class="logheader">Week 2</p>
                    <ul>
                        <li><div class="logdate">May 25, 2020:</div> Discussed progress with insturctors, and revised schedule wuith team members.</li>
                        <li><div class="logdate">May 29, 2020:</div> Developed state diagram for elevator operation.</li>
                        <li><div class="logdate">May 30, 2020:</div> Updated about page with picture.</li>
                        <li><div class="logdate">May 31, 2020:</div> Updated homepage, weekly log functionality, created final state diagram, added logic page.</li>
                    </ul>
                </div>
                
                <div class="log">
                    <p class="logheader">Week 3</p>
                    <ul>
                        <li><div class="logdate">June 1, 2020:</div> Discussed plans to complete STM code.</li>
                        <li><div class="logdate">June 2, 2020:</div> Added a map and ids to the about page.</li>
                        <li><div class="logdate">June 4, 2020:</div> Began implementing CSS from assignment 1.</li>
                        <li><div class="logdate">June 5, 2020:</div> Continue to implement CSS and update logbook page.</li>
                        <li><div class="logdate">June 7, 2020:</div> CAN functionality for STM.</li>
                    </ul>
                </div>

                <div class="log">
                    <p class="logheader">Week 4</p>
                    <ul>
                        <li><div class="logdate">June 8, 2020:</div> Discussed plans to start database</li>
                        <li><div class="logdate">June 13, 2020:</div> Created databse following Software slides.</li>
                        <li><div class="logdate">June 14, 2020:</div> Attempted to get databse to work with user input.</li>
                    </ul>
                </div>
                <div class="log">
                    <p class="logheader">Week 5</p>
                    <ul>
                        <li><div class="logdate">June 15, 2020:</div> Discussed plans to further implement databases and general project direction.</li>
                        <li><div class="logdate">June 21, 2020:</div> Made working test page on own machine and rolled out to live version.</li>
                    </ul>
                </div>
                <div class="log">
                    <p class="logheader">Week 6/7</p>
                    <ul>
                        <li><div class="logdate">June 22, 2020:</div> Discussed plans for login access, audio, IFTTT voice command and diagnostic options.</li>
                        <li><div class="logdate">June 28 - July 1, 2020:</div> Recouperated team members moral at cottage.</li>
                        <li><div class="logdate">July 3, 2020:</div> Researched and began work on implementing IFTTT voice commands.</li>
                        <li><div class="logdate">July 4, 2020:</div> Continued work on implementing IFTTT voice commands.</li>
                    </ul>
                </div>
                <div class="log">
                    <p class="logheader">Week 8</p>
                    <ul>
                        <li><div class="logdate">July 6, 2020:</div> Discussed plans for voice command and looking forward in project.</li>
                        <li><div class="logdate">July 10, 2020:</div> Continued work on implementing IFTTT voice commands.</li>
                    </ul>
                </div>
                <div class="log">
                    <p class="logheader">Week 9</p>
                    <ul>
                        <li><div class="logdate">July 13, 2020:</div> Discussed plans for voice command and finishing phase 2.</li>
                        <li><div class="logdate">July 22, 2020:</div> Decided to switch from IFTTT to a voice recognition API. Started implementation.</li>
                        <li><div class="logdate">July 25, 2020:</div> Continued implementation of voice recognition API.</li>
                        <li><div class="logdate">July 26, 2020:</div> Team meeting for final rundown of phase 2. Put voice recognition API on hold until phase 3.</li>
                    </ul>
                </div>
                <div class="log">
                    <p class="logheader">Week 10</p>
                    <ul>
                        <li><div class="logdate">July 20, 2020:</div> Discussed plans for phase 3, decided to put voice control on hold and work on CAN instead.</li>
                        <li><div class="logdate">July 26, 2020:</div> CAN communication code started.</li>
                    </ul>
                </div>
            </div>
            
        </main>
        
        <footer>
			<div style="padding:8px;"><a href="#top">Back to Top</a></div>
            This page is part of Engineering Project VI. © Kevin M 2020
        </footer>
        
    </body>
</html>   

        
        

