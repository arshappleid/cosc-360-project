<?php
session_start();
require_once("./../../server/functions/item_info.php");
require_once("./../../server/functions/comments.php");
require_once("./../../server/GLOBAL_VARS.php");

if (!isset($_SESSION['BREADCRUMBS'])) {
	$_SESSION['BREADCRUMBS'] = array();
}

$current_page = ["Admin Management", "./admin_management.php"];
$last_item_index = count($_SESSION['BREADCRUMBS']) - 1;

// Add the current page only if it's not the last one already in the breadcrumb trail
if ($last_item_index < 0 || $_SESSION['BREADCRUMBS'][$last_item_index][0] != $current_page[0] && (!in_array($current_page, $_SESSION['BREADCRUMBS']))) {
	array_push($_SESSION['BREADCRUMBS'], $current_page);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Admin Management</title>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>
	<script type="text/javascript" src="./scripts/home.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="css/global.css" />
	<link rel="stylesheet" href="css/admin_management.css" />

</head>

<body>
	<div class="container">
		<div class="headerblack">
			<a href="home.php" class="home-button">Home</a>
			<?php
			if (isset($_SESSION['USER_EMAIL']) || isset($_SESSION['ADMIN_EMAIL'])) {
				echo "<div style = \"display:flex;\">";
				echo "<a href=\"account_page.php\" class=\"login-button\">";
				//echo "<img id = \"avatar_img\" src = \"./../server/getUserImages.php>";
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
		<?php include_once './../../server/breadcrumbs.php' ?>
	</div>
	<div>
		<?php include_once './../../server/admin_management/display_all_users.php' ?>
	</div>
</body>