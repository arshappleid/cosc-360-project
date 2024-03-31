<?php
session_start();
include '../server/functions/item_info.php';
require_once("./../server/functions/item_info.php");
require_once("./../server/functions/comments.php");
require_once("./GLOBAL_VARS.php");

$items = Item_info::getHomePageItems();

//print_r($items);

foreach ($items as $item) {
    $item_id = Item_info::getItemInfo($item['ITEM_ID']);
    //$item_price = Item_info::getCurrentPrice($item['ITEM_ID']);
    $store_name = Item_info::getStoreName($item['STORE_ID']);
    if ($item_id == "NO_ITEM_FOUND") continue;

    echo "<section>";
    echo "<aside>";

    // Left Bar
    echo "<section>"; // Left Section
    echo "<aside>";
    echo "<img class =\"display-image\" src = \"./../server/getItemImage.php?ITEM_ID=" . urlencode($item['ITEM_ID']) . "\" alt=\"NO IMAGE IN DATABASE\">";
    echo "<h3>" . htmlspecialchars($item['ITEM_NAME']) . "</h3>";
    echo "<h2>" . htmlspecialchars($item['Item_Price']) . "$" . "</h2>";
    echo "<h1>" . $store_name . "</h1>";
    echo "<button><a href=\"product.php?ITEM_ID=" . urlencode($item['ITEM_ID']) . "\">See Product Details</a></button>";
    echo "</aside>";
    // Price chart within the Article Tags
    echo "<article>";
    include "./priceChart.php"; // Bug
    echo "</article>";
    echo "</section>";
    echo "</aside>";

    // Right Bar
    echo "<article>";

    // Display comments
    $comments = Comments::getAllCommentsForItem($item['ITEM_ID']); // Handle 1 comment and more than 1
    if($comments == "NO_COMMENTS_ADDED_YET"){
        echo "<h3>No Comments yet.</h3>";
    }elseif (is_array($comments)) {
            echo "<table id=\"comment_table\">";
        if (is_array($comments) && !empty($comments) && is_array($comments[0])) { // Multiple Comments
                foreach ($comments as $comment) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars(User_management::getUser_First_Last_Name($comment['USER_ID'])) . "</td>";
                    echo "<td>" . htmlspecialchars($comment['COMMENT_TEXT']) . "</td>";
                    echo "<td>" . (new DateTime($comment['DATE_TIME_ADDED']))->format($COMMENT_DATE_TIME_FORMAT) . "</td>";
                    // Show a Deletion Button here
                    if (isset($_SESSION['ADMIN_EMAIL']) || (isset($_SESSION['USER_EMAIL']) && $comment['USER_ID'] == Admin_management::getUserID($_SESSION['USER_EMAIL']))) {
                        // Show the Delete Button
                        echo "<td><a href=\"./../server/deleteComment.php?commentId=" . htmlspecialchars($comment['COMMENT_ID']) . "\" class=\"button\">Delete Comment</a></td>";
                    }
                    echo "</tr>";
                }
            }else{ // Just 1 comment
                echo "<tr>";
                echo "<td>" . htmlspecialchars(User_management::getUser_First_Last_Name($comments['USER_ID'])) . "</td>";
                echo "<td>" . htmlspecialchars($comments['COMMENT_TEXT']) . "</td>";
                echo "<td>" . (new DateTime($comments['DATE_TIME_ADDED']))->format($COMMENT_DATE_TIME_FORMAT) . "</td>";
                // Show a Deletion Button here
                if (isset($_SESSION['ADMIN_EMAIL']) || (isset($_SESSION['USER_EMAIL']) && $comments['USER_ID'] == Admin_management::getUserID($_SESSION['USER_EMAIL']))) {
                    // Show the Delete Button
                    echo "<td><a href=\"./../server/deleteComment.php?commentId=" . htmlspecialchars($comments['COMMENT_ID']) . "\" class=\"button\">Delete Comment</a></td>";
                }
                echo "</tr>";
            }
            echo "</table>";

    }

    // Render the add comment form inside the article for each item.
    if (isset($_SESSION['USER_EMAIL']) || isset($_SESSION['ADMIN_EMAIL'])) {
        $email = isset($_SESSION['USER_EMAIL']) ? $_SESSION['USER_EMAIL'] : $_SESSION['ADMIN_EMAIL'];
        echo "<form action=\"./../server/addcomment.php\" method=\"post\">";
        echo "<input type=\"text\" placeholder=\"Add new Comment...\" name=\"COMMENT_TEXT\">";
        echo "<input type=\"hidden\" name=\"ITEM_ID\" value=\"" . htmlspecialchars($item['ITEM_ID']) . "\">";
        echo "<input type=\"hidden\" name=\"USER_EMAIL\" value=\"" . htmlspecialchars($email) . "\">";
        echo "<button type=\"submit\">Add Comment</button>";
        echo "</form>";
    }

    echo "</article>";
    echo "</section>";
}
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>