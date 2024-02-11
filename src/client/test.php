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
echo "deleteComment function :" . deleteComment(1) . "<br>";
echo "addComment function :" . addComment("MY New comment", 1, "test@gmail.com") . "<br>";
echo "itemExists should exist function :" . itemExists(1) . "<br>";
echo "itemExists shot not function :" . itemExists(99) . "<br>";
echo "commentExists function :" . commentExists(1) . "<br>";
echo "getUserID function :" . getUserID("test@gmail.com") . "<br>";
echo "getAllCommentsForItem - should have no comments - function :" . getAllCommentsForItem(99) . "<br>";
echo "getAllCommentsForItem - should have comments -  function :" . implode("<br>", getAllCommentsForItem(1)) . "<br>";
echo "getBanStatus function :" . getBanStatus("test@gmail.com") . "<br>";
