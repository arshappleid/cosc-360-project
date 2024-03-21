<?php
session_start();
include_once "./functions/admin_management.php";
// Input validation and sanitization
$itemName = $_POST['ITEM_NAME'];
$description = $_POST['DESCRIPTION'];
$storeId = $_POST['STORE_ID'];
$itemPrice = $_POST['ITEM_PRICE'];
$externalLink = $_POST['EXTERNAL_LINK'];

// Error handling and message display
if (
	!empty($itemName) && !empty($description) && !empty($storeId) && !empty($itemPrice) &&
	!empty($externalLink)
) {
	$resp = addItem($itemName, $description, $storeId, $itemPrice, $externalLink);
	$_SESSION["message"] = $resp;
	header('Location: ../client/admin_panel.php');
} else {
	$_SESSION["message"] = "Not All Values Provided";
	header('Location: ../client/admin_panel.php');
}
