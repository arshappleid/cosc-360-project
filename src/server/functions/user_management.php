<?php

include_once 'db_connection.php';
/**
 * Summary of validateUserLogin
 * @param mixed $email
 * @param mixed $hashed_password
 * @return bool if the given hashed password , matches the hashed password in the database
 */
function validateUserLogin($email, $hashed_password)
{

	$query = "SELECT * FROM USERS WHERE Email = ?";
	try {
		$response = executePreparedQuery($query, array('s', $email));
		if ($response[0] === true) {
			if (is_array($response[1])) {
				return $response[1]['MD5_Password'] === $hashed_password;
			} else {
				// Handle the case where $response[1] is not an array
				// For example, log an error or throw an exception
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
 * @return boolean , True if the User is created , and False if it is was not created.
 * If returns false, user prob already exists.
 */
function createUser($EMAIL, $FIRST_NAME, $LAST_NAME, $MD5_PASSWORD)
{

	// Check to see if the user with the same email already exists.
	$query = "INSERT INTO USERS (EMAIL, FIRST_NAME, LAST_NAME, MD5_PASSWORD) VALUES (?,?,?,?);";

	try {
		$response = executePreparedQuery($query, array('ssss', array($EMAIL, $FIRST_NAME, $LAST_NAME, $MD5_PASSWORD)));
		if ($response[0]) {
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
	// Check to see if the user with the same email already exists.
	echo "testing for email : " . $EMAIL;
	$query = "SELECT * FROM USERS WHERE Email = ?;";
	try {
		$response = executePreparedQuery($query, array('s', array($EMAIL)));

		if ($response[0] == true) {
			if (count($response[1]) == 0) {
				return "USER_NOT_EXISTS";
			}
			return "USER_EXISTS";
		}
	} catch (Exception $e) {
		echo "Error occured , when using Database function to try to validate User.<br>";
		echo $e->getMessage();
	}
}
