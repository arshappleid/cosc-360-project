<?php
require_once './functions/db_connection.php';
session_start();

$email = $_SESSION['USER_EMAIL'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])) {
    $table = "USERS";
    $whereCol = "Email";
    $whereValue = $email;
    $uploadDir = "./images/temp";

    $result = updateImage($table, $whereCol, $whereValue, $uploadDir);
    //echo $result;
    header('Location: ../client/account_page.php');
	exit();
} else {
    header('Location: ../client/account_page.php');
}