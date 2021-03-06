<?php

	session_start();
	
	
	$PATH_OVERRIDE = 'database/';
	require_once('database/user.php');
	require_once('templates/head.php');
	
	if(!isset($_SESSION["idUser"]))
		$idUser = 0;
	else
		list ($idUser, $emailUser) = getUserInfo();
?>

<div id="wrapper_main">
<!-- IF USER IS LOGGED IN
		SHOW CREATE EVENT ANCHOR -->
	<?php 
		if($idUser != 0){
			echo '<a href="create-event.php" class="create_event">Create Event</a>';
		}
	?>
	
	<section id="search">
		<input type='text' name='searchEvent' id='searchEventText' maxlength="50" placeholder="Search Events..." />
		<label for='searchEventByDateBegin' class='labels hidden'>Initial date: </label>
		<input type='date' id='searchEventByDateBegin' class="hidden" value="<?php echo date("Y-m-d");?>" />
		<label for='searchEventByDateEnd' class='labels hidden'>Final date: </label>
		<input type='date' id='searchEventByDateEnd' class="hidden" value="<?php echo date("Y-m-d",time() + 86400);?>" />
		<select name="search" id="searchType" >
			<option value="name">Name</option>
			<option value="type">Type</option>
			<option value="city">City</option>
			<option value="date">Date</option>
		</select>
		<input type='button' value='Search' class='beginSearch' />
	</section>
	<section id="events"></section>

	<!-- Hidden div containing the templates -->
	<div id="hidden" style="display: none;">
		<!-- Template for Event -->
		<div class="event thumb">
			<div class="eventphoto"><a href="" class="event_more"><img class="EventImage" src=""></a></div>
			<h3><span class="event_name"></span></h3>
			<p><span class="event_date_time"></span></p>
			<p><span class="event_address"></span></p>
			<p><span class="event_type"></span></p>
			<a href="" class="event_more btn">View more</a>
		</div>
	</div>
</div>
</body>
<script type="text/javascript">
	$(document).ready(function()
	{
		<?php if (isset($_GET['action'])) {?>
			if ('<?php echo $_GET['action']; ?>' == 'yes') {
				//swal("Congratulations!", "You have changed your life by registering in the most beautiful website in the world :)", "success");
				swal("Congratulations!", "Ranger has let you register :)", "success");
			}
			if ('<?php echo $_GET['action']; ?>' == 'no') {
				//swal("Why would you cancel the registration?",":( :( :(");
				swal("You have canceled the registration.","You are not worthy of Ranger.");
			}
			if ('<?php echo $_GET['action']; ?>' == 'yesemail') {
				swal('Ranger was not able to send you an email.', 'But Ranger thinks you are worthy, and has let you register.','warning');
				//swal('There was an error sending you an email.', 'But you are already registed!','warning');
			}
			if ('<?php echo $_GET['action']; ?>' == 'fail') {
				swal("Unable to login. Do not fool Ranger.","Go see a doctor. You're having memory problems!", "error");
			}
		<?php }?>
		loadPublicEvents();

		$('#searchEventText').keypress(function(e){
			if(e.keyCode==13){
				$('.beginSearch').click();
				return true;
			}  
		});
		
		$('.beginSearch').click(function() {
			if ($('#searchType').val() == 'date'){
				searchEvents($('#searchEventByDateBegin').val(),$('#searchEventByDateEnd').val(),$('#searchType').val());
			} else{
				searchEvents($('input[name="searchEvent"]').val(),0,$('#searchType').val());
			}
		})
		$('#searchType').on('change',function(){
			if ($(this).val() == 'date'){
				$('#searchEventText').addClass('hidden');
				$('#searchEventByDateBegin').removeClass('hidden');
				$('#searchEventByDateEnd').removeClass('hidden');
				$('.labels').removeClass('hidden');
			} else {
				$('#searchEventText').removeClass('hidden');
				$('#searchEventByDateBegin').addClass('hidden');
				$('#searchEventByDateEnd').addClass('hidden');
				$('.labels').addClass('hidden');
			}
		})
	});
</script>
</html>
