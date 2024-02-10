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
 * 
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
      $stmt->bind_param(...$params);
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
          return array(true, "NO_DATA_RETURNED");
        }

        if (count($data) == 1) {
          return array(true, $data[0]);
        }

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