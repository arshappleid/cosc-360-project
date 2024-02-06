<?php session_start();?>
<!DOCTYPE html>
<html>

<head>
	<title>UBC Market Store</title>
	<link rel="stylesheet"
		type="text/css"
		href="./css/home.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<!-- Bootstrap core CSS -->
	<link href="bootstrap3_defaultTheme/dist/css/bootstrap.css"
		rel="stylesheet">
</head>

<body>

	<header>Welcome to our Store</header>
	<nav>
		<a href="#home">Home</a>
		<a href="#news">News</a>
	</nav>

	<form method="POST"
		action="./../server/create_user.php">

		<label for="username">Username</label>
		<input type="text"
			id="username"
			name="username">


		<label for="password">Password</label>
		<input type="password"
			default=""
			id="password"
			name="password">


		<button type="submit">Submit</button>
		<button type="reset">Reset</button>
	</form>
	<form method="GET"
		action="./create_user_account.php">
		<button type="submit">Create new Account</button>
	</form>
	<?php 
    if (isset($_SESSION['message'])) {
        echo "<p style = \"color:red;\">" . $_SESSION['message'] . "</p>";
    }
?>

	<footer>Have A Great Day</footer>

</body>
</html>