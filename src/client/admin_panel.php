<?php 
session_start();
require_once("./../server/functions/item_info.php");
require_once("./../server/functions/comments.php");
require_once("./../server/GLOBAL_VARS.php");

// Add this to every page to modify breadcrumbs
if (!isset($_SESSION['BREADCRUMBS'])) {
    $_SESSION['BREADCRUMBS'] = array();
}

$current_page = ["ADMIN", "./admin_panel.php"];
$last_item_index = count($_SESSION['BREADCRUMBS']) - 1;

if ($_SESSION['BREADCRUMBS'][$last_item_index][0] != $current_page[0]) {
    array_push($_SESSION['BREADCRUMBS'], $current_page);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Panel</title>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <script type="text/javascript" src="./jquery-library/jquery-3.1.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./css/global.css" />
    <link rel="stylesheet" href="./css/admin_panel.css" />
</head>
<body>
    <div class="container">
        <div class="headerblack">
            <a href="home.php" class="home-button">Home</a>
            <?php if (isset($_SESSION['USER_EMAIL']) || isset($_SESSION['ADMIN_EMAIL'])): ?>
                <a href="account_page.php" class="login-button">Account</a>
            <?php else: ?>
                <a href="login.php" class="login-button">Login</a>
                <a href="admin_login.php" class="admin-login-button">Admin Login</a>
                <a href="create_account.php" class="create-account-button">Create Account</a>
            <?php endif; ?>
        </div>

        <div class="headeryellow">
            <div class="search-container">
                <input type="text" placeholder="Search...">
                <?php
                $stores = getAllStoreList();
                if (count($stores) == 0) {
                    echo $stores;
                } else {
                    echo "<select id=\"store_select\" class=\"select_dropdown\">";
                    foreach ($stores as $key => $store) {
                        echo "<option value=\"" . htmlspecialchars($store['STORE_ID']) . "\">" . htmlspecialchars($store['STORE_NAME']) . "</option>";
                    }
                    echo "</select>";
                }
                ?>
                <button type="submit">Search</button>
            </div>
        </div>

        <?php include_once './../server/breadcrumbs.php'; ?>

        <div class="underheadercontainer">
            <div class="overlay">
                <form id="Input_Form">
                    <fieldset>
                        <legend>Add New Item</legend>
                            <div class="row">
                                <div class="col">
                                    <input type="text" name="ITEM_NAME" placeholder="Item Name">
                                    <input type="text" name="ITEM_EXTERNAL_LINK" placeholder="External Link">
                                    <?php
                                    if (count($stores) > 0) {
                                        echo "<select id=\"store_select\" name=\"STORE_ID\" class=\"select_dropdown\">";
                                        foreach ($stores as $key => $store) {
                                            echo "<option value=\"" .$store['STORE_ID']. "\">" .$store['STORE_NAME']. "</option>";
                                        }
                                        echo "</select>";
                                    }
                                    ?>
                                </div>
                                <div class="col">
                                    <textarea name="ITEM_DESCRIPTION" placeholder="Description..."></textarea>
                                    <input type="file" name="PRODUCT_IMAGE">
                                </div>
                            </div>
                        <input type="submit" value="Submit">
                        <input type="reset" value="Reset">
                    </fieldset>
                </form>
            </div>
            <div class="triangleextendblack"></div>
            <div class="triangle-element"></div>
        </div>
    </div>
    <footer>
        <p>Footer</p>
    </footer>
</body>