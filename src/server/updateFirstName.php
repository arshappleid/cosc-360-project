<?php
require_once './functions/user_management.php';
session_start();

try {
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$firstName = $_POST['firstName'];
		$email = $_SESSION['USER_EMAIL'];


		if (isset($firstName)) {
			if (User_management::editUserFirstName($email, $firstName,) == "NAME_UPDATED") {
				header('Location: ../client/home/account_page.php');
				exit();
			} else {
				$_SESSION['MESSAGE'] = 'error on user creation';
				header('Location: ../client/home/account_page.php');
			}
			header('Location: ../client/home/account_page.php');
			exit();
		}
	}
} catch (Exception $e) {
	echo "<script>console.error(" . json_encode($e->getMessage()) . ");</script>";
}
