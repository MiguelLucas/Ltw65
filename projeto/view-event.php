<?php 

session_start();
require_once('templates/head.php'); 

?>

<div id="wrapper_main">
<section id="event"></section>
<section id="comments">
	<h2>Comments</h2>
	<ol>
		<form>
			<input class="parent_comment" type="hidden" name="parentComment" value="">
			<!-- CHANGE INPUT TO HIDDEN AFTER LOGIN -->
			<input class="user_id" type="text" name="idUser" value="">
			<input class="comment_content" type="text" name="content" value="" placeholder="Write a comment...">
		</form>
	</ol>
</section>
<aside>
	<button class="going" type="button">Go to event</button>
	<button class="invite" type="button">Invite</button>
	<button class="share" type="button">Share</button>
</aside>
</div>
<!-- Hidden div containing the templates -->
<div id="hidden" style="display: none;">
	<!-- Template for Event -->
	<article class="event">
	<header>
		<button class="edit_event">Edit</button>
		<h1 class="event_name"></h1>
		<p><span class="event_date_time"></span></p>
		<p><span class="event_address"></span></p>
	</header>
		<div>
			<img class="event_img" src="">
			<button class="change_photo" type="button">Change Photo</button>
		</div>
		<p><span class="event_type"></span></p>
		<p><span class="event_privacy"></span> hosted by <span class="event_owner"></span>.</p>
		<p><span class="event_desc"></span></p>
	</article>

	<!-- Template for Comments -->
	<li>
		<header>
			<span class="author"></span>
			<span class="publish_date"></span>
		</header>
		<p class="comment_text"></p>
	</li>

	<!-- Form for Event edit -->
	<div class="event_form">
		<form>
			<input class="event_id" type="hidden" name="idEvent" value="">
			<input class="user_id" type="hidden" name="idUser" value="">
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
		$('button.edit_event').click(function(){
			fillEditEventForm();
		});

	});
</script>
</html>