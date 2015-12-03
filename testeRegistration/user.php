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

function isRegisted($email){
	return getUserByEmail($email);
}
?>