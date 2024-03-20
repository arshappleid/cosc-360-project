<?php

include_once './functions/admin_management.php';

if (isset($_POST['ITEM_NAME']) & isset($_POST['EXTERNAL_LINK']) & isset($_POST['DESCRIPTION']) & isset($_POST['STORE_ID']) & isset($_POST['ITEM_PRICE'])) {
	$resp = addItem($_POST['ITEM_NAME'], $_POST['DESCRIPTION'], $_POST['STORE_ID'], $_POST['ITEM_PRICE'], $_POST['EXTERNAL_LINK']);
	header('Location: ../client/admin_panel.php?message=' . $resp);
}

header('Location: ../client/admin_panel.php?message=NOT_ALL_VALUES_RECIEVED');
