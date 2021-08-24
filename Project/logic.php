<?php

	include('php/pagesetup.php');

?>
<!DOCTYPE html>
<html lang="en">
        <head>
            <title>Project VI - Elevator Logic</title>

			<link rel="stylesheet" type="text/css" href="css/style.css">
			<link rel="stylesheet" type="text/css" href="css/userheader.css">
			
			<meta name="description" content="This is the logic design page of the elevators"/>
			<meta name="robots" content="noindex nofollow" />
			<meta http-equiv="author" content="Matt H, Kevin M" />
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
				<p class="headertitle">Project VI - Elevator Logic</p>
				This page is for elevator logic documents.
			</header>
			
			<nav>
				<a class="navbttn" href="index.php">HOME</a>
				<a class="navbttn" href="about.php">ABOUT</a>
				<a class="navbttn" href="designs.php">DESIGN FILES</a>
			</nav>

			<main style="text-align: center; color: rgb(210,210,210); margin-top: 50px;">
				
				<p>The elevator will implement a first in first out (FIFO) queue. The following state diagram represents the the 3 floor FIFO logic.</p>
				
				<h2> States:<br> 00 = Floor 1<br>01 = Floor 2<br>10 = Floor 3<br><br>Input:<br> F3 F2 F1</h2>

				<img class="aboutimg" style="margin-top: 40px; max-height: 600px;" src="images/StateDiagram.jpg" alt="Picture of state diagram." title="FIFO state diagram" height="606" />
			</main>
    
			<footer style="padding-top: 50px;">
				This page is part of Engineering Project VI. &copy Kevin M 2020
			</footer>
        </body>
</html>
