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
echo "checkAdminExists Should not exist : function :" . Admin_management::checkAdminExists("test1@gmail.com") . "<br>";
echo "checkAdminExists Should Exist : function :" .  Admin_management::checkAdminExists("test@gmail.com") . "<br>";
echo "checkuserexists Should Exist : function :" .  User_management::validateUserLogin("test@gmail.com", "5f4dcc3b5aa765d61d8327deb882cf99") . "<br>";
echo "checkuserexists Should Exist : function :" .  User_management::validateUserLogin("test@gmail.com", "wrongpassword") . "<br>";
echo "GetItemID Item Exists : " . Admin_management::getItemID("Smartphone", 1) . "<br/>";
