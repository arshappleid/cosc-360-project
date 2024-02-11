<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Create Account</title>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="createaccountstyles.css" />
    <link href="bootstrap3_defaultTheme/dist/css/bootstrap.css"
		rel="stylesheet">
  </head>
  <body>
    
    <div class="container">
      <div class="headerblack">
        <a href="#" class="home-button">Home</a>
      </div>
      <div class="headeryellow">
        <div class="search-container">
          <input type="text" placeholder="Search...">
          <select>
            <option value="option1">Option 1</option>
            <option value="option2">Option 2</option>
            <option value="option3">Option 3</option>
          </select>
          <button type="submit">Search</button>
        </div>
      </div>
      <div class="triangleextendblack"> 
        <form id = "createAccountForm" method="POST" action="./../../server/create_user.php">

          <input type="email" id="email" name="email" placeholder="E-mail" required>

          <input type="password" id="password" name="password" placeholder="Password" required>

          <input type="password" id="password2" name="password2" placeholder="Re-enter Password" required>

          <input type="text" id="firstName" name="firstName" placeholder="First Name" required>

          <input type="text" id="lastName" name="lastName" placeholder="Last Name" required>

          <input type="file" id="profilePicture" name="profilePicture" placeholder="Upload Profile Picture" accept="image/*">

          <div class="button-container">
            <button type="submit">Create Account</button>
          </div>
        </form> 
      </div>
      <div class="triangle-element"></div>     
    </div>
    <div class="footerblack"></div>

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
