<?php

session_start();
require_once("./../server/functions/item_info.php");
if (!isset($_SESSION['SELECTED_STORE'])) {
	$_SESSION['SELECTED_STORE'] = 1;
}
$items = Item_info::getAllItems_IDS_AtStore($_SESSION['SELECTED_STORE']);



echo "<section>";
echo "<aside>";
echo "<h3>Item1</h3>";
echo "</aside>";
echo "<article>";
echo "<h3>Item 1 Comment</h3>";
echo "</article>";
echo "</section>";
