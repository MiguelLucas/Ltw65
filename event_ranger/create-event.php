<?php 

	session_start();
	if(!isset($_SESSION["idUser"])){
		header( "Location: index.php" );
	}

	$PATH_OVERRIDE = 'database/';
	require_once('templates/head.php');
	require_once('database/user.php');
	
	list ($idUser) = getUserInfo();

?>
<div id="wrapper_main">
<section id="event">
	<!-- Form for Event creation -->
	<div class="event_form">
		<form>
			<input class="event_id" type="hidden" name="idEvent" value="">
			<input class="user_id" type="hidden" name="idUser" value="<?php echo $idUser ?>">
			<label>Name:
				<input class="event_name" type="text" name="name" value="" placeholder="Name your event" maxlength="150">
			</label>
			<div id="event_name_error" class="error_msg"></div>
			<label>Date:
				<input class="event_date" type="date" name="date" value="">
			</label>
			<div id="event_date_error" class="error_msg"></div>
			<label>Time:
				<input class="event_time" type="time" name="time" value="">
			</label>
			<label>Location:
				<input class="event_address" type="text" name="address" value="" placeholder="Where will the event take place?">
			</label>
			<div id="event_address_error" class="error_msg"></div>
			<label>Description:
				<textarea class="event_desc" name="description" value="" placeholder="Write a brief description of your event."></textarea>
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
			<button class="save_button" type="button">Create</button>
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
</div>
</body>
<script type="text/javascript">
	$(document).ready(function()
	{
		loadEventTypeOptions($('.event_type'));

		verifyEventData(createEvent);
	});
</script>
</html>