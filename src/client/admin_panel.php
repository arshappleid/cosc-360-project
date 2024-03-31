<?php
session_start();
require_once("./../server/functions/item_info.php");
require_once("./../server/functions/comments.php");
require_once("./../server/GLOBAL_VARS.php");

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Admin Panel</title>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<script type="text/javascript" src="./jquery-library/jquery-3.1.1.min.js"></script>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="./css/global.css" />
	<link rel="stylesheet" href="./css/admin_panel.css" />

	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

</head>
<!-- Refer to https://www.w3schools.com/html/html_layout.asp for Layout Design -->

<body>

	<div class="container">
		<div class="headerblack">
			<a href="home.php" class="home-button">Home</a>
			<?php
			if (isset($_SESSION['ADMIN_EMAIL'])) {
				echo "<a href=\"login.php\" class=\"login-button\">";
				//echo "<img id = \"avatar_img\" src = \"./../server/getUserImages.php>";
				echo "Logout</a>";
				echo "<a href=\"display_users.php\"
				class=\"admin-login-button\">Users</a>";
			} else {
				echo "<a href=\"login.php\" class=\"login-button\">";
				echo "Login</a>";
			}
			?>
			</a>
		</div>

		<div class="headeryellow">
			<div class="search-container">
				<input type="text" placeholder="Search...">
				<?php
				$stores = Item_info::getAllStoreList();
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
				<button type="submit">Search</button>
			</div>
		</div>
		<div class="underheadercontainer">
			<div class="overlay">

				<label for="bulk-upload">Bulk Upload</label>
				<input type="radio" name="upload-type" id="bulk-upload" value="1">

				<label for="individual-upload">Individual Upload</label>
				<input type="radio" name="upload-type" id="individual-upload" checked value="0">

				<form id="fileUploadForm" style="display:none;" method="POST" action="./../server/addItemToStore.php">
					<label for="PRODUCT_IMAGE">Upload Product Info</label>
					<input type="file" id="PRODUCT_INFO" name="PRODUCT_INFO">
					<?php
					$stores = Item_info::getAllStoreList();
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
					<br>
					<button type="Submit">Add Items</button>
					<button type="Reset">Reset</button>
					<p id="message"></p>
				</form>


				<form id="Input_Form" method="POST">
					<fieldset>
						<legend>Add New Item</legend>
						<div class="row">
							<div class="col">
								<input type="text" name="ITEM_NAME" placeholder="Item Name">
								<input type="text" name="ITEM_EXTERNAL_LINK" placeholder="External Link">
								<?php
								$stores = Item_info::getAllStoreList();
								if (count($stores) > 0) {
									echo "<select id=\"store_select\" name=\"STORE_ID\" class=\"select_dropdown\">";
									foreach ($stores as $key => $store) {
										echo "<option value=\"" . $store['STORE_ID'] . "\">" . $store['STORE_NAME'] . "</option>";
									}
									echo "</select>";
								}
								?>
							</div>
							<div class="col">
								<textarea name="ITEM_DESCRIPTION" placeholder="Description..."></textarea><br>
								<label for="PRODUCT_IMAGE">Product Image : </label>
								<input type="file" name="PRODUCT_IMAGE">
							</div>
						</div>
						<button type="submit">Add Item</button>
						<button type="reset">Reset</button>
					</fieldset>
				</form>
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
				$('#fileUploadForm').show();
				$('#Input_Form').hide();
			});

			// When 'Individual Upload' is clicked
			$('#individual-upload').click(function() {
				$('#Input_Form').show();
				$('#fileUploadForm').hide();
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
						STORE_ID: storeID
					};

					return fetch('./../server/addMultipleItemToStore.php', {
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