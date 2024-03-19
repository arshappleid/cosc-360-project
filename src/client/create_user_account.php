<?php
session_destroy();
session_start();
?>
<!DOCTYPE html>
<html>

<head>
	<title>UBC Market Store</title>
	<link rel="stylesheet" type="text/css" href="./css/create_user_account.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<!-- Bootstrap core CSS -->
	<link href="bootstrap3_defaultTheme/dist/css/bootstrap.css" rel="stylesheet">
</head>

<body>
	<form method="POST" action="./../server/verify_user_login.php">

		<label for="username">Username</label>
		<input type="text" name="username">

		<label for="email">Email</label>
		<input type="text" name="email">


		<label for="password">Password</label>
		<input type="password" name="password">


		<label for="retype_password">Re-Type Password</label>
		<input type="password" name="retype_password">


		<button type="submit">Create Account</button>
		<button type="reset">Reset</button>
	</form>

</body>

</html>