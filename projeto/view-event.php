<!DOCTYPE html>
<html>
<head>
	<title>Eventful</title>
	<meta charset='UTF-8'>
  <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
  <script type="text/javascript" src="script.js"></script>
	<!-- <link rel="stylesheet" href="style.css"> -->
</head>
<body>
	<section id="events">
		
	</section>

	<!-- Hidden div containing the templates -->
	<div id="hidden" style="display: none;">
		<!-- Template for Event -->
		<div class="event">
			<p class="event_name"></p>
			<p><span class="event_date"></span></p>
			<p><span class="event_desc"></span></p>
			<p><span class="event_type"></span></p>
			<p><span class="event_privacy"></span></p>
			<img class="event_img" src="">
		</div>
	</div>

</body>

<script type="text/javascript">
	$(document).ready(function()
	{
		loadEvent(<?php echo $_GET['idEvent']; ?>);
	});
</script>
</html>