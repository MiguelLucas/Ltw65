<!DOCTYPE html>
<html>
<head>
	<title>Eventful</title>
	<meta charset='UTF-8'>
  <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
  <!-- Sweet Alert library -->
  <script src="include/swal/sweetalert.min.js"></script>
  <link rel="stylesheet" type="text/css" href="include/swal/sweetalert.css">
  <script type="text/javascript" src="script.js"></script>
	<!-- <link rel="stylesheet" href="style.css"> -->
	<style type="text/css"> form input, form select {display: block;}</style>
</head>
<body>
<header>
	<h1>Eventful</h1>
	<nav>
		<ul>
			<li><a href="">Browse</a></li>
			<li><a href="">My Events</a></li>
			<li><a href="">Something else</a></li>
		</ul>
	</nav>
</header>
<section id="event">
	<!-- Form for Event creation/edit -->
	<div class="event_form">
		<form>
			<input class="event_id" type="hidden" name="idEvent" value="">
			<label>Name:
				<input class="event_name" type="text" name="name" value="" placeholder="Name your event">
			</label>
			<label>Date:
				<input class="event_date" type="date" name="date" value="">
			</label>
			<label>Time:
				<input class="event_time" type="time" name="time" value="">
			</label>
			<label>Location:
				<input class="event_address" type="text" name="address" value="" placeholder="Where will the event take place?">
			</label>
			<label>Description:
				<input class="event_desc" type="text" name="description" value="" placeholder="Give a brief description of your event">
			</label>
			<label>Type:
				<select class="event_type" name="type">
					<option value=""></option>
				</select>
			</label>
			<label>Privacy:
				<select class="event_privacy" name="private">
					<option value="1">Private</option>
					<option value="0">Public</option>
				</select>
			</label>
			<label>Photo:
				<input class="event_img" type="text" name="eventPhoto" value="" placeholder="fake a url">
			</label>
			<button class="save_button" type="button">Teste</button>
			<a class="cancel" href="">Cancel</a>
		</form>
	</div>
</section>

<!-- Hidden div containing the templates -->
<div id="hidden" style="display: none;">
	<!-- Form for Event's photo edit -->
	<form>
		<input class="event_photo" type="file" name="eventPhoto">
	</form>
</div>

</body>
<!-- 
<script type="text/javascript">
	$(document).ready(function()
	{
		// console.log('hello');
		// loadEvent(<?php echo $_GET['idEvent']; ?>);
		// loadButtons();
		// getEventTypes();
		// createEvent_submit();

	});
</script>

 -->
<script type="text/javascript">
	$(document).ready(function()
	{
		console.log('hello!!!!');
		$('.save_button').click(function() {
    		// alert('send data!');
    		createEvent_submit();
  		});
	});
</script>
</html>