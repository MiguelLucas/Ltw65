<?php
	include_once('connection.php');

	/* get all events */
	function getAllEvents($dbh) {
		$stmt = $db->prepare('SELECT * FROM Event');
  		$stmt->execute();  
  		$events = $stmt->fetchAll();
  		echo json_encode($events);
	}
	
	
	if ( $_SERVER['REQUEST_METHOD'] == 'GET' ) {
		getAllEvents();
	}
?>