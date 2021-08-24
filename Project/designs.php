<?php

	include('php/pagesetup.php');

?>
<!DOCTYPE html>
<html lang="en">
        <head>

            <title>Project VI - Designs</title>
			
			<link rel="stylesheet" type="text/css" href="css/style.css">
			<link rel="stylesheet" type="text/css" href="css/userheader.css">
			
			<meta name="description" content="This is the design page"/>
            <meta name="robots" content="noindex nofollow" />
            <meta http-equiv="author" content="Matt H" />
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
				<p class="headertitle">Project VI - Designs</p>
				This page is for desgin documents.
			</header>
			
			<nav>
				<a class="navbttn" href="index.php">HOME</a>
				<a class="navbttn" href="about.php">ABOUT</a>
				<a class="navbttn" href="designs.php">DESIGN FILES</a>
			</nav>

			<div class="main" style="text-align: center;">
				<h2 style="font-size: 36px;">Design Documents</h2>
				
				<img style="padding-top: 40px;" src="images/Virtual-controls-and-indicators-design.png" alt="Virtual controls and indicators design">
				<p>
				Virtual controls and indicators design.
				</p>

				<img style="padding-top: 60px;" src="images/Virtual-controls-and-indicators-design-comments.png" alt="Virtual controls and indicators design with comments">
				<p>
				Virtual controls and indicators design with comments that describe function and design.
				</p>
			</div>
    
			<footer style="padding-top: 50px;">
				This page is part of Engineering Project VI. &copy Matt H. 2020
			</footer>
        </body>
</html>
