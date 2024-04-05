<?php

include_once "./functions/admin_management.php";

// Get JSON as a string
$json_str = file_get_contents('php://input');

// Decode the JSON into an associative array
$data = json_decode($json_str, true);

// Input validation and sanitization
$itemName = $data['ITEM_NAME'] ?? null;
$description = $data['DESCRIPTION'] ?? null;
$storeId = $data['STORE_ID'] ?? null;
$itemPrice = $data['ITEM_PRICE'] ?? null;
$externalLink = $data['EXTERNAL_LINK'] ?? null;

// Error handling and message display
if (!empty($itemName) && !empty($description) && !empty($storeId) && !empty($itemPrice) && !empty($externalLink)) {
    $resp = Admin_management::addItem($itemName, $description, $storeId, $itemPrice, $externalLink);
    $response = ["status" => $resp];
} else {
    $response = ["status" => "Not All Values Provided"];
}

// Set the Content-Type header
header('Content-Type: application/json');
$httpResponseCode = 200; // OK
http_response_code($httpResponseCode);
echo json_encode($response);
