<?php

	session_start();
	

	require_once('templates/head.php'); 
  
?>

<div id="wrapper_main">
<!-- IF USER IS LOGGED IN
		SHOW CREATE EVENT ANCHOR -->
	<a href="create-event.php" class="create_event">Create Event</a>
	<section id="events"></section>

	<!-- Hidden div containing the templates -->
	<div id="hidden" style="display: none;">
		<!-- Template for Event -->
		<div class="event">
			<a href="" class="event_more"><img class="event_img" src=""></a>
			<h3><span class="event_name"></span></h3>
			<p><span class="event_date_time"></span></p>
			<p><span class="event_address"></span></p>
			<a href="" class="event_more">View more</a>
		</div>
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
