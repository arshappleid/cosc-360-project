<?php
require_once './functions/db_connection.php';
include_once "./functions/Image.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] != "POST") {
	$_SESSION["message"] = "INVALID RESPONSE";
	header('Location: ' . $_SERVER['HTTP_REFERER']);
}

$email = $_SESSION['USER_EMAIL'];
$table = "USERS";
$whereCol = "Email";
$whereValue = $email;

if (isset($_FILES['image']) && is_uploaded_file($_FILES['image']['tmp_name'])) {
    $result = Image::upload($table, $whereCol, $whereValue, "image");
    //echo $result;
    header('Location: ../client/account_page.php');
	exit();
} else {
    header('Location: ../client/account_page.php');
}