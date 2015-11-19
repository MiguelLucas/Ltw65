<?php

require_once('connection.php');

function createUser() {
	global $db;

	if(isset($_POST['register'])){
		$first_name = $_POST['firstName'];
		$last_name = $_POST['lastName'];
		$email = $_POST['email'];
		$birth_date = $_POST['birthDate'];
		$password = $_POST['password'];
		//$photo = $_POST['email'];

		$query = "INSERT INTO User (firstName, lastName, birthDate, email, password ) 
		VALUES ( '$firstName', '$lastName', '$birthDate', '$email', '$password')";
		
		$stmt = $db->prepare($query);
		$stmt->execute();  
	}
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	createUser();
}
?>