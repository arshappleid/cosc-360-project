<?php
require_once './functions/user_management.php'>
session_start();
$username = $_POST['username'];
$email = $_POST['email'];
$hashedPassword = $_POST['password'];

if(isset($username) && isset($email) && $isset($hashedPassword)){
	
	if(createUser($username, $email , $hashedPassword)){
		$_SESSION['admin_user_id'] = $username;
		header('Location: ../client/home.php');
		exit();
	}else{
		$_SESSION['message'] = 'User already exists';
<<<<<<< HEAD
		header('Location: ../client/create_user_account.php')
=======
		header('Location: ../client/createaccountpage/create_account.php');		
>>>>>>> c08fc60 (testing upload to specified branch)
	}
	$_SESSION['admin_user_id'] = $username;
	header('Location: ../client/home.php');
	exit();
}