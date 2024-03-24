<?php
session_start();
require_once("./../server/functions/item_info.php");
require_once("./../server/functions/comments.php");
require_once("./../server/GLOBAL_VARS.php");

if (!isset($_SESSION['BREADCRUMBS'])) {
	$_SESSION['BREADCRUMBS'] = array();
}

$current_page = ["product", "./product.php"];
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
	<script type="text/javascript" src="./scripts/home.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="css/product.css" />
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

		<div class="headeryellow">
			<div class="search-container">
				<input type="text" placeholder="Search...">
				<?php
				$stores = Item_info::getAllStoreList();
				$stores = Item_info::getAllStoreList();
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
		<div class="underheadercontainer">
				<div class="overlay">
                <div class="first">
						<div class = "left">

                            <?php
                            //code to decide if comment-button and/or chart image should be shown;
                            //both these are accessed in the javascript code at bottom of page
                            $show_button = isset($_SESSION['USER_EMAIL']) & !isset($_SESSION['ADMIN_EMAIL']);
                            $show_chart = true;

                            //$item_ID = $_GET['ITEM_ID'];
                            $item_ID = 1;
                            $item = item_info::getItemInfo($item_ID);
                            $itemName = $item['ITEM_NAME'];
                            $itemPrice = 2.99; //getItemPrice($item_ID);
                            $itemImage = "../server/images/banana.jpg";
                            $chartImage = "../server/images/chart.jpg";


                            echo "<img src=" . $itemImage." id=item-image>"
                            ."<div id=\"item-name\">" . $itemName . "</div>" 
                            ."<div id=\"item-price\">" . $itemPrice . "</div>"
                            ."<button id=\"comment-button\">Add Comment</button>";
                            ?>
						</div>
                        <div class="right">
                            <?php
                                echo "<img src=" . $chartImage . " id=\"chart\">";
                            ?>
                        </div>
				</div>
                <!--- adding comments doesnt work yet ---->
				<form id="add-comment-form" action="../server/addcomment.php">
						<label for="add-comment-text" id = "form-label">Add Comment</label>
						<textarea id="add-comment-text" name="add-comment-text"></textarea>
						<button type="submit">Submit</button>
				</form>
                    <div class="second">
                        <div id = "all-comments">
                            <?php
                            //posts the user ID, comment ID and text for all the comments. 
                            //the  user image is a placeholder 
                            if (isset($item_ID)){
                                $item_comments = comments::getAllCommentsForItem($item_ID);
                                if ($item_comments){
                                    foreach($item_comments as $comment){
                                        $commentUserID = $comment['USER_ID'];
                                        $commentID = $comment['COMMENT_ID'];
                                        $commentText = $comment['COMMENT_TEXT'];
                                        $testUserImage =  "../../server/images/userImages/admin/test@gmail.com.jpeg";

                                        echo "<div class=\"comment-container\">"
                                        ."<div class=\"user-info\"><div class=\"user-id\">user id: " . $commentUserID . "</div>"
                                        ."<img src =\"".$testUserImage . "\" class='user-image'></div>"
                                        ."<p class=\"comment-text\">" . $commentText . "</p></div>";
                                    }
                                }
                            }
                            ?>
                        </div>
                        <div id = "similar-items">
                            <?php
                            /*this code is not functional, I just filled out what I think would be needed 
                            $similarItems = item_info::getSimilarItems($item_ID);
                            if ($similarItems){
                                foreach($similarItems as $similarItem){
                                 $similarItemName = $similarItem['ITEM_NAME'];
                                 $similarItemPrice = getPrice($similarItem['ITEM_ID']);
                                 $similarItemImage = $similarItem['DISPLAY_IMAGE'];

                                 echo "<div class=\"similar-item-info\"><img src=\"banana.jpg\">"
                                 ."<div class=\"similar-item-name\">" . $similarItemName . "</div>"
                                 ."<div class=\"similar-item-price\">" . $similarItemPrice . "</div></div>";
                                
                                }
                            }
                            */
                            ?>
                            <?php
                            //this code populates similar-items with placeholders... something like the code above can replace it 
                            $similarItemName = "Similar Item";
                            $similarItemPrice = "$2.99";
                            $similarItemImage = "../server/images/banana.jpg";

                            $numSimilarItems= 3 ;
                            for ($numSimilarItems;$numSimilarItems>0; $numSimilarItems--){
                                echo "<div class=\"similar-item-info\"><img src=" . $similarItemImage . ">"
                                ."<div class=\"similar-item-name\">" . $similarItemName . "</div>"
                                ."<div class=\"similar-item-price\">" . $similarItemPrice . "</div></div>";
                            }
                            echo "</div>";
                            ?>                  
						<?php					
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
					}else{
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
	echo "<script type=\"text/javascript\" src=\"./scripts/product.js\"></script>";
	?>

<script>
    //this funuction centers the item image and info if the chart img is not rendered in the right container
    $(document).ready(function() {
        // Check if the right container has an image
        var showChart = <?php echo json_encode($show_chart); ?>;
        if (!showChart) {
            $('.right').hide();
            $('.first').css('justify-content','center');
        }
    });

    $(document).ready(function() {
			// This function should make the visible button if the right conditions are set
			// If they aren't, top and bottom margin for product-info are 1em respectively
			// If the button is there, then
			var show_button = <?php echo json_encode($show_button); ?>;
			// Change margins if button is visible
			if (!show_button) {
				$('.left').css({
					'position': 'relative', // Change position to relative
                'top': '1em' // Move down by 1em
				});
                $('#comment-button').hide();
			}
		});
        //this form reveals the message form if the comment button is clicked
        document.addEventListener("DOMContentLoaded", function() {
        const commentButton = document.getElementById("comment-button");
        const commentForm = document.getElementById("add-comment-form");

        commentButton.addEventListener("click", function() {
            if (commentForm.style.display === "none") {
                commentForm.style.display = "block";
                commentButton.textContent = "Hide Comment Form";
            } else {
                commentForm.style.display = "none";
                commentButton.textContent = "Add Comment";
            }
        });
    });
</script>

</body>