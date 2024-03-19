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
 * @param string $uploadDir Location to Store the image on server
 * Stores the image in the uploadDir/whereValue.jpeg
 */
function updateImage($table, $whereCol, $whereValue, $uploadDir = "images/temp")
{
  global $connection;
  $tempName = $_FILES['image']['tmp_name'];
  $fileExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
  $newName = $whereValue . "." . $fileExtension;

  if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
  }

  $destinationPath = $uploadDir . '/' . $newName;
  if (!move_uploaded_file($tempName, $destinationPath)) {
    return "UNABLE_TO_MOVE_FILE";
  }

  $check = getimagesize($destinationPath);
  if ($check !== false) {
    // Assuming you want to store the image's content in the database,
    // It's more common to store just a reference to the file location.
    $imgContent = addslashes(file_get_contents($destinationPath));

    // Make sure to protect against SQL injection
    $query = "UPDATE $table SET DISPLAY_IMAGE = ? WHERE $whereCol = ?";

    if ($stmt = $connection->prepare($query)) {
      // Bind the parameters
      $stmt->bind_param("bs", $imgContent, $whereValue);

      // Execute the prepared statement
      if ($stmt->execute()) {
        $stmt->close();
        return "IMAGE_UPLOADED_SUCCESSFULLY";
      } else {
        $stmt->close();
        return "UNABLE_TO_UPLOAD_IMAGE";
      }
    } else {
      return "COULD_NOT_PREPARE_STATEMENT";
    }
  } else {
    return "COULD_NOT_LOAD_IMAGE";
  }
}
function updateImage2($table, $whereCol, $whereValue, $uploadDir = "images/temp")
{
  global $connection;
  $tempName = $_FILES['image']['tmp_name'];
  $fileExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
  $newName = $whereValue . "." . $fileExtension;

  if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
  }

  $destinationPath = $uploadDir . '/' . $newName;
  if (!move_uploaded_file($tempName, $destinationPath)) {
    return "UNABLE_TO_MOVE_FILE";
  }

  $check = getimagesize($destinationPath);
  if ($check !== false) {
    // Assuming you want to store the image's content in the database,
    // It's more common to store just a reference to the file location.
    $imgContent = addslashes(file_get_contents($_FILES['image']['name']));

    // Make sure to protect against SQL injection
    $query = "UPDATE $table SET DISPLAY_IMAGE = ? WHERE $whereCol = ?";

    if ($stmt = $connection->prepare($query)) {
      // Bind the parameters
      $stmt->bind_param("bs", $imgContent, $whereValue);

      // Execute the prepared statement
      if ($stmt->execute()) {
        $stmt->close();
        return "IMAGE_UPLOADED_SUCCESSFULLY";
      } else {
        $stmt->close();
        return "UNABLE_TO_UPLOAD_IMAGE";
      }
    } else {
      return "COULD_NOT_PREPARE_STATEMENT";
    }
  } else {
    return "COULD_NOT_LOAD_IMAGE";
  }
}


/**
 * Returns the DISPLAY_IMAGE Attribute in the table
 * @param string $table The name of the database table to insert the image into.
 * @param string $whereCol The column name that will be used in the WHERE clause for identifying the record.
 * @param mixed $whereValue The value of the column specified in $whereCol to identify the record.
 * Return Values
 * - COULD_NOT_GET_IMAGE
 */
function getImage($table, $whereCol, $whereValue)
{
  global $connection;
  $query = "SELECT DISPLAY_IMAGE FROM $table WHERE $whereCol = ?";

  if ($stmt = $connection->prepare($query)) {
    $stmt->bind_param("s", $whereValue);

    if ($stmt->execute()) {
      $result = $stmt->get_result();
      if ($row = $result->fetch_assoc()) {
        if (empty($row["DISPLAY_IMAGE"])) {
          return "NO IMAGE";
        } else {
          return $row["DISPLAY_IMAGE"];
        }
      } else {
        return "NO_IMAGE_FOUND";
      }
    } else {
      return "COULD_NOT_EXECUTE_QUERY";
    }

    $stmt->close();
  } else {
    return "COULD_NOT_PREPARE_STATEMENT";
  }
}
