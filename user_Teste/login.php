<?php

require_once('connection.php');


function loginUser()
{
    if(empty($_POST['email']))
    {
        $this->HandleError("Email is empty!");
        return false;
    }
     
    if(empty($_POST['password']))
    {
        $this->HandleError("Password is empty!");
        return false;
    }
     
	$emailUser = $_POST['email'];
	$password = $_POST['password'];
     
    if(!CheckLoginInDB($emailUser,$password))
    {
        return false;
    }
     $_SESSION['emailUser'] = $emailUser;
    
	if( isset($_SESSION['emailUser']) ){
		header("location:userPage.html?action=yes");
	}
		
    return true;
}



function CheckLoginInDB($emailUser, $password) {
	global $db;


	$query = "SELECT * FROM User WHERE email='$emailUser' and password = $password";

		
	$stmt = $db->prepare($query);
	$stmt->execute();  
	$result = $stmt->fetchAll();


	$numRows = count ($result);
	if ( $numRows == 1){
		return true;

	} else {
		return false;
	}
}



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	loginUser();
}



?>