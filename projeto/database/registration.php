<?php
require_once('../templates/head.php');
require_once('connection.php');
require_once('user.php');
require_once('../libs/phpmailer/class.phpmailer.php');

function is_leap_year($year)
{
	return ((($year % 4) == 0) && ((($year % 100) != 0) || (($year %400) == 0)));
}

function createUser() {
	global $db;

	if (isset($_POST['canceled'])){
		header("location:../index.php?action=no");
		return false;
	} else {
		if(isset($_POST['register'])){
		$first_name = $_POST['firstName'];
		$last_name = $_POST['lastName'];
		$birth_day = $_POST['day'];
		$birth_month = $_POST['month'];
		$birth_year = $_POST['year'];
		$birth_date = $birth_year . "-" . $birth_month . "-" . $birth_day;
		$email = $_POST['email'];
		$password = $_POST['password'];
		
		
		
		if (!validate_name($first_name)){
			header("location:../signup.php?action=no");
			return false;
		}
		if (!validate_name($last_name)){
			header("location:../signup.php?action=no");
			return false;
		}
		
		
		/*
		* verificação se já existe email na DB
		*/
		
		if(isRegisted($email)){
			header("location:../signup.php?action=email");
			return false;
		}
		
		/*
		* Verificação de data
		*/
		
		$birth_date = $birth_year . "-" . $birth_month . "-" . $birth_day;
		strtotime($birth_date);
		$today = date("Y-m-d");
		
		//verifica se data introduzida é superior à data de hoje
		if($birth_date > $today){
			header("location:../signup.php?action=no");
			return false;
		}
		
		//verifica se data introduzida está correta
		if (is_leap_year($birth_year)){
			if ($birth_month == 02){
				if ($birth_day > 29){
					header("location:../signup.php?action=no");
					return false;
				}
			}
		}else{
			if ($birth_month == 02){
				if ($birth_day > 28){
					header("location:../signup.php?action=no");
					return false;
				}
			}
		}
		if ($birth_month == 02 or $birth_month == 04 or $birth_month == 06 or $birth_month == 09 or $birth_month == 11){
			if ($birth_day > 30){
				header("location:../signup.php?action=no");
				return false;
			}
		}
		
		/*
		* Verificação de email
		*/
		
		if (!validate_email($email)){
			header("location:../signup.php?action=no");
			return false;
		}
		
		/*
		* Verificação de password
		*/
		
		if (!validate_password($password)){
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
				header("location:../index.php?action=yesemail");
			}
				
        } else {
			//houve algum erro
            header("location:../signup.php.html?action=no");
        }
	} 
	}
	
}

function validate_name($name){
	
	if (preg_match("([0-9]*)", $name)) {
		
	  return true;
	} else {
		var_dump($name);
		die;
		return false;
	}
}

function validate_email($email){
	if (preg_match("(\S+@\S+\.\S+)", $email)){
		return true;
	} else {
		var_dump($email);
		die;
		return false;
	}
}

function validate_password($password){
	if (strlen($password) < 6){
		return false;
	} else {
		if (preg_match("(\d)",$password)){
			if (preg_match('/[a-zA-Z]/',$password)) {
				return true;
			} 
		}
	}		
	return false;
		
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
