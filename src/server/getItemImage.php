<?php
require_once './functions/db_connection.php';

if (isset($_GET['ITEM_ID'])) {
	$imageData = getImage("ITEMS", "ITEM_ID", $_GET['ITEM_ID']);
	if ($imageData['status'] === "SUCCESS") {
		header('Content-Type: ' . $imageData['mime']);
		echo $imageData['data'];
		exit;
	} else {
		// Handle other statuses accordingly
		echo $imageData['status'];
	}
} else {
	echo "COULD NOT GET ITEM_ID";
}
