<?php
session_start();
require_once("./../../../server/functions/item_info.php");
require_once("./../../../server/functions/comments.php");
require_once("./../../../server/GLOBAL_VARS.php");

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
	<link rel="stylesheet" href="./../../css/user_detail.css" />
	<link rel="stylesheet" href="./../../css/global.css" />
	<link rel="stylesheet" href="./../../css/mobile/global.css" media="screen and (max-width: 650px)" />



</head>

<body>

	<div class="container">
		<div class="headerblack">
			<a href="./../../home.php" class="home-button">Home</a>
			<?php
			$name = User_management::getUser_First_Last_Name(User_management::getUserID($_SESSION['USER_EMAIL']));
			echo "<p class=\"greeting-text\"> Hello Admin :) , " . $name  . " </p>";
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
				echo "<a href=\"./../../admin_login.php\"
				class=\"admin-login-button\">Admin Login</a>";
				echo "<a href=\"./../../create_account.php\"
				class=\"create-account-button\">Create Account</a>";
			}
			?>
		</div>

		<?php include_once './../../../server/breadcrumbs.php' ?>
		<div class="underheadercontainer">
			<div class="overlay">
				<!---- //table with user details ---->
				<?php
				$user_id = $_GET['user_id'];
				if (isset($user_id)) {
					$user = User_management::getAllUserDataFromID($user_id);
					if (is_array($user)) {
						if ($user['BANNED_STATUS'] == 1) {
							$banstatus = 'Banned';
						} else {
							$banstatus = 'Not Banned';
						}
						//table with user details 
						echo "<div class=\"user-info-container\">";
						echo "<table id=\"user_table\">";
						echo "<caption> User Information </caption>";
						echo "<tr><th scope=\"row\">User ID</th><td>" . $user['USER_ID'] . "</td></tr>";
						echo "<tr><th scope=\"row\">First Name</th><td>" . $user['First_Name'] . "</td></tr>";
						echo "<tr><th scope=\"row\">Last Name</th><td>" . $user['Last_Name'] . "</td></tr>";
						echo "<tr><th scope=\"row\">Email</th><td>" . $user['Email'] . "</td></tr>";
						echo "<tr><th scope=\"row\">Profile Picture</th><td><img  class= \"pfp-image\" src=\"./../server/getUserImages.php?USER_ID=" . urlencode($user['USER_ID']) . "\" alt=\"NO IMAGE IN DATABASE\"></td></tr>";
						echo "<tr><th scope=\"row\">Banned Status</th><td>" . $banstatus . "</td></tr>";

						echo "</table></div>";
					} else {
						echo "<h4>Error Retrieving User Data: " . $user . "</h4>";
					}
					//now for comments 
					$testUserImage = "../../../../server/images/userImages/admin/test@gmail.com.jpeg";
					$user_comments = User_management::getAllUserCommentsDescending($user_id);
					if (is_array($user_comments)) {

						echo "<div class=\"all-user-comments\">";
						echo "All Comments by " . $user['Email'];
						//checking if $user_comments is multidimensional - ie if there is more than 1 comment 
						if (isset($user_comments[0]) && is_array($user_comments[0])) {
							foreach ($user_comments as $user_comment) {
								echo "<div class=\"comment-container\">";
								echo "<div class=\"user-info\"><div class=\"user-id\">" . User_management::getUser_First_Last_Name($user_id) . "</div>";

								//code for generating a store ID for the item 
								$ITEM_ID = $user_comment['ITEM_ID'];
								$storeIDForItem = item_info::getStoreId_forItem($ITEM_ID);

								echo "<img src=\"./../../../server/getUserImages.php?USER_ID=" . $user_id . "\" class='user-image' alt='User Image'></div>";
								echo "<p class=\"comment-text\">" . $user_comment['COMMENT_TEXT'] . "</p>";
								$datetime = new DateTime($user_comment['DATE_TIME_ADDED']);
								// Format the date and time separately
								$formatted_date = $datetime->format('F j Y');
								$formatted_time = $datetime->format('g:ia');
								$formatted_datetime = $formatted_date . "<br>at " . $formatted_time;
								echo "<div class=\"date_time_comment_added\">" . $formatted_datetime . "</div>";
								echo "<button class=\"go-to-item-button\"><a href=./../product.php?ITEM_ID=" . $ITEM_ID . "&STORE_ID=" . $storeIDForItem . ">Go to item</a></button>";
								echo "</div>";
							}
						} else {
							// Directly use the single comment for users with only one comment
							$user_comment = $user_comments;
							echo "<div class=\"comment-container\">";
							echo "<div class=\"user-info\"><div class=\"user-id\">" . User_management::getUser_First_Last_Name($user_id) . "</div>";
							$ITEM_ID = $user_comment['ITEM_ID'];
							$storeIDForItem = item_info::getStoreId_forItem($ITEM_ID);
							echo "<img src=\"./../../../server/getUserImages.php?USER_ID=" . $user_id . "\" class='user-image' alt='user-image'></div>";
							echo "<p class=\"comment-text\">" . $user_comment['COMMENT_TEXT'] . "</p>";

							$datetime = new DateTime($user_comment['DATE_TIME_ADDED']);
							// Format the date and time separately
							$formatted_date = $datetime->format('F j Y');
							$formatted_time = $datetime->format('g:ia');
							$formatted_datetime = $formatted_date . "<br>at " . $formatted_time;
							echo "<div class=\"date_time_comment_added\">" . $formatted_datetime . "</div>";
							echo "<button class=\"go-to-item-button\"><a href=./../product.php?ITEM_ID=" . $ITEM_ID . "&STORE_ID=" . $storeIDForItem . ">Go to item</a></button>";
							echo "</div>";
						}
					} else {
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
					<li><a href="./../../home.php">Home</a></li>
					<?php
					if (isset($_SESSION['USER_EMAIL']) || isset($_SESSION['ADMIN_EMAIL'])) {
						echo "<li><a href=\"account_page.php\">Account</a></li>";
					} else {
						echo "<li><a href=\"./../../create_account.php\">Create Account</a></li>
						<li><a href=\"./../../login.php\">Login</a></li>
						<li><a href=\"./../../admin_login.php\">Admin Login</a></li>";
					}
					?>
				</ul>
			</nav>
			<p>&copy; Banana Hammock 2024</p>
		</div>
	</footer>
	<?php
	echo "<script type=\"text/javascript\" src=\"./../../scripts/home.js\"></script>";
	echo "<script>updateGlobalVariable(1)</script>";
	?>

</body>