<?php
include './functions/user_management.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['USER_EMAIL'])) {
    //die("User email is not set in the session.");
}  

var_dump($_SESSION['USER_EMAIL']);
var_dump($users);



$users = User_management::getAllUserData($_SESSION['USER_EMAIL']);

echo $users;

//print_r($users);

if (is_array($users)) {
    echo "<table id=\"user_table\">";
    echo "<tr><th>First Name</th><td>" . htmlspecialchars($users['First_Name']) . "</td></tr>";
    echo "<tr><th>Last Name</th><td>" . htmlspecialchars($users['Last_Name']) . "</td></tr>";
    echo "<tr><th>Email</th><td>" . htmlspecialchars($users['Email']) . "</td></tr>";
    echo "<tr><th>Profile Picture</th><td><img src=\"./../server/getUserImages.php?USER_ID=" . urlencode($users['USER_ID']) . "\" alt=\"NO IMAGE IN DATABASE\"></td></tr>";
    echo "</table>";
} else {
    echo "<h4>Error Retrieving User Data: " . htmlspecialchars($users) . "</h4>";
}

