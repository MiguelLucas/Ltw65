<?php

	session_start();
	if(!isset($_SESSION["emailUser"])){
	header( "Location: index.php" );
	}

	require_once('templates/head.php');
	require_once('database/user.php');

	list ($idUser, $emailUser, $firstName, $lastName, $birthDate, $age) = getUserInfo();
	
	$photoURL = getUserPhoto();
  
?>

<body>

<aside id="userAside">
	
	<section id="userInfo">
		
		<div id="userphoto">
			<img src="<?php echo $photoURL; ?>" alt="User profile image" height="128" width="128">
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
			<li><a href="#myEvents" class="sel">My Events</a></li>
			<li><a href="#attendingEvents">Attending Events</a></li>
			<li><a href="#myInvites">My Invites</a></li>
		</ul>
	</nav>
	
</aside>

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

<content id= "userContent">
	<section id="myEvents">
	</section>
	  
	<section id="attendingEvents" class="hidden">
		<p>Most recent actions:</p>
	</section>
	  
	<section id="myInvites" class="hidden">
		<p>Friends list:</p>
	</section>
</content>
<script type="text/javascript">
	$(document).ready(function()
	{
		loadEventsCreatedByUser(<?php echo $idUser ?>);
		loadAttendingEventsByUser(<?php echo $idUser ?>);

	});
	$(function(){
		$('#userMenu ul li a').on('click', function(e){
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

</body>
</html>