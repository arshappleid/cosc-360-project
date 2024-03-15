<?php
if (isset($_POST['SELECTED_STORE'])) {
	session_start(); // Start the session if you are using sessions to store the global variable
	$_SESSION['SELECTED_STORE'] = $_POST['SELECTED_STORE']; // Update the global variable

	echo "Global variable updated successfully to " . $_SESSION['SELECTED_STORE'];
	// You can process and respond back to the AJAX call if needed
}
