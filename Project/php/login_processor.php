<?php
function redirectTo($page) {
	header("Location:" . $page);
	exit();
}

session_start();

date_default_timezone_set('America/New_York');

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

$query = 'SELECT password, active, admin FROM loginInfo WHERE username = :username';   //formatted query. parameters identified by ':'

$statement = $db->prepare($query);      //Object created from query that contains methods for executing (inserting) and fetching
$params = [
	'username' => $username
];
$statement->execute($params);     //execute is the method for inserting the formatted array into the database

$result = $statement->fetch();

$numrows = $statement->rowCount($result);

if ($numrows == 0) {
	$_SESSION["status"] = 'failuser';
	redirectTo("../login.php");
	//header("Location:../login.php");
	//exit();
}

if (strcasecmp($result["password"],$password)) {	//fail
	$_SESSION["status"] = 'failpass';
	$_SESSION["admin"] = 0;
	redirectTo("../login.php");
	//header("Location:../login.php");
	//exit();
} else { 											//username and password valid...
	if (strcasecmp($result["active"],'1') == 0) {					// active account (success)
		$_SESSION["active"] = 1;
		$_SESSION["status"] = 'active';
		$_SESSION["username"] = $username;
		if (strcasecmp($result["admin"],'1') == 0) {
			$_SESSION["timeout"] = time() + 1200;
		} else {
			$_SESSION["timeout"] = time() + 600;
		}
		
		if (strcasecmp($result["admin"],'1') == 0) {
			$_SESSION["admin"] = 1;
		} else {
			$_SESSION["admin"] = 0;
		}
		redirectTo("../control.php");
		//header("Location:../control.php");
		//exit();
		
	} else {										// inactive account (fail)
		$_SESSION["active"] = 0;
		$_SESSION["status"] = 'nonactive';
		redirectTo("../login.php");
		//header("Location:../login.php");
		//exit();
	}
}
?>
<!DOCTYPE HTML>

<html>
<body>
<h1>DEBUG INFO</h1>
Result: <?php echo var_dump($result); ?><br>
Username: <?php echo $_SESSION["username"]; ?><br>
Password: <?php echo $_POST["password"]; ?><br>
Active: <?php echo $_SESSION["active"]; ?><br>
Admin: <?php echo $_SESSION["admin"]; ?>

</body>
</html>