<?php
session_start();
require_once("./../../server/functions/item_info.php");
require_once("./../../server/functions/comments.php");
require_once("./../../server/GLOBAL_VARS.php");

if (!isset($_SESSION['BREADCRUMBS'])) {
	$_SESSION['BREADCRUMBS'] = array();
}

$current_page = ["add item", "./add_items.php"];
$last_item_index = count($_SESSION['BREADCRUMBS']) - 1;

// Add the current page only if it's not the last one already in the breadcrumb trail
if ($last_item_index < 0 || $_SESSION['BREADCRUMBS'][$last_item_index][0] != $current_page[0] && (!in_array($current_page, $_SESSION['BREADCRUMBS']))) {
	array_push($_SESSION['BREADCRUMBS'], $current_page);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Admin Panel</title>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<script type="text/javascript" src="./../jquery-library/jquery-3.1.1.min.js"></script>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="./../css/global.css" />
	<link rel="stylesheet" href="./../css/admin_panel.css" />
	<link rel="stylesheet" href="../css/mobile/global.css"  media="screen and (max-width: 480px)" /> 

	<script type="text/javascript" src="./../scripts/add_items.js" defer></script>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

</head>

<body>

	<div class="container">
		<div class="headerblack">
			<a href="../home.php" class="home-button">Home</a>
			<?php
			$name = User_management::getUser_First_Last_Name(User_management::getUserID($_SESSION['USER_EMAIL']));
			echo "<p class=\"greeting-text\"> Hello Admin :) , " . $name  . " </p>";
			echo "<a href=\"login.php\" class=\"login-button\">";
			if (isset($_SESSION['ADMIN_EMAIL'])) {
				echo "Logout</a>";
			} else {
				echo "Login</a>";
			}
			?>
			</a>
		</div>

		<?php include_once './../../server/breadcrumbs.php' ?>
		<div class="underheadercontainer">
			<div class="overlay">
				<div class="form-container">
					<div class="radio-container">
						<label for="bulk-upload">Bulk Upload</label>
						<input type="radio" name="upload-type" id="bulk-upload" value="1">

						<label for="individual-upload">Individual Upload</label>
						<input type="radio" name="upload-type" id="individual-upload" checked value="0">

						<label for="new-category">Add New Category</label>
						<input type="radio" name="upload-type" id="new-category" value="0">
					</div>
					<form id="bulk-upload-form" style="display:none;" method="POST" action="./../../server/addItemToStore.php">
						<label for="PRODUCT_INFO">Upload Product Info</label>
						<input type="file" id="PRODUCT_INFO" name="PRODUCT_INFO">
						<?php
						$stores = Item_info::getAllStoreList();
						if (count($stores) == 0) {
							echo $stores;
						} else {
							echo "<select id = \"store_select\">";
							foreach ($stores as $key => $store) {
								echo "<option value=\"" . $store['STORE_ID'] . "\" >" . $store['STORE_NAME'] . "</option>";
							}
							echo "</select>";
						}
						?>
						<br>
						<button type="Submit">Add Items</button>
						<button type="Reset">Reset</button>
						<p id="bulk_message"></p>
					</form>


					<form id="individual-upload-form" method="POST" action="./../../server/addItemToStore.php" enctype="multipart/form-data">
						<fieldset>
							<legend>Add New Item</legend>
							<div class="row">
								<div class="col">
									<label for="ITEM_NAME" class="visually-hidden">Item Name</label>
									<input type="text" name="ITEM_NAME" id="ITEM_NAME" placeholder="Item Name">
									<label for="ITEM_EXTERNAL_LINK" class="visually-hidden">Item External Link</label>
									<input type="text" name="ITEM_EXTERNAL_LINK" id="ITEM_EXTERNAL_LINK" placeholder="External Link">
									<label for="ITEM_PRICE">Item Price $</label>
									<input type="number" name="ITEM_PRICE" placeholder="10.99" step="0.01">
									<?php
									$stores = Item_info::getAllStoreList();
									if (is_array($stores)) {
										echo "<label for=\"store_select\">Select Store</label><br>";
										echo "<select id=\"store_select\" name=\"STORE_ID\">";
										foreach ($stores as $key => $store) {
											echo "<option value=\"" . $store['STORE_ID'] . "\">" . $store['STORE_NAME'] . "</option>";
										}
										echo "</select>";
									}
									$categories = Item_info::getAllCategories();
									if (is_array($categories)) {
										echo "<br>";
										echo "<label for=\"category_select\">Select Category</label><br>";
										echo "<select id=\"category_select\" name=\"ITEM_CATEGORY\">";
										foreach ($categories as $category) {
											echo "<option value=\"" . $category . "\">" . $category  . "</option>";
										}
										echo "</select>";
									}

									?>
								</div>
								<div class="col">
									<label for="ITEM_DESCRIPTION" class="visually-hidden">Item Description </label>
									<textarea name="ITEM_DESCRIPTION" id="ITEM_DESCRIPTION" placeholder="Item Description..."></textarea><br>
									<label for="PRODUCT_IMAGE">Product Image</label>
									<input type="file" name="PRODUCT_IMAGE" id="PRODUCT_IMAGE">
								</div>
							</div>
							<button type="submit">Add Item</button>
							<button type="reset">Reset</button>
							<p id="individual_item_message"></p>
						</fieldset>
					</form>

					<form id="new-category-form" action="./../../server/addCategory.php" style="display:none;" method="GET">
						<fieldset>
							<legend>Add New Category</legend>
							<input type="text" placeholder="Category Name" name="CATEGORY_NAME">


							<textarea type="text" placeholder="Description " name="CATEGORY_DESCRIPTION"></textarea>
							<br>

							<button type="submit">Add Category</button>
						</fieldset>
					</form>
					<?php
					if (isset($_SESSION["message"])) {
						echo "<p id = \"message\" style = \"color:red;text-align:center;\">" . $_SESSION["message"] . "</p>";
						unset($_SESSION["message"]);
					}
					?>
				</div>
			</div>
			<div class="triangleextendblack"></div>
			<div class="triangle-element"></div>
		</div>


	</div>
	</div>
	<footer>
		<div class="footerblack">
			<nav>
				<ul>
					<li><a href="home.php">Home</a></li>
					<?php
					if (isset($_SESSION['USER_EMAIL']) || isset($_SESSION['ADMIN_EMAIL'])) {
						echo "<li><a href=\"account_page.php\">Account</a></li>";
					} else {
						echo "<li><a href=\"create_account.php\">Create Account</a></li>
					<li><a href=\"login.php\">Login</a></li>
					<li><a href=\"admin_login.php\">Admin Login</a></li>";
					}
					?>
				</ul>
			</nav>
			<p>&copy; Banana Hammock 2024</p>
		</div>
	</footer>
</body>