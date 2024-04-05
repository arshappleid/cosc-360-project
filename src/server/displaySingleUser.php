<?php
include './functions/user_management.php';

if (!isset($_SESSION['USER_EMAIL'])) {
    //die("User email is not set in the session.");
}  

$users = User_management::getAllUserData($_SESSION['USER_EMAIL']);

//print_r($users);

if (is_array($users)) {
    echo "<table id=\"user_table\">";
    echo "<caption> User Information </caption>";
    echo "<tr><th scope=\"row\">First Name</th><td>" . htmlspecialchars($users['First_Name']) . "</td></tr>";
    echo "<tr><th scope=\"row\">Last Name</th><td>" . htmlspecialchars($users['Last_Name']) . "</td></tr>";
    echo "<tr><th scope=\"row\">Email</th><td>" . htmlspecialchars($users['Email']) . "</td></tr>";
    echo "<tr><th scope=\"row\">Profile Picture</th><td><img src=\"./../server/getUserImages.php?USER_ID=" . urlencode($users['USER_ID']) . "\" alt=\"NO IMAGE IN DATABASE\"></td></tr>";
    echo "</table>";
} else {
    echo "<h4>Error Retrieving User Data: " . htmlspecialchars($users) . "</h4>";
}

