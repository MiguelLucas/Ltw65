<!DOCTYPE html>
<html>
<head>
	<title>Event Ranger</title>
	<meta charset='UTF-8'>
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<!-- Sweet Alert library (available at: https://t4t5.github.io/sweetalert/) -->
	<script src="libs/swal/sweetalert.min.js"></script>
	<link rel="stylesheet" type="text/css" href="libs/swal/sweetalert.css">
	<!-- Moments.js library (available at: http://momentjs.com/) -->
	<script type="text/javascript" src="libs/moment.min.js"></script>
	<!-- Fonts -->
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,800,600,700' rel='stylesheet' type='text/css'>
	<!-- Our own scripts and styles -->
	<script type="text/javascript" src="scripts/events.js"></script>
	<script type="text/javascript" src="scripts/registration.js"></script>
	<script type="text/javascript" src="scripts/profile.js"></script>
	<script type="text/javascript" src="scripts/comment.js"></script>
	<script type="text/javascript" src="scripts/imageUpload.js"></script>
	<link rel="stylesheet" href="styles/style.css">
</head>
<body>
<header>
<div>
	<h1><a href="index.php">Event Ranger</a></h1>
	<?php
		if(!isset($_SESSION["idUser"])) {
			include('header_notloggedin.php'); // will include header_notloggedin.php
		} else {
			include('header_loggedin.php'); // will include header_loggedin.php
		}
	?>
</div>
</header>