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
	static function ValidateStoreId($STORE_ID)
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
	static function getAllItemsAtStore($STORE_ID)
	{
		if (Item_info::ValidateStoreId($STORE_ID) == "INVALID_STORE_ID") {
			return "INVALID_STORE_ID";
		}

		$query = "SELECT 
			ITEMS.ITEM_ID, 
			ITEMS.ITEM_NAME,
			ITEM_CATEGORY.CATEGORY_NAME, 
			Latest_Price_Entry.Item_Price, 
			ITEMS.ITEM_DESCRIPTION, 
			ITEMS.EXTERNAL_LINK, 
			Latest_Price_Entry.STORE_ID, 
			Latest_Price_Entry.Time_Updated
		FROM 
			ITEMS 
		LEFT JOIN 
			ITEM_CATEGORY ON ITEMS.ITEM_ID = ITEM_CATEGORY.ITEM_ID
		LEFT JOIN (
			SELECT 
				ITEM_ID, 
				STORE_ID, 
				Item_Price, 
				Time_Updated
			FROM 
				Item_Price_Entry
			WHERE 
				(ITEM_ID, Time_Updated) IN (
					SELECT 
						ITEM_ID, 
						MAX(Time_Updated)
					FROM 
						Item_Price_Entry
					WHERE 
						STORE_ID = ?
					GROUP BY 
						ITEM_ID
				)
		) AS Latest_Price_Entry ON ITEMS.ITEM_ID = Latest_Price_Entry.ITEM_ID
		WHERE 
			Latest_Price_Entry.STORE_ID = ?";
		try {
			$response = executePreparedQuery($query, array('ss', $STORE_ID, $STORE_ID)); // Adjusted parameter structure
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
	 * Summary of getHomePageItems
	 * @return mixed
	 * 
	 * Returns Items from the Home Page as an Array
	 * - 
	 * - [ITEM_ID,ITEM_NAME,STORE_ID,Item_Price,Item_Entry]
	 * - [[ITEM_ID,ITEM_NAME,STORE_ID,Item_Price,Item_Entry],[ITEM_ID,ITEM_NAME,STORE_ID,Item_Price,Item_Entry]]
	 * 
	 */
	static function getHomePageItems()
	{
		$query = "
        SELECT 
            ITEMS.ITEM_ID, 
            ITEM_NAME, 
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
        ORDER BY ITEMS.ITEM_ID, LatestPriceEntry.STORE_ID;
    ";

		try {
			$response = executePreparedQuery($query, array()); // Assuming executePreparedQuery is a custom function
			if ($response[0]) { // Check if query executed properly
				if ($response[1] === "NO_DATA_RETURNED") {
					return "NO_ITEMS_IN_DATABASE";
				} else if (is_array($response[1]) && count($response[1]) >= 1) {
					return $response[1];
				}
			}
		} catch (Exception $e) {
			echo "Error occurred when using Database function to try to retrieve home page items.<br>";
			echo $e->getMessage();
		}
	}


	static function getAllItemData($ITEM_ID)
	{
		$query = "SELECT * FROM ITEMS RIGHT JOIN Item_Price_Entry ON ITEMS.ITEM_ID = Item_Price_Entry.ITEM_ID  LEFT JOIN ITEM_CATEGORY ON ITEMS.ITEM_ID = ITEM_CATEGORY.ITEM_ID
				  	WHERE ITEMS.ITEM_ID = ?";
		try {
			$response = executePreparedQuery($query, array('i', $ITEM_ID)); // Adjusted parameter structure
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
	 * 	- INVALID_STORE_ID
	 * 	- NO_ENTRIES_FOUND
	 * 	-  [[Time_Updated_1,Item_Price_1],[Time_Updated_2,Item_Price_2]]
	 * 
	 */
	static function getAllPrices_Latest_To_Oldest($ITEM_ID, $STORE_ID, $LIMIT_BY = 30)
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
	 * Summary of parsed_GetAllPrices
	 * @param mixed $ITEM_ID
	 * @param mixed $STORE_ID
	 * @param mixed $LIMIT_BY
	 * @return mixed
	 * 
	 * Utilized Item::getAllPrices_Latest_To_Oldest() to return the parsed Array Values , for ChartJS Api To Consume
	 * - [[Date1,Date2],[Price1,Price2]]
	 */
	static function parsed_GetAllPrices($ITEM_ID, $STORE_ID, $LIMIT_BY = 30)
	{
		$records = Item_info::getAllPrices_Latest_To_Oldest($ITEM_ID, $STORE_ID, $LIMIT_BY);
		if (!is_array($records)) {
			// String Response
			return $records;
		}
		$prices = array();
		$dates = array();
		foreach ($records as $record) {
			$dates[] = (new DateTime($record['TIME_UPDATED']))->format('d M y');
			$prices[] = $record['Item_Price'];
		}
		return array($dates, $prices);
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
