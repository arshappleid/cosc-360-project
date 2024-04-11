<?php

require_once './functions/admin_management.php';
session_start();
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$email = $_POST['email'];
$hashedPassword = $_POST['password'];


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	try {
		if (isset($firstName) && isset($lastName) && isset($email) && isset($hashedPassword)) {
			$response = Admin_management::createAdmin($firstName, $lastName, $email, $hashedPassword);
			$response2 = User_management::createUser($email, $firstName, $lastName, $hashedPassword);
			//echo $response;
			if ($response == "USER_CREATED") {
				header('Location: ../client/account_page.php');
			} elseif ($response == "ADMIN_ALREADY_REGISTERED") {
				$_SESSION['MESSAGE'] = "ADMIN ALREADY REGISTERED";
				header('Location: ../client/create_admin.php');
			} else {
				$_SESSION['MESSAGE'] = "ERROR ON ADMIN CREATIONS";
				header('Location: ../client/create_admin.php');
			}
			exit();
		} else {
			$_SESSION['MESSAGE'] = "Please Provide all Values";
			header('Location: ../client/create_admin.php');
		}
	} catch (Exception $e) {
		echo "Error occured when creating the new Admin.<br>";
		echo $e->getMessage();
	}
}
