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

/**
 * Summary of getAllItems_IDS_AtStore
 * @param int $STORE_ID
 * @return array 
 * 
 * Returns an Associative array , of all the ITEM_ID at a store.
 * Response Values :
 * 		- NO_ITEMS_AVAILABLE_AT_STORE
 * 		- ['ITEM_1_ID','ITEM_2_ID']
 */
function getAllItems_IDS_AtStore($STORE_ID)
{
	$query = "SELECT * FROM Item_Price_Entry where STORE_ID = ?;";
	try {
		$response = executePreparedQuery($query, array('i', $STORE_ID)); // Adjusted parameter structure
		if ($response[0]) { // Query executed properly
			if ($response[1] === "NO_DATA_RETURNED") {
				return "NO_ITEMS_AVAILABLE_AT_STORE";
			} else if (is_array($response[1]) && count($response[1]) >= 1) { // Corrected condition to check for an array with at least one result
				if (count($response) == 1) {
					return $response['ITEM_ID'];
				}
				$data = array();

				foreach ($response[1] as $item) {
					$data[] = $item['ITEM_ID'];
				}
				return $data;
			}
		}
	} catch (Exception $e) {
		echo "Error occurred, when using Database function to try to validate User.<br>";
		echo $e->getMessage();
	}
}
/**
 * Summary of getItemInfo
 * @param int $ITEM_ID
 * @return array
 * 
 * Returns an associate array (length 1) of response with all the item info.
 */
function getItemInfo($ITEM_ID)
{
	$query = "SELECT * FROM ITEMS where ITEM_ID = ?;";
	try {
		$response = executePreparedQuery($query, array('i', $ITEM_ID)); // Adjusted parameter structure
		if ($response[0]) { // Query executed properly
			if ($response[1] === "NO_DATA_RETURNED") {
				return "NO_ITEM_FOUND";
			} else if (is_array($response[1]) && count($response[1]) >= 1) { // Corrected condition to check for an array with at least one result
				return $response[1];
			}
		}
	} catch (Exception $e) {
		echo "Error occurred, when using Database function to try to validate User.<br>";
		echo $e->getMessage();
	}
}
