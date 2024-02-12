<?php session_start();
require_once("./../server/functions/item_info.php");
require_once("./../server/functions/comments.php");
require_once("./GLOBAL_VARS.php");

if (!isset($_SESSION['SELECTED_STORE'])) {
	$_SESSION['SELECTED_STORE'] = 1;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Login Page</title>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible"
		content="IE=edge" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>
	<meta name="viewport"
		content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet"
		href="./css/global.css" />
	<link rel="stylesheet"
		href="./css/home.css" />
</head>
<!-- Refer to https://www.w3schools.com/html/html_layout.asp for Layout Design -->

<body class="default_body">
	<header>Welcome to our Grocery Tracker</header>
	<nav>
		<a href="#">Home</a>
		<a href="./admin_login.php">Logout</a>
	</nav>
	<div id="search_bar">Search Bar</div>
	<?php
	$item_IDS = getAllItems_IDS_AtStore($_SESSION["SELECTED_STORE"]);
	if ($item_IDS != "NO_ITEMS_AVAILABLE_AT_STORE") {
		echo "<h3>Items Available at store = " . count($item_IDS) . "</h3>";
	} else {
		echo "<h3> No Items Available</h3>";
	}

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

	?>
	<footer>
		<p>Footer</p>
	</footer>

</body>