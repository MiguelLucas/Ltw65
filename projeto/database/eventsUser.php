<?php

require_once('connection.php');

/*
 * Sees if user created the event
 */
function userIsCreator($idEvent, $idUser){
	global $db;

	$query = "SELECT idUserCreator FROM Event WHERE idEvent =".$idEvent;
	
	$stmt = $db->prepare($query);
	$stmt->execute();
	$user = $stmt->fetchAll();
	if($user[0]['idUserCreator'] == $idUser)
		return true;
	
	return false;
}


/*
 * Sees if user is registered in the event
 */
function userIsRegistered($idEvent, $idUser){
	global $db;

	$query = "SELECT * FROM Registration WHERE idUser =".$idUser." AND idEvent = ".$idEvent;
	
	$stmt = $db->prepare($query);
	$stmt->execute();
	$register = $stmt->fetchAll();
	if($register != NULL)
		return true;
	return false;
}

/*
 * Sees if event is public
 */
function eventIsPublic($idEvent){
	global $db;

	$query = "SELECT private FROM Event WHERE idEvent =".$idEvent;
	
	$stmt = $db->prepare($query);
	$stmt->execute();
	$state = $stmt->fetchAll();
	if($state[0]['private'] == 0)
		return true;
	
	return false;
}
 

?>
