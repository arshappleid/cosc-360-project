<?php
require_once './functions/user_management.php';
session_start();
try {
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$firstName = $_POST['firstName'];
		$lastName = $_POST['lastName'];
		$email = $_POST['email'];
		$hashedPassword = $_POST['password'];

		if (isset($firstName) && isset($lastName) && isset($email) && isset($hashedPassword)) {
			if (User_management::createUser($email, $firstName, $lastName, $hashedPassword) == "USER_CREATED") {
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
	}
} catch (Exception $e) {
	echo "<script>console.error(" . json_encode($e->getMessage()) . ");</script>";
}
