<?php

	include('php/pagesetupuni.php');

?>
<!DOCTYPE html>
<html lang="en">
    <head>

		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" type="text/css" href="css/userheader.css">
		
        <title>Weekly Log Book - Victor Palczewski</title>
        <meta name="description" content="This is the log book of Victor Palczewski"/>
        <meta name="robots" content="noindex nofollow" />
        <meta http-eqiv="author" content="Victor P" />
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
            <p id=top class="headertitle">Victor Palczewski</p>
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
                <img class="aboutimg" src="images/victor.jpg" alt="Picture of Victor P">
                <p class="abouttext">Currently a 3rd year student studying Electonics Engineering Systems at Conestoga College</p>
                <p class="abouttext">Highest degree/diploma completed: Highschool</p>
                <p class="abouttext">Courses this semester:</p>
                <ul class="abouttext">
                    <li>Software Engineering - SENG73000</li>
                    <li>Advanced Topics in Mathematics - MATH73235</li>
                    <li>Data Communications and Network - INFO73180</li>
                    <li>Thermodynamics - MECH73115</li>
                    <li>Introduction to Natural Science - SCIE71000</li>
                    <li>Engineering Project VI - EECE73125</li>
                </ul>

            </div>
          
            <div class="statuscolumn">
                <p class="statustitle">LOG BOOK</p>
                <div class="log">
                    <p class="logheader">Week 1</p>
                    <ul>
                        <li><div class="logdate">May 21, 2020:</div> Created the first meeting minutes document for week 1</li>
                        <li><div class="logdate">May 22, 2020:</div> Discussed team roles further, I was assigned the task of implementing the Gantt Chart into our website</li>
                        <li><div class="logdate">May 23, 2020:</div> Finished implementing the Gantt Chart page of our website</li>
                    </ul>
                </div>
                
                <div class="log">
                    <p class="logheader">Week 2</p>
                    <ul>
                        <li><div class="logdate">May 24, 2020:</div> Created the second meeting minutes document for week 2</li>
                        <li>Started to look at the CAN functionality during the week and what it takes to implement basic filters</li>
                        <li><div class="logdate">May 31, 2020:</div> Finished creating a local repo that I can practice CSS and HTML on</li>
                    </ul>
                </div>
                
                <div class="log">
                    <p class="logheader">Week 3</p>
                    <ul>
                        <li><div class="logdate">June 2, 2020:</div> Continued to work on the website, adding meta tags, a map etc.</li>
                        <li><div class="logdate">June 4, 2020:</div> Worked on the STM32 board and configured loopback mode</li>
                        <li><div class="logdate">June 5, 2020:</div> Continued to look at how to use the CAN filters</li>
                    </ul>
                </div>
                <div class="log">
                    <p class="logheader">Week 4</p>
                    <ul>
                        <li><div class="logdate">June 8, 2020:</div> Created the fourth meeting minutes document for week 4</li>
                        <li><div class="logdate">June 10, 2020:</div> Started on the status document for week 4</li>
                        <li><div class="logdate">June 11, 2020:</div> With the help of Michael, we finally figured out how the STM worked with filters</li>
                    </ul>
                </div>
                <div class="log">
                    <p class="logheader">Week 5</p>
                    <ul>
                        <li><div class="logdate">June 15, 2020:</div> Created the fifth meeting minutes document for week 5</li>
                        <li><div class="logdate">June 16, 2020:</div> Started on the status document for week 5</li>
                        <li><div class="logdate">June 20, 2020</div>Played Jenga for what seemed like 6 hours with my pet hamster. He won.</li>
                    </ul>
                </div>
                <div class="log">
                    <p class="logheader">Week 6/7</p>
                    <ul>
                        <li><div class="logdate">June 22, 2020:</div> Created the sixth meeting minutes document for week 6</li>
                        <li><div class="logdate">June 25, 2020:</div> Created the seventh meeting minutes document for week 7</li>
                        <li><div class="logdate">July 4, 2020:</div> Started to research different possible diagnostic options for the elevator (call elevator through phone etc.)</li>
                    </ul>
                </div>
                <div class="log">
                    <p class="logheader">Week 8</p>
                    <ul>
                        <li><div class="logdate">July 6, 2020:</div> Created the 8th meeting minutes document for week 8</li>
                        <li><div class="logdate">June 25, 2020:</div> Created a basic diagnostics table on the elevator schema on the Rpi - will add more info as it becomes available</li>
                    </ul>
                </div>
                <div class="log">
                    <p class="logheader">Week 9</p>
                    <ul>
                        <li><div class="logdate">July 13, 2020:</div> Created the 9th meeting minutes document for week 9</li>
                        <li><div class="logdate">July 18, 2020:</div> Kept working on the basic diagnostic communications between the pi and the website</li>
                        <li><div class="logdate">July 19, 2020:</div> Kept working on the basic diagnostic communications however, Matt stepped in since I was getting nowhere by myself</li>
                    </ul>
                </div>
            </div>
            
        </main>
        
        <footer>
			<div style="padding:8px;"><a href="#top">Back to Top</a></div>
            This page is part of Engineering Project VI. &copy Victor P 2020 <br />
        </footer>
    </body>
</html>
