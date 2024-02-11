<?php
include_once './../server/functions/user_management.php';
include_once './../server/functions/admin_management.php';
include_once './../server/functions/comments.php';
include_once './../server/functions/item_info.php';


echo "createUser function :" . createUser("test2@gmail.com", "TEST", "USER", MD5("password")) . "<br>";
echo "userExists function :" . userExists("tet2@gmail.com") . "<br>";
echo "validateUser function :" . validateUserLogin("test@gmail.com", MD5("password")) . "<br>";
echo "validateAdmin function :" . validateAdminLogin("test@gmail.com", MD5("password")) . "<br>";

echo "userUpdatePassword function :" . userUpdatePassword("test@gmail.com", MD5("password"), MD5("newpassword")) . "<br>";
echo "userUpdatePassword  reset it back function :" . userUpdatePassword("test@gmail.com", MD5("newpassword"), MD5("password")) . "<br>";

echo "editUserFirstName function :" . editUserFirstName("test@gmail.com", "New Name") . "<br>";

echo "editUserLastName function :" . editUserLastName("test@gmail.com", "New LastName") . "<br>";

echo "toggleBanUserAccount function :" . toggleBanUserAccount("test@gmail.com") . "<br>";
