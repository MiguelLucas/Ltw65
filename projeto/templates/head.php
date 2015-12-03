<!DOCTYPE html>
<html>
<head>
	<title>Eventful</title>
	<meta charset='UTF-8'>
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<!-- Sweet Alert library (available at: https://t4t5.github.io/sweetalert/) -->
	<script src="libs/swal/sweetalert.min.js"></script>
	<link rel="stylesheet" type="text/css" href="libs/swal/sweetalert.css">
	<!-- Moments.js library (available at: http://momentjs.com/) -->
	<script type="text/javascript" src="libs/moment.min.js"></script>
	<!-- Our own scripts and styles -->
	<script type="text/javascript" src="scripts/events.js"></script>
	<script type="text/javascript" src="scripts/registration.js"></script>
	<link rel="stylesheet" href="styles/style.css">
	<style type="text/css"> form input, textarea, form select {display: block;} .hidden {display: none;}</style>
</head>
<body>
<header>
	<?php
		if(!isset($_SESSION["emailUser"])) {
			include('header_notloggedin.php'); // will include header_notloggedin.php
		} else {
			include('header_loggedin.php'); // will include header_loggedin.php
		}
	?>
</header>