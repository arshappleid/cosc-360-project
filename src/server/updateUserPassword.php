<?php
require_once './functions/user_management.php';
session_start();
$oldPassword = $_POST['oldpassword'];
$newPassword = $_POST['password'];
$email = $_SESSION['USER_EMAIL'];

if (isset($oldPassword) && isset($newPassword)) {
	if (User_management::userUpdatePassword($email, $oldPassword, $newPassword) == "PASSWORD_UPDATED") {
		header('Location: ../client/account_page.php');
		exit();
	} else {
		$_SESSION['MESSAGE'] = 'error on password change';
		header('Location: ../client/account_page.php');
	}
	header('Location: ../client/account_page.php');
	exit();
}