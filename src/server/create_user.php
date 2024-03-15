<?php
require_once './functions/user_management.php';
	session_start();
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$email = $_POST['email'];
$hashedPassword = $_POST['password'];

if (isset($firstName) && isset($lastName) && isset($email) && isset($hashedPassword)) {
	if (createUser($email, $firstName, $lastName, $hashedPassword)) {
		$_SESSION['EMAIL'] = $email;
		header('Location: ../client/home.php');
		exit();
	} else {
		$_SESSION['MESSAGE'] = 'error on user creation';
		header('Location: ../client/create_user.php');
	}
	$_SESSION['EMAIL'] = $email;
	header('Location: ../client/home.php');
	exit();
}

