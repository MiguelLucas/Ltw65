<?php

require_once('connection.php');

/* Function that fetches events from the database and returns a JSON object.

The query is built according to parameters given:
If no parameter is given, returns all events (because '1=1' = true)
If other parameters are given, they will be added to the query */
function getEvent() {
	global $db;

	$query = "SELECT * FROM Event WHERE 1=1";
	if (isset($_GET['id'])) {
		$query .= " AND idEvent = " . $_GET['id'];
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

/* Depending on the type of request (GET, POST, PUT, DELETE), execute the corresponding function */
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	getEvent();
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
