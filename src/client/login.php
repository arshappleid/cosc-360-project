<?php
session_start();
require_once("./../server/functions/item_info.php");
require_once("./../server/functions/comments.php");
//require_once("/../server/functions/user_management.php");
require_once("./../server/GLOBAL_VARS.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Login Page</title>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="css/login.css" />
	<link rel="stylesheet" href="css/global.css" />
</head>

<body>

	<div class="container">
		<div class="headerblack">
			<a href="home.php" class="home-button">Home</a><br>
		</div>

		<header class="headeryellow">
			<div class="search-container">
				<label for="search-input" class="visually-hidden">Enter keywords to search:</label>
				<input type="text" id="search-input" placeholder="Search...">
				<?php
				$stores = Item_info::getAllStoreList();
				if (count($stores) == 0) {
					echo $stores;
				} else {
					echo "<label for =\"store_select\" class=\"visually-hidden\">Filter by store:</label>";
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
		</header>
		<?php include_once './../server/breadcrumbs.php' ?>
		<div class="underheadercontainer">
			<div class="overlay">
				<form id="loginForm" method="POST" action="./../server/validate_user.php">
					<label for="email" class="visually-hidden">Email</label>
					<input type="email" id="email" name="email" placeholder="E-mail">
					<label for="password" class="visually-hidden">Password</label>
					<input type="password" id="password" name="password" placeholder="Password">
					<div class="button-container">
						<button type="submit">Login</button>
						<?php
						if (isset($_SESSION['MESSAGE'])) {
							echo "<h4 class=\"error_message\">" . $_SESSION['MESSAGE'] . "</h4>";
							unset($_SESSION['MESSAGE']);
						}
						?>
					</div>
					<a class="accounttext" href="create_account.php">Need an account?</a>
					<a class="accounttext" href="./admin_login.php">Admin Login</a>
				</form>

			</div>
			<div class="triangleextendblack"></div>
			<div class="triangle-element"></div>


		</div>
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