<?php

	session_start();
	if(!isset($_SESSION["idUser"])){
		header( "Location: index.php" );
	}

	$PATH_OVERRIDE = 'database/';
	require_once('templates/head.php');
	require_once('database/password.php');
	require_once('database/user.php');

	list ($idUser, $emailUser, $firstName, $lastName, $birthDate) = getUserInfo();


?>

<div id="wrapper_main">
    <section id="userProfile">
			<div class="profileinfo">
				<h2>Edit your Profile</h2>
				
				<div class="gear">
					<label>E-Mail:</label>
					<span id="email" class="datainfo"><?php echo $emailUser ?></span>
					<a href="#" class="editlink">Edit Info</a>
					<a class="savebtn">Save</a>
				</div>
				
				<div class="gear">
					<label>First Name:</label>
					<span id="firstName" class="datainfo"><?php echo $firstName ?></span>
					<a href="#" class="editlink">Edit Info</a>
					<a class="savebtn">Save</a>
				</div>

				<div class="gear">
					<label>Last Name:</label>
					<span id="lastName" class="datainfo"><?php echo $lastName ?></span>
					<a href="#" class="editlink">Edit Info</a>
					<a class="savebtn">Save</a>
				</div>
				
				<div class="gear">
					<label>Birthday:</label>
					<span id="date" class="datainfo"><?php echo $birthDate ?></span>
					<a href="#" class="editdatelink">Edit Info</a>
					<a class="datesavebtn">Save</a>
				</div>
				
				<div class="gear">
					<label>Password:</label>
					<span id="password" class="datainfo"></span>
					<a href="#" class="editlink">Edit Info</a>
					<a class="savebtn">Save</a>
				</div>
				
			</div>
		</section>
		</div>
  </body>
  <script>
	  $(document).ready(function(){
		  <?php if (isset($_GET['action'])) {?>
			if ('<?php echo $_GET['action']; ?>' == 'yes') {
				 swal("Your password was successfully edited", ":)", "success");
			}
			if ('<?php echo $_GET['action']; ?>' == 'no') {
				 swal("The passwords didn't match!", "Please try again", "error");
			}
		  <?php } ?>
		  
		$(".editlink").on("click", function(e){
		  e.preventDefault();
			var dataset = $(this).prev(".datainfo");
			var savebtn = $(this).next(".savebtn");
			var theid   = dataset.attr("id");
			var newid   = theid+"-form";
			var currval = dataset.text();
			
			dataset.empty();
			if (theid == 'password'){
				var form = $('<form id="get_password" action="database/password.php" method="POST">').appendTo(dataset);
				$('<label id="currentPasswordLabel"> Current Password: </label>').appendTo(form);
				$('<input type="password" name="currentPassword" id="currentPassword" class="hlite">').appendTo(form);
				$('<label id="newPasswordLabel"> New Password: </label>').appendTo(form);
				$('<input type="password" name="newPassword" id="newPassword" class="hlite">').appendTo(form);
				$('<input type="text" name="emailUser" id="emailUser" style="display: none">').appendTo(form);
			} else {
				$('<input type="text" name="'+newid+'" id="'+newid+'" value="'+currval+'" class="hlite">').appendTo(dataset);
			}
			
			$(this).css("display", "none");
			savebtn.css("display", "block");
		});
		$(".savebtn").on("click", function(e){
			e.preventDefault();
			var elink   = $(this).prev(".editlink");
			var dataset = elink.prev(".datainfo");
			
			var child 	= dataset.children();
			var newDataType   = dataset.attr("id");
			var newval;
			if (newDataType == 'password'){
				newval = $('#newPassword').val();
				if (newval && newval != ""){
					if (detectPassword(newval)){
						var curPassword = $('#currentPassword').val();
						$('#emailUser').val('<?php echo $emailUser ?>');
						$('#get_password').submit();
						return true;
					}
					else
						return false;
				}
				else{
					swal("Watch out!", "The input field is empty!", "error");
					return false;
				}
					
			} else {
				newval = child.val();
			}
			
			if (newval && newval != ""){
				if (newDataType == 'firstName' || newDataType == 'lastName'){
					if(!detectNames(newval)){
						return false;
					}
				}
				if (newDataType == 'email'){
					if(!detectEmail(newval)){
						return false;
					}
				}
			} else {
				swal("Watch out!", "The input field is empty!", "error");
				return false;
			}
				
			
			//id,firstname,lastname,email,date,password
			if (newDataType == 'email'){
				editUser(<?php echo $idUser ?>,"","",newval,"","");
			}
			if (newDataType == 'firstName')
				editUser(<?php echo $idUser ?>,newval,"","","","");
			if (newDataType == 'lastName')
				editUser(<?php echo $idUser ?>,"",newval,"","","");
			
			
			$(this).css("display", "none");
			child.remove();
			if (newDataType != 'password')
				dataset.html(newval);
			
			elink.css("display", "block");
		});
		
		//edição datas
		$(".editdatelink").on("click", function(e){
		  e.preventDefault();
			var dataset = $(this).prev(".datainfo");
			var savebtn = $(this).next(".datesavebtn");
			var theid   = dataset.attr("id");
			var newid   = theid+"-form";
			var currval = dataset.text();
			
			dataset.empty();
			
			$('<input type="date" name="'+newid+'" id="'+newid+'" value="'+currval+'" class="hlite">').appendTo(dataset);
			
			$(this).css("display", "none");
			savebtn.css("display", "block");
		});
		
		$(".datesavebtn").on("click", function(e){
			e.preventDefault();
			var elink   = $(this).prev(".editdatelink");
			var dataset = elink.prev(".datainfo");
			
			var child 	= dataset.children();
			var newval 	= child.val();
			var newDataType   = dataset.attr("id");
			
			if (newval && newval != ""){
				if (newDataType == 'date'){
					if(!moment(newval).isValid()){
						swal("Hum...", "Are you sure that is your birthdate?", "error");
						return false;
					}
				}
			}
			else 
				return false;
			
			editUser(<?php echo $idUser ?>,"","","",newval,"");
			
			$(this).css("display", "none");
			child.remove();
			dataset.html(newval);
			
			elink.css("display", "block");
		});
	});
  </script>
</html>
