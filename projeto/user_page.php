<?php

	session_start();
	if(!isset($_SESSION["emailUser"])){
		header( "Location: index.php" );
	}

	$PATH_OVERRIDE = 'database/';
	require_once('templates/head.php');
	require_once ('database/user.php');
	
	list ($idUser, $emailUser, $firstName, $lastName, $birthDate, $age) = getUserInfo();
	
	$photoURL = getUserPhoto();
  
?>

<body>
<div id="wrapper_main">

<aside id="userAside">
	
	<section id="userInfo">
		
		<div id="userphoto">
			<img class = 'UserImage' src="<?php echo $photoURL; ?>" alt="User profile image">
			<div class = 'changePhoto' style="display: none;"> Change Photo </div>
		</div>

		<div id="name">
			<p> <?php echo $firstName . ' ' . $lastName; ?></p>
		</div>
		
		<div id="age">
			<p> <?php echo $birthDate; ?> </p>
		</div>


		<form method="get" action="./edit_profile.php">
			<button type="submit">Edit Profile</button>
		</form>
		
	</section>
	
	<nav id="userMenu">
		<ul>
			<li class = 'userPagetab'><a href="#myEvents" class="sel">My Events</a></li>
			<li class = 'userPagetab'><a href="#attendingEvents">Attending Events</a></li>
			<li class = 'userPagetab'><a href="#myInvites">My Invites</a></li>
			<li><a href="create-event.php" class="create_event">Create Event</a></li>
		</ul>
	</nav>
	
</aside>

<!-- Hidden div containing the templates -->
<div id="hidden" style="display: none;">
	<!-- Template for Event -->
	<div class="event">
		<a href="" class="event_more"><img class="EventImage" src=""></a>
		<p><span class="event_name"></span></p>
		<p><span class="event_date_time"></span></p>
		<p><span class="event_address"></span></p>
		<a href="" class="event_more">View more</a>
	</div>
	
	<!-- Form for Upload photos -->

	<form method="post" id="fileUpload" name="fileUpload"  >
		<input  class="uploadPhoto" type="file" name="file" required />
	</form>
	
</div>

<content id= "userContent">
	<section id="myEvents">
		<h3>My Events</h3>
	</section>
	  
	<section id="attendingEvents" class="hidden">
		<h3>Attending Events</h3>
	</section>
	  
	<section id="myInvites" class="hidden">
		<h3>My Invites</h3>
	</section>
</content>

<script type="text/javascript">
	$(document).ready(function()
	{
		document.getElementById("fileUpload").onchange = function() {
			$('#fileUpload').submit(submitForm('User',<?php echo $idUser; ?>));

		};
				
		
		loadEventsCreatedByUser(<?php echo $idUser ?>);
		loadAttendingEventsByUser(<?php echo $idUser ?>);
		
		$('img.UserImage').mouseover(function(){
			 $( this ).animate({
				opacity: 0.4,
				borderWidth: "10px"
			} );
			$('.changePhoto').show();
		});
		$('img.UserImage').mouseout(function(){
			 $( this ).animate({
				opacity: 1,
				borderWidth: "10px"
			} );
			$('.changePhoto').hide();
		});
		
		$('img.UserImage').click(function(){
			$('.uploadPhoto').click();

		});

	});
	
	$(function(){
		$('#userMenu ul li.userPagetab a').on('click', function(e){
		e.preventDefault();
		var newcontent = $(this).attr('href');

		$('#userMenu ul li a').removeClass('sel');
		$(this).addClass('sel');

		$('#userContent section').each(function(){
		  if(!$(this).hasClass('hidden')) { $(this).addClass('hidden'); }
		});

		$(newcontent).removeClass('hidden');


		});
		
		
	});
	
</script>
</div>
</body>
</html>
