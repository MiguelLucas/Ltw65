<?php
	session_start();
	if(isset($_SESSION["emailUser"]))
		header( "Location: index.php" );
	require_once('templates/head.php');
?>
<div id="wrapper_main">
	<form id="register" action="database/registration.php" method="post">
	<fieldset>
		<legend>Register</legend>
		<label for='firstName' >First Name: </label>
		<input type='text' name='firstName' id='firstName' maxlength="50" onchange='detectFirstName(this.value)' />
		<div id="firstNameErr" style="display: none"></div>
		<label for='lastName' >Last Name: </label>
		<input type='text' name='lastName' id='lastName' maxlength="50" onchange='detectLastName(this.value)' />
		<div id="lastNameErr" style="display: none"></div>
		<label for='email' >Email Address:</label>
		<input type='text' name='email' id='email' maxlength="50" onchange='detectEmail(this.value)' />
		<div id="emailErr" style="display: none"></div>
		<fieldset>
		<label for='birthDate' name='birthDate' id='birthDate'>Birth Date:</label>
		<select name="day" id="day">
			<option>Day</option>
			<script>listDays();</script>
		</select>
		<select name="month" id="month">
			<option>Month</option>
			<option value="01">January</option>
			<option value="02">February</option>
			<option value="03">March</option>
			<option value="04">April</option>
			<option value="05">May</option>
			<option value="06">June</option>
			<option value="07">July</option>
			<option value="08">August</option>
			<option value="09">September</option>
			<option value="10">October</option>
			<option value="11">November</option>
			<option value="12">December</option>
		</select>
		<select name="year" id="year">
			<option>Year</option>
			<script>listYears();</script>
		</select>
		</fieldset>
		<!--<input type='date' name='birthDate' id='birthDate' /> serve para selecionar a partir do calendario-->
		<label for='password' >Password:</label>
		<input type='password' name='password' id='password' maxlength="50" onchange='detectPassword(this.value)' />
		<div id="passwordErr" style="display: none"></div>
		<input type='submit' name='canceled' value='Cancel' />
		<input type='button' value='Register' onclick='validateNewUser(this.form,this.form.firstName.value,this.form.lastName.value,this.form.email.value,
		this.form.day.value,this.form.month.value,this.form.year.value,this.form.password.value)' />
		<input type='hidden' name='register' />
	</fieldset>
	</form>
</div>
</body>
<script>
	$(document).ready(function()
	{
		<?php if (isset($_GET['action'])) {?>
			if ( '<?php echo $_GET['action'] ?>' == 'no' ){
				swal("There has been an error while registering!","Please try again!","error");
			}
			if ( '<?php echo $_GET['action'] ?>' == 'email' ){
				swal("This email already exists!","Please try again with a different email.","error");
			}
		<?php }?>
	});
</script>
</html>
