<?php
require_once('connection.php');

/* Function that fetches events from the database and returns a JSON object.

The query is built according to parameters given:
If no parameter is given, returns all events (because '1=1' = true)
If other parameters are given, they will be added to the query */
function getEvent() {
	global $db;

	$query = "SELECT idEvent, name, date, description, EventType.type, address, private, eventPhoto FROM Event, EventType WHERE Event.type = EventType.idEventType";
	if (isset($_GET['idEvent'])) {
		$query .= " AND idEvent = " . $_GET['idEvent'];
	}
	if (isset($_GET['name'])) {
		$query .= " AND name LIKE '%" . $_GET['name'] . "%'";
	}
	if (isset($_GET['type'])) {
		$query .= " AND type = " . $_GET['type'];
	}

	$stmt = $db->prepare($query);
	$stmt->execute();  
	$events = $stmt->fetchAll();

	/* Content-Type must be defined, otherwise the output is seen as plain text */
	header("Content-Type: application/json");
	echo json_encode($events);
}

// function createEvent() {
// 	global $db;

// 	$stmt = $db->prepare($query);
// 	$stmt->execute();
// 	$
// }

function getEventTypes() {
	global $db;

	$query = "SELECT type FROM EventType";

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
		/* throw an error or choose a default */
		echo "action not a key in GET array";
	} else {
		switch ($_GET['action']) {
			case 'event':
				getEvent();
				break;
			case 'event_types':
				getEventTypes();
				break;
			default:
				/* throw an error or choose a default */
				echo "action is defined to unexpected value";
				break;
			}
	}
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	createEvent();
}
if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
	editEvent();
}
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
	deleteEvent();
}
?>
