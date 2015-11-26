<?php

require_once('connection.php');

function createUser() {
	global $db;

	if(isset($_POST['register'])){
		$first_name = $_POST['firstName'];
		$last_name = $_POST['lastName'];
		$email = $_POST['email'];
		$birth_day = $_POST['day'];
		$birth_month = $_POST['month'];
		$birth_year = $_POST['year'];
		$password = $_POST['password'];
		
		$birth_date = $birth_year . "-" . $birth_month . "-" . $birth_day;
		//$photo = $_POST['photo'];

		$query = "INSERT INTO User (firstName, lastName, birthDate, email, password ) 
		VALUES ( '$first_name', '$last_name', '$birth_date', '$email', '$password')";
		
		$stmt = $db->prepare($query);
		$result = $stmt->execute();  
	
		if ($result){
		  echo "<p>You have been successfully registered!</p>";
		} else {
		  echo "<p>Sorry, there has been a problem inserting your details.</p>";
		}
	}
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	createUser();
}
?>