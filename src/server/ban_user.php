<?php

require_once("./functions/admin_management.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['userEmail'])) {
    $userEmail = $_POST['userEmail'];
    Admin_management::toggleBanUserAccount($userEmail);
    header('Location: ../client/display_users.php');
}