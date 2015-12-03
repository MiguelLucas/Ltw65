<?php

	session_start();
	if(!isset($_SESSION["emailUser"])){
	header( "Location: index.php" );
	}

	require_once('templates/head.php'); 
  
?>

<body>

<aside id="userAside">

	<section id="userInfo">
		<div id="userphoto">
			<img src="images/user_image.png" alt="User profile image" height="128" width="128">
		</div>

		  <section id="bio">
			<p>Can't a guy call his mother pretty without it seeming strange? Amen. I think that's one of Mom's little fibs, you know, like I'll sacrifice anything for my children.</p>

			<p>She's always got to wedge herself in the middle of us so that she can control everything. Yeah. Mom's awesome. I run a pretty tight ship around here. With a pool table.</p>
		  </section>


		<form method="get" action="./edit_profile.php">
			<button type="submit">Edit Profile</button>
		</form>
		
	</section>

	<section id="selectEvents" class="hidden">

     </section>

</aside>

<section id="userEvents">

	<!-- Hidden div containing the templates -->
	<div id="hidden" style="display: none;">
		<!-- Template for Event -->
		<div class="event">
			<p><strong>Name: </strong><span class="event_name"></span></p>
			<p><span class="event_date"></span></p>
			<p><span class="event_desc"></span></p>
			<p><span class="event_type"></span></p>
			<img class="event_img" src="">
		</div>
	</div>
	
</section>
	
</body>
</html>
