<?php
include_once './functions/comments.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['COMMENT_TEXT']) & isset($_POST['ITEM_ID']) & isset($_POST['USER_EMAIL'])) {
		$resp = Comments::addComment($_POST['COMMENT_TEXT'], $_POST['ITEM_ID'], $_POST['USER_EMAIL']);
		//echo $resp;
		//return $resp;
		header('Location: ../client/home.php');
	}
}
