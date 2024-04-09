<?php

session_start();
include_once './functions/user_management.php';
include_once './functions/db_connection.php';
include_once './functions/admin_management.php';

$userId = $_GET['USER_ID'];
//print_r($userId);


	if (User_management::userExists($_SESSION['USER_EMAIL'])) {
		$imageData =  getImage("USERS", "USER_ID", $userId);
		if ($imageData['status'] === "SUCCESS") {
			header('Content-Type: ' . $imageData['mime']);
			echo $imageData['data'];
			exit;
		}
	} else {
		echo "NO user found by getUSERIMAGES.php";
		exit;
	}
