<!DOCTYPE html>
<html>
<head>
	<title>Eventful</title>
	<meta charset='UTF-8'>
  <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
  <script type="text/javascript" src="script.js"></script>
	<!-- <link rel="stylesheet" href="style.css"> -->
	<style type="text/css"> form input, form select {display: block;}</style>
</head>
<body>
	<section id="event">
	</section>

	<!-- Hidden div containing the templates -->
	<div id="hidden" style="display: none;">
		<!-- Template for Event -->
		<div class="event">
		<button class="edit_event">Edit</button>
			<img class="event_img" src="">
			<p class="event_name"></p>
			<p><span class="event_date"></span></p>
			<p><span class="event_time"></span></p>
			<p><span class="event_desc"></span></p>
			<p><span class="event_type"></span></p>
			<p><span class="event_address"></span></p>
			<p><span class="event_privacy"></span></p>
		</div>

		<!-- Form for Event creation/edit -->
		<div class="event_edit">
			<form class="event_form">
				<input class="event_id" type="hidden" name="idEvent" value="">
				<label>Name:
					<input class="event_name" type="text" name="name" value="" placeholder="Name your event">
				</label>
				<label>Description:
					<input class="event_desc" type="text" name="description" value="" placeholder="Write a description of your event">
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
				<label>Type:
					<select class="event_type" name="type">
						<option value=""></option>
					</select>
				</label>
				<label>Privacy
					<select class="event_privacy" name="private">
						<option value="1">Private</option>
						<option value="0">Public</option>
					</select>
				</label>
				<label>Photo:
					<input class="event_img" type="text" name="eventPhoto" value="" placeholder="fake a url">
				</label>
				<input type="submit" value="Save">
				<a class="cancel" href="">Cancel</a>
			</form>
			<button class="delete_event">Delete</button>
		</div>
	</div>

</body>

<script type="text/javascript">
	$(document).ready(function()
	{
		loadEvent(<?php echo $_GET['idEvent']; ?>);
		loadButtons();
		getEventTypes();

	});


</script>
</html>