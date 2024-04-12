<?php
require_once("./../server/functions/admin_management.php");
$users = Admin_management::getInactiveUsers();

if (is_array($users)) {
    if (count($users) == 0) {
        echo "<h4>No Users Found</h4>";
    } else {
        echo "<table id=\"user_table\">";
        echo "<caption> Inactive Users Information </caption>";
        echo "<tr><th scope=\"col\">First Name</th><th scope=\"col\">Last Name</th><th scope=\"col\">Email</th><th scope=\"col\">Login's This Month</th>";
        echo "<th scope=\"col\">Ban Status</th><th scope=\"col\">Total Comments</th><th scope=\"col\">Toggle Ban</th><th scope=\"col\">User Info</th></tr>";
        foreach ($users as $user) {
            $user_id = User_management::getUserID($user['Email']);

            $numComments = User_management::getCommentCount($user_id);
            
            echo "<tr>";
            echo "<td>" . $user['First_Name'] . "</td>";
            echo "<td>" . $user['Last_Name'] . "</td>";
            echo "<td>" . $user['Email'] . "</td>";
            echo "<td>" . Login_tracking::getCountForCurrentMonth($user_id) . "</td>";
            echo "<td>" . ($user['BANNED_STATUS'] == 1 ? "Banned" : "Not Banned") . "</td>";
            echo "<td>" . $numComments;
            echo "</td>";
            if (Admin_management::checkAdminExists($user['Email']) == 'ADMIN_NOT_EXIST') {
                echo "<td>" . "<button class = \"detail-button\" id=\"toggle_ban_user\"><a href=\"./display_users.php?toggle_ban_userID=" . $user_id . "\" >Toggle Ban</a></button></td>";
            } else {
                echo "<td> Admin </td>";
            }
            
            echo "<td><button class = \"detail-button\"><a href=\"./track_user_comments.php?user_id=" . $user_id . "\">User Details</a></button></td>";
            echo "</tr>";
        }
        echo "</table>";
    }
} else {
    echo "<h4>Error Retrieving Users</h4>";
}

