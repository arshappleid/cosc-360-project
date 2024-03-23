<?php

include_once 'db_connection.php';

class Item_info
{
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
	static function itemExists($ITEM_ID)
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
	 * 		- ['ITEM_1_ID']
	 * 		- ['ITEM_1_ID','ITEM_2_ID']
	 */
	static function getAllItems_IDS_AtStore($STORE_ID)
	{
		$query = "SELECT * FROM Item_Price_Entry where STORE_ID = ?;";
		try {
			$response = executePreparedQuery($query, array('i', $STORE_ID)); // Adjusted parameter structure
			if ($response[0]) { // Query executed properly
				if ($response[1] === "NO_DATA_RETURNED") {
					return "NO_ITEMS_AVAILABLE_AT_STORE";
				} else if (is_array($response[1]) && count($response[1]) >= 1) { // Corrected condition to check for an array with at least one result
					if (!is_array($response[1][0])) {
						return array($response[1]['ITEM_ID']);
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
	 * Possible Return Types :
	 * - INVALID_ITEM_ID
	 * - [[ITEM_ID,ITEM_NAME,ITEM_DESCRIPTION,EXTERNAL_LINK,ITEM_IMAGE,CATEGORY_NAME],[ITEM_ID,ITEM_NAME,ITEM_DESCRIPTION,EXTERNAL_LINK,ITEM_IMAGE,CATEGORY_NAME]]
	 */
	static function getItemInfo($ITEM_ID)
	{
		if (Item_info::itemExists($ITEM_ID) == "ITEM_NOT_EXISTS") {
			return "INVALID_ITEM_ID";
		}
		$query = "SELECT * FROM ITEMS LEFT JOIN ITEM_CATEGORY ON ITEMS.ITEM_ID = ITEM_CATEGORY.ITEM_ID where ITEMS.ITEM_ID = ?;";
		try {
			$response = executePreparedQuery($query, array('i', $ITEM_ID)); // Adjusted parameter structure
			if ($response[0]) { // Query executed properly
				if ($response[1] === "NO_DATA_RETURNED") {
					return "INVALID_ITEM_ID";
				} else if (is_array($response[1]) && count($response[1]) >= 1) { // Corrected condition to check for an array with at least one result
					return $response[1];
				}
			}
		} catch (Exception $e) {
			echo "Error occurred, when using Database function to try to validate User.<br>";
			echo $e->getMessage();
		}
	}


	/**
	 * Returns a list of all the stores from the STORE table in the database.
	 */
	static function getAllStoreList()
	{
		$query = "SELECT * FROM STORE;";
		try {
			$response = executePreparedQuery($query, array()); // Adjusted parameter structure
			if ($response[0]) { // Query executed properly
				if ($response[1] === "NO_DATA_RETURNED") {
					return "NO_STORES_IN_DATABASE";
				} else if (is_array($response[1]) && count($response[1]) >= 1) { // Corrected condition to check for an array with at least one result
					return $response[1];
				}
			}
		} catch (Exception $e) {
			echo "Error occurred, when using Database function to try to validate User.<br>";
			echo $e->getMessage();
		}
	}

	static function getHomePageItems()
	{
		$query = "SELECT * FROM ITEMS RIGHT JOIN Item_Price_Entry ON ITEMS.ITEM_ID = Item_Price_Entry.ITEM_ID NATURAL JOIN ITEM_CATEGORY;";
		try {
			$response = executePreparedQuery($query, array()); // Adjusted parameter structure
			if ($response[0]) { // Query executed properly
				if ($response[1] === "NO_DATA_RETURNED") {
					return "NO_ITEMS_IN_DATABASE";
				} else if (is_array($response[1]) && count($response[1]) >= 1) { // Corrected condition to check for an array with at least one result
					return $response[1];
				}
			}
		} catch (Exception $e) {
			echo "Error occurred, when using Database function to try to validate User.<br>";
			echo $e->getMessage();
		}
	}
	/**
	 * Summary of getAllPrioes
	 * @param mixed $ITEM_ID
	 * @return mixed
	 * 
	 * Returns the $LIMIT_BY Latest Record.
	 * If no value for $LIMIT_BY provided, provides latest 30 prices
	 * Sample Return : [[Time_Updated_1,Item_Price_1],[Time_Updated_2,Item_Price_2],[Time_Updated_3,Item_Price_3]]
	 * 
	 * Possible return types :
	 *  - INVALID_ITEM_ID
	 * 	- NO_ENTRIES_FOUND
	 * 	-  [[Time_Updated_1,Item_Price_1],[Time_Updated_2,Item_Price_2]]
	 * 
	 */
	static function getAllPrices_Latest_To_Oldest($ITEM_ID, $LIMIT_BY = 30)
	{
		if (Item_info::itemExists($ITEM_ID) == "ITEM_NOT_EXISTS") {
			return "INVALID_ITEM_ID";
		}
		$query = "SELECT TIME_UPDATED,Item_Price FROM `Item_Price_Entry` WHERE ITEM_ID = ? ORDER BY TIME_UPDATED DESC";
		try {
			$response = executePreparedQuery($query, array('s', $ITEM_ID));
			if ($response[0]) { // Query executed properly
				if ($response[1] === "NO_DATA_RETURNED") {
					return "NO_ENTRIES_FOUND";
				} else if (is_array($response[1]) && count($response[1]) >= 1) { // Corrected condition to check for an array with at least one result
					return $response[1];
				}
			}
		} catch (Exception $e) {
			echo "Error occurred, when using Database function to try to validate User.<br>";
			echo $e->getMessage();
		}
	}

	static function getCurrentPrice($ITEM_ID, $STORE_ID)
	{ //print_r($ITEM_ID); print_r($STORE_ID);
		if (Item_info::getItemInfo($ITEM_ID) == "NO_ITEM_FOUND") {
			return "INVALID_ITEM_ID";
		}
		$query = "SELECT Item_Price FROM `Item_Price_Entry` WHERE ITEM_ID = ? AND STORE_ID = ? ORDER BY TIME_UPDATED DESC LIMIT 1";
		try {
			$response = executePreparedQuery($query, array('ii', $ITEM_ID, $STORE_ID));
			if ($response[0]) { // Query executed properly
				if ($response[1] === "NO_DATA_RETURNED") {
					return "NO_PRICE_FOUND";
				} else if (is_array($response[1]) && count($response[1]) == 1) { // Corrected condition to check for an array with at least one result
					return $response[1]['Item_Price'];
				}
			}
		} catch (Exception $e) {
			echo "Error occurred, when using Database function to try to validate User.<br>";
			echo $e->getMessage();
		}
	}

	static function getStoreName($STORE_ID)
	{
		$query = "SELECT STORE_NAME FROM STORE WHERE STORE_ID = ?";
		try {
			$response = executePreparedQuery($query, array('i', $STORE_ID));
			if ($response[0]) { // Query executed properly
				if ($response[1] === "NO_DATA_RETURNED") {
					return "NO_STORE_FOUND";
				} else if (is_array($response[1]) && count($response[1]) == 1) { // Corrected condition to check for an array with at least one result
					return $response[1]['STORE_NAME'];
				}
			}
		} catch (Exception $e) {
			echo "Error occurred, when using Database function to try to validate User.<br>";
			echo $e->getMessage();
		}
	}
}
