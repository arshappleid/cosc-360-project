<?php
include_once './../server/functions/user_management.php';
echo "createUser function :" . createUser("test2@gmail.com", "TEST", "USER", MD5("password")) . "<br>";
echo "userExists function :" . userExists("tet2@gmail.com") . "<br>";
