<?php
require_once('connection.php');

/* Function that fetches events from the database and returns a JSON object.

The query is built according to parameters given:
If no parameter is given, returns all events (because '1=1' = true)
If other parameters are given, they will be added to the query */
function getEvent() {
	global $db;

	$query = "SELECT idEvent, name, date, description, EventType.type, address, private, eventPhoto, idUserCreator, firstName AS userFirstName, lastName AS userLastName FROM Event, EventType, User WHERE Event.type = idEventType AND idUserCreator = idUser AND Event.active = 1";
	if (isset($_GET['idEvent']))
		$query .= " AND idEvent = " . $_GET['idEvent'];
	if (isset($_GET['name']))
		$query .= " AND name LIKE '%" . $_GET['name'] . "%'";
	if (isset($_GET['type']))
		$query .= " AND type = " . $_GET['type'];
	if (isset($_GET['address']))
		$query .= " AND address LIKE '%" . $_GET['address'] . "%'";
	if (isset($_GET['private_event']))
		$query .= " AND private = " . $_GET['private_event'];
	if (isset($_GET['type_name']))
		$query .= " AND EventType.type LIKE '%" . $_GET['type_name'] . "%'";
	if (isset($_GET['dateBegin']))
		$query .= " AND date >= '" . $_GET['dateBegin'] . "' AND date <= '" . $_GET['dateEnd'] . "'";
	if (isset($_GET['idUserCreator']))
		$query .= " AND idUserCreator = " . $_GET['idUserCreator'];

				
	$stmt = $db->prepare($query);
	$stmt->execute();  
	$events = $stmt->fetchAll();

	/* Content-Type must be defined, otherwise the output is seen as plain text */
	header("Content-Type: application/json");
	echo json_encode($events);
}
/* Event Edition */
function editEvent() {
	global $db;

	parse_str(file_get_contents("php://input"), $putVars);

	$query = "UPDATE Event SET ";
	if (isset($putVars['name']))
		$query .= "name = \"" . $putVars['name'] . "\"";
	if (isset($putVars['description']))
		$query .= ", description = \"" . $putVars['description'] . "\"";
	if ((isset($putVars['date'])) AND (isset($putVars['time'])))
		$query .= ", date = \"" . $putVars['date'] . " " . $putVars['time'] . "\"";
	if (isset($putVars['address']))
		$query .= ", address = \"" . $putVars['address'] . "\"";
	if (isset($putVars['type']))
		$query .= ", type = " . $putVars['type'];
	if (isset($putVars['private']))
		$query .= ", private = " . $putVars['private'];

	$query .= " WHERE idEvent = " . $putVars['idEvent'];

	$stmt = $db->prepare($query);
	$stmt->execute();

	header("Content-Type: application/json");
	echo json_encode(array('success' => true));
}

/* Event deletion */
function deleteEvent() {
	global $db;

	parse_str(file_get_contents("php://input"), $deleteVars);
	//echo 'delete';
	//echo $deleteVars['idEvent'];
	
	$query = "UPDATE Event SET active = 0";

	$query .= " WHERE idEvent = " . $deleteVars['idEvent'];

	$stmt = $db->prepare($query);
	$stmt->execute();

	//header("Content-Type: application/json");
	//echo '{"redirect":true,"redirect_url":"index.php"}';
}


/*
 * Sees if user created the event

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
 */

/*
 * Sees if user is registered in the event

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
 */

/*
 * Registration of user in event
 */
function eventRegisterUser(){
	global $db;

	$query = "INSERT INTO Registration (idUser, idEvent) VALUES (";
	if (isset($_POST['user_id']))
		$query .= $_POST['user_id'] . ", ";
	if (isset($_POST['event_id']))
		$query .= $_POST['event_id'];

	$query .= ")";

	$stmt = $db->prepare($query);
	$stmt->execute();

	$last_id = $db->lastInsertID();

	header("Content-Type: application/json");
	echo '{"redirect":true,"redirect_url":"view-event.php?idEvent=' . $last_id . '"}';
}

/*
 * Cancel registration of user in event
 */
function cancelEventRegisterUser(){
	global $db;

	$query = "DELETE FROM Registration WHERE idUser =".$_POST['user_id']." AND idEvent = ".$_POST['event_id'];
	//echo $query;
	$stmt = $db->prepare($query);
	$stmt->execute();

	$last_id = $_POST['event_id'];

	header("Content-Type: application/json");
	echo '{"redirect":true,"redirect_url":"view-event.php?idEvent=' . $last_id . '"}';
}

/*
 * Sees if event is public

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
 */

