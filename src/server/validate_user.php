<?php
session_start();
require_once './functions/user_management.php';
$email = $_POST['email'];
$hashedPassword = $_POST['password'];

if (isset($email) && isset($hashedPassword)) {
	if (validateUserLogin($email, $hashedPassword) == "VALID_LOGIN") {
		$_SESSION['USER_EMAIL'] = $email;
		header('Location: ../client/home.php');
		exit();
	} else {
		$_SESSION['MESSAGE'] = 'INVALID LOGIN';
		header('Location: ../client/login.php');
		exit();
	}
}

header('Location: ../client/login.php');
exit();
