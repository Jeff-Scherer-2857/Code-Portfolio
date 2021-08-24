<?php

	include('php/pagesetupuni.php');

?>
<!DOCTYPE html>
<html>
    <head>

        <link rel="stylesheet" type="text/css" href="css/request_style.css">
		<link rel="stylesheet" type="text/css" href="css/userheader.css">

        <title>Forms: Request Access</title>
        <meta name="description" content="This is the request access form"/>
        <meta name="robots" content="noindex nofollow" />
        <meta http-eqiv="author" content="Victor P" />
        <meta http-equiv="pragma" content="no-cache" />
    </head>
    <body onload="document.getElementById('otherdetails').addEventListener('keyup', countChars); countChars();">

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
		
        <form action="php/ChangeUser_processor.php" method="post" id="access">
            <div id="myForm">
                <h1 id="formtitle">Change Password</h1>
				<div style="margin: 20px 0px 30px 0px; height: 160px;">
					<div class="textcell"><p id="inputlabel">Username: </p><input type="text" name="username" id="username"/></div>
                    <div class="textcell"><p id="inputlabel">Password: </p><input type="password" name="password" id="password"/></div>
                    <div class="textcell"><p id="inputlabel">New Password: </p><input type="password" name="newpassword" id="newpassword"/></div>
				</div>
				
				<input type="button" value="Submit" id="detailsbttn"></input>
				
				<div class="links">
					<a href="index.php">Home Page</a>
					<a href="about.php">About Page</a>
				</div>
            </div>
        </form>
        <br />
        <p id="copyright"><i>©Victor Palczewski; Matt Hengeveld</i></p>
    </body>
</html>
