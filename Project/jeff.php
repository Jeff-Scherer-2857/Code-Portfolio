<?php

	include('php/pagesetupuni.php');

?>
<!DOCTYPE html>
<html lang="en">
        <head>
		
			<link rel="stylesheet" type="text/css" href="css/style.css">
			<link rel="stylesheet" type="text/css" href="css/userheader.css">
			
            <title>Weekly Log Book - Jeff Scherer</title>
			<meta name="description" content="This is the log book Jeff Scherer"/>
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
			
			<header name="top">
				<p class="headertitle">Jeff Scherer</p>
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
					<img class="aboutimg" src="images/jeff.jpg" alt="It's Me, Jeff">
					<p class="abouttext"> A 3rd year Engineering student at Conestoga College.
						I am considered the "IT guy" at family gatherings even though most problems are stemming from using iPads as laptops.
						Slowly realizing that 95% of the time, turning it off and turning it back on is the easiest solution
					</p>
				</div>
			  
				<div class="statuscolumn">
					<p class="statustitle">LOG BOOK</p>
					<div class="log">
						<p class="logheader">Week 1</p>
						<ul>
							<li><div class="logdate">May 21:</div> Created base HTML pages for Project VI.</li>
							<li><div class="logdate">May 22:</div> Created Github Repository for Summer Semester.</li>
							<li><div class="logdate">May 22:</div> Added group members to repo to be cloned on local machines.</li>
							<li><div class="logdate">May 24:</div> Math homework - study materials for Wednesday Quiz.</li>
							<li><div class="logdate">May 24:</div> Glanced at Software Assignment #1 (<b>**Ask Michael for Clarification on SW assignments/course groups**</b>).</li>
						</ul>
					</div>
					
					<div class="log">
						<p class="logheader">Week 2</p>
						<ul>
							<li><div class="logdate">May 28:</div> Organized similarities between Software assignment #1 and Project web page.</li>
							<li><div class="logdate">May 30:</div> Updated Project web page for weekly deliverables.</li>
							<li><div class="logdate">May 31:</div> Started Assignment #1 for Data Communications.</li>
							<li><div class="logdate">May 31:</div> Slacked on Math homework... goi ng to catch up before Tuesday's lecture.</li>
							<li><div class="logdate">May 31:</div> Slacked on Natural Sciences lectures. Will catch up on lectures this week.</li>
						</ul>
					</div>
					
					<div class="log">
						<p class="logheader">Week 3</p>
						<ul>
							<li><div class="logdate">June 4:</div> Met with group to discuss Phase 2 of Project VI.</li>
							<li><div class="logdate">June 5:</div> Went through .pdf file provided by Michael to setup STM32 with CAN.</li>
                            <li><div class="logdate">June 6:</div> Converted personal log page to the consistent CSS created by Matt.</li>
                            <li><div class="logdate">June 6:</div> Met with group to go over deliverables and outstanding items.</li>
						</ul>
					</div>

					<div class="log">
						<p class="logheader">Week 4</p>
						<ul>
							<li><div class="logdate">June 10:</div> Went back through STM code and tried to troubleshoot why filters weren't working</li>
							<li><div class="logdate">June 11:</div> Met with Michael and group. Found filter/ID error was from not shifting bits in register.</li>
                            <li><div class="logdate">June 12-14:</div> Caught up on assignments and lectures from other classes.</li>
						</ul>
					</div>

					<div class="log">
						<p class="logheader">Week 5</p>
						<ul>
							<li><div class="logdate">June 15:</div> Met with team to discuss weekly goals.</li>
							<li><div class="logdate">June 16-19:</div> Long week -- two quizzes, an assignment and a midterm, Porject took a bit of a back seat.</li>
                            <li><div class="logdate">June 20-21:</div> Figured out audio on pi... waiting for camera to be back online to see if it working.</li>
						</ul>
					</div>

					<div class="log">
						<p class="logheader">Week 6 and Reading Week</p>
						<ul>
							<li><div class="logdate">June 29:</div> Met with team to discuss weekly goals to accomplished.</li>
							<li><div class="logdate">June 30:</div> Found example prorams to run audio in C++.</li>
                            <li><div class="logdate">July 2:</div> Wrote a base program to demonstrate elevator sounds.</li>
							<li><div class="logdate">July 4:</div> Created sample audio files for elevator announcements.</li>
						</ul>
					</div>

					<div class="log">
						<p class="logheader">Week 8</p>
						<ul>
							<li><div class="logdate">July 9:</div> Met with team to discuss weekly goals to accomplished.</li>
							<li><div class="logdate">July 11:</div> Wrote script on control.php page to play audio</li>
                            <li><div class="logdate">July 12:</div> implemented audio on Control Page for control buttons</li>
						</ul>
					</div>

					<div class="log">
						<p class="logheader">Week 9</p>
						<ul>
							<li><div class="logdate">July 13:</div> Met with team to go over phase 2 rubric. Only a couple oustanding tasks.</li>
							<li><div class="logdate">July 16:</div> Started looking forward to CAN implementation of elevator operation</li>
                            <li><div class="logdate">July 19:</div> Met with team again to make sure everything was in-line of phase 2 debrief.</li>
						</ul>
					</div>

					<div class="log">
						<p class="logheader">Week 10</p>
						<ul>
							<li><div class="logdate">July 20:</div> Met with team to look forward to phase 3 and how we're going to connect everything together.</li>
							<li><div class="logdate">July 25:</div> After a busy week, met with team to discuss weekly goals for project.</li>
						</ul>
					</div>
	
				</div>
				
			</main>
			
			<footer>
				<div style="padding:8px;"><a href="#top">Back to Top</a></div>
				This page is part of Engineering Project VI. &copy Jeff S 2020
			</footer>
			
        </body>
</html>