<?php

include_once 'db_connection.php';

function addImage($table, $whereCol, $whereValue, $userImageFileName)
{
	global $connection;
	$check = getimagesize($_FILES["image"]["tmp_name"]);
	if ($check !== false) {
		$image = $_FILES[$userImageFileName]['tmp_name'];
		$imgContent = addslashes(file_get_contents($image));

		//Insert image content into database
		$insert = $connection->query("INSERT into $table (image, image_name) VALUES ('$imgContent', '" . $image . "')");


		if ($insert) {
			echo "File uploaded successfully.";
		} else {
			echo "File upload failed, please try again.";
		}
	} else {
		echo "Please select an image file to upload.";
	}
}
