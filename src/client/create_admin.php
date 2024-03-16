<!DOCTYPE html>
<html>

<head>
	<link rel="stylesheet"
		type="text/css"
		href="./css/create_admin.css">
	<script src="./jquery-library/jquery-3.1.1.min.js"
		type="text/javascript"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>
	<script>
	$(document).ready(function() {
		$("form").submit(function(e) {
			var allFilled = true;
			$("form input").each(function() {
				if ($(this).val() === "") {
					allFilled = false;
					return false; // Break the loop
				}
			});

			if (!allFilled) {
				e.preventDefault(); // Prevent form submission
				$("#message").text("Not all of the fields have been filled properly.");
			} else {
				e.submit()
				$("#message").text("");
			}
		});
	});
	</script>
</head>

<body>
	<form method="post">
		<label for="firstName">First Name:</label>
		<input type="text"
			name="firstName">
		<label for="lastName">Last Name:</label>
		<input type="text"
			name="lastName">

		<label for="email">Login Email:</label>
		<input type="email"
			name="email">

		<label for="password">Password:</label>
		<input type="password"
			name="password">
		<label for="passwordRetype">Re-Type Password:</label>
		<input type="password"
			name="passwordRetype">

		<button type="submit">Create Account</button>
		<button type="reset">Reset</button>
		<p id="message"></p>
	</form>
</body>

</html>