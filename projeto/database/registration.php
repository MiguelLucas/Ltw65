<?php
require_once('../templates/head.php')
require_once('connection.php');
require_once('user.php');
require_once('../libs/phpmailer/class.phpmailer.php');

function createUser() {
	global $db;

	if(isset($_POST['register'])){
		$first_name = $_POST['firstName'];
		$last_name = $_POST['lastName'];
		$birth_day = $_POST['day'];
		$birth_month = $_POST['month'];
		$birth_year = $_POST['year'];
		$birth_date = $birth_year . "-" . $birth_month . "-" . $birth_day;
		$email = $_POST['email'];
		$password = $_POST['password'];
		
		if(isRegisted($email)){
			echo "<script>swal('Error!', 'The user already exists!', 'error');</script>";
			header("location:../signup.php?action=no");
			return false;
		}
		
		$password_hashed = sha1($password);
		
		$query = "INSERT INTO User (firstName, lastName, birthDate, email, password ) 
		VALUES ( '$first_name', '$last_name', '$birth_date', '$email', '$password_hashed')";
			
		$stmt = $db->prepare($query);
		$result = $stmt->execute();  
		
		if ($result){
			if (sendMail($first_name,$last_name,$email)){
				echo "<script>swal('Congratulations!', 'You have been successfully registered.', 'success');</script>";
				header("location:../index.php?action=yes");
			} else {
				echo "<script>swal('There was an error sending you an email.', 'But you are already registed!');</script>";
				header("location:../index.php?action=yes");
			}
				
        } else {
			//houve algum erro
            header("location:../signup.php.html?action=no");
        }
	} else if (isset($_POST['canceled'])){
		header("location:../index.php?action=no");
	}
}


define('GUSER', 'ltw.team65@gmail.com'); // GMail username
define('GPWD', 'inesmarianamiguel');

function sendMail($first_name,$last_name,$email){
	$mail = new PHPMailer();
	$mail->CharSet = 'UTF-8';	//UTF-8 necessary for accented characters like 'António'
	$mail->IsSMTP();		// Activate SMTP
	$mail->SMTPDebug = 0;		// debugging: 1 = errors and messages, 2 = only messages
	$mail->SMTPAuth = true;		// authentication activated
	$mail->SMTPSecure = 'ssl';	// SSL required by Gmail
	$mail->Host = 'smtp.gmail.com';	// SMTP used
	$mail->Port = 465;  		// Port 465 must be opened for SSL
	$mail->Username = GUSER;
	$mail->Password = GPWD;
	$mail->From = 'ltw.team65@gmail.com';
	$mail->FromName = 'LTW - Team 65';
	$mail->Subject = 'Congratulations on registering!';
	$mail->Body = 'Hello ' . $first_name . ' ' . $last_name . '!' . "\r\n" . "\r\n" . 'You have just registered on the most beautiful event management website in the world :)';
	$mail->AddAddress($email);
	if(!$mail->Send()) {
		echo 'Mail error: '.$mail->ErrorInfo; 
		return false;
	} else {
		echo 'Mensagem enviada!';
		return true;
	}
	
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	createUser();
}

?>
</body>
</html>
