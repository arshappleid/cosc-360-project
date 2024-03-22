<?php
session_start();
require_once './functions/admin_management.php';
$email = $_POST['email'];
$hashedPassword = $_POST['password'];

if (isset($email) && isset($hashedPassword)) {
	if (Admin_management::validateAdminLogin($email, $hashedPassword) == "VALID_LOGIN") {
		$_SESSION['ADMIN_EMAIL'] = $email;
		//$_SESSION['DISPLAY_NAME'] = displayName($email);
		$_SESSION['USER_EMAIL'] = $email;
		header('Location: ../client/home.php');
		exit();
	} else {
		$_SESSION['MESSAGE'] = 'INVALID LOGIN';
		header('Location: ../client/admin_login.php');
		exit();
	}
}

header('Location: ../client/validate_admin.php');
exit();
