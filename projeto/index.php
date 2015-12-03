<?php require_once('templates/header.php'); ?>
<body>
<!-- IF USER IS LOGGED IN
		SHOW CREATE EVENT ANCHOR -->
	<a href="create-event.php" class="create_event">Create Event</a>

	<section id="events"></section>

	<!-- Hidden div containing the templates -->
	<div id="hidden" style="display: none;">
		<!-- Template for Event -->
		<div class="event">
			<a href="" class="event_more"><img class="event_img" src=""></a>
			<p><span class="event_name"></span></p>
			<p><span class="event_date_time"></span></p>
			<p><span class="event_address"></span></p>
			<a href="" class="event_more">View more</a>
		</div>
	</div>

</body>
<script type="text/javascript">
	$(document).ready(function()
	{
		loadEvents();

	});
</script>
</html>
