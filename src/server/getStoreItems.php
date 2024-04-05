<?php
session_start();
include '../server/functions/item_info.php';
require_once("./../server/functions/item_info.php");
require_once("./../server/functions/comments.php");
require_once("./GLOBAL_VARS.php");
$storeId = $_GET['SELECTED_STORE'];
//print_r($storeId);
$item_IDS = Item_info::getAllItems_IDS_AtStore($storeId);

if ($item_IDS == "NO_ITEMS_AVAILABLE_AT_STORE") {
    echo "<section>";
    echo "<h3>" . $NO_ITEM_AVAILABLE_AT_THE_STORE_MESSAGE . "</h3>";
    echo "</section>";
    exit;
}

foreach ($item_IDS as $item_ID) {
    $item = Item_info::getItemInfo($item_ID);
    $item_price = Item_info::getCurrentPrice($item_ID, $storeId);
    //print_r($item_price);
    $store_name = Item_info::getStoreName($storeId);
    if ($item == "NO_ITEM_FOUND") continue;

    echo "<section>";
    echo "<aside>";
    echo "<img class =\"display-image\" src = \"./../server/getItemImage.php?ITEM_ID=" . urlencode($item['ITEM_ID']) . "\" alt=\"NO IMAGE IN DATABASE\">";
    echo "<h3>" . htmlspecialchars($item['ITEM_NAME']) . "</h3>";
    echo "<h2>" . $item_price . "$" . "</h2>";
    echo "<h1>" . $store_name . "</h1>";
    echo "<a href=\"product.php?ITEM_ID=" . urlencode($item['ITEM_ID']) . "\">See Product Details</a>";
    echo "</aside>";
    echo "<article>";

    // Display comments
    $comments = Comments::getAllCommentsForItem($item_ID);
    if (is_array($comments)) {
        if (count($comments) == 0) {
            echo "<h4>No Comments Yet.</h4>";
        } else {
            echo "<table id=\"comment_table\">";
            echo "<caption class=\"visually-hidden\">All Comments For Item</caption>";   //added caption for table, and headers for table
            echo "<tr><th scope=\"col\">Username</th><th scope=\"col\">User Comment</th><th scope=\"col\">Date Added</th></tr>"; //added date added column header
            foreach ($comments as $comment) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars(User_management::getUser_First_Last_Name($comment['USER_ID'])) . "</td>";
                echo "<td>" . htmlspecialchars($comment['COMMENT_TEXT']) . "</td>";
                echo "<td>" . (new DateTime($comment['DATE_TIME_ADDED']))->format(GLOBAL_VARS::$COMMENT_DATE_TIME_FORMAT) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    }

    // Render the add comment form inside the article for each item.
    if (isset($_SESSION['USER_EMAIL']) || isset($_SESSION['ADMIN_EMAIL'])) {
        $email = isset($_SESSION['USER_EMAIL']) ? $_SESSION['USER_EMAIL'] : $_SESSION['ADMIN_EMAIL'];
        echo "<form action=\"./../server/addcomment.php\" action=\"post\">";
        echo "<input type=\"text\" placeholder=\"Add new Comment...\" name=\"COMMENT_TEXT\">";
        echo "<input type=\"hidden\" name=\"ITEM_ID\" value=\"" . htmlspecialchars($item_ID) . "\">";
        echo "<input type=\"hidden\" name=\"USER_EMAIL\" value=\"" . htmlspecialchars($email) . "\">";
        echo "<button type=\"submit\">Add Comment</button>";
        echo "</form>";
    }

    echo "</article>";
    echo "</section>";
}
