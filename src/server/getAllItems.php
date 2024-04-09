<?php

global $COMMENT_DATE_TIME_FORMAT;
session_start();
require_once("./../server/functions/item_info.php");
require_once("./../server/functions/comments.php");
require_once("./../server/functions/admin_management.php");
require_once("./GLOBAL_VARS.php");

$items = Item_info::getHomePageItems();

//print_r($items);

foreach ($items as $item) {
    $item_id = Item_info::getItemInfo($item['ITEM_ID']);
    //$item_price = Item_info::getCurrentPrice($item['ITEM_ID']);
    $store_name = Item_info::getStoreName($item['STORE_ID']);
    if ($item_id == "NO_ITEM_FOUND") {
        continue;
    }

    // Left Bar
    echo "<section>"; // Left Section
    echo "<aside>";
    echo "<img class =\"display-image\" src = \"./../server/getItemImage.php?ITEM_ID=" . urlencode($item['ITEM_ID']) . "\" alt=\"Product Image\">";
    echo "<h3>" . htmlspecialchars($item['ITEM_NAME']) . "</h3>";
    echo "<h1>" . htmlspecialchars($item['Item_Price']) . "$ at " .  $store_name . "</h1>";
    echo "<h4><b>" . "Upvotes :</b> " . htmlspecialchars($item['UPVOTES']) . "</h4>";

    // Button container
    echo "<div class=\"button-container\">";

    echo "<a href=\"./home/product.php?ITEM_ID=" . urlencode($item['ITEM_ID']) . "&STORE_ID=" . urlencode($item['STORE_ID']) . "\" class=\"details-button\">See Product Details</a>";

    if (isset($_SESSION['USER_EMAIL'])) {
        try {
            echo "<form action=\"./../server/upvoteItem.php\" method=\"POST\" class=\"upvote-form\">";
            echo "<input type=\"hidden\" name=\"ITEM_ID\" value=\"" . $item['ITEM_ID'] . "\">";
            echo "<input type=\"submit\" value=\"Upvote\" class=\"upvote-button\">";
            echo "</form>";
        } catch (Exception $e) {
            echo "Error occurred while rendering upvote ID: " . $e;
        }
    }

    echo "</div>"; // Close button container
    echo "</aside>";

    // Right Bar
    echo "<article>";

    // Display comments
    $comments = Comments::getAllCommentsForItem($item['ITEM_ID']); // Handle 1 comment and more than 1
    if ($comments == "NO_COMMENTS_ADDED_YET") {
        echo "<h3>No Comments yet.</h3>";
    } elseif (is_array($comments)) {
        echo "<table id=\"comment_table\">";
        echo "<caption class=\"visually-hidden\">All Comments For Item</caption>";
        // Ensure $comments is always treated as an array.
        if (isset($comments['USER_ID'])) {
            $comments = [$comments]; // Wrap single comment in an array
        }
        //added table headings, including adding another column for date time added. However, they are not showing up .
        foreach ($comments as $comment) {
            echo "<tr>";
            echo "<td>";
            echo htmlspecialchars(User_management::getUser_First_Last_Name($comment['USER_ID']));
            echo "<br><img src=\"./../server/getUserImages.php?USER_ID=" . $comment['USER_ID'] . "\" class='user-image'>";
            echo "</td>";
            echo "<td>" . htmlspecialchars($comment['COMMENT_TEXT']) . "</td>";
            try {
                echo "<td>" . (new DateTime($comment['DATE_TIME_ADDED']))->format('d, M Y') . "</td>";
            } catch (Exception $e) {
                echo "<td>Could Not Parse Date</td>";
            }
            // Show a Deletion Button here
            if (isset($_SESSION['ADMIN_EMAIL']) || (isset($_SESSION['USER_EMAIL']) && $comment['USER_ID'] == Admin_management::getUserID($_SESSION['USER_EMAIL']))) {
                // Show the Delete Button
                echo "<td><a href=\"./../server/deleteComment.php?commentId=" . htmlspecialchars($comment['COMMENT_ID']) . "\" class=\"button\">Delete Comment</a></td>";
            }
            echo "</tr>";
        }

        echo "</table>";
    }

    // Render the add comment form inside the article for each item.
    if (isset($_SESSION['USER_EMAIL']) || isset($_SESSION['ADMIN_EMAIL'])) {
        $email = $_SESSION['USER_EMAIL'] ?? $_SESSION['ADMIN_EMAIL'];
        echo "<form class =\"Comment_Form\" action=\"./../server/addcomment.php\" method=\"post\">";
        echo "<label for=\"Comment_input\" class=\"visually-hidden\">Add Comment Text</label>";
        echo "<input class=\"Comment_Input\" id = \"Comment\" type=\"text\" placeholder=\"Add new Comment...\" name=\"COMMENT_TEXT\">";
        echo "<input type=\"hidden\" name=\"ITEM_ID\" value=\" " . htmlspecialchars($item['ITEM_ID']) . "\" >";
        echo "<input type=\"hidden\" name=\"USER_EMAIL\" value=\" " . htmlspecialchars($email) . " \" >";
        echo "<p class = \"Comment_Msg\" style = \"display:none;color:red;\">Comment Text Cannot be Empty</p>";
        echo "<button class=\"add-comment-button\" type=\"submit\">Add Comment</button>";
        echo "</form>";
    }

    echo "</article>";
    echo "</section>";
}
?>
<script>
    $(document).ready(function() {
        $(".Comment_Form").on("submit", function(event) {
            var field1Value = $(this).find(".Comment_Input").val();
            if (field1Value.trim().length === 0) {
                $(this).find(".Comment_Msg").show();
                event.preventDefault(); // prevent form submission
            }
        });
        $(".Comment_Input").on("keyup", function() {
            // Hide the message when the user starts typing
            var inputVal = $(this).val().trim();
            if (inputVal.length > 0) {
                $(this).closest(".Comment_Form").find(".Comment_Msg").hide();
            } else {
                // Optional: Show the message again if the input is empty
                $(this).closest(".Comment_Form").find(".Comment_Msg").show();
            }
        });
    });
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>