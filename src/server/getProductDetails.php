<?php
session_start();
include '../server/functions/item_info.php';
require_once("./../server/functions/item_info.php");
require_once("./../server/functions/comments.php");
require_once("./GLOBAL_VARS.php");

$item_id = $_GET['ITEM_ID'];
$item_IDS = Item_info::getAllItemData($item_id);
//print_r($item_IDS);

foreach ($item_IDS as $item_ID) {
    $store_name = Item_info::getStoreName($item_ID['STORE_ID']);
    if ($item == "NO_ITEM_FOUND") continue;

    echo "<section>";
    echo "<aside>";
    echo "<img src = \"./../server/getItemImage.php?ITEM_ID=" . urlencode($item_ID['ITEM_ID']) . "\" alt=\"NO IMAGE IN DATABASE\">";
    echo "<h3>" . htmlspecialchars($item_ID['ITEM_NAME']) . "</h3>";
    echo "<h2>" . htmlspecialchars($item_ID['Item_Price']) . "$" . "</h2>";
    echo "<h1>" . $store_name . "</h1>";
    echo "</aside>";
    echo "<article>";

    // Display comments
    $comments = Comments::getAllCommentsForItem($item_ID['ITEM_ID']);
    if (is_array($comments)) {
        if (count($comments) == 0) {
            echo "<h4>No Comments Yet.</h4>";
        } else {
            echo "<table id=\"comment_table\">";
            foreach ($comments as $comment) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars(User_management::getUser_First_Last_Name($comment['USER_ID'])) . "</td>";
                echo "<td>" . htmlspecialchars($comment['COMMENT_TEXT']) . "</td>";
                echo "<td>" . (new DateTime($comment['DATE_TIME_ADDED']))->format($COMMENT_DATE_TIME_FORMAT) . "</td>";
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
        echo "<input type=\"hidden\" name=\"ITEM_ID\" value=\"" . htmlspecialchars($item_ID['ITEM_ID']) . "\">";
        echo "<input type=\"hidden\" name=\"USER_EMAIL\" value=\"" . htmlspecialchars($email) . "\">";
        echo "<button type=\"submit\">Add Comment</button>";
        echo "</form>";
    }

    echo "</article>";
    echo "</section>";
}

