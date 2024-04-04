<?php
session_start();
require_once("./../server/functions/item_info.php");
require_once("./../server/functions/comments.php");
require_once("./../server/GLOBAL_VARS.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Banana Hammock</title>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>
	<script type="text/javascript" src="./scripts/home.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="css/global.css" />
	<link rel="stylesheet" href="css/home.css" />
	</script>
</head>

<body>

	<div class="container">
		<div class="headerblack">
			<a href="home.php" class="home-button">Home</a>
			<?php

			if (isset($_SESSION['USER_EMAIL']) || isset($_SESSION['ADMIN_EMAIL'])) {
				echo "<div style = \"display:flex;\">";
				if (isset($_SESSION['USER_EMAIL'])) {
					echo "<a href=\"home/track_user_comments.php\" class=\"admin-login-button\" >History</a>";
				}

				if (isset($_SESSION['ADMIN_EMAIL'])) {
					echo "<a href=\"display_users.php\" class=\"admin-management-button\" >Admin Management</a>";
				}
				echo "<a href=\"account_page.php\" class=\"login-button\">";
				echo "Account</a>";
				echo "</div>";
			} else {
				echo "<a href=\"login.php\" class=\"login-button\">";
				echo "Login</a>";
			}
			?>
			</a>
			<?php
			if (!isset($_SESSION['USER_EMAIL']) & !isset($_SESSION['ADMIN_EMAIL'])) {
				echo "<a href=\"admin_login.php\"
				class=\"admin-login-button\">Admin Login</a>";
				echo "<a href=\"create_account.php\"
				class=\"create-account-button\">Create Account</a>";
			}
			?>
		</div>

		<div class="headeryellow">
			<div class="search-container">
				<input type="text" id="search-input" placeholder="Search...">
				<?php
				$stores = Item_info::getAllStoreList();
				if (count($stores) == 0) {
					echo $stores;
				} else {
					echo "<select id = \"store_select\" class=\"select_dropdown\">";
					echo "<option value=\"all\">All Stores</option>";
					foreach ($stores as $key => $store) {
						echo "<option value=\"" . $store['STORE_ID'] . "\" >" . $store['STORE_NAME'] . "</option>";
					}
					echo "</select>";
				}
				?>
				<button type="button" id="search-button">Search</button>
			</div>
		</div>

		<?php include_once './../server/breadcrumbs.php' ?>
		<?php include_once './../server/weather.php' ?>
		<div class="underheadercontainer">
			<div class="overlay">
				<?php
				echo "<div id = \"item_list\"></div>";
				//echo '<pre>' . print_r($_SESSION, true) . '</pre>';
				?>
			</div>
			<div class="triangleextendblack"></div>
			<div class="triangle-element"></div>
		</div>
	</div>
	<footer>
		<div>
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
	<?php
	echo "<script type=\"text/javascript\" src=\"./scripts/home.js\"></script>";
	?>

</body>