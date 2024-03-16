<?php session_start() ?>
<!DOCTYPE html>
<html>

<head>
	<link rel="stylesheet" type="text/css" href="./css/create_admin.css">
	<script src="./jquery-library/jquery-3.1.1.min.js" type="text/javascript"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>
	<script>
		$(document).ready(function() {
			// File Type Checking
			$("#userImage").on("change", function() {
				var fileName = $(this).val();
				var extension = fileName.split('.').pop().toLowerCase();
				var validImageExtensions = ['jpg', 'jpeg', 'png', 'gif'];

				if ($.inArray(extension, validImageExtensions) === -1) {
					$("#message").text("Unsupported Image Format. Please upload : jpg, jpeg, png, gif");
				} else {
					$("#message").text(""); // Clear message if file is valid
				}
			});


			// Password Checking 
			$("#passwordRetype").on("keyup", function() {
				var password = $("#password").val()
				var retypePassword = $("#passwordRetype").val()

				if (password != retypePassword && retypePassword != "") {
					$("#message").text("Passwords do not match.");
				} else {
					$("#message").text("");
				}
			});
			$("form").submit(function(e) {
				var allFilled = true;
				$("form input").each(function() {
					if ($(this).val() === "" && $(this).attr('id') != "userImage") {
						allFilled = false;
						return false; // Break the loop
					}
				});

				var password = $("#password").val()
				var retypePassword = $("#passwordRetype").val()

				if (password != retypePassword) {
					$("#message").text("Passwords do not match.");
					e.preventDefault();
					return;
				}

				if (!allFilled) {
					e.preventDefault(); // Prevent form submission
					$("#message").text("Not all of the fields have been filled properly.");
				} else {
					$("#message").text("");
					// Hash The password
					var password = document.getElementById("password").value;
					var hashedPassword = CryptoJS.MD5(password).toString();
					document.getElementById("password").value = hashedPassword;
					e.submit();


				}
			});
		});
	</script>
</head>

<body>
	<form method="post" action="./../server/create_admin.php" enctype="multipart/form-data">
		<label for="
		firstName">First Name:</label>
		<input type="text" name="firstName">
		<label for="lastName">Last Name:</label>
		<input type="text" name="lastName">

		<label for="email">Login Email:</label>
		<input id="email" type="email" name="email">

		<label for="password">Password:</label>
		<input id="password" type="password" name="password">
		<label for="passwordRetype">Re-Type Password:</label>
		<input id="passwordRetype" type="password" name="passwordRetype">

		<label for="userImage">User Image:</label>
		<input type="file" id="userImage" name="image">

		<button type="submit">Create Account</button>
		<button type="reset">Reset</button>
		<p id="message"></p>
		<?php if (isset($_SESSION['MESSAGE'])) {
			echo "<p id = \"message\">" . $_SESSION['MESSAGE'] . "</p>";
			unset($_SESSION['MESSAGE']);
		}
		?>
	</form>
</body>

</html>