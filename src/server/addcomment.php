<?php
include_once './functions/comments.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['COMMENT_TEXT']) & isset($_POST['ITEM_ID']) & isset($_POST['USER_EMAIL'])) {
		$resp = addComment($_POST['COMMENT_TEXT'], $_POST['ITEM_ID'], $_POST['USER_EMAIL']);
		return $resp;
	}
}
