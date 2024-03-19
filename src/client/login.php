<?php
session_start();
require_once("./../server/functions/item_info.php");
require_once("./../server/functions/comments.php");
require_once("./../server/GLOBAL_VARS.php");
$_SESSION['BREADCRUMBS'] = array();


$current_page = ["login", "./login.php"];
$last_item_index = count($_SESSION['BREADCRUMBS']) - 1;

// Add the current page only if it's not the last one already in the breadcrumb trail
if ($last_item_index < 0 || $_SESSION['BREADCRUMBS'][$last_item_index][0] != $current_page[0]) {
	array_push($_SESSION['BREADCRUMBS'], $current_page);
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
		href="css/loginstyles.css" />
	<link rel="stylesheet"
		href="css/global.css" />
</head>

<body>

	<div class="container">
		<div class="headerblack">
			<a href="home.php"
				class="home-button">Home</a>
		</div>

		<div class="headeryellow">
			<div class="search-container">
				<input type="text"
					placeholder="Search...">
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
				<button type="submit">Search</button>
			</div>
		</div>
		<?php include_once './../server/breadcrumbs.php' ?>
		<a href="./admin_login.php">Admin Login</a>
		<div class="triangleextendblack">
			<form id="loginForm"
				method="POST"
				action="../server/validate_user.php">
				<input type="email"
					id="email"
					name="email"
					placeholder="E-mail">
				<input type="password"
					id="password"
					name="password"
					placeholder="Password">
				<div class="button-container">
					<button type="submit">Login</button>
					<?php
					if (isset($_SESSION['MESSAGE'])) {
						echo "<h4 class=\"error_message\">" . $_SESSION['MESSAGE'] . "</h4>";
						unset($_SESSION['MESSAGE']);
					}
					?>
				</div>
				<a class="accounttext"
					href="create_account.php">Need an account?</a>
			</form>
		</div>
		<div class="triangle-element"></div>
	</div>
	<div class="footerblack">&copy; Banana Hammock 2024</div>

	<script>
	document.getElementById("loginForm").addEventListener("submit", function(e) {
		e.preventDefault();
		var email = document.getElementById("email").value;
		var password = document.getElementById("password").value;

		if (!email || !password) {
			alert('Please enter both email and password.');
			return;
		}

		var password = document.getElementById("password").value;
		var hashedPassword = CryptoJS.MD5(password).toString();
		document.getElementById("password").value = hashedPassword;
		this.submit();
	});
	</script>


</body>

</html>