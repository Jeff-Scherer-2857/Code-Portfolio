<?php

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

$usern = $_POST['username'];
$activestr = $_POST['active'];
$active = 0;	// default not active
if (strcmp($activestr,'1') == 0) {	// if POST['active'] is 1
	$active = 1;	// active
}

// INSERT INTO loginInfo TABLE
$query = 'UPDATE loginInfo SET active = :active
          WHERE username = :usern';   //formatted query. parameters identified by ':'

$statement = $db->prepare($query);      //Object created from query that contains methods for executing (inserting) and fetching
$params = [
	'active' => $active,
	'usern' => $usern	
];
$statement->execute($params);     //execute is the method for inserting the formatted array into the database

?>