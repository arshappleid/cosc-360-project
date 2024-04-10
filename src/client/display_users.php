<?php
session_start();
require_once("./../server/functions/item_info.php");
require_once("./../server/functions/admin_management.php");
require_once("./../server/GLOBAL_VARS.php");

if (!isset($_SESSION['ADMIN_EMAIL'])) {
	header('Location: ./bad_navigation.php');
}
//getting the user email from teh user ID via the get request, so the email doesnt have to be passed through the get request 
if (isset($_GET["toggle_ban_userID"])) {
	$bannedUserID = $_GET["toggle_ban_userID"];
	$bannedUserEmail = User_management::getAllUserDataFromID($bannedUserID)['Email'];
	Admin_management::toggleBanUserAccount($bannedUserEmail);
    unset($_GET["toggle_ban_userID"]);
}

if (!isset($_SESSION['BREADCRUMBS'])) {
	$_SESSION['BREADCRUMBS'] = array();
}

$current_page = ["display users", "./display_users.php"];
$last_item_index = count($_SESSION['BREADCRUMBS']) - 1;

// Add the current page only if it's not the last one already in the breadcrumb trail
if ($last_item_index < 0 || $_SESSION['BREADCRUMBS'][$last_item_index][0] != $current_page[0] && (!in_array($current_page, $_SESSION['BREADCRUMBS']))) {
	array_push($_SESSION['BREADCRUMBS'], $current_page);
}


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
					<?php include_once './../server/breadcrumbs.php' ?>
		<div class="underheadercontainer">
			<div class="overlay">
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