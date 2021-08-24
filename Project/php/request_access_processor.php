<?php
function redirectTo($page) {
	header("Location:" . $page);
	exit();
}

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

$first = $_POST['firstname'];
$last = $_POST['lastname'];
$usern = $_POST['username'];
$passw = sha1($_POST['password']);
$other = $_POST['otherdetails'];

try {
	$usertype = $_POST['fac_or_student'];
	$stud_fac = 1;	// student = 0; facaulty = 1
	if ($usertype == "student") {
		$stud_fac = 0;
	}
	if($stud_fac > 1 || $stud_fac < 0){
		throw new InvalidUserTypeException();
	}
} catch (InvalidUserException $e){
	echo "Error: Invalid user type.";
}


$involvement = $_POST['involvement'];

$options = '';
foreach ($involvement as $o) {
	$options .= '/' . $o;
}
if (strcmp($options, '') == 0) {
	$options = 'None Selected';
}

// INSERT INTO userInfo TABLE
$query = 'INSERT INTO userInfo (username,firstName,lastName,otherInfo,date,time,STUD_FAC,options)
          VALUES (:username,:firstName,:lastName,:otherInfo,:date,:time,:STUD_FAC,:options)';   //formatted query. parameters identified by ':'

$statement = $db->prepare($query);      //Object created from query that contains methods for executing (inserting) and fetching
$params = [
	'username' => $usern,
    'firstName' => $first,
    'lastName' => $last,
    'otherInfo' => $other,
    'date' => date("Y/m/d"),
    'time' => date("H:i:s"),
	'STUD_FAC'=> $stud_fac,
	'options' => $options
];
$result = $statement->execute($params);     //execute is the method for inserting the formatted array into the database

$active = 0;
$admin = 0;

// INSERT INTO loginInfo TABLE
$query = 'INSERT INTO loginInfo (username,password,active,admin)
          VALUES (:usern,:passw,:active,:admin)';   //formatted query. parameters identified by ':'

$statement = $db->prepare($query);      //Object created from query that contains methods for executing (inserting) and fetching
$params = [
	'usern' => $usern,
	'passw' => $passw,
	'active' => $active,
	'admin' => $admin
];
$statement->execute($params);     //execute is the method for inserting the formatted array into the database

redirectTo("../index.php");

?>