<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Login Page</title>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible"
		content="IE=edge" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>
	<meta name="viewport"
		content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet"
		href="./css/global.css" />
	<link rel="stylesheet"
		href="./css/admin_login.css" />
</head>

<body class="default_body">
	<div>
		<h3>Admin Login</h3>
		<form id="login_form"
			method="POST"
			action="./../server/validate_admin.php">
			<input class="input_field"
				placeholder="E-mail"
				type="text"
				name="email">
			<input class="input_field"
				placeholder="Password"
				type="password"
				name="password">
			<?php
			if (isset($_SESSION['MESSAGE'])) {
				echo "<h4 class=\"error_message\">" . $_SESSION['MESSAGE'] . "</h4>";
				unset($_SESSION['MESSAGE']);
			}
			?>
			<div id="button_holder">
				<button type="submit">Login</button>
				<button type="reset">Reset</button>
			</div>
		</form>
	</div>

	<script>
	document.getElementById("login_form").addEventListener("submit", function(e) {
		e.preventDefault();
		var email = document.getElementById("login_form").elements['email'].value;
		var password = document.getElementById("login_form").elements['password'].value;

		if (!email || !password) {
			alert('Please enter both email and password.');
			return;
		}
		var hashedPassword = CryptoJS.MD5(password).toString();
		document.getElementById("login_form").elements['password'].value = hashedPassword;
		this.submit();
	});
	</script>


</body>

</html>