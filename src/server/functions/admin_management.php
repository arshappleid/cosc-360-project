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
/**
 * Creates an admin user in the database.
 * 
 * @param string $firstName The first name of the admin.
 * @param string $lastName The last name of the admin.
 * @param string $email The email address of the admin.
 * @param string $md5password The MD5 hashed password of the admin.
 * @param string|null $userImage An optional path or identifier for the user's image.
 * @return string A message indicating the result of the operation.
 */
function createAdmin($firstName, $lastName, $email, $md5password, $userImage = null)
{
	$query = "INSERT INTO Admins(First_Name,Last_Name,Email,MD5_Password) VALUES(?,?,?,?);";
	try {
		$response = executePreparedQuery($query, array('ssss', $firstName, $lastName, $email, $md5password));
		if ($response[0] == true) {
			if ($userImage) {
				updateImage("Admins", "Email", $email, $userImage);
			}
			return "USER_CREATED";
		} else {
			return "USER_NOT_CREATED";
		}
	} catch (Exception $e) {
		echo "Error occured , when using Database function to try to validate User.<br>";
		echo $e->getMessage();
	}
}
