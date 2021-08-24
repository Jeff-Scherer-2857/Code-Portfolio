<?php

	include('php/pagesetup.php');

?>
<!DOCTYPE html>
<html>
    <head>

        <link rel="stylesheet" type="text/css" href="css/request_style.css">
		<link rel="stylesheet" type="text/css" href="css/userheader.css">

        <title>Forms: Request Access Admin Page</title>
        <meta name="description" content="This is the request access form"/>
        <meta name="robots" content="noindex nofollow" />
        <meta http-eqiv="author" content="Victor P" />
        <meta http-equiv="pragma" content="no-cache" />
    </head>
    <body >
    
		<script>
			function activeChange(checkbox) {
				var uname = checkbox.id;
				var boxChecked = 0;
				if (checkbox.checked) {
					boxChecked = 1;
				}
				
				var xhttp = new XMLHttpRequest();
				xhttp.open("POST","php/useractive.php",true);
				xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				var ajaxstr = "username=" + uname + "&active=" + boxChecked;
				//console.log(ajaxstr);
				xhttp.send(ajaxstr);
			}
			
			function adminChange(checkbox) {
				var uname = checkbox.id;
				var boxChecked = 0;
				if (checkbox.checked) {
					boxChecked = 1;
				}
				
				var xhttp = new XMLHttpRequest();
				xhttp.open("POST","php/useradmin.php",true);
				xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				var ajaxstr = "username=" + uname + "&admin=" + boxChecked;
				//console.log(ajaxstr);
				xhttp.send(ajaxstr);
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
		
        <div>
			<?php
			
				if (isset($_SESSION["admin"]) && strcasecmp($_SESSION["admin"],'1') == 0 && strcasecmp($_SESSION["active"],'1') == 0) {	// if active account and account is admin
				
					try {
						$db = new PDO(
							'mysql:host=127.0.0.1;port=3306;dbname=elevator',     //Data source name
							'webuser',                                                 //Username
							'12345678'                                                      //Password
						);
						$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						//echo "connection successful";
					} catch(PDOException $e) {
						//echo "Connection failed: " . $e->getMessage();
					}

					$username = $_POST['username'];
					$password = $_POST['password'];

					//Return arrays with keys that are the name of the fields
					$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

					// userInfo
					$query = 'SELECT * FROM userInfo';   //formatted query. parameters identified by ':'

					$statement = $db->prepare($query);      //Object created from query that contains methods for executing (inserting) and fetching
					$statement->execute();     //execute is the method for inserting the formatted array into the database

					//$result = $statement->fetch();
					$allResult = $statement->fetchAll();
					
					// loginInfo
					$query2 = 'SELECT * FROM loginInfo ORDER BY username DESC';   //formatted query. parameters identified by ':'

					$statement2 = $db->prepare($query2);      //Object created from query that contains methods for executing (inserting) and fetching
					$statement2->execute();     //execute is the method for inserting the formatted array into the database

					//$result = $statement->fetch();
					$allResult2 = $statement2->fetchAll();
					

					$numrows = $statement->rowCount($allResult);
					
					echo '<div id="accountctrlcontainer">';
					echo '<div id="numrec">Number of records: ' . $numrows . '</div>';
					
					//echo var_dump($allResult);
					
					echo '<div class="recordtitles lightrecord">';
					echo '<div class="usercol">Username</div>';
					echo '<div class="namecol">First Name</div>';
					echo '<div class="namecol">Last Name</div>';
					echo '<div class="otherinfocol">About</div>';
					echo '<div class="datetimecol">Date</div>';
					echo '<div class="datetimecol">Time</div>';
					echo '<div class="stud_faccol">Student/Faculty</div>';
					echo '<div class="optionscol">Options</div>';
					echo '<div class="activecol">Active</div>';
					echo '<div class="admincol">Admin</div>';
					echo '</div>';
					
					for ($i = 0; $i < $numrows; $i++) {
						echo '<div class="record';
						if ($i % 2) {
							echo ' lightrecord">';
						} else {
							echo '">';
						}
						echo '<div class="usercol">' . $allResult[$i]['username'] . '</div>';
						echo '<div class="namecol">' . $allResult[$i]['firstName'] . '</div>';
						echo '<div class="namecol">' . $allResult[$i]['lastName'] . '</div>';
						echo '<div class="otherinfocol">' . $allResult[$i]['otherInfo'] . '</div>';
						echo '<div class="datetimecol">' . $allResult[$i]['date'] . '</div>';
						echo '<div class="datetimecol">' . $allResult[$i]['time'] . '</div>';
						echo '<div class="stud_faccol">';
						echo (strcmp($allResult[$i]['STUD_FAC'],'0'))?('Faculty'):('Student');
						echo '</div>';
						echo '<div class="optionscol">' . $allResult[$i]['options'] . '</div>';
						echo '<div class="checkbox"><input type="checkbox" id="' . $allResult[$i]['username'] . '" name="' . $allResult[$i]['username'] . 'activecheck" value="active"';
						echo (strcmp($allResult2[$i]['active'],'0'))?('checked="checked"'):('');
						echo ' onchange="activeChange(this)"></div>';
						echo '<div class="checkbox"><input type="checkbox" id="' . $allResult[$i]['username'] . '" name="' . $allResult[$i]['username'] . 'admincheck" value="admin"';
						echo (strcmp($allResult2[$i]['admin'],'0'))?('checked="checked"'):('');
						echo ' onchange="adminChange(this)"></div>';
						echo '</div>';
					}
					
					echo '</div>';
					
				} else {
					echo '<div style="height: 80px; text-align: center; margin-top: 25%; padding-top: 25px; float: center; background-color: rgb(117,24,9); color: rgb(255,255,255); font-size: 32px;">ACCESS DENIED!<div>';
				}
				
			
			?>
		</div>
		
		<div style="width: 640px; margin: 50px auto 10px auto;">
			<a class="navbttn" href="index.php">HOME</a>
			<a class="navbttn" href="about.php">ABOUT</a>
			<a class="navbttn" href="control.php">ELEVATOR</a>
		</div>
		
        <footer>
			This page is part of Engineering Project VI. &copy Matt Hengeveld 2020
		</footer>
    </body>
</html>
