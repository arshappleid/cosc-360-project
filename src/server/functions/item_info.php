<?php

include_once 'db_connection.php';
include_once __DIR__ . "./../GLOBAL_VARS.php";

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
	public static function itemExists($ITEM_ID)
	{
		$query = "SELECT * FROM ITEMS WHERE ITEM_ID = ?;";
		try {
			$response = executePreparedQuery($query, array('i', $ITEM_ID)); // Adjusted parameter structure
			if ($response[0]) { // Query executed properly
				if ($response[1] === "NO_DATA_RETURNED") {
					return "ITEM_NOT_EXISTS";
				} elseif (is_array($response[1]) && count($response[1]) >= 1) { // Corrected condition to check for an array with at least one result
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
	public static function getAllItems_IDS_AtStore($STORE_ID)
	{
		$query = "SELECT * FROM Item_Price_Entry where STORE_ID = ?;";
		try {
			$response = executePreparedQuery($query, array('i', $STORE_ID)); // Adjusted parameter structure
			if ($response[0]) { // Query executed properly
				if ($response[1] === "NO_DATA_RETURNED") {
					return "NO_ITEMS_AVAILABLE_AT_STORE";
				} elseif (is_array($response[1]) && count($response[1]) >= 1) { // Corrected condition to check for an array with at least one result
					if (!isset($response[1][0])) {
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
	public static function getItemInfo($ITEM_ID)
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
				} elseif (is_array($response[1]) && count($response[1]) >= 1) { // Corrected condition to check for an array with at least one result
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
	public static function getAllStoreList()
	{
		$query = "SELECT * FROM STORE;";
		try {
			$response = executePreparedQuery($query, array()); // Adjusted parameter structure
			if ($response[0]) { // Query executed properly
				if ($response[1] === "NO_DATA_RETURNED") {
					return "NO_STORES_IN_DATABASE";
				} elseif (is_array($response[1]) && count($response[1]) >= 1) { // Corrected condition to check for an array with at least one result
					return $response[1];
				}
			}
		} catch (Exception $e) {
			echo "Error occurred, when using Database function to try to validate User.<br>";
			echo $e->getMessage();
		}
	}

	/**
	 * Summary of ValidateStoreId
	 * @param mixed $STORE_ID
	 * @return string
	 *
	 * Returns Status if the STORE_ID Exists in STORE Table
	 * Sample Responses :
	 * - STORE_EXISTS
	 * - INVALID_STORE_ID
	 */
	public static function ValidateStoreId($STORE_ID)
	{
		$query = "SELECT STORE_ID FROM STORE WHERE STORE_ID = ?";
		try {
			$response = executePreparedQuery($query, array('s', $STORE_ID)); // Adjusted parameter structure
			if ($response[0]) { // Query executed properly
				if ($response[1] === "NO_DATA_RETURNED") {
					return "INVALID_STORE_ID";
				}
				return "STORE_EXISTS";
			}
		} catch (Exception $e) {
			echo "Error occurred, when using Database function to try to validate User.<br>";
			echo $e->getMessage();
		}
	}

	/**
	 * Summary of getAllItemsAtStore
	 * @return mixed
	 * Sample Response :
	 * - INVALID_STORE_ID
	 * - [ITEM_ID,ITEM_NAME,CATEGORY_NAME,ITEM_PRICE,ITEM_DESCRIPTION,EXTERNAL_LINK,STORE_ID,Time_Updated]
	 * - [[ITEM_ID,ITEM_NAME,CATEGORY_NAME,ITEM_PRICE,ITEM_DESCRIPTION,EXTERNAL_LINK,STORE_ID,Time_Updated],[ITEM_ID,ITEM_NAME,CATEGORY_NAME,ITEM_PRICE,ITEM_DESCRIPTION,EXTERNAL_LINK,STORE_ID,Time_Updated]]
	 */
	public static function getAllItemsAtStore($STORE_ID)
	{
		if (Item_info::ValidateStoreId($STORE_ID) == "INVALID_STORE_ID") {
			return "INVALID_STORE_ID";
		}

		$query = "
		SELECT 
				ITEMS.ITEM_ID, 
				ITEM_NAME, 
				ITEMS.UPVOTES,
				LatestPriceEntry.STORE_ID, 
				LatestPriceEntry.Item_Price,
				LatestPriceEntry.Item_Entry
			FROM ITEMS
			JOIN (
				SELECT 
					Item_Price_Entry.ITEM_ID, 
					Item_Price_Entry.STORE_ID, 
					Item_Price_Entry.Item_Price,
					Item_Price_Entry.Item_Entry
				FROM Item_Price_Entry
				INNER JOIN (
					SELECT 
						ITEM_ID, 
						STORE_ID, 
						MAX(Item_Entry) AS MaxItemEntry
					FROM Item_Price_Entry
					WHERE STORE_ID = ?
					GROUP BY ITEM_ID, STORE_ID
				) AS MaxEntries ON Item_Price_Entry.ITEM_ID = MaxEntries.ITEM_ID 
					AND Item_Price_Entry.STORE_ID = MaxEntries.STORE_ID 
					AND Item_Price_Entry.Item_Entry = MaxEntries.MaxItemEntry
			) AS LatestPriceEntry ON ITEMS.ITEM_ID = LatestPriceEntry.ITEM_ID
			WHERE LatestPriceEntry.STORE_ID = ?
			ORDER BY ITEMS.UPVOTES DESC, LatestPriceEntry.STORE_ID;
		";

		try {
			$response = executePreparedQuery($query, array('ss', $STORE_ID, $STORE_ID));
			if ($response[0]) { // Query executed properly
				if ($response[1] === "NO_DATA_RETURNED") {
					return "NO_ITEMS_IN_DATABASE";
				} elseif (is_array($response[1]) && count($response[1]) >= 1) {
					return $response[1];
				}
			}
		} catch (Exception $e) {
			echo "Error occurred, when using Database function to try to validate User.<br>";
			echo $e->getMessage();
		}
	}
	/**
	 * Summary of getHomePageItems
	 * @return mixed
	 *
	 * Returns Items from the Home Page as an Array
	 * -
	 * - [ITEM_ID,ITEM_NAME,STORE_ID,Item_Price,Item_Entry]
	 * - [[ITEM_ID,ITEM_NAME,STORE_ID,Item_Price,Item_Entry],[ITEM_ID,ITEM_NAME,STORE_ID,Item_Price,Item_Entry]]
	 *
	 */
	public static function getHomePageItems()
	{
		$query = "
        SELECT 
            ITEMS.ITEM_ID, 
            ITEM_NAME, 
			ITEMS.UPVOTES,
            LatestPriceEntry.STORE_ID, 
            LatestPriceEntry.Item_Price,
            LatestPriceEntry.Item_Entry
        FROM ITEMS
        JOIN (
            SELECT 
                Item_Price_Entry.ITEM_ID, 
                Item_Price_Entry.STORE_ID, 
                Item_Price_Entry.Item_Price,
                Item_Price_Entry.Item_Entry
            FROM Item_Price_Entry
            INNER JOIN (
                SELECT 
                    ITEM_ID, 
                    STORE_ID, 
                    MAX(Item_Entry) AS MaxItemEntry
                FROM Item_Price_Entry
                GROUP BY ITEM_ID, STORE_ID
            ) AS MaxEntries ON Item_Price_Entry.ITEM_ID = MaxEntries.ITEM_ID 
                AND Item_Price_Entry.STORE_ID = MaxEntries.STORE_ID 
                AND Item_Price_Entry.Item_Entry = MaxEntries.MaxItemEntry
        ) AS LatestPriceEntry ON ITEMS.ITEM_ID = LatestPriceEntry.ITEM_ID
        LEFT JOIN ITEM_CATEGORY ON ITEMS.ITEM_ID = ITEM_CATEGORY.ITEM_ID
        ORDER BY ITEMS.UPVOTES DESC, LatestPriceEntry.STORE_ID;
    ";

		try {
			$response = executePreparedQuery($query, array());
			if ($response[0]) { // Check if query executed properly
				if ($response[1] === "NO_DATA_RETURNED") {
					return "NO_ITEMS_IN_DATABASE";
				} elseif (is_array($response[1]) && count($response[1]) >= 1) {
					return $response[1];
				}
			}
		} catch (Exception $e) {
			echo "Error occurred when using Database function to try to retrieve home page items.<br>";
			echo $e->getMessage();
		}
	}


	public static function getAllItemData($ITEM_ID, $STORE_ID)
	{
		$query = "SELECT ITEMS.ITEM_ID, ITEMS.ITEM_NAME, ITEMS.ITEM_DESCRIPTION, ITEMS.UPVOTES, Item_Price_Entry.Item_Entry, Item_Price_Entry.STORE_ID, Item_Price_Entry.Item_Price
		   			FROM ITEMS JOIN Item_Price_Entry ON ITEMS.ITEM_ID = Item_Price_Entry.ITEM_ID
				  	WHERE ITEMS.ITEM_ID = ? AND Item_Price_Entry.STORE_ID = ?
					ORDER BY Item_Price_Entry.Item_Entry DESC LIMIT 1;";
		try {
			$response = executePreparedQuery($query, array('ii', $ITEM_ID, $STORE_ID)); // Adjusted parameter structure
			if ($response[0]) { // Query executed properly
				if ($response[1] === "NO_DATA_RETURNED") {
					return "NO_ITEMS_IN_DATABASE";
				} elseif (is_array($response[1]) && count($response[1]) >= 1) {
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
	 * 	- INVALID_STORE_ID
	 * 	- NO_ENTRIES_FOUND
	 * -  [Time_Updated_1,Item_Price_1]
	 * 	-  [[Time_Updated_1,Item_Price_1],[Time_Updated_2,Item_Price_2]]
	 *
	 */
	public static function getAllPrices_Latest_To_Oldest($ITEM_ID, $STORE_ID, $LIMIT_BY = 30)
	{
		if (Item_info::itemExists($ITEM_ID) == "ITEM_NOT_EXISTS") {
			return "INVALID_ITEM_ID";
		}
		if (Item_info::ValidateStoreId($STORE_ID) == "INVALID_STORE_ID") {
			return "INVALID_STORE_ID";
		}

		$query = "SELECT TIME_UPDATED,Item_Price 
					FROM `Item_Price_Entry` 
					WHERE 
					ITEM_ID = ? AND STORE_ID = ?
					ORDER BY TIME_UPDATED DESC";
		try {
			$response = executePreparedQuery($query, array('ss', $ITEM_ID, $STORE_ID));
			if ($response[0]) { // Query executed properly
				if ($response[1] === "NO_DATA_RETURNED") {
					return "NO_ENTRIES_FOUND";
				} elseif (is_array($response[1]) && count($response[1]) >= 1) { // Corrected condition to check for an array with at least one result
					return $response[1];
				}
			}
		} catch (Exception $e) {
			echo "Error occurred, when using Database function to try to validate User.<br>";
			echo $e->getMessage();
		}
	}
	/**
	 * Summary of parsed_GetAllPrices
	 * @param mixed $ITEM_ID
	 * @param mixed $STORE_ID
	 * @param mixed $LIMIT_BY
	 * @return mixed
	 *
	 * Utilized Item::getAllPrices_Latest_To_Oldest() to return the parsed Array Values , for ChartJS Api To Consume
	 * - [[Date1,Date2],[Price1,Price2]]
	 */
	public static function parsed_GetAllPrices($ITEM_ID, $STORE_ID, $LIMIT_BY = 30)
	{
		$records = Item_info::getAllPrices_Latest_To_Oldest($ITEM_ID, $STORE_ID, $LIMIT_BY);
		if (!is_array($records)) {
			// String Response
			return $records;
		}
		$prices = array();
		$dates = array();
		foreach ($records as $record) {
			$date = DateTime::createFromFormat('Y-m-d H:i:s', (string) $record['TIME_UPDATED']);
			if ($date) {
				$dates[] = (string) $date->format('d M y');
				$prices[] = $record['Item_Price'];
			} else {
				$dates[] = (string) $record['TIME_UPDATED'];
			}
		}

		return array($dates, $prices);
	}

	public static function getCurrentPrice($ITEM_ID, $STORE_ID)
	{
		//print_r($ITEM_ID); print_r($STORE_ID);
		if (Item_info::getItemInfo($ITEM_ID) == "NO_ITEM_FOUND") {
			return "INVALID_ITEM_ID";
		}
		$query = "SELECT Item_Price FROM `Item_Price_Entry` WHERE ITEM_ID = ? AND STORE_ID = ? ORDER BY TIME_UPDATED DESC LIMIT 1";
		try {
			$response = executePreparedQuery($query, array('ii', $ITEM_ID, $STORE_ID));
			if ($response[0]) { // Query executed properly
				if ($response[1] === "NO_DATA_RETURNED") {
					return "NO_PRICE_FOUND";
				} elseif (is_array($response[1]) && count($response[1]) == 1) { // Corrected condition to check for an array with at least one result
					return $response[1]['Item_Price'];
				}
			}
		} catch (Exception $e) {
			echo "Error occurred, when using Database function to try to validate User.<br>";
			echo $e->getMessage();
		}
	}

	public static function getStoreName($STORE_ID)
	{
		$query = "SELECT STORE_NAME FROM STORE WHERE STORE_ID = ?";
		try {
			$response = executePreparedQuery($query, array('i', $STORE_ID));
			if ($response[0]) { // Query executed properly
				if ($response[1] === "NO_DATA_RETURNED") {
					return "NO_STORE_FOUND";
				} elseif (is_array($response[1]) && count($response[1]) == 1) { // Corrected condition to check for an array with at least one result
					return $response[1]['STORE_NAME'];
				}
			}
		} catch (Exception $e) {
			echo "Error occurred, when using Database function to try to validate User.<br>";
			echo $e->getMessage();
		}
	}

	/**
	 * Summary of getAllItems_IDS_AtStore
	 * Returns an Associative array , of all the ITEM_ID at a store.
	 * Response Values :
	 * 		- NO_ITEMS_AVAILABLE_AT_STORE
	 * 		- ['CATEGORY_1']
	 * 		- ['CATEGORY_1','CATEGORY_2']
	 */
	public static function getAllCategories()
	{
		$query = "SELECT CATEGORY_NAME FROM CATEGORY_INFO;";
		try {
			$response = executePreparedQuery($query, array(''));
			if ($response[0]) { // Query executed properly
				// Just One Category , or multiple categories
				if (is_array($response[1]) & array_key_exists("CATEGORY_NAME", $response[1])) {
					return array($response[1]["CATEGORY_NAME"]);
				}

				if (is_array($response[1]) & is_array($response[1][0])) {
					$categories = array();
					foreach ($response[1] as $category) {
						$categories[] = $category["CATEGORY_NAME"];
					}
					return $categories;
				}
				return $response[1];
			}
		} catch (Exception $e) {
			echo "Error occurred, when using Database function to try to validate User.<br>";
			echo $e->getMessage();
		}
	}
	/**
	 * Summary of checkCategoryExists
	 * @param mixed $CATEGORY_NAME
	 * @return bool|string
	 * 
	 * Returns EXISTS or NOT_EXIST , if a CATEGORY_NAME with the provied name exists in the CATEGORY_INFO Table
	 */
	public static function checkCategoryExists($CATEGORY_NAME)
	{
		try {
			$query = "SELECT CATEGORY_NAME FROM CATEGORY_INFO WHERE CATEGORY_NAME = ?";
			$resp =  executePreparedQuery($query, array('s', $CATEGORY_NAME));
			if ($resp[0]) {
				if ($resp[1] == "NO_DATA_RETURNED") {
					return "NOT_EXISTS";
				}
				return "EXISTS";
			}
			return "NOT_UPDATED";
		} catch (Exception $e) {
			return false;
		}
	}



	/**
	 * Summary of upvoteItem
	 * @param mixed $ITEM_ID
	 * @return bool|string
	 * 
	 * Returns UPDATED or NOT_UPDATED, if was able to increment the upvote Counter
	 */
	public static function upvoteItem($ITEM_ID)
	{

		try {
			$query = "UPDATE ITEMS SET UPVOTES = UPVOTES + 1 WHERE ITEM_ID = ?";
			$resp =  executePreparedQuery($query, array('i', intval($ITEM_ID)));
			if ($resp[0]) {
				return "UPDATED";
			}
			return "NOT_UPDATED";
		} catch (Exception $e) {
			return false;
		}
	}
	/**
	 * Summary of addCategory
	 * @param mixed $CATEGORY_NAME
	 * @param mixed $CATEGORY_DESCRIPTION
	 * @return bool|string
	 * 
	 * Possible Return Values :
	 * - CATEGORY_WITH_NAME_ALREADY_EXISTS
	 * - ADDED
	 * - NOT_ADDED
	 */
	public static function addCategory($CATEGORY_NAME, $CATEGORY_DESCRIPTION)
	{
		try {
			if (self::checkCategoryExists($CATEGORY_NAME) == "EXISTS") {
				return "CATEGORY_WITH_NAME_ALREADY_EXISTS";
			}
			$query = "INSERT INTO CATEGORY_INFO VALUES(?,?)";
			$resp =  executePreparedQuery($query, array('ss', $CATEGORY_NAME, $CATEGORY_DESCRIPTION));
			if ($resp[0]) {
				return "ADDED";
			}
			return "NOT_ADDED";
		} catch (Exception $e) {
			return false;
		}
	}
}
