<?php
session_start();
require_once("./../server/functions/item_info.php");
require_once("./../server/functions/comments.php");
require_once("./../server/GLOBAL_VARS.php");

// Add this to every page to modify breadcrumbs
if (!isset($_SESSION['BREADCRUMBS'])) {
	$_SESSION['BREADCRUMBS'] = array();
}

$current_page = ["ADMIN", "./admin_panel.php"];
$last_item_index = count($_SESSION['BREADCRUMBS']) - 1;
// Add the current page only if it's not the last one already in the breadcrumb trail
if ($last_item_index < 0 || $_SESSION['BREADCRUMBS'][$last_item_index][0] != $current_page[0] && (!in_array($current_page, $_SESSION['BREADCRUMBS']))) {
	array_push($_SESSION['BREADCRUMBS'], $current_page);
}
?>
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Admin Panel</title>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<script type="text/javascript" src="./jquery-library/jquery-3.1.1.min.js"></script>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<script type="text/javascript" src="./jquery-library/jquery-3.1.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="./css/global.css" />
	<link rel="stylesheet" href="./css/admin_panel.css" />
</head>
<!-- Refer to https://www.w3schools.com/html/html_layout.asp for Layout Design -->

<body class="default_body">
	<?php echo "<h3>" . $ADMIN_PANEL_HEADING . "</h3>" ?>
	<nav>
		<a href="#">Home</a>
		<a href="./admin_login.php">Logout</a>
		<?php
		if (isset($_SESSION['LOGGED_IN_ADMIN'])) {
			echo "<a href=\"./admin_panel.php\">Admin</a>";
		}
		?>
	</nav>
	<?php include_once './../server/breadcrumbs.php' ?>
	<div>

		<form id="Input_Form" method="POST" action="./../server/addItemToStore.php">
			<fieldset>
				<legend>Add New Item</legend>
				<div class="
			container
			text-center">
					<div clas="row">
						<div class="col">
							<input type="text" name="ITEM_NAME" placeholder="Item Name">
							<input type="text" name="ITEM_EXTERNAL_LINK" placeholder="External Link">
							<input type="text" name="ITEM_NAME" placeholder="Item Name">
							<input type="text" name="EXTERNAL_LINK" placeholder="External Link">
							<label for="ITEM_PRICE">Item Price</label>
							<input type="number" name="ITEM_PRICE" pattern="[0-9]{1,2}" step="0.01">
							<?php
							$stores = getAllStoreList();
							if (count($stores) == 0) {
								echo $stores;
							} else {
								echo "<select id = \"store_select\" 
								name = \"STORE_ID\"
								class=\"select_dropdown\">";
								foreach ($stores as $key => $store) {
									echo "<option value=\"" . $store['STORE_ID'] . "\" >" . $store['STORE_NAME'] . "</option>";
								}
								echo "</select>";
							}
							?>
						</div>
						<div class="col">
							<textarea type="text" name="ITEM_DESCRIPTION" placeholder="Description..."></textarea>
							<input type="file" name="PRODUCT_IMAGE">
							<textarea type="text" name="DESCRIPTION" placeholder="Description..."></textarea>
							<input type="file" name="PRODUCT_IMAGE">
						</div>
					</div>
				</div>
				<button type="submit">Add Item</button>
				<input type="reset">
			</fieldset>
		</form>
		<?php
		if (isset($_GET['message'])) {
			echo "<p>" . $_GET['message'] . "</p><br>";
			unset($_GET['message']);
		}
		?>
	</div>
	</div>
	<footer>
		<p>Footer</p>
	</footer>
</body>