<?php

include_once 'db_connection.php';
include_once 'user_management.php';
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
			if (count($response[1]) == true) {
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
 * Returns String if an Admin is already registered or not
 * @param mixed $email
 * @return string
 * 
 * Posible return Values
 * - ADMIN_EXISTS
 * - ADMIN_NOT_EXIST
 */
function checkAdminExists($email)
{
	$query = "SELECT Email FROM Admins WHERE Email = ?";
	$response = executePreparedQuery($query, array('s', $email));
	if ($response[0] == true) {
		if ($response[1] == "NO_DATA_RETURNED") {
			return "ADMIN_NOT_EXIST";
		}
		return "ADMIN_EXISTS";
	}
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
 * 
 * Possible Return Values:
 * - ADMIN_ALREADY_REGISTERED
 */
function createAdmin($firstName, $lastName, $email, $md5password, $userImage = null)
{
	if (checkAdminExists($email) == "ADMIN_EXISTS") {
		return "ADMIN_ALREADY_REGISTERED";
	}
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

function displayName($email)
{
	if (userExists($email) == "USER_EXISTS") {
		$response = executePreparedQuery("SELECT First_Name, Last_Name FROM USERS WHERE EMAIL = ?", array("s", $email));
		return $response[1]['First_Name'] . " " . $response[1]['Last_Name'];
	}

	if (checkAdminExists($email)) {
		$response = executePreparedQuery("SELECT First_Name, Last_Name FROM Admins WHERE EMAIL = ?", array("s", $email));
		return $response[1]['First_Name'] . " " . $response[1]['Last_Name'];
	}
}
/**
 * Returs the ITEM_ID of an given ITEM_NAME, if it exists in ITEMS Database
 * @param mixed $ITEM_NAME
 * @return mixed
 * Possible Return Values:
 * - ITEM_ID as String
 * - ITEM_NOT_FOUND
 * - COULD_NOT_EXECUTE_QUERY
 * 
 * If multiple items with the same name exist , will return the ID of the first record.
 */
function getItemID($ITEM_NAME)
{

	$query = "SELECT ITEM_ID FROM ITEMS WHERE ITEM_NAME = ?";
	try {
		$response = executePreparedQuery($query, array('s', $ITEM_NAME));
		if ($response[0] == true) {
			if (is_array($response[1])) {
				if (is_array($response[1][0])) {
					return $response[1][0]['ITEM_ID'];
				}
				return $response[1]['ITEM_ID'];
			} else {
				return "ITEM_NOT_FOUND";
			}
		} else {
			return "COULD_NOT_EXECUTE_QUERY";
		}
	} catch (Exception $e) {
		echo "Error occured , when using Database function to try to validate User.<br>";
		echo $e->getMessage();
	}
}
/**
 * Summary of addItem
 * @param mixed $ITEM_NAME
 * @param mixed $ITEM_DESCRIPTION
 * @param mixed $STORE_ID
 * @param mixed $ITEM_PRICE
 * @param mixed $EXTERNAL_LINK
 * @return string
 * 
 * Possible Return Values :
 * - ITEM_NOT_ADDED
 * - ITEM_ADDED
 * - ITEM_WITH_NAME_ALREADY_EXISTS
 * 
 */
function addItem($ITEM_NAME, $ITEM_DESCRIPTION, $STORE_ID, $ITEM_PRICE, $EXTERNAL_LINK)
{
	$ITEM_ID = getItemID($ITEM_NAME);
	if ($ITEM_ID != "ITEM_NOT_FOUND") {
		return "ITEM_WITH_NAME_ALREADY_EXISTS";
	}
	global $connection;
	$query1 = "INSERT INTO ITEMS (ITEM_NAME, ITEM_DESCRIPTION, EXTERNAL_LINK) VALUES (?, ?, ?);";
	$query2 = "INSERT INTO Item_Price_Entry (STORE_ID, ITEM_ID, ITEM_PRICE) VALUES (?, ?, ?);";

	$connection->begin_transaction();
	try {
		$stmt1 = $connection->prepare($query1);
		if (!$stmt1) {
			return "ITEM_NOT_ADDED";
		}
		$stmt1->bind_param('sss', $ITEM_NAME, $ITEM_DESCRIPTION, $EXTERNAL_LINK);
		if ($stmt1->execute()) {
			$ITEM_ID = $connection->insert_id; // Corrected to get the last inserted ID

			$ITEM_PRICE = strval(number_format(floatval($ITEM_PRICE), 2));
			$stmt2 = $connection->prepare($query2);
			if (!$stmt2) {
				throw new Exception($connection->error);
			}
			// Corrected parameter types 'sii' if STORE_ID and ITEM_ID are integers
			$stmt2->bind_param('iii', $STORE_ID, $ITEM_ID, $ITEM_PRICE);
			if ($stmt2->execute()) {
				$connection->commit();
				return "ITEM_ADDED";
			} else {
				$connection->rollback();
				return "ITEM_NOT_ADDED";
			}
		} else {
			$connection->rollback();
			return "ITEM_NOT_ADDED";
		}
	} catch (Exception $e) {
		$connection->rollback();
		echo "Error occurred, when using Database function to try to add item.<br>";
		echo $e->getMessage();
	}
}
