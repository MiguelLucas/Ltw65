<?php 

	session_start();
	
	$PATH_OVERRIDE = 'database/';
	require_once('templates/head.php');
	require_once('database/user.php');
	require_once('database/eventsUser.php');
	
	if(!isset($_SESSION["idUser"])){
		$idUser = 0;
		$emailUser = 0;
	}
	else
		list ($idUser, $emailUser) = getUserInfo();
	if(!hasAccess($_GET['idEvent'], $idUser)){
		header( "Location: index.php" );
	}
		
	

?>

<div id="wrapper_main">
<section id="event"></section>
<aside>
	<?php
		//User is not creator
		if($idUser != 0 && !userIsCreator($_GET['idEvent'], $idUser)){  
			if(!userIsRegistered($_GET['idEvent'], $idUser))
				echo '<button class="registration" type="button">Attend Event</button>';
			else echo '<button class="registration going" type="button">Cancel Registration</button>';
		}
		//User is creator
		if(userIsCreator($_GET['idEvent'], $idUser) || eventIsPublic($_GET['idEvent'])){
			echo '<button class="invite" type="button">Invite</button>';
			
		}
		
	?>
	
</aside>
<section id="comments">
	<h2>Comments</h2>
	<?php
		//if there isn't a user logged in, don't let him comment
		if ($idUser != 0){
			echo "<form>
					<input id='comment_content' type='textarea' name='content' placeholder='Write a comment...'>
					<button class='postComment' type='button'>Post Comment</button>
				</form>
				";
		}
	?>
	<ul id='main_comment'>
			
	</ul>
</section>
</div>
<!-- Hidden div containing the templates -->
<div id="hidden" style="display: none;">

	<!-- Template to list users attending event -->
	<li class="userInEvent"></li>
	
	<!-- Template for Event -->
	<article class="event">
	<header>
		<?php 
		if($idUser != 0 && userIsCreator($_GET['idEvent'], $idUser)){
			echo '<button class="edit_event">Edit</button>';
		}
		?>
		
		<h1 class="event_name"></h1>
		<p><span class="event_date_time"></span></p>
		<p><span class="event_address"></span></p>
	</header>
		<div id="eventphoto">
			<img class = 'EventImage' src="" alt="Event image">
			<div class = 'changePhoto' style="display: none;"> Change Photo </div>
		</div>
		
		
		<p><span class="event_type"></span></p>
		<p><span class="event_privacy"></span> hosted by <span class="event_owner"></span>.</p>
		<p><span class="event_desc"></span></p>
		<ul class="attendingUsers">
			</span> Attending Users <span class="attending_users">
		</ul>
	</article>

	<!-- Template for Comments -->
	<li class="comment_item">
		<header>
			<span class="author"></span>
			<span class="publish_date"></span>
		</header>
		<p class="comment_text"></p>
		
		<ul class="nested_comment">
		<?php
			if ($idUser != 0){
				echo "<form class='nested_form' style='display: none;'>
					<input class='childCommentContent' type='textarea' placeholder='Write a comment...'>
					<button class='postChildComment' type='button'>Post Comment</button>
				</form>
				";
			}
		?>
		</ul>
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
			<a class="cancel" href="">Cancel</a>
			<button class="save_button" type="button">Save</button>
		</form>
		<button class="delete_event">Delete</button>
	</div>

	<!-- Form for Event's photo edit -->
	<form method="post" id="fileUpload" name="fileUpload"  >
		<input  class="uploadPhoto" type="file" name="file" required />
	</form>
</div>

</body>

<script type="text/javascript">
	$(document).ready(function()
	{
		loadEvent(<?php echo $_GET['idEvent']; ?>);
		
		
			var creator = false;
			<?php if($idUser != 0 && userIsCreator($_GET['idEvent'], $idUser)){?>
				creator = true;
			<?php }?>
		

		
		if(creator == true){
			document.getElementById("fileUpload").onchange = function() {
				$('#fileUpload').submit(submitForm('Event',<?php echo $_GET['idEvent']; ?>));

			};
			
			$('img.EventImage').mouseover(function(){
				 $( this ).animate({
					opacity: 0.4,
					borderWidth: "10px"
				} );
				$('.changePhoto').show();
			});
			$('img.EventImage').mouseout(function(){
				 $( this ).animate({
					opacity: 1,
					borderWidth: "10px"
				} );
				$('.changePhoto').hide();
			});
			
			$('img.EventImage').click(function(){
				$('.uploadPhoto').click();

			});
		}
		
	
		
		//edit event
		$('button.edit_event').click(function(){
			fillEditEventForm();
		});
		console.log('<?php echo $emailUser; ?>');
		//send invite
		$('button.invite').click(function(){
			if ('<?php echo $emailUser ?>' != 0 ){
				var emailUser = '<?php echo $emailUser; ?>';
				sendInviteDialog('<?php echo $idUser; ?>', emailUser , <?php echo $_GET['idEvent']; ?>);
				//sendTeste();
			}
			
  		});
		
		$('button.registration').click(function(){
			if($(this).hasClass('going')){
				cancelUserEventRegistration(<?php echo $_GET['idEvent']; ?>, <?php echo $idUser; ?>);
				$(this).removeClass('going');
				$(this).text('Attend Event');
				//window.location.reload();
			}
			else{
				registerUserEvent(<?php echo $_GET['idEvent']; ?>, <?php echo $idUser; ?>);
				$(this).addClass('going');
				$(this).text('Cancel Registration');
				//window.location.reload();
			}
	
		});
		
		
		// Loads comments from this event	
		loadCommentsWithCallback(<?php echo $_GET['idEvent']; ?>, <?php echo $idUser ?>);	
		// When posting a root comment, input is validated, comment is created, and the comment section is emptied and reloaded
		$('.postComment').click(function() {
			if (validateInput($('input[name="content"]').val()))
				createComment(<?php echo $idUser ?> , <?php echo $_GET['idEvent']; ?>,0, function()
					{
						$('#main_comment').empty();
						$('#comment_content').val('');

						loadCommentsWithCallback(<?php echo $_GET['idEvent']; ?>, <?php echo $idUser ?>);
					});
  		});
		// When posting a child comment, input is validated, comment is created, and the comment section is emptied and reloaded
		$('.postChildComment').click(function() {
			if (validateInput($('input[id="' + this.id + '"]').val()))
				createComment(<?php echo $idUser ?> , <?php echo $_GET['idEvent']; ?>, this.id, function()
					{
						$('#main_comment').empty();
						$('#comment_content').val('');

						loadCommentsWithCallback(<?php echo $_GET['idEvent']; ?>, <?php echo $idUser ?>);
					});
  		});
		
		
		
	});
</script>
</html>