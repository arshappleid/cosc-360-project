<?php
require_once './functions/User_management.php';
session_start();
$firstName = $_POST['firstName'];
$email = $_SESSION['USER_EMAIL'];


if (isset($firstName)) {
	if (User_management::editUserFirstName($email, $firstName,) == "NAME_UPDATED") {
		header('Location: ../client/account_page.php');
		exit();
	} else {
		$_SESSION['MESSAGE'] = 'error on user creation';
		header('Location: ../client/account_page.php');
	}
	header('Location: ../client/account_page.php');
	exit();
}