<?php
session_start();
if (!isset($_SESSION['ADMIN_EMAIL'])) {
	header('Location: ./bad_navigation.php');
}
require_once "./../server/functions/item_info.php";
