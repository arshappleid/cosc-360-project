<?php
session_start();
include_once './functions/User_management.php';
include_once './functions/db_connection.php';
include_once './functions/admin_management.php';


if (isset($_SESSION['USER_EMAIL'])) {
	if (User_management::userExists($_SESSION['USER_EMAIL'])) {
		$imageData =  getImage("Users", "Email", $_SESSION['USER_EMAIL']);
		if ($imageData['status'] === "SUCCESS") {
			header('Content-Type: ' . $imageData['mime']);
			echo $imageData['data'];
			exit;
		}
	} else {
		echo "NO user found by getUSERIMAGES.php";
		exit;
	}
}


if (isset($_SESSION['ADMIN_EMAIL'])) {
	if (Admin_management::checkAdminExists($_SESSION['ADMIN_EMAIL'])) {
		$imageData =  getImage("Admins", "Email", $_SESSION['ADMIN_EMAIL']);
		if ($imageData['status'] === "SUCCESS") {
			header('Content-Type: ' . $imageData['mime']);
			echo $imageData['data'];
			exit;
		}
		exit; // Make sure no other output follows
	}
}
