<?php
require_once('../libs/phpmailer/class.phpmailer.php');
define('GUSER', 'ltw.team65@gmail.com'); // GMail username
define('GPWD', 'inesmarianamiguel');

function sendMail($email,$subject,$body){

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
	$mail->Subject = $subject;
	$mail->Body = $body;
	$mail->AddAddress($email);
	if(!$mail->Send()) {
		//echo 'Mail error: '.$mail->ErrorInfo; 
		return false;
	} else {
		//echo 'Mensagem enviada!';
		return true;
	}
	
}
?>