<?php
session_start();
include_once 'db_connection.php';

class Image
{
	/**
	 * Summary of add
	 * @param mixed $table - In which to insert the image
	 * @param mixed $whereCol - Identify row with
	 * @param mixed $whereValue	- Record Match Value
	 * @param mixed $imageName - Image Name on the server
	 * @return string
	 * 
	 * Will Also delete the file reference from the server , once uploaded
	 * 
	 * Posssible return values
	 * - IMAGE_ADDED
	 * - IMAGE_NOT_FOUND
	 * - ERROR_WITH_SQL_QUERY
	 */
	public static function upload($table, $whereCol, $whereValue, $imageName)
	{
		global $connection;
		try {
			$check = getimagesize($_FILES[$imageName]["tmp_name"]);
			if ($check !== false) {
				$imageData = file_get_contents($_FILES[$imageName]['tmp_name']);

				//Insert image content into database
				$query = "UPDATE " . $table . " SET DISPLAY_IMAGE = ? WHERE " . $whereCol . " = ?";
				$stmt = mysqli_stmt_init($connection);

				if (mysqli_stmt_prepare($stmt, $query)) {
					mysqli_stmt_bind_param($stmt, "bs", $null, $whereValue);
					mysqli_stmt_send_long_data($stmt, 0, $imageData);
					$result = mysqli_stmt_execute($stmt) or die(mysqli_stmt_error($stmt));
					unlink($_FILES[$imageName]["tmp_name"]);
					return "IMAGE_ADDED";
				} else {
					return "ERROR_WITH_SQL_QUERY : " . mysqli_error($connection);
				}
			} else {
				return "IMAGE_NOT_FOUND";
			}
		} catch (Exception $e) {
			echo "Error Occured While Uploaded Image : " . $e . "<br>";
		}
	}
}
