<?php

	session_start();
	
	if (!isset($_SESSION["timeout"])) {
		$_SESSION["timeout"] = 0;
	}
	
	if (!isset($_SESSION["active"])) {
		$_SESSION["active"] = 0;
	}
	
	if (!isset($_SESSION["status"])) {
		$_SESSION["status"] = 'none';
	}
	
	if (!isset($_SESSION["username"])) {
		$_SESSION["username"] = '';
	}
	
	if (!isset($_SESSION["admin"])) {
		$_SESSION["admin"] = 0;
	}

	/*
	SESSION variables

	status:
		active - user is logged in and session is active
		fail - login attempt failed. See 'fail' variable for details
		logout - user has logged out
		timeout - session timed output_add_rewrite_var
		nonactive - waiting for request accesss confirmation
		none - no session
	*/

	if (isset($_SESSION["timeout"]) && strcasecmp($_SESSION["status"],'active') == 0) {
		if ($_SESSION['timeout'] < time()) {
			$_SESSION['status'] = 'timeout';
		}
	}

	if ($_SESSION['status'] == 'active') {
		header("Location:../control.php");
		exit();
	}
?>
<!DOCTYPE html>
<html>
    <head>
		<!--- CryptoJS -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/sha1.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/components/sha1-min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/components/lib-typedarrays-min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/aes.js"></script>
	
        <link rel="stylesheet" type="text/css" href="css/login_style.css">
		<link rel="stylesheet" type="text/css" href="css/userheader.css">
		
        <title>Login</title>
        <meta name="description" content="This is the login page for our project"/>
        <meta name="robots" content="noindex nofollow" />
        <meta http-equiv="author" content="Victor P" />
        <meta http-equiv="pragma" content="no-cache" />
    </head>
    <body onload="document.getElementById('user').focus();">

		<script>
			function checkUserInput(val) {
				if (val.length <= 7) {
					alert("Username must be 7 or more characters");
					document.getElementById("user").value = "";
				}
				
			}
			
			function checkPassInput(val) {
				if (val.length <= 7) {
					alert("Password must be 7 or more characters");
					document.getElementById("pass").value = "";
				}
				
			}
			
			function checkInput() {
				if (document.getElementById("user").value.length <= 7 || document.getElementById("pass").value.length <= 7) {
					alert("Username and password must both be 7 or more characters");
					document.getElementById("loginForm").reset();
				} else {
					// create hidden form in javascript
					var loginForm = document.createElement('form');
					loginForm.action = 'php/login_processor.php';
					loginForm.method = 'POST';
					
					// username
					var loginUser = document.createElement('input');
					loginUser.type = 'hidden';
					loginUser.name = 'username';
					loginUser.value = document.getElementById("user").value;
					loginForm.appendChild(loginUser);
					
					//password
					var loginPass = document.createElement('input');
					loginPass.type = 'hidden';
					loginPass.name = 'password';
					loginPass.value = CryptoJS.SHA1(document.getElementById("pass").value);
					console.log(loginPass.value);
					loginForm.appendChild(loginPass);
					
					//submit form
					document.body.appendChild(loginForm);
					loginForm.submit()
				}
			}
		</script>
		
		<div id="userheader">
			
			<?php
				if ($_SESSION['status'] == 'active') {
					echo '<div id="userheadername">';
					echo $_SESSION['username'];
					echo '</div>';
					echo '<div id="userheaderbttn"><a href="php/wipesession.php">LOGOUT</a></div>';
				} else {
					echo '<div id="userheaderbttn"><a href="login.php">LOGIN</a></div>';
				}						
			?>
			
		</div>
		
		<div id="redmessage" <?php if($_SESSION['status'] == 'none' || $_SESSION['status'] == 'active') {echo 'style="visibility: hidden;"';} ?>>
			<p id="messagetext">
				<?php
					switch ($_SESSION['status']) {
						case 'failuser':
							echo 'Username does not exist.';
							$_SESSION['status'] = 'none';
							break;
						case 'failpass':
							echo 'Password incorrect. Please try again.';
							$_SESSION['status'] = 'none';
							break;
						case 'timeout':
							echo 'Session expired.';
							$_SESSION['status'] = 'none';
							break;
						case 'nonactive':
							echo 'Access request is being processed.';
							$_SESSION['status'] = 'none';
							break;
						default:
							echo 'Internal Error.';
					}
				?>
			</p>
		</div>
		
        <form id="loginform">
            <header>
				<h1 class="headertitle">Project IV Login</h1>
			</header>
            
            <div id="usernamediv">
                <label for="user" class="text_label">Username:</label> <!--The "for='user'" targets the entire box plus the "username" text, making it cleaner-->
                <input class="text_input" id="user" type="text" class="text-input" name="username" onchange="checkUserInput(this.value)" required/>
            </div>

            <div id="passworddiv">
                <label for="pass" class="text_label">Password:</label>
                <input class="text_input" id="pass" type="password" class="text-input" name="password" onchange="checkPassInput(this.value)" required/>
            </div>
           
            <div id="submitdiv"><input type="button" value="Log In" id="submit" onclick="checkInput()" /></div> <!--Login button-->
			
            <div class="links">
                <a href="request_access.php">Request Access</a>
                <a href="index.php">Homepage</a>
                <a href="about.php">About</a>
            </div>
            
        </form>
		
        <br />
        <p id="copyright"><i>© Victor Palczewski</i></p>

        <audio id="player" controls><source src="images/meme.mp3" type="audio/mp3"></audio>
    </body>
</html>
