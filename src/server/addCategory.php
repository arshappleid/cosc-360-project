<?php

session_start();
include_once './functions/comments.php';
try {
	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		if (isset($_GET['CATEGORY_NAME'])) {
			if ($_GET['CATEGORY_NAME'] != "" && $_GET['CATEGORY_DESCRIPTION'] != "") {
				$resp = Item_info::addCategory(trim(($_GET['CATEGORY_NAME'])), trim($_GET['CATEGORY_DESCRIPTION']));
				$_SESSION["message"] = str_replace("_", " ", $resp);
				header('Location: ../client/home.php');
			} else {
				$_SESSION["message"] = "Cannot Add Empty Category Names";
			}
		}
	}
} catch (Exception $e) {
	echo "<script>console.error(" . json_encode($e->getMessage()) . ");</script>";
}
if (isset($_SERVER['HTTP_REFERER'])) {
	header('Location: ' . $_SERVER['HTTP_REFERER']);
	exit;
} else {
	header('Location: ../client/home.php');
	exit;
}
