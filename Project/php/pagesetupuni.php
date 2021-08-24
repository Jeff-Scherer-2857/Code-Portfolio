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

?>