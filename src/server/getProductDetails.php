<?php
session_start();
require_once "./../server/functions/item_info.php";
require_once "./../server/functions/comments.php";
require_once "./../server/GLOBAL_VARS.php";

$item_id = $_GET['ITEM_ID'] ?? null;
//print_r($item_id);
$store_id = $_GET['STORE_ID'] ?? null;
//print_r($store_id);

if ($item_id === null || $store_id === null) {
    echo "Item ID or Store ID not provided.";
    exit;
}

$item_data = Item_info::getAllItemData($item_id, $store_id);
//print_r($item_data);

if ($item_data === "NO_ITEMS_IN_DATABASE" || $item_data === "INVALID_STORE_ID") {
    echo "<p>No item found for the provided item and store ID.</p>";
    exit;
}

// If a single item is returned without being wrapped in an array
if (isset($item_data['ITEM_ID'])) {
    $item_data = [$item_data]; // Ensure $item_data is always an array for consistency
}

$testUserImage = "../../server/images/userImages/admin/test@gmail.com.jpeg";
$show_button = isset($_SESSION['USER_EMAIL']) || isset($_SESSION['ADMIN_EMAIL']);
$userEmail = $_SESSION['USER_EMAIL'] ?? '';
$userID = User_management::getAllUserData($userEmail)['USER_ID'] ?? 0;

foreach ($item_data as $item) {
    echo "<div class=\"first\">";
        echo "<div class=\"left\">";
            echo "<img id=\"item-image\" src=\"./../../server/getItemImage.php?ITEM_ID=" . urlencode($item['ITEM_ID']) . "\" alt=\"Item Image\">";
            echo "<div id=\"item-name\">" . htmlspecialchars($item['ITEM_NAME']) . "</div>";
            echo "<div id=\"item-price\">" . htmlspecialchars($item['Item_Price']) . "$</div>";
            echo "<h1>" . htmlspecialchars(Item_info::getStoreName($item['STORE_ID'])) . "</h1>";
        echo "</div>";

        echo "<div class=\"right\">";
            include "./priceChart.php";
        echo "</div>";
    echo "</div>";

    // Comment form and display section
    echo "<div id=\"form-container\">";
        echo "<button id=\"comment-button\">Show Comment Form</button>";
        echo '<form id="add-comment-form" action="./../../server/addcomment.php" method="post">' .
            '<input type="hidden" id="item-id" name="ITEM_ID" value="' . $item_id . '"/>' .
            '<input type="hidden" id="user-email" name="USER_EMAIL" value="' . $userEmail . '"/>' .
            '<textarea id="add-comment-text" name="COMMENT_TEXT" placeholder="Add new comment..."></textarea>' .
            '<button type="submit">Add Comment</button>' .
            '</form>';
    echo "</div>";

    // Comments display
    echo "<div class=\"second\">";
        echo "<div class=\"all-comments\">";
            $comments = Comments::getAllCommentsForItem($item['ITEM_ID']);
    if (is_array($comments) && count($comments) > 0) {
        if (isset($comments['USER_ID'])) {
            $comments = [$comments]; // Wrap single comment in an array
        }
        foreach ($comments as $comment) {
            echo "<div class=\"comment-container\">";
                echo "<div class=\"user-info\"><div class=\"user-id\">" . User_management::getUser_First_Last_Name($comment['USER_ID']) . "</div>";
                echo "<img src=\"./../../server/getUserImages.php?USER_ID=" . $comment['USER_ID'] . "\" class='user-image' alt='user image'></div>";;
                echo "<p class=\"comment-text\">" . htmlspecialchars($comment['COMMENT_TEXT']) . "</p>";


                $datetime = new DateTime($comment['DATE_TIME_ADDED']);
				// Format the date and time separately
			    $formatted_date = $datetime->format('F j Y');
				$formatted_time = $datetime->format('g:ia');
				$formatted_datetime = $formatted_date . "<br>at " . $formatted_time;
				echo "<div class=\"date_time_comment_added\">" . $formatted_datetime . "</div>";
            echo "</div>";
        }//a

    } else {
        echo "<h4 class=\"no-comment-text\">No Comments Yet.</h4>";
    }
        echo "</div>"; // Close all-comments
    echo "</div>"; // Close second
}
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    var showButton = <?php echo $show_button ? 'true' : 'false'; ?>;
    if (!showButton){
        $('#comment-button').hide();
    }
});
</script>



