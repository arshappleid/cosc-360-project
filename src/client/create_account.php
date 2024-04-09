<?php
session_start();
require_once("./../server/functions/item_info.php");
require_once("./../server/functions/comments.php");
require_once("./../server/GLOBAL_VARS.php");

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
  <link rel="stylesheet" href="css/createaccount.css" />
  <link rel="stylesheet" href="css/global.css" />
</head>

<body>

  <div class="container">
    <div class="headerblack">
      <a href="home.php" class="home-button">Home</a>
    </div>
    <?php include_once './../server/breadcrumbs.php' ?>
    <div class="underheadercontainer">
      <div class="overlay">
        <form id="createAccountForm" method="POST" action="../server/create_user.php">

          <label for="email" class="visually-hidden">Email</label>
          <input type="email" id="email" name="email" placeholder="E-mail" required>

          <label for="password" class="visually-hidden">Password</label>
          <input type="password" id="password" name="password" placeholder="Password" required>

          <label for="password2" class="visually-hidden">Re-enter Password</label>
          <input type="password" id="password2" name="password2" placeholder="Re-enter Password" required>

          <label for="firstName" class="visually-hidden">First Name</label>
          <input type="text" id="firstName" name="firstName" placeholder="First Name" required>

          <label for="lastName" class="visually-hidden">Last Name</label>
          <input type="text" id="lastName" name="lastName" placeholder="Last Name" required>

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
      <div class="triangleextendblack"></div>
      <div class="triangle-element"></div>
    </div>
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
            } else {
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

  <script>
    document.getElementById("createAccountForm").addEventListener("submit", function(e) {
      e.preventDefault();
      var email = document.getElementById("email").value;
      var password = document.getElementById("password").value;
      var password2 = document.getElementById("password2").value;
      var firstName = document.getElementById("firstName").value;
      var lastName = document.getElementById("lastName").value;

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