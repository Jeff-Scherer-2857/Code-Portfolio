<?php

	include('php/pagesetupuni.php');

?>
<!DOCTYPE html>
<html lang="en">
        <head>

			<link rel="stylesheet" type="text/css" href="css/style.css">
			<link rel="stylesheet" type="text/css" href="css/userheader.css">
			
            <title>Project VI - About</title>
            <meta name="description" content="This is the about page of our project"/>
            <meta name="robots" content="noindex nofollow" />
            <meta http-equiv="author" content="Jeff S" />
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

            <header>
				<p class="headertitle">Project VI - About</p>
            </header>

            <nav>
				<a class="navbttn" href="index.php">HOME</a>
				<a class="navbttn" href="about.php">ABOUT</a>
				<a class="navbttn" href="designs.php">DESIGN FILES</a>
				<a class="navbttn" href="control.php">ELEVATOR CONTROL</a>
			</nav>
            
            <main>

                <div class="controlcolumn">
                    <p class="controltitle">ABOUT THE PROJECT</p>
                    <img class="aboutimg" src="images/fig1.jpg" alt="Project Blocks">
					<p class="abouttext"> Welcome to the <i>about</i> page for <b>Project VI</b>. <br />This is where we will provide an overview of our project. Each member will have an individual page to keep track of weekly action items in a formal Log Book. <br />
                        This project will be to control an elevator with the use of CAN bus communications.
                        This project will also track the elevator's operational data nad diagnostic data over networked systems. <br />
                        For a full project description; including individual phases, action items, and outcomes, view the <a href="Project_Charter.pdf">Project Charter</a> <br />
                        For a breakdown of our Project Schedule, please view our <a href="gantt.php">Project Schedule</a>
					</p>
                </div>

                <div class="statuscolumn">
                    <p class="statustitle">Our Team</p>
    
                    <div class="log">
                        <p class="logheader"><b><a href="jeff.php">Jeff Scherer</a></b></p>
                        <ul>
                            <li>An eager 3rd year student still grasping on to his 20's.</li>
                        </ul>
                    </div>
    
                    <div class="log">
                        <p class="logheader"><b><a href="kevin.php">Kevin MacIntosh</a></b></p>
                        <ul>
                            <li>Carrying the team for now, until my back gives out.</li>
                        </ul>
                    </div>

                    <div class="log">
                        <p class="logheader"><b><a href="matt.php">Matt Hengeveld</a></b></p>
                        <ul>
                            <li> Just trying to keep up with these damn kids!</li>
                        </ul>
                    </div>

                    <div class="log">
                        <p class="logheader"><b><a href="victor.php">Victor Palczewski</a></b></p>
                        <ul>
                            <li>  The young guy teaching these old folk what the internet is.</li>
                        </ul>
                    </div>
                </div>

                <div class="map">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2899.52587161604!2d-80.39901898451085!3d43.386936879131355!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x882b8a7ec9d60715%3A0xd5e712873de8af2d!2sConestoga%20College%20-%20Cambridge%20Campus!5e0!3m2!1sen!2sca!4v1591138147663!5m2!1sen!2sca" 
                        width="590" 
                        height="450" 
                        frameborder="0"
                        allowfullscreen="" 
                        aria-hidden="false" 
                        tabindex="0">
                    </iframe>
                    <h6 id="map"><i>Map of the Conestoga College Cambridge Campus</i></h6>
                </div>
                <div class="map">
                    <iframe width="590" height="450" src="https://www.youtube.com/embed/jWYh-hALizA" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
                    </iframe>
                    <h6 id="map"><i>Team Intro Video</i></h6>
                </div>
				

                
            </main>
			
			<footer style="padding-top: 50px;">
				This page is part of Engineering Project VI. &copy Jeff S 2020
			</footer>
        </body>
</html>
