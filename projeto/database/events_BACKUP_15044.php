<?php
require_once('connection.php');

/* Function that fetches events from the database and returns a JSON object.

The query is built according to parameters given:
If no parameter is given, returns all events (because '1=1' = true)
If other parameters are given, they will be added to the query */
function getEvent() {
	global $db;

<<<<<<< HEAD
	// $query = "SELECT idEvent, name, date, description, EventType.type, address, private, eventPhoto FROM Event, EventType WHERE Event.type = EventType.idEventType";
	$query = "SELECT idEvent, name, date, description, EventType.type, address, private, eventPhoto, idUserCreator, firstName AS userFirstName, lastName AS userLastName FROM Event, EventType, User WHERE Event.type = idEventType AND idUserCreator = idUser";
=======
	$query = "SELECT idEvent, name, date, description, EventType.type, address, private, eventPhoto FROM Event, EventType WHERE Event.type = EventType.idEventType";
>>>>>>> origin/master
	if (isset($_GET['idEvent']))
		$query .= " AND idEvent = " . $_GET['idEvent'];
	if (isset($_GET['name']))
		$query .= " AND name LIKE '%" . $_GET['name'] . "%'";
	if (isset($_GET['type']))
		$query .= " AND type = " . $_GET['type'];

				
	$stmt = $db->prepare($query);
	$stmt->execute();  
	$events = $stmt->fetchAll();

	/* Content-Type must be defined, otherwise the output is seen as plain text */
	header("Content-Type: application/json");
	echo json_encode($events);
<<<<<<< HEAD
}

/* Event Edition */
=======


}

>>>>>>> origin/master
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

<<<<<<< HEAD
/* Event deletion */
=======
>>>>>>> origin/master
function deleteEvent() {
	global $db;

	parse_str(file_get_contents("php://input"), $deleteVars);

	$query = "DELETE FROM Event WHERE ";
	if (isset($deleteVars['idEvent']))
		$query .= "idEvent = " . $deleteVars['idEvent'];

	$stmt = $db->prepare($query);
	$stmt->execute();

	//header("Content-Type: application/json");
<<<<<<< HEAD
	//echo '{"redirect":true,"redirect_url":"index.php"}';
}

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
=======
	//echo '{"redirect":true,"redirect_url":"main.html"}';
}

function createEvent() {
	global $db;

var_dump($_POST);

	$query = "INSERT INTO Event (name, description, date, address, type, private) VALUES (";
	if (isset($_POST['name']))
		$query .= $_POST['name'] . ", ";
	if (isset($_POST['description']))
		$query .= $_POST['description'] . ", ";
	if ((isset($_POST['date'])) AND (isset($_POST['time'])))
		$query .= $_POST['date'] . " " . $_POST['time'] . ", ";
	if (isset($_POST['address']))
		$query .= $_POST['address'] . ", ";
	// if (isset($_POST['type']))
	// 	$query .= $_POST['type'] . ", ";
	$query .= "1, ";
>>>>>>> origin/master
	if (isset($_POST['private']))
		$query .= $_POST['private'];

	$query .= ")";
<<<<<<< HEAD
=======
echo $query;
>>>>>>> origin/master

	$stmt = $db->prepare($query);
	$stmt->execute();

	$last_id = $db->lastInsertID();

	header("Content-Type: application/json");
<<<<<<< HEAD
	echo '{"redirect":true,"redirect_url":"view-event.php?idEvent=' . $last_id . '"}';
}

/* Get event types */
function getEventTypes() {
	global $db;

	$query = "SELECT * FROM EventType ORDER BY type ASC";
=======
	echo '{"redirect":true,"redirect_url":"view-event.php?idEvent="' . $last_id . '}';
}

function getEventTypes() {
	global $db;

	$query = "SELECT * FROM EventType";
>>>>>>> origin/master

	$stmt = $db->prepare($query);
	$stmt->execute();  
	$event_types = $stmt->fetchAll();

	header("Content-Type: application/json");
	echo json_encode($event_types);
}

/* Depending on the type of request (GET, POST, PUT, DELETE), execute the corresponding function */
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	/* According to the value of var action, a different function is called */
	if (!array_key_exists("action", $_GET)) {
<<<<<<< HEAD
		echo "An error has occurred";
=======
		/* throw an error or choose a default */
		echo "action not a key in GET array";
>>>>>>> origin/master
	} else {
		switch ($_GET['action']) {
			case 'event':
				getEvent();
				break;
			case 'event_types':
				getEventTypes();
				break;
			default:
<<<<<<< HEAD
				echo "Unexpected action";
=======
				/* throw an error or choose a default */
				echo "action is defined to unexpected value";
>>>>>>> origin/master
				break;
			}
	}
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	createEvent();
}
if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
	editEvent();
<<<<<<< HEAD
=======
	die;
>>>>>>> origin/master
}
if ($_SERVER['REQUEST_METHOD'] == "DELETE") {
	deleteEvent();
}
?>


