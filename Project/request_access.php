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
    
		<script>
			function countChars() {
				var numChars = document.getElementById("otherdetails").value.length;
				console.log(numChars);
				document.getElementById("charNum").value = 180 - numChars;
				if (numChars > 180) {
					alert("You have reached the maximum # of allowed characters.");
					document.getElementById("otherdetails").value = document.getElementById("otherdetails").value.substr(0,180);
					numChars = 180;
				}
			}
			
			function checkUponSubmit() {
				var error = 0;
			
				var emptyField = 0;
				
				let fields = [];
				fields.push(document.getElementById("firstname"));
				fields.push(document.getElementById("lastname"));
				fields.push(document.getElementById("otherdetails"));
				
				fields.forEach(function(item, index, array) {
					if (item.value.length == 0) {
						emptyField++;
						error++;
						item.style.borderColor = "red";
						item.style.borderWidth = "thick";
					}
				})
				
				if (document.getElementById("otherdetails").value == "Other details...") {
					alert("Please enter more details.");
					document.getElementById("otherdetails").style.borderColor = "red";
					document.getElementById("otherdetails").style.borderWidth = "thick";
					error++;
				}
				
				if (!document.getElementById("facultyRadio").checked && !document.getElementById("studentRadio").checked) {
					alert("Please indicate if you are faculty or student.");
					error++;
				}
				
				if (emptyField > 0) {
					alert("There are empty field(s). Please fill out all fields");
				}
				
				if (error == 0) {
					document.getElementById("access").submit();
				}
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
		
        <form action="php/request_access_processor.php" method="post" id="access">
            <div id="myForm">
                <h1 id="formtitle">Request Access</h1>
				<div style="margin: 20px 0px 30px 0px; height: 160px;">
					<div class="textcell"><p id="inputlabel">First Name: </p><input type="text" name="firstname" id="firstname" /></div>
					<div class="textcell"><p id="inputlabel">Last Name: </p><input type="text" name="lastname" id="lastname"/></div>
					<div class="textcell"><p id="inputlabel">Username: </p><input type="text" name="username" id="username"/></div>
					<div class="textcell"><p id="inputlabel">Password: </p><input type="password" name="password" id="password"/></div>
				</div>
                
				<div id="radios">
					<div id="radio"><input type="radio" name="fac_or_student" value="faculty" id="facultyRadio"/> Faculty</div>
					<div id="radio"><input type="radio" name="fac_or_student" value="student" id="studentRadio"/> Student</div>
				</div>
                
				<div id="checks">
					<p>Check all that apply:</p>
					<label><input type="checkbox" name="involvement[]" value="none" /> I have no involvement in the project</label> <br /><!--the label wrap makes it so you can click on the text to select as well-->
					<label><input type="checkbox" name="involvement[]" value="instructor" /> I am an instructor in the project</label> <br />
					<label><input type="checkbox" name="involvement[]" value="instructor_other" /> I am an instructor in a different project</label> <br />
					<label><input type="checkbox" name="involvement[]" value="student" /> I am a student in this project</label> <br />
					<label><input type="checkbox" name="involvement[]" value="student_other" /> I am a student in a different project </label> <br />
					<label><input type="checkbox" name="involvement[]" value="admin" /> I am a college admin</label> <br />
					<label><input type="checkbox" name="involvement[]" value="external" /> I am an external reviewer</label> <br />
					<label><input type="checkbox" name="involvement[]" value="jeff" /> My name Jeff</label> <br />
				</div>	

				<div id="about">
					<p>About yourself:</p>
					<textarea placeholder="Details..." name="otherdetails" id="otherdetails" rows="5" style="resize: none;"></textarea><br />
					<p id="charlabel">Characters remaining:</p>
					<textarea id="charNum" rows="1" cols="3" maxlength="3" readonly="true">0</textarea>
                </div>
				
				<input type="button" value="Submit" id="detailsbttn" onclick="checkUponSubmit()"></input>
				
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
