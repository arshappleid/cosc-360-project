<?php

session_start();
include_once "./functions/admin_management.php";
include_once "./functions/Image.php";
if ($_SERVER['REQUEST_METHOD'] != "POST") {
	$_SESSION["message"] = "INVALID RESPONSE";
	header('Location: ' . $_SERVER['HTTP_REFERER']);
}
// Input validation and sanitization
$itemName = $_POST['ITEM_NAME'];
$description = $_POST['ITEM_DESCRIPTION'];
$storeId = $_POST['STORE_ID'];
$category = $_POST['ITEM_CATEGORY'];
$itemPrice = $_POST['ITEM_PRICE'];
$externalLink = $_POST['ITEM_EXTERNAL_LINK'];

// Error handling and message display
if (
	!empty($itemName) && !empty($description) && !empty($storeId) && !empty($itemPrice) &&
	!empty($externalLink)
) {
	$resp = Admin_management::addItem($itemName, $description, $storeId, $itemPrice, $externalLink, $category);
	if (isset($_FILES['PRODUCT_IMAGE']) && is_uploaded_file($_FILES['PRODUCT_IMAGE']['tmp_name'])) {
		$resp = $resp . "<br>" . Image::upload("ITEMS", "ITEM_NAME", $itemName, "PRODUCT_IMAGE");
	} else {
		$resp = $resp . "<br>" . "Image was not Uploaded Successfully";
	}
	$_SESSION["message"] = str_replace("_", " ", $resp);
} else {
	$_SESSION["message"] = "Not All Values Provided";
}

if (isset($_SERVER['HTTP_REFERER'])) {
	header('Location: ' . $_SERVER['HTTP_REFERER']);
	exit;
} else {
	header('Location: ../client/home/add_items.php');
	exit;
}
