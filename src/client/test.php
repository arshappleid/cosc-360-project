<?php
include_once './../server/functions/user_management.php';
echo "<h3>" . validateUserLogin("test@gmail.com", MD5("password")) . "</h3>";
