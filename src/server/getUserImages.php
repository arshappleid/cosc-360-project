<?php
include_once './functions/user_management.php';
include_once './functions/db_connection.php';
include_once './functions/admin_management.php';


if (isset($_GET['email'])) {
	if (checkAdminExists($_GET['email'])) {
		header("Content-type: image/jpeg");
		echo getImage("Admins", "Email", $_GET['email']);
		exit; // Make sure no other output follows
	} elseif (userExists($_GET['email'])) {
		header("Content-type: image/jpeg");
		echo getImage("Users", "Email", $_GET['email']);
		exit; // Make sure no other output follows
	} else {
		echo "NO user found by getUSERIMAGES.php";
	}
}