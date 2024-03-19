<?php
session_start();
include_once './functions/user_management.php';
include_once './functions/db_connection.php';
include_once './functions/admin_management.php';


if (isset($_SESSION['USER_EMAIL'])) {
	if (userExists($_SESSION['USER_EMAIL'])) {
		header("Content-type: image/jpeg");
		echo getImage("Users", "Email", $_SESSION['USER_EMAIL']);
		exit; // Make sure no other output follows
	} else {
		echo "NO user found by getUSERIMAGES.php";
		exit;
	}
}


if (isset($_SESSION['ADMIN_EMAIL'])) {
	if (checkAdminExists($_SESSION['ADMIN_EMAIL'])) {
		header("Content-type: image/jpeg");
		echo getImage("Admins", "Email", $_SESSION['ADMIN_EMAIL']);
		exit; // Make sure no other output follows
	}
}
