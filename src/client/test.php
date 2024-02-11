<?php
include_once './../server/functions/user_management.php';
include_once './../server/functions/admin_managment.php';
echo "createUser function :" . createUser("test2@gmail.com", "TEST", "USER", MD5("password")) . "<br>";
echo "userExists function :" . userExists("tet2@gmail.com") . "<br>";
echo "validateUser function :" . validateUserLogin("test@gmail.com", MD5("password")) . "<br>";
echo "validateAdmin function :" . validateAdminLogin("test@gmail.com", MD5("password")) . "<br>";
