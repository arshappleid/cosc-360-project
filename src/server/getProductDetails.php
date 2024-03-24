<?php
session_start();
include '../server/functions/item_info.php';
require_once("./../server/functions/item_info.php");
require_once("./../server/functions/comments.php");
require_once("./GLOBAL_VARS.php");

$item_id = $_GET['ITEM_ID'];
$item_IDS = Item_info::getAllItemData($item_id);
//print_r($item_IDS);

if (isset($item_IDS['ITEM_ID'])) { // Assuming a single item would have 'ITEM_ID' set
    $item_IDS = [$item_IDS]; // Wrap the single item in an array
}

$testUserImage = "../../server/images/userImages/admin/test@gmail.com.jpeg";
$chartImage = "../server/images/chart.jpg";
$show_button = (isset($_SESSION['USER_EMAIL']) & !isset($_SESSION['ADMIN_EMAIL']));
$show_chart = true;

foreach ($item_IDS as $item_ID) {
    $store_name = Item_info::getStoreName($item_ID['STORE_ID']);
    if ($item_ID == "NO_ITEM_FOUND") continue;

    echo "<div class = \"first\">";
        echo "<div class = \"left\">";
            echo "<img src = \"./../server/getItemImage.php?ITEM_ID=" . urlencode($item_ID['ITEM_ID']) . "\" alt=\"NO IMAGE IN DATABASE\">";
            echo "<div id=\"item-name\">" . ($item_ID['ITEM_NAME']) . "</div>";
            echo "<div id=\"item-price\">" . ($item_ID['Item_Price']) . "$</div>";
            echo "<h1>" . $store_name . "</h1>";
            //echo "<button id=\"comment-button\">Add Comment</button>";
        echo "</div>";
        echo "<div class = \"right\">";
            echo "<img src =\"" . $chartImage . "\" class='chart'></div>";
        echo "</div>";
    echo "</div>";

    echo '<form id="add-comment-form" action="../server/addcomment.php">' .
    '<label for="add-comment-text" id="form-label">Add Comment</label>' .
    '<textarea id="add-comment-text" name="add-comment-text"></textarea>' .
    '<button type="submit">Submit</button>' .
    '</form>';

    echo "<div class = \"second\">";
        echo "<div class = \"all-comments\">";    

            // Display comments
            $comments = Comments::getAllCommentsForItem($item_ID['ITEM_ID']);
            if (is_array($comments)) {
                if (count($comments) == 0) {
                    echo "<h4>No Comments Yet.</h4>";
                } else {
                    foreach ($comments as $comment) {
                        echo "<div class=\"comment-container\">";
                        echo "<div class=\"user-info\"><div class=\"user-id\">" . User_management::getUser_First_Last_Name($comment['USER_ID']) . "</div>";
                        echo "<img src =\"" .$testUserImage . "\" class='user-image'></div>";
                        echo "<p class=\"comment-text\">" . $comment['COMMENT_TEXT'] . "</p>";
                        echo "</div>";

                    }
                }
            }
        echo "</div>";
    echo "</div>";

    // Render the add comment form inside the article for each item.
    if (isset($_SESSION['USER_EMAIL']) || isset($_SESSION['ADMIN_EMAIL'])) {
        $email = isset($_SESSION['USER_EMAIL']) ? $_SESSION['USER_EMAIL'] : $_SESSION['ADMIN_EMAIL'];
        echo "<form action=\"./../server/addcomment.php\" action=\"post\">";
        echo "<input type=\"text\" placeholder=\"Add new Comment...\" name=\"COMMENT_TEXT\">";
        echo "<input type=\"hidden\" name=\"ITEM_ID\" value=\"" . htmlspecialchars($item_ID['ITEM_ID']) . "\">";
        echo "<input type=\"hidden\" name=\"USER_EMAIL\" value=\"" . htmlspecialchars($email) . "\">";
        echo "<button type=\"submit\">Add Comment</button>";
        echo "</form>";
    }

}

