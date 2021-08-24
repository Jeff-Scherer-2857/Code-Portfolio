<?php

	include('php/pagesetupuni.php');

?>
<!DOCTYPE html>
<html lang="en">
        <head>

			<link rel="stylesheet" type="text/css" href="css/style.css">
			<link rel="stylesheet" type="text/css" href="css/userheader.css">
			
            <title>Project VI Homepage</title>
			<meta name="description" content="This is the design page"/>
            <meta name="robots" content="noindex nofollow" />
            <meta http-equiv="author" content="Matt H" />
            <meta http-equiv="pragma" content="no-cache" />
        </head>
        <body onload="KeepTime()">

			<script>
				function KeepTime() {
					var today = new Date();
					var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
					var time = "      " + today.getHours() + ":" + today.getMinutes();
					var dateTime = time+' '+date;
					console.log(dateTime);
					document.getElementById("datetime").innerHTML = dateTime;
					setInterval(KeepTime, 60000);
				}
			</script>
			
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
				<p class="headertitle">Project VI Homepage</p>
				Welcome to the homepage for Project VI, created by Jeff Scherer, Kevin MacIntosh, Matt Hengeveld, and Victor Palczewski.
			</header>
			
			<div class="genericcolcontainer">
				<div class="genericcol">
					<p class="genericcoltitle">USER ACCESS</p>
					
					<p style="margin-top: 60px;">User access is restricted. Please use the Request Access page to fill out a request access form.</p>
					<p>If you already have an active account, please log in using the Login Page.</p>
					
					<input type="button" value="Login Page" id="accessbttn" onclick="window.location.href = 'login.php';" />
					<input type="button" value="Request Access" id="accessbttn" onclick="window.location.href = 'request_access.php';" />
					
					<?php
						
						if ($_SESSION['admin'] == '1') {
							echo '<div class="links"><a style="padding-top: 230px" href="request_access_admin.php"><b>Admin Account Control</b></a></div>';
						}
					
					?>
					
				</div>
				
				<div class="genericcol">
					<p class="genericcoltitle">PROJECT INFO</p>
					
					<div class="links">
			
						<a href="about.php"><b>About</b></a>
						
						<?php
						
							if ($_SESSION['status'] == 'active') {
								echo '<a href="control.php"><b>Operate Elevator</b></a>';
								echo '<a href="gantt.php"><b>Project Schedule</b></a>';
								echo '<a href="designs.php"><b>Button Designs</b></a>';
								echo '<a href="logic.php"><b>Elevator Logic</b></a>';
								echo '<a href="proj_details.php"><b>Project Details</b></a>';
								echo '<a href="stats.php"><b>Elevator Stats</b></a>';
								echo '<a href="ChangeUser.php"><b>Change Password</b></a>';
							}
						
						?>
						
					</div>
				</div>
			</div>
			
			<footer>
				<p id="datetime"></p>
				This page is part of Engineering Project VI. &copy Jeff S 2020
			</footer>
			
        </body>
</html>