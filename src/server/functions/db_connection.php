<?php
$host = "mysql-server";  // docker container name
$database = "market_database";
$user = "root";   // i created a new user using this login for the db
$password = "secret";
$connection = mysqli_connect($host, $user, $password, $database);

// Check connection
if ($connection->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

/**
 * Executes a prepared SQL query using the provided parameters.
 *
 * This function prepares and executes an SQL query based on the provided query string and parameters.
 * It handles SELECT, INSERT, UPDATE, and DELETE queries. For SELECT queries, it returns an array
 * of associative arrays representing the fetched rows. For INSERT, UPDATE, and DELETE queries,
 * it returns true on successful execution. If the execution fails, it returns false. The function
 * The first element of the array , is boolean if the execution was successfull or not
 * If first element is true , that means database elements got updated.
 *   - If its a select , the second element in the array will return an array of data, which you can loop over , to get the records.
 * If first element is false , that means database elements did not get updated.
 * also manages database connection errors and suppresses warnings while attempting to execute the query.
 *
 * @param string $query The SQL query to execute. The query can include placeholders for parameter binding.
 * @param array $params An array of parameters to bind to the query's placeholders.
 * - Pass an empty array , if it does not require any bind paramters.
 * @return mixed An array of associative arrays for SELECT queries, true for successful INSERT/UPDATE/DELETE,
 *               false on failure, or "nullresult" if an error occurs during parameter binding.
 *               Additionally, it may output error messages directly and modify error reporting levels.
 *
 * @throws Exception Throws an exception if an error occurs during the execution of the query or parameter binding.
 *
 * @global mysqli $connection The global mysqli connection object used for database operations.
 *
 * Usage Example:
 * ```
 * $query = "SELECT * FROM users WHERE id = ?";
 * $params = ['i', $userId]; // 'i' indicates the type of the parameter is integer.
 * $result = executePreparedQuery($query, $params);
 * if (is_array($result)) {
 *     // Process result
 * } elseif ($result === true) {
 *     // Success for non-select queries
 * } else {
 *     // Handle error or failed execution
 * }
 * ```
 */
function executePreparedQuery($query, $params)
{
  error_reporting(E_ALL & ~E_WARNING);
  $isSelect = false;
  try {
    // allows access to the global variable $connection
    global $connection;

    if (isset($query)) {
      if (stripos($query, "SELECT") !== false) {
        // Query Contains the word Select
        $isSelect = true;
      }
    }

    if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error() . "<br>";
      return;
    }
    $stmt = $connection->prepare($query);
    if ($stmt === false) {
      die("Failed to prepare statement: " . $connection->error);
    }
    try {
      if (count($params) > 0) {
        $stmt->bind_param(...$params);
      }
    } catch (Exception $e) {
      return array(false, "Error occured , preparing the sql statement.<br>");
    }
    if ($stmt->execute()) {
      if ($isSelect) {
        // If it a select query, return the result set
        // Read statements need to pass the results to the client
        $result = $stmt->get_result();
        $data = array();
        $row = array();
        while ($row = $result->fetch_assoc()) {
          $data[] = $row;
        }
        if (count($data) == 0) {
          // No response record
          return array(true, "NO_DATA_RETURNED");
        }

        if (count($data) == 1) {
          // Only One response record
          return array(true, $data[0]);
        }
        // More than one response record
        return array(true, $data);
      } else {
        // Possible scenarios are insert, update, delete
        // Return True that the statement go executed.
        return array(true, "STATMENT_EXECUTED");
      }
    } else {
      return array(false, "STATEMENT_DID_NOT_EXECUTE , Message : " . $stmt->error);
    }
  } catch (Exception $e) {
    echo "Error occured , when using executePreparedQuery function.<br>";
    echo $e->getMessage();
  }
  error_reporting(E_ALL);
}

/**
 * Uploads an image to a specified table in the database.
 * Sample Update Query : UPDATE #table DISPLAY_IMAGE  = IMAGEBLOB $whereCol = $whereValue
 * 
 * @param string $table The name of the database table to insert the image into.
 * @param string $whereCol The column name that will be used in the WHERE clause for identifying the record.
 * @param mixed $whereValue The value of the column specified in $whereCol to identify the record.
 * @param string $userImageFileName The form input name attribute for the file upload.
 * 
 * Return Values
 * - IMAGE_UPLOADED_SUCCESSFULLY
 * - UNABLE_TO_UPLOAD_IMAGE
 * - COULD_NOT_CONNECT
 * - COULD_NOT_LOAD_IMAGE
 */
function updateImage($table, $whereCol, $whereValue, $userImageFileName)
{
  global $connection;

  // Check if the file is an image
  $check = getimagesize($_FILES[$userImageFileName]["tmp_name"]);
  if ($check !== false) {
    $image = $_FILES[$userImageFileName]['tmp_name'];
    $imgContent = file_get_contents($image);

    // Prepare a statement to insert image content into the database
    $query = "UPDATE $table SET DISPLAY_IMAGE = ? WHERE $whereCol = $whereValue";
    $stmt = $connection->prepare($query);

    if ($stmt) {
      // Bind the parameters (blob and string) to the prepared statement
      $null = NULL;
      $stmt->bind_param("bs", $image);
      $stmt->send_long_data(0, $imgContent); // Send the blob data in packets

      // Execute the prepared statement
      if (!$stmt->execute()) {
        echo "IMAGE_UPLOADED_SUCCESSFULLY";
        return "IMAGE_UPLOADED_SUCCESSFULLY";
      } else {
        return "UNABLE_TO_UPLOAD_IMAGE";
      }

      // Close the statement
      $stmt->close();
    } else {
      return "COULD_NOT_CONNECT";
    }
  } else {
    return "COULD_NOT_LOAD_IMAGE";
  }
}

/**
 * Uploads an image to a specified table in the database.
 * Sample Update Query : UPDATE #table DISPLAY_IMAGE  = IMAGEBLOB $whereCol = $whereValue
 * 
 * @param string $table The name of the database table to insert the image into.
 * @param string $whereCol The column name that will be used in the WHERE clause for identifying the record.
 * @param mixed $whereValue The value of the column specified in $whereCol to identify the record.
 * Return Values

 * - COULD_NOT_GET_IMAGE
 */
function getImage($table, $whereCol, $whereValue)
{
  global $connection;
  $query = "SELECT DISPLAY_IMAGE from $table WHERE $whereCol = $whereValue";
  $stmt = $connection->prepare($query);
  if ($stmt->execute()) {
    $result = $stmt->get_result();
    return $result["DISPLAY_IMAGE"];
  } else {
    return "COULD_NOT_GET_IMAGE";
  }
}
