<?php
require_once './functions/user_management.php';
session_start();
$lastName = $_POST['lastName'];
$email = $_SESSION['USER_EMAIL'];

//print_r($lastName);
//print_r($email);

if (isset($lastName)) {
	if (User_management::editUserLastName($email, $lastName,) == "NAME_UPDATED") {
		header('Location: ../client/home/account_page.php');
		exit();
	} else {
		$_SESSION['MESSAGE'] = 'error on user creation';
		header('Location: ../client/home/account_page.php');
	}
	header('Location: ../client/home/account_page.php');
	exit();
}
