<?php
include './server/functions/db_connection.php';
$filename = "./../database/init.sql";

try {
    $data = file_get_contents($filename, true);
    if ($data === false) {
        // If the file is not found or cannot be read, throw an exception
      echo "File not found or cannot be read";
      exit;
    }
    $lines = explode(";", $data);

    foreach ($lines as $line) {
        $line = trim($line);
        if ($line != "") {
            try {
                executePreparedQuery($line, array());
            } catch (Exception $e) {
                echo "Could Not Execute : " . $line . "<br>";
            }
        }
    }
    echo "All SQL Loaded From : " . $filename."<br>";

    // Delete the file after processing
    unlink($filename);
    echo "File Deleted from Server : ".$filename."<br>";
} catch (Exception $e) {
    // Handle the error, such as by logging it or displaying a message
    echo "Error: " . $e->getMessage();
}
?>
