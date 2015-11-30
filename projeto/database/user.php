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
?>