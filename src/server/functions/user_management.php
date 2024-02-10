<?php

include_once 'db_connection.php';
/**
 * Summary of validateUserLogin
 * @param mixed $email
 * @param mixed $hashed_password
 * @return string if the given hashed password , matches the hashed password in the database
 */
function validateUserLogin($email, $hashed_password)
{

	$query = "SELECT * FROM USERS WHERE Email = ?";
	try {
		$response = executePreparedQuery($query, array('s', $email));
		if ($response[0] === true) {
			if (is_array($response[1])) {

				if ($response[1]['MD5_Password'] === $hashed_password)
					return "VALID_LOGIN";
				else
					return "INVALID_LOGIN";
			} else {
				return "USER_NOT_FOUND";
			}
		}
	} catch (Exception $e) {
		echo "Error occured , when using Database function to try to validate User.<br>";
		echo $e->getMessage();
	}

	return !empty($data);
}

/**
 * Summary of createUser
 * @param mixed $EMAIL
 * @param mixed $FIRST_NAME
 * @param mixed $LAST_NAME
 * @param mixed $MD5_PASSWORD
 * @return string , True if the User is created , and False if it is was not created.
 * If returns false, user prob already exists.
 */
function createUser($EMAIL, $FIRST_NAME, $LAST_NAME, $MD5_PASSWORD)
{

	// Check to see if the user with the same email already exists.
	if (userExists($EMAIL))
		return "USER_ALREADY_EXISTS";
	$query = "INSERT INTO USERS (Email, First_Name, Last_Name, MD5_Password) VALUES (?,?,?,?);";

	try {
		$response = executePreparedQuery($query, array('ssss', $EMAIL, $FIRST_NAME, $LAST_NAME, $MD5_PASSWORD));
		echo "<h3>" .  implode(",", $response) . "<h3>";
		if ($response[0] == true) {
			return "USER_CREATED";
		} else {
			return "USER_NOT_CREATED";
		}
	} catch (Exception $e) {
		echo "Error occured , when using Database function to try to validate User.<br>";
		echo $e->getMessage();
	}
}

function userExists($EMAIL)
{
	// Corrected the SQL query to use the proper placeholder syntax
	$query = "SELECT * FROM USERS WHERE Email = ?;";
	try {
		$response = executePreparedQuery($query, array('s', $EMAIL)); // Adjusted parameter structure
		if ($response[0]) { // Query executed properly
			if ($response[1] === "NO_DATA_RETURNED") {
				return "USER_NOT_EXISTS";
			} else if (is_array($response[1]) && count($response[1]) >= 1) { // Corrected condition to check for an array with at least one result
				return "USER_EXISTS";
			}
		}
	} catch (Exception $e) {
		echo "Error occurred, when using Database function to try to validate User.<br>";
		echo $e->getMessage();
	}
	return "USER_NOT_EXISTS"; // Default return if no condition is met
}
