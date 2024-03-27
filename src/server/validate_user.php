<?php
session_start();
require_once __DIR__ . './functions/User_management.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

$email = $_POST['email'];
$hashedPassword = $_POST['password'];
print_r($email);
print_r($hashedPassword);

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

header('Location: ../server/validate_user.php');
exit();