<?php

require_once('connection.php');

function changeUserPassword(){
		global $db;
		if(isset($_POST['currentPassword'])){
			$current_password = $_POST['currentPassword'];
			$new_password = $_POST['newPassword'];
			$email = $_POST['emailUser'];
	
		$query = "SELECT password FROM User WHERE email = ";
		$query .= "'" . $email . "'";
		
		$stmt = $db->prepare($query);
		$stmt->execute();  
		$getPassword = $stmt->fetchAll();
		$password = $getPassword[0]['password'];
		
		$password_hashed = sha1($current_password);
		
		
		
		if ($password_hashed == $password){
			$new_password_hashed = sha1($new_password);
			$newquery = "UPDATE User SET password = '" . $new_password_hashed . "' WHERE email = '" . $email . "'";
			$stmt = $db->prepare($newquery);
			$stmt->execute();  
			$stmt->fetchAll();
			header("location:../edit_profile.php?action=yes");
			return true;
		} else{
			header("location:../edit_profile.php?action=no");
			return false;
		}
			
		
		}
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	changeUserPassword();
}
	
?>