<?php

require_once('connection.php');

function is_leap_year($year)
{
	return ((($year % 4) == 0) && ((($year % 100) != 0) || (($year %400) == 0)));
}

function createUser() {
	global $db;

	if(isset($_POST['register'])){
		
		
		$birth_day = $_POST['day'];
		$birth_month = $_POST['month'];
		$birth_year = $_POST['year'];
		
		
		//Validate first and last name
		//Equivalent to 
		$first_name = $_POST['firstName'];
		$last_name = $_POST['lastName'];
		if (empty($_POST["firstName"])) {
			$firstNameErr = "Name is required";
		  } else {
			//$first_name = test_input($_POST["firstName"]);
			// check if name only contains letters and whitespace
			if (!preg_match("/^[a-zA-Z ]*$/",$first_name)) {
			  $firstNameErr = "Only letters and white space allowed"; 
			}
		}
		
		if (empty($_POST["lastName"])) {
			$lastNameErr = "Name is required";
		  } else {
			//$last_name = test_input($_POST["lastName"]);
			// check if name only contains letters and whitespace
			if (!preg_match("/^[a-zA-Z ]*$/",$last_name)) {
			  $lastNameErr = "Only letters and white space allowed"; 
			}
		}
		
		//Validate email, if it already exists in the database
		$email = $_POST['email'];
		if (verify_if_email_exists($email,$db)){
			$email_err = "This email is already registered!";
			return;
		}
		
		$birth_date = $birth_year . "-" . $birth_month . "-" . $birth_day;
		strtotime($birth_date);
		$today = date("Y-m-d");
		
		//verifica se data introduzida é superior à data de hoje
		if($birth_date > $today){
			echo "<p>We don't accept people from the future!</p>";
			return;
		}
		
		//verifica se data introduzida está correta
		if (is_leap_year($birth_year)){
			if ($birth_month == 02){
				if ($birth_day > 29){
					echo "<p>The date is wrongly introduced!</p>";
					return;
				}
			}
		}else{
			if ($birth_month == 02){
				if ($birth_day > 28){
					echo "<p>The date is wrongly introduced!</p>";
					return;
				}
			}
		}
		if ($birth_month == 02 or $birth_month == 04 or $birth_month == 06 or $birth_month == 09 or $birth_month == 11){
			if ($birth_day > 30){
				echo "<p>The date is wrongly introduced!</p>";
				return;
			}
		}
		$password = $_POST['password'];
		if (strlen($password) < 6){
			echo "<p>Password is too short!</p>";
			//$password_err = "Password is too short!";
			return;
		}
		$password_chars = str_split($password);
		$got_number = false;
		$got_letter = false;
		foreach ($password_chars as $password_char){
			if (is_numeric($password_char))
				$got_number = true;
			if (ctype_alpha($password_char))
				$got_letter = true;
		}
		if($got_number == false){
			echo "<p>Password needs at least one number!</p>";
			//$password_err = "Password needs at least one number!";
			return;
		}else if($got_letter == false){
			echo "<p>Password needs at least one letter!</p>";
			//$password_err = "Password needs at least one letter!";
			return;
		}else{
			$options = ['cost' => 12,
						'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM)];
			$password_hashed = password_hash($password, PASSWORD_DEFAULT, $options);
		}
			
		
		
		$query = "INSERT INTO User (firstName, lastName, birthDate, email, password ) 
		VALUES ( '$first_name', '$last_name', '$birth_date', '$email', '$password_hashed')";
			
		$stmt = $db->prepare($query);
		$result = $stmt->execute();  
		
		if ($result){
		  echo "<p>You have been successfully registered!</p>";
		} else {
		  echo "<p>Sorry, there has been a problem inserting your details.</p>";
		}
	}
}

function verify_if_email_exists($email,$db){
	$query = "SELECT * FROM User WHERE 1=1";
	if (isset($_GET['email'])) {
		$query .= " AND email = " . $_GET['email'];
	}

	$stmt = $db->prepare($query);
	$stmt->execute();  
	$allUsers = $stmt->fetchAll();
	
	foreach ($allUsers as $User){
		var_dump($User);
		die;
		if( $User.email == $email)
			return true;
	}
	return false;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	createUser();
}
//gewt (greatest event website)
//eventorming
//
?>
