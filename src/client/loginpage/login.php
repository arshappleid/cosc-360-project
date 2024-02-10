<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login Page</title>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible"
		content="IE=edge" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<meta name="viewport"
		content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet"
		href="loginstyles.css" />
	<link href="bootstrap3_defaultTheme/dist/css/bootstrap.css"
		rel="stylesheet">
</head>
<body>

	<div class="container">
		<div class="headerblack">
			<a href="#"
				class="home-button">Home</a>
		</div>
		<div class="headeryellow">
			<div class="search-container">
				<input type="text"
					placeholder="Search...">
				<select>
					<option value="option1">Option 1</option>
					<option value="option2">Option 2</option>
					<option value="option3">Option 3</option>
				</select>
				<button type="submit">Search</button>
			</div>
		</div>
		<div class="triangleextendblack">
			<form id="loginForm"
				method="POST"
				action="./../../server/verify_user_login.php">
				<input type="email"
					id="email"
					name="email"
					placeholder="E-mail">
				<input type="password"
					id="password"
					name="password"
					placeholder="Password">
				<div class="button-container">
					<button type="submit">Login</button>
				</div>
				<<<<<<< HEAD
					<a
					class="accounttext"
					href="#">Need an account?</a>
					=======
					<a class="accounttext"
						href="./../createaccountpage/create_account.php">Need an account?</a>
					>>>>>>> c08fc60 (testing upload to specified branch)
			</form>
		</div>
		<div class="triangle-element"></div>
	</div>
	<div class="footerblack"></div>

	<script>
	document.getElementById("loginForm").addEventListener("submit", function(e) {
		e.preventDefault();
		var email = document.getElementById("email").value;
		var password = document.getElementById("password").value;

		if (!email || !password) {
			alert('Please enter both email and password.');
			return;
		}

		var password = document.getElementById("password").value;
		var hashedPassword = CryptoJS.MD5(password).toString();
		document.getElementById("password").value = hashedPassword;
		this.submit();
	});
	</script>


</body>
</html>