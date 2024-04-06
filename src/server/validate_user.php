<?php

session_start();
require_once './functions/user_management.php';
require_once './functions/login_tracking.php';


try {
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$email = $_POST['email'];
		$hashedPassword = $_POST['password'];
		if (isset($email) && isset($hashedPassword)) {
			$resp = User_management::validateUserLogin($email, $hashedPassword);
			if ($resp == "VALID_LOGIN") {
				//print_r("shit not broken");
				$_SESSION['USER_EMAIL'] = $email;
				$user_id = User_management::getUserID($email);
				Login_tracking::incrementLoginCount($user_id);
				header('Location: ../client/home.php');
				exit();
			} else {
				$_SESSION['MESSAGE'] = $resp;
				header('Location: ../client/login.php');
				exit();
			}
		}

		header('Location: ../server/validate_user.php');
		exit();
	}
} catch (Exception $e) {
	echo "<script>console.error(" . json_encode($e->getMessage()) . ");</script>";
}
