<?php
session_start();
require_once("./../server/functions/item_info.php");
require_once("./../server/functions/comments.php");
require_once("./../server/GLOBAL_VARS.php");

if (!isset($_SESSION['BREADCRUMBS'])) {
    $_SESSION['BREADCRUMBS'] = array();
}

$current_page = ["create account", "./create_account.php"];
$last_item_index = count($_SESSION['BREADCRUMBS']) - 1;

// Add the current page only if it's not the last one already in the breadcrumb trail
if ($last_item_index < 0 || $_SESSION['BREADCRUMBS'][$last_item_index][0] != $current_page[0]) {
    array_push($_SESSION['BREADCRUMBS'], $current_page);
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Create Account</title>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/createaccountstyles.css" />
    <link rel="stylesheet" href="css/global.css" />
  </head>
  <body>
    
    <div class="container">
      <div class="headerblack">
        <a href="home.php" class="home-button">Home</a>
      </div>

      <div class="headeryellow">
        <div class="search-container">
          <input type="text" placeholder="Search...">
          <?php
					$stores = getAllStoreList();
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
      <div class="triangleextendblack"> 
        <form id = "createAccountForm" method="POST" action="../server/create_user.php">

          <input type="email" id="email" name="email" placeholder="E-mail" required>

          <input type="password" id="password" name="password" placeholder="Password" required>

          <input type="password" id="password2" name="password2" placeholder="Re-enter Password" required>

          <input type="text" id="firstName" name="firstName" placeholder="First Name" required>

          <input type="text" id="lastName" name="lastName" placeholder="Last Name" required>

          <input type="file" id="profilePicture" name="profilePicture" placeholder="Upload Profile Picture" accept="image/*">

          <div class="button-container">
          <?php
          if (isset($_SESSION['MESSAGE'])) {
				      echo "<h4 class=\"error_message\">" . $_SESSION['MESSAGE'] . "</h4>";
				      unset($_SESSION['MESSAGE']);
			      }
            ?>
            <button type="submit">Create Account</button>
          </div>
        </form> 
      </div>
      <div class="triangle-element"></div>     
    </div>
    <div class="footerblack">&copy; Banana Hammock 2024</div>

    <script>
      document.getElementById("createAccountForm").addEventListener("submit", function (e) {
        e.preventDefault();
        var email = document.getElementById("email").value;
        var password = document.getElementById("password").value;
        var password2 = document.getElementById("password2").value;
        var firstName = document.getElementById("firstName").value;
        var lastName = document.getElementById("lastName").value;
        var profilePicture = document.getElementById("profilePicture").value;

        if (password !== password2) {
            alert("Passwords Don't Match");
            return;
        }

        var hashedPassword = CryptoJS.MD5(password).toString();
        document.getElementById("password").value = hashedPassword;
        this.submit();
      });
    </script>

    
  </body>
</html>