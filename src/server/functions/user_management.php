<?php

include_once './db_connection.php';

function validateUserLogin($email, $hashed_password)
{

	$query = "SELECT * FROM Users WHERE Email = ? AND MD5_Password = ?";
	try {
		$response = executePreparedQuery($query, array('ss', $email, $hashed_password));
		if ($response === true) {
		}
	} catch (Exception $e) {
		echo "Error occured , when using Database function to try to validate User.<br>";
		echo $e->getMessage();
	}

	return !empty($data);
}
