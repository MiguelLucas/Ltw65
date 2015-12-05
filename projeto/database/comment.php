<?php
require_once('connection.php');
/* Function that fetches comments from the database and returns a JSON object.
The query is built according to parameters given:
If no parameter is given, returns all events (because '1=1' = true)
If other parameters are given, they will be added to the query */
function getComment() {
	global $db;
	
	$query = "SELECT idComment, content, photo, date, Comment.idUser, idEvent, parentComment, firstName AS userFirstName, lastName AS userLastName FROM Comment,User WHERE User.idUser = Comment.idUser";
	
	if (isset($_GET['idComment']))
		$query .= " AND idComment = " . $_GET['idComment'];
	if (isset($_GET['idUser']))
		$query .= " AND idUser = " . $_GET['idUser'];
	if (isset($_GET['idEvent']))
		$query .= " AND idEvent = " . $_GET['idEvent'];
	if (isset($_GET['parentComment']))
		$query .= " AND parentComment = " . $_GET['parentComment'];
				
	$stmt = $db->prepare($query);
	$stmt->execute();  
	$comments = $stmt->fetchAll();
	
	
	
	/* Content-Type must be defined, otherwise the output is seen as plain text */
	header("Content-Type: application/json");
	echo json_encode($comments);
}

function createComment() {
	global $db;
	
	$query = "INSERT INTO Comment (content, idUser, idEvent, parentComment) VALUES (";
	
	if (isset($_POST['content']))
		$query .= "\"" . $_POST['content'] . "\", ";
	if (isset($_POST['idUser']))
		$query .= $_POST['idUser'] . ", ";
	if (isset($_POST['idEvent']))
		$query .= $_POST['idEvent']. ", ";
	if (isset($_POST['parentComment']))
		$query .= $_POST['parentComment'];
	$query .= ")";
	$stmt = $db->prepare($query);
	$stmt->execute();
	
	$last_id = $db->lastInsertID();
	
	header("Content-Type: application/json");
	echo '{"redirect":true,"redirect_url":"view_comments.php?idEvent=' . $last_id . '"}';
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	if (!array_key_exists("action", $_GET)) {
		echo "An error has occurred";
	} else {
		switch ($_GET['action']) {
			case 'comment':
				getComment();
				break;
			default:
				echo "Unexpected action";
				break;
			}
	}
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	createComment();
}
?>