/* Event creation */
function createEvent() {
	global $db;

	$query = "INSERT INTO Event (idUserCreator, name, description, date, address, type, private) VALUES (";
	if (isset($_POST['user_id']))
		$query .= $_POST['user_id'] . ", ";
	if (isset($_POST['name']))
		$query .= "\"" . $_POST['name'] . "\", ";
	if (isset($_POST['description']))
		$query .= "\"" . $_POST['description'] . "\", ";
	if ((isset($_POST['date'])) AND (isset($_POST['time'])))
		$query .= "\"" . $_POST['date'] . " " . $_POST['time'] . "\", ";
	if (isset($_POST['address']))
		$query .= "\"" . $_POST['address'] . "\", ";
	if (isset($_POST['type']))
		$query .= $_POST['type'] . ", ";
	if (isset($_POST['private']))
		$query .= $_POST['private'];

	$query .= ")";

	$stmt = $db->prepare($query);
	$stmt->execute();

	$last_id = $db->lastInsertID();

	header("Content-Type: application/json");
	echo '{"redirect":true,"redirect_url":"view-event.php?idEvent=' . $last_id . '&replytocom=0"}';
}

/* Get event types */
function getEventTypes() {
	global $db;

	$query = "SELECT * FROM EventType ORDER BY type ASC";

	$stmt = $db->prepare($query);
	$stmt->execute();  
	$event_types = $stmt->fetchAll();

	header("Content-Type: application/json");
	echo json_encode($event_types);
}


/* Get events attend by a user */
function getAttendingEvents() {
	global $db;
	
	//FALTA CONFIRMAR SE ESTA ISSET ************************************************************************************************
	
	$query = "SELECT * FROM Event WHERE active = 1 AND idEvent IN(SELECT idEvent FROM Registration WHERE idUser = ". $_GET['idAttendingUser'].")";

	$stmt = $db->prepare($query);
	$stmt->execute();  
	$events = $stmt->fetchAll();
	/* Content-Type must be defined, otherwise the output is seen as plain text */
	header("Content-Type: application/json");
	echo json_encode($events);
}


/*
 * Send invite to private event
 */
function sendInvite(){
	
	global $db;
	
	//sees if invited user is registred
	$query = "SELECT idUser FROM User WHERE active = 1 AND email = '" . $_POST['invite_user_email'] . "'";
	$stmt = $db->prepare($query);
	$stmt->execute();  
	$user = $stmt->fetchAll();
	
	
	//invited user is registred
	if($user != NULL){
		
		//get invited user id
		$invitedUserId = $user[0]['idUser'];
	
		$query = "SELECT * FROM Invite WHERE idReceiver = " . $invitedUserId . " AND idEvent = " . $_POST['id_event'];
		$stmt = $db->prepare($query);
		$stmt->execute(); 
		$invite = $stmt->fetchAll();
		
		//Invite already exists
		if($invite != NULL){
			//echo 'nononononononono\n';
			$response = array('inviteAlreadySent'=> true);
			header("Content-Type: application/json");
			echo json_encode($response);
			die();
		}
		
		$query = "INSERT INTO Invite (idSender, idReceiver, idEvent) VALUES (" . $_POST['user_id'] . "," .  $invitedUserId . "," .  $_POST['id_event'] . ")";	
		$stmt = $db->prepare($query);
		$stmt->execute();
	
		$response = array('success'=> true);
		header("Content-Type: application/json");
		//echo json_encode($response);
		echo json_encode($response);

		
	}
	
}


/* Depending on the type of request (GET, POST, PUT, DELETE), execute the corresponding function */
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	/* According to the value of var action, a different function is called */
	if (!array_key_exists("action", $_GET)) {
		echo "An error has occurred";
	} else {
		switch ($_GET['action']) {
			case 'event':
				getEvent();
				break;
			case 'event_types':
				getEventTypes();
				break;
			case 'attending':
				getAttendingEvents();
				break;
			default:
				echo "Unexpected action";
				break;
			}
	}
}



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	if (!array_key_exists("action", $_POST)) {
		echo "An error has occurred";
	} else {
		switch ($_POST['action']) {
			case 'create_event':
				createEvent();
				break;
			case 'user_register_event':
				eventRegisterUser();
				break;
			case 'user_cancel_register_event':
				cancelEventRegisterUser();
				break;	
			case 'send_invite':
				sendInvite();
				break;	
				
			default:
				echo "Unexpected action";
				break;
			}
	}
	
	

}
if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
	editEvent();
}
if ($_SERVER['REQUEST_METHOD'] == "DELETE") {
	deleteEvent();
}
?>


