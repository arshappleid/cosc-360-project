<?php

include './functions/admin_management.php';

if (isset($_GET["ban_user"])) {
	Admin_management::toggleBanUserAccount($_GET["ban_user"]);
	unset($_GET["ban_user"]);
}

$users = Admin_management::getAllUsers();

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
            echo "</td>";
	        echo "<td>" ;
            echo '<form action="../server/ban_user.php" method="post">' . 
                    '<input type="hidden" name="userEmail" value="' . $user['Email'] . '">' .
                    '<button type="submit" class="detail-button">Toggle Ban</button>' 
                    .'</form></td>';
            echo "<td><button class = \"detail-button\"><a href=\"./track_user_comments.php?user_id=" . $user_id . "\">User Details</a></button></td>";
            echo "</tr>";
        }
        echo "</table>";
    }
} else {
    echo "<h4>Error Retrieving Users</h4>";
}
