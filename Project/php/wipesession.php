<?php 

session_start();

$_SESSION['status'] = 'none';
$_SESSION['admin'] = '0';
$_SESSION['active'] = '0';

header("Location:../index.html");
exit();

?>