<?php

	session_start();
	if(!isset($_SESSION["emailUser"])){
		header( "Location: index.php" );
	}

	$PATH_OVERRIDE = 'database/';
	require_once('templates/head.php');
	require_once('database/user.php');

	list ($idUser, $emailUser, $firstName, $lastName, $birthDate) = getUserInfo();
?>
<div id="wrapper_main">
	<section id="core">
		<div class="profileinfo">
			<h2>Update your Profile Info &rarr;</h2>
			
			<div class="gear">
				<label>E-Mail:</label>
				<span id="email" class="datainfo"><?php echo $emailUser ?></span>
				<a href="#" class="editlink">Edit Info</a>
				<a class="savebtn">Save</a>
			</div>
			
			<div class="gear">
				<label>First Name:</label>
				<span id="firstname" class="datainfo"><?php echo $firstName ?></span>
				<a href="#" class="editlink">Edit Info</a>
				<a class="savebtn">Save</a>
			</div>

			<div class="gear">
				<label>Last Name:</label>
				<span id="lastname" class="datainfo"><?php echo $lastName ?></span>
				<a href="#" class="editlink">Edit Info</a>
				<a class="savebtn">Save</a>
			</div>
			
			<div class="gear">
				<label>Birthday:</label>
				<span id="birthday" class="datainfo"><?php echo $birthDate ?></span>
				<a href="#" class="editdateink">Edit Info</a>
				<a class="datesavebtn">Save</a>
			</div>
			
			<div class="gear">
				<label>City/Town:</label>
				<span id="citytown" class="datainfo">Los Angeles, CA</span>
				<a href="#" class="editlink">Edit Info</a>
				<a class="savebtn">Save</a>
			</div>
		</div>
	</section>
</div>
</body>
</html>
