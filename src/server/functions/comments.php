<?php

include_once 'db_connection.php';
include_once 'user_management.php';
include_once 'item_info.php';
/**
 * Summary of addComment
 * @param mixed $COMMENT_TEXT
 * @param mixed $ITEM_ID
 * @param mixed $USER_EMAIL
 * @return string - Returns Status if a Comment was deleted
 * Return Values:
 * - USER_NOT_EXISTS
 * - ITEM_NOT_EXISTS
 * - COMMENT_ADDED
 * - COMMENT_NOT_ADDED
 */
function addComment($COMMENT_TEXT, $ITEM_ID, $USER_EMAIL)
{

	if ( User_management::userExists($USER_EMAIL) == "USER_NOT_EXISTS") return "USER_NOT_EXISTS";
	if (itemExists($ITEM_ID == "ITEM_NOT_EXISTS")) return "ITEM_NOT_EXISTS";
	$user_ID = getUserID($USER_EMAIL);

	$query = "INSERT INTO Comments(COMMENT_TEXT ,ITEM_ID ,USER_ID, DATE_TIME_ADDED) VALUES(?,?,?,$user_ID,NOW());";

	try {
		$response = executePreparedQuery($query, array('i', $COMMENT_TEXT, $ITEM_ID, $USER_EMAIL));
		if ($response[0]) { // Query executed properly
			return "COMMENT_ADDED";
		}
		return "COMMENT_NOT_ADDED";
	} catch (Exception $e) {
		echo "Error occurred, when using Database function to try to validate User.<br>";
		echo $e->getMessage();
	}
}
/**
 * Summary of getUserID
 * @param mixed $USER_EMAIL
 * @return string
 * 
 * If User_Email does not exists returns USER_NOT_EXISTS
 * 
 * Return the User_Id of the given User Email
 * 
 */
function getUserID($USER_EMAIL)
{
	try {
		if ( User_management::userExists($USER_EMAIL) == "USER_NOT_EXISTS")
			return "USER_NOT_EXISTS";
		$user_ID = executePreparedQuery("SELECT * FROM USERS WHERE Email = ?;", array('i', $USER_EMAIL))[1]["USER_ID"];
		return $user_ID;
	} catch (Exception $e) {
		echo "Error occurred, when using Database function to try to validate User.<br>";
		echo $e->getMessage();
	}
}

function commentExists($COMMENT_ID)
{
	// Corrected the SQL query to use the proper placeholder syntax
	$query = "SELECT * FROM Comments WHERE COMMENT_ID = ?;";
	try {
		$response = executePreparedQuery($query, array('i', $COMMENT_ID)); // Adjusted parameter structure
		if ($response[0]) { // Query executed properly
			if ($response[1] === "NO_DATA_RETURNED") {
				return "COMMENT_NOT_EXISTS";
			} else if (is_array($response[1]) && count($response[1]) >= 1) { // Corrected condition to check for an array with at least one result
				return "COMMENT_EXISTS";
			}
		}
	} catch (Exception $e) {
		echo "Error occurred, when using Database function to try to validate User.<br>";
		echo $e->getMessage();
	}
	return "COMMENT_NOT_EXISTS"; // Default return if no condition is met
}

/**
 * Summary of deleteComment
 * @param int $Comment_Id
 * @return string - Returns Confirmation , if the comment was deleted or not
 * Return Values:
 * - COMMENT_DELETED
 * - COMMENT_NOT_DELETED
 *
 * Deletes the comment , given the comment ID.
 */
function deleteComment($Comment_Id)
{
	if (commentExists($Comment_Id) == "COMMENT_NOT_EXISTS")
		return "COMMENT_NOT_EXISTS";

	$query = "DELETE FROM Comments WHERE COMMENT_ID = ?";

	try {
		$response = executePreparedQuery($query, array('i', $Comment_Id));
		if ($response[0]) { // Query executed properly
			return "COMMENT_DELETED";
		}
		return "COMMENT_NOT_DELETED";
	} catch (Exception $e) {
		echo "Error occurred, when using Database function to try to validate User.<br>";
		echo $e->getMessage();
	}
}
/**
 * Summary of getAllCommentsForItem
 * @param int $Item_Id
 * @return mixed - Return an associate array of all the comments , associated with an ID.
 * 
 * Return Values:
 * - Array - of all the comments
 * 		- Only 1 comment : [comment1]
 * 		- More than 1 comment : [comment1,comment2]
 * - 0 Comments : NO_COMMENTS_ADDED_YET
 */
function getAllCommentsForItem($Item_Id)
{
	if (itemExists($Item_Id) == "ITEM_NOT_EXISTS")
		return "ITEM_NOT_EXISTS";

	$query = "SELECT * FROM Comments WHERE ITEM_ID = ?";
	try {
		$response = executePreparedQuery($query, array('s', $Item_Id));

		if ($response[0] === true) {
			if (is_array($response[1])) {
				// Valid Response
				if (count($response[1]) == 0)
					return "NO_COMMENTS_ADDED_YET";
				elseif (!is_array($response[1][0])) // if the first element is not an
					return array($response[1]);

				return $response[1];
			} else {
				return "NO_COMMENTS_ADDED_YET";
			}
		}
	} catch (Exception $e) {
		echo "Error occured , when using Database function to try to validate User.<br>";
		echo $e->getMessage();
	}

	return !empty($data);
}