<?php
session_start();
include '../server/functions/item_info.php';
require_once("./../server/functions/item_info.php");
require_once("./../server/functions/comments.php");

$storeId = $_GET['SELECTED_STORE'];
$item_IDS = getAllItems_IDS_AtStore($storeId);

if (isset($storeId)) {
	foreach ($item_IDS as $item_ID) {
		$item = getItemInfo($item_ID);
		if ($item == "NO_ITEM_FOUND") continue;
		echo "<section>";
		echo "<aside>";
		echo "<img>";
		echo "<h3>" . $item['ITEM_NAME'] . "</h3>";
		echo "</aside>";
		echo "<article>";


		$comments = getAllCommentsForItem($item_ID);
		if (is_array($comments)) {
			if (count($comments) == 0) {
				echo "<h4>No Comments Yet.</h4>";
			} else {
				echo "<table id = \"comment_table\">";
				foreach ($comments as $comment) {
					echo "<tr>";
					echo "<td>" . getUser_First_Last_Name($comment['USER_ID']) . "</td>";
					echo "<td>" . $comment['COMMENT_TEXT'] . "</td>";
					echo "<td>" . (new DateTime($comment['DATE_TIME_ADDED']))->format($COMMENT_DATE_TIME_FORMAT) . "</td>";
					echo "</tr>";
				}
				echo "</table>";
			}
		}
		echo "</article>";
		echo "</section>";
	}
}
