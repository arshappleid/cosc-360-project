<?php

include_once './functions/comments.php';
if ($_SERVER['METHOD'] = "GET" && isset($_GET['commentId'])) {
	$resp = Comments::deleteComment($_GET['commentId']);
	if (isset($_SERVER['HTTP_REFERER'])) {
		header('Location: ' . $_SERVER['HTTP_REFERER']);
		exit;
	} else {
		header('Location: ../client/home.php');
		exit;
	}
}
