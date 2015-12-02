<!-- 
IF HTTP REFERRER NOT INDEX
	REDIRECT TO INDEX

IF USER NOT LOGGED IN	
	REDIRECT TO INDEX

 -->
<?php require_once('templates/header.php'); ?>
<section id="event">
	<!-- Form for Event creation -->
	<div class="event_form">
		<form>
			<input class="event_id" type="hidden" name="idEvent" value="">
			<!-- CHANGE INPUT TO HIDDEN AFTER LOGIN -->
			<input class="user_id" type="text" name="idUser" value="">
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

</body>
<script type="text/javascript">
	$(document).ready(function()
	{
		loadEventTypeOptions($('.event_type'));

		$('.save_button').click(function() {
    		verifyCreateEventData();
  		});
	});
</script>
</html>