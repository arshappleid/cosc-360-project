<?php
require_once './functions/admin_management.php';
session_start();
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$email = $_POST['email'];
$hashedPassword = $_POST['password'];


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($firstName) && isset($lastName) && isset($email) && isset($hashedPassword)) {
		if (createAdmin($firstName, $lastName, $email, $hashedPassword)) {

			// Upload The Image
			if (isset($_FILES[$email]) && $_FILES[$email]["error"] == 0) {
				$userImage = file_get_contents($_FILES[$email]["name"]);
				updateImage("Admins", "Email", $email, $userImage);
			} else {
				echo "Could not trace file";
			}

			header('Location: ../client/admin_login.php');
			exit();
		} else {
			$_SESSION['MESSAGE'] = 'error on Admin creation';
			header('Location: ../client/create_admin.php');
		}
		$_SESSION['EMAIL'] = $email;
		header('Location: ../client/home.php');
		exit();
	}
}
