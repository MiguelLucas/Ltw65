<?php

require_once('connection.php');

function createUser() {
	global $db;

	if(isset($_POST['register'])){
		$first_name = $_POST['firstName'];
		$last_name = $_POST['lastName'];
		$birth_day = $_POST['day'];
		$birth_month = $_POST['month'];
		$birth_year = $_POST['year'];
		$birth_date = $birth_year . "-" . $birth_month . "-" . $birth_day;
		$email = $_POST['email'];
		$password = $_POST['password'];
		
		//VERIFICAR SE EMAIL JA EXISTE
		
		$password_hashed = sha1($password);
		
		$query = "INSERT INTO User (firstName, lastName, birthDate, email, password ) 
		VALUES ( '$first_name', '$last_name', '$birth_date', '$email', '$password_hashed')";
			
		$stmt = $db->prepare($query);
		$result = $stmt->execute();  
		
		if ($result){
			header("location:index.php?action=yes");
        } else {
			//houve algum erro
            header("location:registration.html?action=no");
        }
	} else if (isset($_POST['canceled'])){
		header("location:index.php?action=no");
	}
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	createUser();
}
//gewt (greatest event website)
//eventorming
//
?>
