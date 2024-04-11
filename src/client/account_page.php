<?php
session_start();
require_once("./../server/functions/item_info.php");
require_once("./../server/functions/comments.php");
require_once("./../server/GLOBAL_VARS.php");

if (!isset($_SESSION['BREADCRUMBS'])) {
	$_SESSION['BREADCRUMBS'] = array();
}

$current_page = ["account details", "./account_page.php"];
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
	<meta http-equiv="X-UA-Compatible"
		content="IE=edge" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>
	<script type="text/javascript"
		src="./scripts/home.js"></script>
	<meta name="viewport"
		content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet"
		href="css/account.css" />
	<link rel="stylesheet"
		href="css/global.css" />
	<link rel="stylesheet" href="css/mobile/global.css"  media="screen and (max-width: 650px)" /> 

</head>

<body>

	<div class="container">
		<div class="headerblack">
			<a href="home.php"
				class="home-button">Home</a>
			<?php
			if (isset($_SESSION['USER_EMAIL']) || isset($_SESSION['ADMIN_EMAIL'])) {
				$name = User_management::getUser_First_Last_Name(User_management::getUserID($_SESSION['USER_EMAIL']));
				if (isset($_SESSION['ADMIN_EMAIL'])) {
					echo "<p class=\"greeting-text\"> Hello Admin :) , " . $name  . " </p>";
				} else {
					echo "<p class=\"greeting-text\"> Hello User :) , " . $name  . " </p>";
				}
				echo "<a href=\"../server/logout.php\" class=\"login-button\">";
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


		<?php include_once './../server/breadcrumbs.php' ?>
		<div class="underheadercontainer">
			<div class="overlay">
				<?php include_once './../server/displaySingleUser.php' ?>
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
			</nav>
			<p>&copy; Banana Hammock 2024</p>
		</div>
	</footer>

	<script>
    document.getElementById("updatePasswordForm").addEventListener("submit", function(e) {
      e.preventDefault();
      var oldpassword = document.getElementById("oldpassword").value;
      var password = document.getElementById("password").value;
	  var password2 = document.getElementById("password2").value;

      if (password !== password2) {
        alert("Passwords Don't Match");
        return;
      }

      var hashedOldPassword = CryptoJS.MD5(oldpassword).toString();
      document.getElementById("oldpassword").value = hashedOldPassword;

	  var hashedNewPassword = CryptoJS.MD5(password).toString();
      document.getElementById("password").value = hashedNewPassword;

      this.submit();
    });
  </script>

</body>