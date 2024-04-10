<?php

require_once './functions/item_info.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$ITEM_ID = trim($_POST['ITEM_ID']);
	$result = Item_info::upvoteItem(intval($ITEM_ID));
}

header("Location: ./../client/home.php");
