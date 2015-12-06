<?php

	require_once('connection.php');

	if ($_POST["label"]) {
	/* According to the value of var label, a different function is called */
		if (!array_key_exists("label", $_POST)) {
			echo "An error has occurred";
		} else {
			switch ($_POST["label"]) {
				case 'Event':
					imageUploadEvent();
					break;
				case 'User':
					imageUploadUser();
					break;
				default:
					echo "Unexpected label";
					break;
			}
		}
	}
	
	
	function imageUploadUser(){
		header("Content-Type: application/json");
		global $db;
		
		if ($_POST["label"]) {
			$label = $_POST["label"];
		}
		if ($_POST["id"]) {
			$id = $_POST["id"];
		}
		$allowedExts = array("gif", "jpeg", "jpg", "png");
		$temp = explode(".", $_FILES["file"]["name"]);
		$extension = end($temp);
		if ((($_FILES["file"]["type"] == "image/gif")
			|| ($_FILES["file"]["type"] == "image/jpeg")
			|| ($_FILES["file"]["type"] == "image/jpg")
			|| ($_FILES["file"]["type"] == "image/pjpeg")
			|| ($_FILES["file"]["type"] == "image/x-png")
			|| ($_FILES["file"]["type"] == "image/png"))
			&& ($_FILES["file"]["size"] < 200000)
			&& in_array($extension, $allowedExts)) {
		
				if ($_FILES["file"]["error"] > 0) {
					echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
				} else {
					$timeStamp = time();
					$filename = $timeStamp.$label.$id.$_FILES["file"]["name"];
					//echo "Upload: " . $_FILES["file"]["name"] . "<br>";
					//echo "Type: " . $_FILES["file"]["type"] . "<br>";
					//echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
					//echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";

					if (file_exists("../img/users/" . $filename)) {
						echo $filename . " already exists. ";
					} else {
						move_uploaded_file($_FILES["file"]["tmp_name"],
						"../img/users/" . $filename);
						//echo "Stored in: " . "../img/users/" . $filename;
						$query = "UPDATE User SET profilePhoto = '" . $filename . "' WHERE idUser = " . $id;
						$stmt = $db->prepare($query);
						$stmt->execute();
						
						$result[] = array('src' => '../img/users/' . $filename);
						
						
						echo json_encode($result);
						
					}
				}
		} else {
			echo "Invalid file";
		}
	}
		
	
	
	function imageUploadEvent(){
		
		
		if ($_POST["label"]) {
			$label = $_POST["label"];
		}
		if ($_POST["id"]) {
			$id = $_POST["id"];
		}
		$allowedExts = array("gif", "jpeg", "jpg", "png");
		$temp = explode(".", $_FILES["file"]["name"]);
		$extension = end($temp);
		if ((($_FILES["file"]["type"] == "image/gif")
			|| ($_FILES["file"]["type"] == "image/jpeg")
			|| ($_FILES["file"]["type"] == "image/jpg")
			|| ($_FILES["file"]["type"] == "image/pjpeg")
			|| ($_FILES["file"]["type"] == "image/x-png")
			|| ($_FILES["file"]["type"] == "image/png"))
			&& ($_FILES["file"]["size"] < 200000)
			&& in_array($extension, $allowedExts)) {
		
				if ($_FILES["file"]["error"] > 0) {
					echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
				} else {
					$timeStamp = time();
					$filename = $timeStamp.$label.$id.$_FILES["file"]["name"];
					echo "Upload: " . $_FILES["file"]["name"] . "<br>";
					echo "Type: " . $_FILES["file"]["type"] . "<br>";
					echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
					echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";

					if (file_exists("../img/events/" . $filename)) {
						echo $filename . " already exists. ";
					} else {
						move_uploaded_file($_FILES["file"]["tmp_name"],
						"../img/events/" . $filename);
						echo "Stored in: " . "../img/events/" . $filename;
					}
				}
		} else {
			echo "Invalid file";
		}
	}	

	
	

?>