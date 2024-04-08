<?php
session_start();
if (!isset($_SESSION['ADMIN_EMAIL'])) {
	header('Location: ./bad_navigation.php');
}

require_once("./../server/functions/item_info.php");
require_once("./../server/functions/admin_management.php");
require_once("./../server/functions/login_tracking.php");
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
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="css/display_users.css" />
	<link rel="stylesheet" href="css/global.css" />
</head>

<body>

	<div class="container">
		<div class="headerblack">
			<a href="home.php" class="home-button">Home</a>
			<?php
			if (isset($_SESSION['USER_EMAIL']) || isset($_SESSION['ADMIN_EMAIL'])) {
				echo "<a href=\"login.php\" class=\"login-button\">";
				//echo "<img id = \"avatar_img\" src = \"./../server/getUserImages.php>";
				echo "Logout</a>";
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

		<?php //include_once './../server/breadcrumbs.php' ?>

		<div class="underheadercontainer">
			<div class="overlay">
					<div class="user-search-container">
							<label for="user-search-input" class="visually-hidden">Enter keywords to search</label> 
							<input type="text" id="user-search-input" placeholder="Search by first name, last name or email...">
							<select id = "user_select" name="user_select" class="user_select_dropdown">
								<option value="all_users">All Users </option>
								<option value= "active_users">Active Users</option>
								<option value= "inactive_users">Inactive Users</option>
							</select>
							<button type="button" id="user-search-button">Search</button>
					</div>
					<div class = "table-container">
						<?php
						echo "<table id=\"user_table\"></table>";
						//Table rows will be populated dynamically
						?>
					</div>
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
	<script type="text/javascript" src="./scripts/display_users.js"></script>
</body>