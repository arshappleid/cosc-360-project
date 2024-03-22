<?php
include './functions/admin_management.php';

$users = Admin_management::getAllUsers();
//print_r($users);
//$itemid = Admin_management::getItemID("Laptop", 1);
//print_r($itemid);
//$itemid1 = Admin_management::getItemID("Laptop", 3);
//print_r($itemid1);
if (is_array($users)) {
    if (count($users) == 0) {
        echo "<h4>No Users Found</h4>";
    } else {
        echo "<table id=\"user_table\">";
        echo "<tr><th>First Name</th><th>Last Name</th><th>Email</th></tr>";
        foreach ($users as $user) {
            echo "<tr>";
            echo "<td>" . $user['First_Name'] . "</td>";
            echo "<td>" . $user['Last_Name'] . "</td>";
            echo "<td>" . $user['Email'] . "</td>";
            echo "<td><button>User Details</button>";
            echo "</tr>";
        }
        echo "</table>";
    }
} else {
    echo "<h4>Error Retrieving Users</h4>";
}
?>