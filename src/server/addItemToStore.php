<?php
session_start();
include_once "./functions/admin_management.php";
// Input validation and sanitization
$itemName = $_POST['ITEM_NAME'];
$description = $_POST['DESCRIPTION'];
$storeId = $_POST['STORE_ID'];
$category = $_POST['ITEM_CATEGORY'];
$itemPrice = $_POST['ITEM_PRICE'];
$externalLink = $_POST['EXTERNAL_LINK'];

// Error handling and message display
if (
	!empty($itemName) && !empty($description) && !empty($storeId) && !empty($itemPrice) &&
	!empty($externalLink)
) {
	$resp = Admin_management::addItem($itemName, $description, $storeId, $itemPrice, $externalLink, $category);
	$_SESSION["message"] = $resp;
	header('Location: ../client/admin_panel.php');
} else {
	$_SESSION["message"] = "Not All Values Provided";
	header('Location: ../client/admin_panel.php');
}
