<?php

include_once 'db_connection.php';

// Edit Comments as Admin
// Add comments as User

/**
 * Summary of itemExists
 * @param mixed $ITEM_ID
 * @return string = Returns Status If an Item Exists or not
 * Return Values:
 * - ITEM_EXISTS
 * - ITEM_NOT_EXISTS
 */
function itemExists($ITEM_ID)
{
	// Corrected the SQL query to use the proper placeholder syntax
	$query = "SELECT * FROM ITEMS WHERE ITEM_ID = ?;";
	try {
		$response = executePreparedQuery($query, array('i', $ITEM_ID)); // Adjusted parameter structure
		if ($response[0]) { // Query executed properly
			if ($response[1] === "NO_DATA_RETURNED") {
				return "ITEM_NOT_EXISTS";
			} else if (is_array($response[1]) && count($response[1]) >= 1) { // Corrected condition to check for an array with at least one result
				return "ITEM_EXISTS";
			}
		}
	} catch (Exception $e) {
		echo "Error occurred, when using Database function to try to validate User.<br>";
		echo $e->getMessage();
	}
	return "USER_NOT_EXISTS"; // Default return if no condition is met
}
