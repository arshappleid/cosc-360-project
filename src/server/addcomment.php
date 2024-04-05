<?php

include_once './functions/comments.php';
try {
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if (isset($_POST['COMMENT_TEXT']) & isset($_POST['ITEM_ID']) & isset($_POST['USER_EMAIL'])) {
			if ($_POST['COMMENT_TEXT'] != "") {
				$resp = Comments::addComment(trim($_POST['COMMENT_TEXT']), trim($_POST['ITEM_ID']), trim($_POST['USER_EMAIL']));
			}
		}
	}
} catch (Exception $e) {
	echo "<script>console.error(" . json_encode($e->getMessage()) . ");</script>";
}
header('Location: ./../client/home.php');
exit;
