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

	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

</head>

<body>

	<div class="container">
		<div class="headerblack">
			<a href="../home.php" class="home-button">Home</a>
			<?php
			echo "<a href=\"login.php\" class=\"login-button\">";
			if (isset($_SESSION['ADMIN_EMAIL'])) {
				//echo "<img id = \"avatar_img\" src = \"./../server/getUserImages.php>";
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
				<div class = "form-container">
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
					<p id="message"></p>
				</form>


				<form id="individual-upload-form" method="POST">
					<fieldset>
						<legend>Add New Item</legend>
						<div class="row">
							<div class="col">
								<label for="ITEM_NAME" class="visually-hidden">Item Name</label>
								<input type="text" name="ITEM_NAME" id="ITEM_NAME" placeholder="Item Name">
								<label for="ITEM_EXTERNAL_LINK" class="visually-hidden">Item External Link</label>
								<input type="text" name="ITEM_EXTERNAL_LINK" id="ITEM_EXTERNAL_LINK" placeholder="External Link">
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
					echo "<p style = \"color:red;\">" . $_SESSION["message"] . "</p>";
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
				<p>&copy; Banana Hammock 2024</p>
			</nav>
		</div>
	</footer>
	<script>
		$(document).ready(function() {
			// When 'Bulk Upload' is clicked
			$('#bulk-upload').click(function() {
				$('#bulk-upload-form').show();
				$('#individual-upload-form').hide();
				$('#new-category-form').hide();
			});

			// When 'Individual Upload' is clicked
			$('#individual-upload').click(function() {
				$('#bulk-upload-form').hide();
				$('#individual-upload-form').show();
				$('#new-category-form').hide();
			});

			$('#new-category').click(function() {
				$('#bulk-upload-form').hide();
				$('#individual-upload-form').hide();
				$('#new-category-form').show();
			});
		});

		document.getElementById('fileUploadForm').addEventListener('submit', function(event) {
			event.preventDefault(); // Prevents the default form submission
			const file = document.getElementById('PRODUCT_INFO').files[0];
			if (!file) {
				alert('Please select a file');
				return;
			}

			const reader = new FileReader();

			reader.onload = async function(e) {
				const content = e.target.result;
				const rows = content.split('\n');
				const storeID = $('#fileUploadForm #store_select').val();
				const apiResponses = [];
				var itemsAdded = 0;
				// Use Promise.all to wait for all fetch calls to complete
				await Promise.all(rows.map(row => {
					const record = row.split(',').map(entry => entry.trim());
					if (record.length < 4) return;
					if (record.some(field => field === "")) {
						apiResponses.push({
							row: index + 1,
							reason: 'Invalid format or missing fields'
						});
						return; // Skip this record
					}
					const postData = {
						ITEM_NAME: record[0],
						DESCRIPTION: record[1],
						ITEM_PRICE: record[2],
						EXTERNAL_LINK: record[3],
						CATEGORY_NAME: record[4],
						STORE_ID: storeID
					};

					return fetch('./../../server/addMultipleItemToStore.php', {
							method: 'POST',
							headers: {
								'Content-Type': 'application/json',
							},
							body: JSON.stringify(postData)
						})
						.then(response => response.json())
						.then(data => {
							apiResponses.push(data.status);
							if (data.status === "ITEM_ADDED") {
								itemsAdded++;
							}
						})
				}));

				// Now, apiResponses is fully populated
				$("#message").text(apiResponses.join(", ") + "\n;Items Added : " +
					itemsAdded); // Corrected jQuery selector and join array

			};

			reader.readAsText(file);
		});
	</script>

</body>