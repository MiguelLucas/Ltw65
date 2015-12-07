<?php

	
	require_once('connection.php');

	function getUserByEmail($email) {
		global $db;
		$query = "SELECT * FROM User WHERE email = '";
		$query .= $email;
		$query .= "'";
		$stmt = $db->prepare($query);
		$stmt->execute();
		$user = $stmt->fetch();
		return $user;
	}

	function getUserById($id) {
		global $db;
		$query = "SELECT * FROM User WHERE idUser = '";
		$query .= $id;
		$query .= "'";
		$stmt = $db->prepare($query);
		$stmt->execute();
		$user = $stmt->fetch();
		return $user;
	}

	function getAllUsers(){
		global $db;

		$query = "SELECT idUser,firstName,lastName,birthDate,email,password,profilePhoto FROM User";
		
		$stmt = $db->prepare($query);
		$stmt->execute();  
		$users = $stmt->fetchAll();
		
		header("Content-Type: application/json");
		echo json_encode($users);
	}
	function isRegisted($email){
		return getUserByEmail($email);
	}
	
	function getUserInfo(){
		global $db;
		if(isset($_SESSION["idUser"])){
			$idUser = $_SESSION["idUser"];
			$query = "SELECT * FROM User WHERE idUser='$idUser'";
			$stmt = $db->prepare($query);
			$stmt->execute();  
			$result = $stmt->fetchAll();
			$emailUser = $result[0]["email"];
			$firstName = $result[0]["firstName"];
			$lastName = $result[0]["lastName"];
			$birthDate = $result[0]["birthDate"];

			$age = date_diff(date_create($birthDate), date_create('today'))->format('%d anos');
			return array ($idUser, $emailUser, $firstName, $lastName, $birthDate, $age);
	  }

	}
	
	function getUserPhoto(){
		global $db;
		if(isset($_SESSION["idUser"])){
			$idUser = $_SESSION["idUser"];
			$query = "SELECT profilePhoto FROM User WHERE idUser='$idUser'";
			$stmt = $db->prepare($query);
			$stmt->execute();  
			$result = $stmt->fetchAll();
			
			$nameFile = $result[0]["profilePhoto"];
			return "img\\users\\" . $nameFile;
			
	  }

	}
function editUser(){
		global $db;

		parse_str(file_get_contents("php://input"), $putVars);

		$query = "UPDATE User SET ";
		if (isset($putVars['firstName']) && !empty($putVars['firstName']))
			$query .= "firstName = '" . $putVars['firstName'] . "'";
		if (isset($putVars['lastName']) && !empty($putVars['lastName']))
			$query .= "lastName = '" . $putVars['lastName'] . "'";
		if (isset($putVars['email']) && !empty($putVars['email'])){
			$_SESSION["emailUser"] = $putVars['email']; 
			$query .= "email = '" . $putVars['email'] . "'";
		}
			
		if (isset($putVars['password']) && !empty($putVars['password'])){
			$password_hashed = sha1($putVars['password']);
			$query .= "password = '" . $password_hashed . "'";
		}
		if (isset($putVars['date']) && !empty($putVars['date']))
			$query .= "birthDate = '" . $putVars['date']. "'";

		
		$query .= " WHERE idUser = " . $putVars['idUser'];
		
		$stmt = $db->prepare($query);
		$stmt->execute();

		header("Content-Type: application/json");
		echo json_encode(array('success' => true));
	}
		
	
		
	
			
	if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
			editUser();
	}

?>