<?php
include_once "./../functions/admin_management.php";
if (isset($_GET["ban_user"])) {
	Admin_management::toggleBanUserAccount($_GET["ban_user"]);
	unset($_GET["ban_user"]);
}

$users = Admin_management::getAllUsers();
if ($users == "NO_USERS_FOUND") {
	echo "<h3>No Users Found</h3>";
	exit;
}
echo "<table>";
echo "<tr><th>First Name</th><th>Last Name</th><th>Email</th><th>Ban Status</th></tr>";
foreach ($users as $user) {
	echo "<tr>";
	echo "<td>" . $user['Email'] . "</td>";
	echo "<td>" . $user['First_Name'] . "</td>";
	echo "<td>" . $user['Last_Name'] . "</td>";
	echo "<td>" . ($user['BANNED_STATUS'] == 1 ? "Banned" : "Active") . "</td>";
	echo "<td>" . "<a href=\"./display_all_users.php?ban_user=" . $user['Email'] . "\">Toggle Ban</a></td>";
	echo "</tr>";
}
echo "</table>";
