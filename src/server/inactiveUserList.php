<?php

include './functions/admin_management.php';
//include './functions/user_management.php';
include './functions/login_tracking.php';

if (isset($_GET["ban_user"])) {
	Admin_management::toggleBanUserAccount($_GET["ban_user"]);
	unset($_GET["ban_user"]);
}

$users = Admin_management::getInactiveUsers();

if (is_array($users)) {
    if (count($users) == 0) {
        echo "<h4>No Users Found</h4>";
    } else {
        echo "<table id=\"user_table\">";
        echo "<caption> All Users Information </caption>";
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
            echo "<td>" . ($user['BANNED_STATUS'] == 1 ? "Banned" : "Active") . "</td>";
            echo "<td>" . $numComments;

            if ($numComments>0){
                echo "  <a href=\"./track_user_comments.php?user_id=" . $user_id . "\">Track</a>";
            }

            echo "</td>";
	        echo "<td>" . "<a href=\"./display_users.php?ban_user=" . $user['Email'] . "\">Toggle Ban</a></td>";
            echo "<td><a href=\"./track_user_comments.php?user_id=" . $user_id . "\">User Details</a></td>";
            //echo "<td><button>User Details</button>";
            echo "</tr>";
        }
        echo "</table>";
    }
} else {
    echo "<h4>Error Retrieving Users</h4>";
}

