<?php

	include('php/pagesetup.php');

?>
<!DOCTYPE html>
<html lang="en">
        <head>

			<link rel="stylesheet" type="text/css" href="css/gantt_style.css">
			<link rel="stylesheet" type="text/css" href="css/userheader.css">
			
            <title>Project Schedule - Gantt Chart</title>
			<meta name="description" content="Project schedule in the form of a Gantt chart"/>
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
			
			<header>
				<p class="headertitle">Project Schedule - Gantt Chart</p>
			</header>
			
			<nav>
				<a class="navbttn" href="index.php">HOME</a>
				<a class="navbttn" href="about.php">ABOUT</a>
				<a class="navbttn" href="designs.php">DESIGN FILES</a>
				<a class="navbttn" href="control.php">ELEVATOR CONTROL</a>
			</nav>
			
			<div class="legend"> 
				<div class="legendtitle">Legend</div>
				<div class="legendentry"><a href="jeff.php">JS - Jeff Sherer</a></div>
				<div class="legendentry"><a href="kevin.php">KM - Kevin MacIntosh</a></div>
				<div class="legendentry"><a href="matt.php">MH - Matt Hengeveld</a></div>
				<div class="legendentry"><a href="victor.php">VP - Victor Palczewski</a></div>
			</div>
			
			<main class="smallmain">
			
				<div class="banner">Phase 1</div>

				<div class="row headerrow">
				
					<div class="col1">Week</div>
					<div class="weekcol">1</div>
					<div class="weekcol">2</div>
					<div class="weekcol">3</div>
					<div class="weekcol">4</div>
					<div class="weekcol">5</div>
					<div class="weekcol">6</div>
					<div class="weekcol">7</div>
					<div class="weekcol">8</div>
					<div class="weekcol">9</div>
					<div class="weekcol">10</div>
					<div class="weekcol">11</div>
					<div class="weekcol">12</div>
					<div class="weekcol">13</div>
					<div class="weekcol">14</div>
				
				</div>
				
				<div class="row">
				
					<div class="col1 topicrow">Project Plan</div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
				
				</div>
				
				<div class="row">
				
					<div class="col1">Create initial website for project</div>
					<div class="weekcol">JS VP</div>
					<div class="weekcol">JS VP</div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
				
				</div>
				
				<div class="row">
				
					<div class="col1">Fully completed Gantt Chart</div>
					<div class="weekcol">KM</div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
				
				</div>
				
				<div class="row">
				
					<div class="col1">Design Virtual Controls & Indicators</div>
					<div class="weekcol"></div>
					<div class="weekcol">MH</div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
				
				</div>
				
				<div class="row">
				
					<div class="col1">Elevator car controls built in HTML/CSS</div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol">MH</div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
				
				</div>
				
				<div class="row">
				
					<div class="col1">FSM Logic for Elevator</div>
					<div class="weekcol"></div>
					<div class="weekcol">KM JS</div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
				
				</div>
				
				<div class="row">
				
					<div class="col1">Outline of required states</div>
					<div class="weekcol"></div>
					<div class="weekcol">TEAM</div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
				
				</div>
				
				<div class="row">
				
					<div class="col1">Develop test plans</div>
					<div class="weekcol"></div>
					<div class="weekcol">VP</div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
				
				</div>
				
			</main>
			
			<main>
				
				<div class="banner">Phase 2</div>

				<div class="row headerrow">
				
					<div class="col1">Week</div>
					<div class="weekcol">1</div>
					<div class="weekcol">2</div>
					<div class="weekcol">3</div>
					<div class="weekcol">4</div>
					<div class="weekcol">5</div>
					<div class="weekcol">6</div>
					<div class="weekcol">7</div>
					<div class="weekcol">8</div>
					<div class="weekcol">9</div>
					<div class="weekcol">10</div>
					<div class="weekcol">11</div>
					<div class="weekcol">12</div>
					<div class="weekcol">13</div>
					<div class="weekcol">14</div>
				
				</div>
				
				<div class="row">
				
					<div class="col1 topicrow">User Interface</div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
				
				</div>
				
				<div class="row">
				
					<div class="col1">Changes values in database</div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol">VP</div>
					<div class="weekcol">VP</div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
				
				</div>
				
				<div class="row">
				
					<div class="col1">Responds to changes in database</div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol">KM</div>
					<div class="weekcol">KM</div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
				
				</div>
				
				<div class="row">
				
					<div class="col1 topicrow">Repository</div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
				
				</div>
				
				<div class="row">
				
					<div class="col1">Database setup and accepting values</div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol">JS</div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
				
				</div>
				
				<div class="row">
				
					<div class="col1 topicrow">Diagnostic Reports</div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
				
				</div>
				
				<div class="row">
				
					<div class="col1">Produes based on contents in database</div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol">MH</div>
					<div class="weekcol">MH</div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
				
				</div>
				
				<div class="row">
				
					<div class="col1 topicrow">Authorized User Access</div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
				
				</div>
				
				<div class="row">
				
					<div class="col1">Username/password authorization using database</div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol">VP</div>
					<div class="weekcol">VP</div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
				
				</div>
				
				<div class="row">
				
					<div class="col1">Username & password encryption (HTTPS)</div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol">MH</div>
					<div class="weekcol">MH</div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
				
				</div>
				
				<div class="row">
				
					<div class="col1 topicrow">Announce Floor Numbers</div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
				
				</div>
				
				<div class="row">
				
					<div class="col1">Speaker used to announce floors</div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol">MH KM</div>
					<div class="weekcol">MH KM</div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
				
				</div>
				
				<div class="row">
				
					<div class="col1 topicrow">Quarantine Mode</div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
				
				</div>
				
				<div class="row extrarowpadding">
				
					<div class="col1">Operate the elevator without buttons</div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol">JS VP</div>
					<div class="weekcol">JS VP</div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
				
				</div>
				
			</main>
			
			<main>
				
				<div class="banner">Phase 3</div>

				<div class="row headerrow">
				
					<div class="col1">Week</div>
					<div class="weekcol">1</div>
					<div class="weekcol">2</div>
					<div class="weekcol">3</div>
					<div class="weekcol">4</div>
					<div class="weekcol">5</div>
					<div class="weekcol">6</div>
					<div class="weekcol">7</div>
					<div class="weekcol">8</div>
					<div class="weekcol">9</div>
					<div class="weekcol">10</div>
					<div class="weekcol">11</div>
					<div class="weekcol">12</div>
					<div class="weekcol">13</div>
					<div class="weekcol">14</div>
				
				</div>
				
				<div class="row">
				
					<div class="col1 topicrow">CAN/LAN Network Communication</div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol">MH KM</div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
				
				</div>
				
				<div class="row">
				
					<div class="col1">CAN activity changes values in database</div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol">VP</div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
				
				</div>
				
				<div class="row">
				
					<div class="col1 topicrow">Finite State Machine Logic Written</div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol">KM JS</div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
				
				</div>
				
				<div class="row">
				
					<div class="col1">C/C++, PHP, Python implementation</div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol">MH VP</div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
				
				</div>
				
				<div class="row headerrow">
				
					<div class="col1">Additional Capabilities</div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
				
				</div>
				
				<div class="row">
				
					<div class="col1">Web interface animations</div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol">JS</div>
					<div class="weekcol"></div>
				
				</div>
				
				<div class="row">
				
					<div class="col1">Javascript-based statistics interface</div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol">MH</div>
					<div class="weekcol">MH</div>
				
				</div>
				
				<div class="row">
				
					<div class="col1">Statistics backend</div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol">KM</div>
					<div class="weekcol">KM</div>
					<div class="weekcol"></div>
				
				</div>
				
				<div class="row">
				
					<div class="col1">Elevator Music</div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol">VP</div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
				
				</div>
				
				<div class="row headerrow">
				
					<div class="col1">Final</div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
				
				</div>
				
				<div class="row">
				
					<div class="col1 finalrow">Ideas for Capstone</div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol">TEAM</div>
					<div class="weekcol">TEAM</div>
					<div class="weekcol">TEAM</div>
				
				</div>
				
				<div class="row">
				
					<div class="col1 finalrow">Final Report & Presentation</div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol"></div>
					<div class="weekcol">TEAM</div>
					<div class="weekcol">TEAM</div>
				
				</div>
				
			</main>
			
			<footer>
				This page is part of Engineering Project VI. &copy Victor P & Matt H. 2020
			</footer>
			
        </body>
</html>