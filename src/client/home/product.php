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
</head>

<body>

	<div class="container">
		<div class="headerblack">
			<a href="../home.php" class="home-button">Home</a>
			<?php
			if (isset($_SESSION['USER_EMAIL']) || isset($_SESSION['ADMIN_EMAIL'])) {
				echo ">";
				//echo "<img id = \"avatar_img\" src = \"./../server/getUserImages.php>";
				echo "Logout</a>";
			} else {
				echo ">";
				echo "Login</a>";
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
					<li><a href="../home.php">Home</a></li>
					<?php
					if (isset($_SESSION['USER_EMAIL']) || isset($_SESSION['ADMIN_EMAIL'])) {
						echo ">Account</a></li>";
					} else {
						echo ">Admin Login</a></li>\"";
					}
					?>
				</ul>
				<p>&copy; Banana Hammock 2024</p>
			</nav>
		</div>
	</footer>
	<script>
		/*var showChart = <?php// echo json_encode($show_chart); ?>;*/
		var showButton = <?php echo json_encode($show_button); ?>;
	</script>
	<script src="../scripts/product.js"></script>
</body>