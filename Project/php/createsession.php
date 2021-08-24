<?php 

session_start();

$_SESSION['status'] = 'none';
$_SESSION["active"] = 0;
$_SESSION["admin"] = 0;
$_SESSION["timeout"] = 0;
$_SESSION["username"] = '';

header("Location:../index.html");
exit();

?>