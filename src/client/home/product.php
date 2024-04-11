<?php
session_start();
require_once("./../../server/functions/item_info.php");
require_once("./../../server/functions/comments.php");
require_once("./../../server/GLOBAL_VARS.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Banana Hammock</title>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4"></script>
	<script type="text/javascript" src="../scripts/home.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="../css/product.css" />
	<link rel="stylesheet" href="../css/global.css" />
	<link rel="stylesheet" href="../css/mobile/global.css"  media="screen and (max-width: 480px)" /> 


</head>

<body>

	<div class="container">
		<div class="headerblack">
			<a href="../home.php" class="home-button">Home</a>
			
			<?php
			$name = User_management::getUser_First_Last_Name(User_management::getUserID($_SESSION['USER_EMAIL']));
			if (isset($_SESSION['USER_EMAIL']) || isset($_SESSION['ADMIN_EMAIL'])) {
				echo ">";
				//echo "<img id = \"avatar_img\" src = \"./../server/getUserImages.php>";
				echo "Logout</a>";
			} else {
				echo ">";
				echo "Login</a>";
			}
			if (isset($_SESSION['ADMIN_EMAIL'])) {
				echo "<p class=\"greeting-text\"> Hello Admin :) , " . $name  . " </p>";

			} else {
				echo "<p class=\"greeting-text\"> Hello User :) , " . $name  . " </p>";
			}
			?>
			</a>
			<?php
			if (!isset($_SESSION['USER_EMAIL']) & !isset($_SESSION['ADMIN_EMAIL'])) {
				echo ">Admin Login</a>\"";
				echo ">Create Account</a>\"";
			}
			?>
		</div>

		<?php include_once './../../server/breadcrumbs.php' ?>
		<div class="underheadercontainer">
			<div class="overlay">
				<?php echo "<div id = \"product_list\"></div>"; ?>
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
		/*var showChart = <?php php// echo json_encode($show_chart); ?>;*/
		var showButton = <?php echo json_encode($show_button); ?>;
	</script>
	<script src="../scripts/product.js"></script>
</body>