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
 * @return string ,
 * Possible return values :
 * - USER_ALREADY_EXISTS
 * - 
 */
function createUser($EMAIL, $FIRST_NAME, $LAST_NAME, $MD5_PASSWORD)
{

	// Check to see if the user with the same email already exists.
	if (userExists($EMAIL) == "USER_EXISTS") {
		return "USER_ALREADY_EXISTS";
	}
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

/**
 * Summary of createUser
 * @param mixed $EMAIL
 * @param mixed $FIRST_NAME
 * @param mixed $LAST_NAME
 * @param mixed $MD5_PASSWORD
 * @param blob $USR_IMAGE_BLOB - blob for the user image
 * @return string , 
 * Possible Return Values :
 * - USER_ALREADY_EXISTS
 * - USER_CREATED
 * - USER_NOT_CREATED
 */
function createUser_WithImage($EMAIL, $FIRST_NAME, $LAST_NAME, $MD5_PASSWORD, $USR_IMAGE_BLOB)
{

	// Check to see if the user with the same email already exists.
	if (userExists($EMAIL) == "USER_EXISTS")
		return "USER_ALREADY_EXISTS";
	$query = "INSERT INTO USERS (Email, First_Name, Last_Name, MD5_Password , User_Image) VALUES (?,?,?,?,?);";

	try {
		$response = executePreparedQuery($query, array('ssssb', $EMAIL, $FIRST_NAME, $LAST_NAME, $MD5_PASSWORD, $USR_IMAGE_BLOB));
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
/**
 * Summary of userExists
 * @param mixed $EMAIL
 * @return string
 * Possible return values :
 * - USER_NOT_EXISTS
 * - USER_EXISTS
 */
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
	return "COULD_NOT_PROCESS"; // Default return if no condition is met
}
/**
 * Summary of userUpdatePassword
 * @param mixed $EMAIL
 * @param mixed $OLD_PASSWORD_HASH
 * @param mixed $NEW_PASSWORD_HASH
 * @return string
 * 
 * Updates the password for a user, after verifying 
 * 	1. If the user exists or not exists.
 *  2. If the old provided provided , matches the current provided password or not *  * Return Values:
 * 	 	- USER_NOT_EXISTS
 * 		- INVALID_OLD_PASSWORD
 * 		- PASSWORD_UPDATED
 * 		- PASSWORD_NOT_UPDATED_ERROR
 * Then Updates the password
 */
function userUpdatePassword($EMAIL, $OLD_PASSWORD_HASH, $NEW_PASSWORD_HASH)
{
	if (userExists($EMAIL) == "USER_NOT_EXISTS") {
		return "USER_NOT_EXISTS";
	}
	if (validateUserLogin($EMAIL, $OLD_PASSWORD_HASH) != "VALID_LOGIN") {
		return "INVALID_OLD_PASSWORD";
	}
	$query = "UPDATE USERS SET MD5_PASSWORD = ? WHERE Email = ?;";

	try {
		$response = executePreparedQuery($query, array('ss', $NEW_PASSWORD_HASH, $EMAIL));
		if ($response[0]) { // Query executed properly
			return "PASSWORD_UPDATED";
		}
		return "PASSWORD_NOT_UPDATED_ERROR";
	} catch (Exception $e) {
		echo "Error occurred, when using Database function to try to validate User.<br>";
		echo $e->getMessage();
	}
}

/**
 * Summary of editUserFirstName
 * @param mixed $EMAIL
 * @param mixed $NEW_NAME
 * @return string - Returns if the name was updated or not
 *  Return Values:
 * 	 	- USER_NOT_EXISTS
 * 		- NAME_UPDATED
 * 		- NAME_NOT_UPDATED_ERROR
 * Updates the First Name , for the provided Email
 */
function editUserFirstName($EMAIL, $NEW_NAME)
{
	if (userExists($EMAIL) == "USER_NOT_EXISTS") {
		return "USER_NOT_EXISTS";
	}

	$query = "UPDATE USERS SET First_Name = ? WHERE Email = ?;";

	try {
		$response = executePreparedQuery($query, array('ss', $NEW_NAME, $EMAIL));
		if ($response[0]) { // Query executed properly
			return "NAME_UPDATED";
		}
		return "NAME_NOT_UPDATED_ERROR";
	} catch (Exception $e) {
		echo "Error occurred, when using Database function to try to validate User.<br>";
		echo $e->getMessage();
	}
}

/**
 * Summary of editUserFirstName
 * @param mixed $EMAIL
 * @param mixed $NEW_NAME
 * @return string - Returns if the name was updated or not
 *  Return Values:
 * 	 	- USER_NOT_EXISTS
 * 		- NAME_UPDATED
 * 		- NAME_NOT_UPDATED_ERROR
 * 
 * Updates the Last Name , for the provided Email
 */
function editUserLastName($EMAIL, $NEW_NAME)
{
	if (userExists($EMAIL) == "USER_NOT_EXISTS") {
		return "USER_NOT_EXISTS";
	}

	$query = "UPDATE USERS SET Last_Name = ? WHERE Email = ?;";

	try {
		$response = executePreparedQuery($query, array('ss', $NEW_NAME, $EMAIL));
		if ($response[0]) { // Query executed properly
			return "NAME_UPDATED";
		}
		return "NAME_NOT_UPDATED_ERROR";
	} catch (Exception $e) {
		echo "Error occurred, when using Database function to try to validate User.<br>";
		echo $e->getMessage();
	}
}
/**
 * Summary of getBanStatus
 * @param mixed $USER_EMAIL
 * @return bool|string
 * 
 * Returns BANNED or NOT_BANNED
 */
function getBanStatus($USER_EMAIL)
{
	if (userExists($USER_EMAIL) == "USER_NOT_EXISTS")
		return "USER_NOT_EXISTS";

	$query = "SELECT * FROM USERS WHERE Email = ?";
	try {
		$response = executePreparedQuery($query, array('s', $USER_EMAIL));
		if ($response[0] === true) {
			if (is_array($response[1])) {
				if ($response[1]['BANNED_STATUS'] != "0")
					return "BANNED";
				else
					return "NOT_BANNED";
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
 * Summary of deleteUser
 * @param mixed $USER_EMAIL
 * @return string
 * 
 * Deletes The Associated Comments , and the User
 * 
 * Return Values:
 * 	 	- USER_NOT_EXISTS
 * 		- USER_DELETED
 * 		- USER_NOT_DELETED
 */
function deleteUser($USER_EMAIL)
{
	if (userExists($USER_EMAIL) == "USER_NOT_EXISTS")
		return "USER_NOT_EXISTS";

	$query1 = "DELETE  FROM USERS WHERE Email = ?";
	$user_id = intval(getUserID($USER_EMAIL));
	$query2 = "DELETE  FROM Comments WHERE  USER_ID = ?";

	$response = executePreparedQuery($query1, array('s', $USER_EMAIL));
	$response = executePreparedQuery($query2, array('i', $user_id));
	if ($response[0] === true) {
		return "USER_DELETED";
	}
	return "USER_NOT_DELETED";
}


function getUser_First_Last_Name($USER_ID)
{
	$USER_ID = intval($USER_ID);
	$query = "SELECT First_Name, Last_Name FROM USERS WHERE USER_ID = ?;";
	try {
		$response = executePreparedQuery($query, array('i', $USER_ID));
		if ($response[0]) { // Query executed properly
			if ($response[1] == "NO_DATA_RETURNED") {
				return "NO_NAME_FOUND";
			}
			return $response[1]['First_Name'] . " " . $response[1]['Last_Name'];
		}
		return "NO_NAME_FOUND";
	} catch (Exception $e) {
		echo "Error occurred, when using Database function to try to validate User.<br>";
		echo $e->getMessage();
	}
}
