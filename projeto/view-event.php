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
<section id="event"></section>
<section id="comments">
	<h2>Comments</h2>
	<ol>
		<form>
			<input class="idUser" type="hidden" name="idUser" value="">
			<input class="comment_content" type="text" name="content" value="" placeholder="Write a comment...">
		</form>
	</ol>
</section>

<!-- Hidden div containing the templates -->
<div id="hidden" style="display: none;">
	<!-- Template for Event -->
	<article class="event">
	<header>
		<button class="edit_event">Edit</button>
		<h1 class="event_name"></h1>
		<p><span class="event_date"></span></p>
		<p><span class="event_time"></span></p>
		<p><span class="event_address"></span></p>
	</header>
		<div><img class="event_img" src=""></div>
		<p><span class="event_desc"></span></p>
		<p><span class="event_type"></span></p>
		<p><span class="event_privacy"></span></p>
	</article>

	<!-- Template for Comments -->
	<li>
		<header>
			<span class="author"></span>
			<span class="publish_date"></span>
		</header>
		<p class="comment_text"></p>
	</li>

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
				<select class="event_type" name="type"></select>
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
			<button class="save_button" type="button">Save</button>
			<a class="cancel" href="">Cancel</a>
		</form>
		<button class="delete_event">Delete</button>
	</div>

	<!-- Form for Event's photo edit -->
	<form>
		<input class="event_photo" type="file" name="eventPhoto">
	</form>
</div>

</body>

<script type="text/javascript">
	$(document).ready(function()
	{
		loadEvent(<?php echo $_GET['idEvent']; ?>);
		loadButtons();

	});
</script>
</html>