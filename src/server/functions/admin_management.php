<?php

include_once 'db_connection.php';
/**
 * Summary of validateAdminLogin
 * @param mixed $email
 * @param mixed $hashed_password
 * @return string if the given hashed password , matches the hashed password in the database
 * 
 * Validates if an Admin login info is correct.
 */
function validateAdminLogin($email, $hashed_password)
{

	$query = "SELECT * FROM Admins WHERE Email = ?";
	try {
		$response = executePreparedQuery($query, array('s', $email));
		if ($response[0] === true) {
			if (is_array($response[1])) {

				if ($response[1]['MD5_Password'] === $hashed_password)
					return "VALID_LOGIN";
				else
					return "INVALID_LOGIN";
			} else {
				return "ADMIN_NOT_FOUND";
			}
		}
	} catch (Exception $e) {
		echo "Error occured , when using Database function to try to validate User.<br>";
		echo $e->getMessage();
	}

	return !empty($data);
}

/**
 * Summary of toggleBanUserAccount
 * @param mixed $userEmail
 * @return bool|string - Account Updated or not
 * 
 * Toggles between the banned status for a UserEmail provided.
 */
function toggleBanUserAccount($userEmail)
{
	$query = "UPDATE USERS SET BANNED_STATUS = NOT BANNED_STATUS WHERE Email = ?;";
	try {
		$response = executePreparedQuery($query, array('s', $userEmail));
		if ($response[0] === true) {
			return "STATUS_UPDATED";
		} else {
			return "STATUS_NOT_UPDATED";
		}
	} catch (Exception $e) {
		echo "Error occured , when using Database function to try to validate User.<br>";
		echo $e->getMessage();
	}

	return !empty($data);
}
/**
 * Summary of getAllUsers
 * @return mixed
 * 
 * Returns NO_USERS_FOUND , if no users found.
 * Else Returns an Asssociative Array of all the users.
 */
function getAllUsers()
{
	$query = "SELECT * FROM USERS;";
	try {
		$response = executePreparedQuery($query, array());
		if ($response[0] === true) {
			if (count($response[1]) >= 1) {
				return $response[1];
			} else {
				return "NO_USERS_FOUND";
			}
		} else {
			return "DID_NOT_EXECUTE";
		}
	} catch (Exception $e) {
		echo "Error occured , when using Database function to try to validate User.<br>";
		echo $e->getMessage();
	}

	return !empty($data);
}
