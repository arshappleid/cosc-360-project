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
	<link rel="stylesheet" href="css/user_detail.css" />
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
				<!---- //table with user details ---->
			<?php 
			$user_id = $_GET['user_id'];
			if (isset($user_id)){
				$user = User_management::getAllUserDataFromID($user_id);
				if (is_array($user)) {
					//table with user details 
					echo "<div class=\"user-info-container\">";
					echo "<table id=\"user_table\">";
					echo "<caption> User Information </caption>";
					echo "<tr><th scope=\"row\">User ID</th><td>" . $user['USER_ID'] . "</td></tr>";
					echo "<tr><th scope=\"row\">First Name</th><td>" . $user['First_Name'] . "</td></tr>";
					echo "<tr><th scope=\"row\">Last Name</th><td>" . $user['Last_Name'] . "</td></tr>";
					echo "<tr><th scope=\"row\">Email</th><td>" . $user['Email'] . "</td></tr>";
					echo "<tr><th scope=\"row\">Profile Picture</th><td><img src=\"./../server/getUserImages.php?USER_ID=" . urlencode($user['USER_ID']) . "\" alt=\"NO IMAGE IN DATABASE\"></td></tr>";
					echo "<tr><th scope=\"row\">Banned Status</th><td>" . $user['BANNED_STATUS'] . "</td></tr>";

					echo "</table></div>";
				} else {
					echo "<h4>Error Retrieving User Data: " .$user . "</h4>";
				}
				//now for comments 
				$testUserImage = "../../server/images/userImages/admin/test@gmail.com.jpeg";
				$user_comments = User_management::getAllUserCommentsDescending($user_id);
				if (is_array($user_comments)){

					echo "<div class=\"all-comments\">";
					echo "All Comments by " . $user['Email'];

					foreach($user_comments as $user_comment){
						echo "<div class=\"comment-container\">";
                        echo "<div class=\"user-info\"><div class=\"user-id\">" . User_management::getUser_First_Last_Name($user_id) . "</div>";
						echo "<a href=product.php?ITEM_ID=" . $user_comment["ITEM_ID"] . ">Go to item</a>";
						echo "<img src=\"" . $testUserImage . "\" class='user-image'></div>";
                        echo "<p class=\"comment-text\">" . $user_comment['COMMENT_TEXT'] . "</p>";
						echo "<div class=\"date_time_comment_added\">" . $user_comment['DATE_TIME_ADDED'] . "</div>";
                    echo "</div>";

					}
				}
				else{
					echo "No comments by this user";
				}
				echo "</div>";
			}
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
	echo "<script>updateGlobalVariable(1)</script>";
	?>

</body>