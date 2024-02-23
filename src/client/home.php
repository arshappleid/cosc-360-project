<?php session_start();
require_once("./../server/functions/item_info.php");
require_once("./../server/functions/comments.php");
require_once("./../server/GLOBAL_VARS.php");


?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Login Page</title>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<script type="text/javascript" src="./jquery-library/jquery-3.1.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>

	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="./css/global.css" />
	<link rel="stylesheet" href="./css/home.css" />

</head>
<!-- Refer to https://www.w3schools.com/html/html_layout.asp for Layout Design -->

<body class="default_body">
	<header>Welcome to our Grocery Tracker</header>
	<nav>
		<a href="#">Home</a>
		<a href="./admin_login.php">Logout</a>
	</nav>
	<div id="search_bar">
		<input type="text" placeholder="Search Items...">
		<?php
		$stores = getAllStoreList();
		if (count($stores) == 0) {
			echo $stores;
		} else {
			echo "<select id = \"store_select\" class=\"select_dropdown\">";
			foreach ($stores as $key => $store) {
				echo "<option value=\"" . $store['STORE_ID'] . "\" >" . $store['STORE_NAME'] . "</option>";
			}
			echo "</select>";
		}
		?>


	</div>
	<?php
	echo "<div id = \"item_list\"></div>";

	?>
	<footer>
		<p>Footer</p>
	</footer>

	<!--Since we would want to run these scripts after the pages have loaded.-->
	<script type="text/javascript" src="./scripts/change_store.js"></script>
	<?php echo "<script>
	updateGlobalVariable(1);
	</script>";
	?>

</body>