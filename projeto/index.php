<?php

	session_start();
	

	require_once('templates/head.php'); 
  
?>

<div id="wrapper_main">
<!-- IF USER IS LOGGED IN
		SHOW CREATE EVENT ANCHOR -->
	<a href="create-event.php" class="create_event">Create Event</a>
	<section id="search">
		<input type='text' name='searchEvent' id='searchEventText' maxlength="50" style='display: block' />
		<img src="img/index/searchIcon.png" id="searchImg">
		<label for='searchEventByDateBegin' class='labels' style='display: none'>Initial date: </label>
		<input type='date' id='searchEventByDateBegin' style='display: none' value="<?php echo date("Y-m-d");?>" />
		<label for='searchEventByDateEnd' class='labels' style='display: none'>Final date: </label>
		<input type='date' id='searchEventByDateEnd' style='display: none' value="<?php echo date("Y-m-d",strtotime("+ 1 day"));?>" />
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
		loadPublicEvents();
		
		$('.beginSearch').click(function() {
			if ($('#searchType').val() == 'date'){
				searchEvents($('#searchEventByDateBegin').val(),$('#searchEventByDateEnd').val(),$('#searchType').val());
			} else{
				searchEvents($('input[name="searchEvent"]').val(),0,$('#searchType').val());
			}
		})
		$('#searchType').on('change',function(){
			if ($(this).val() == 'date'){
				$('#searchEventText').attr('style','display: none');
				$('#searchEventByDateBegin').attr('style','display: block');
				$('#searchEventByDateEnd').attr('style','display: block');
				$('#searchImg').attr('style','display: none');
				$('.labels').attr('style','display: block');
			} else {
				$('#searchEventText').attr('style','display: block');
				$('#searchEventByDateBegin').attr('style','display: none');
				$('#searchEventByDateEnd').attr('style','display: none');
				$('#searchImg').attr('style','display: block');
				$('.labels').attr('style','display: none');
			}
			
		})

	});
</script>
</html>
