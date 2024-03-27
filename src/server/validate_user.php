<?php
session_start();
require_once './functions/User_management.php';
$email = $_POST['email'];
$hashedPassword = $_POST['password'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($email) && isset($hashedPassword)) {
		if (User_management::validateUserLogin($email, $hashedPassword) == "VALID_LOGIN") {
			//print_r("shit not broken");
			$_SESSION['USER_EMAIL'] = $email;
			header('Location: ../client/home.php');
			exit();
		} else {
			$_SESSION['MESSAGE'] = 'INVALID LOGIN';
			header('Location: ../client/login.php');
			exit();
		}
	}
}

header('Location: ../client/login.php');
exit();