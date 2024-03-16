<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once './../server/functions/user_management.php';
include_once './../server/functions/admin_management.php';
include_once './../server/functions/comments.php';
include_once './../server/functions/item_info.php';
include_once './../server/functions/db_connection.php';
echo "checkAdminExists Should not exist : function :" . checkAdminExists("test1@gmail.com") . "<br>";
echo "checkAdminExists Should Exist : function :" .  checkAdminExists("test@gmail.com") . "<br>";
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Image Display</title>
</head>

<body>
	<?php
	if (isset($_SESSION['EMAIL'])) {
		echo "<img src=\"./../server/getUserImages.php?email=" . urlencode($_SESSION['EMAIL']) . "\" alt=\"\"><br>";
	} else {
		echo "SESSION VARIABLE NOT SET";
	}
	echo "<img src=\"./../server/getUserImages.php?email=test2@gmail.com\" alt=\"Admin Image\"><br>";
	?>
</body>

</html>
<?php

echo "createUser function :" . createUser("test2@gmail.com", "TEST", "USER", MD5("password")) . "<br>";
echo "createUser function :" . createUser("test1@gmail.com", "test", "user", MD5("password")) . "<br>";
echo "userExists -Should Exist-function :" . userExists("test@gmail.com") . "<br>";
echo "userExists - Should Not Exist -function :" . userExists("tet2@gmail.com") . "<br>";
echo "validateUser function :" . validateUserLogin("test@gmail.com", MD5("password")) . "<br>";
echo "validateAdmin function :" . validateAdminLogin("test@gmail.com", MD5("password")) . "<br>";

echo "userUpdatePassword function :" . userUpdatePassword("test@gmail.com", MD5("password"), MD5("newpassword")) .
	"<br>";
echo "userUpdatePassword reset it back function :" . userUpdatePassword(
	"test@gmail.com",
	MD5("newpassword"),
	MD5("password")
) . "<br>";

echo "editUserFirstName function :" . editUserFirstName("test@gmail.com", "New Name") . "<br>";

echo "editUserLastName function :" . editUserLastName("test@gmail.com", "New LastName") . "<br>";

echo "toggleBanUserAccount function :" . toggleBanUserAccount("test@gmail.com") . "<br>";
echo "deleteComment function :" . deleteComment(1) . "<br>";
echo "addComment function :" . addComment("MY New comment", 1, "test@gmail.com") . "<br>";
echo "itemExists should exist function :" . itemExists(1) . "<br>";
echo "itemExists shot not function :" . itemExists(99) . "<br>";
echo "commentExists function :" . commentExists(1) . "<br>";
echo "getUserID function :" . getUserID("test@gmail.com") . "<br>";
echo "getAllCommentsForItem - should have no comments - function :" . getAllCommentsForItem(99) . "<br>";
//echo "getAllCommentsForItem - should have comments - function :" . implode("<br>", getAllCommentsForItem(1)) . "<br>";
echo "getBanStatus function :" . getBanStatus("test@gmail.com") . "<br>";
echo "deleteUser function :" . deleteUser("test@gmail.com") . "<br>";
echo "createUser function :" . createUser("test77@gmail.com", "test", "user", MD5("password")) . "<br>";
echo "getAllItems_IDS_AtStore function :" . implode(",", getAllItems_IDS_AtStore(2)) . "<br>";
