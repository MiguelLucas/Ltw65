<?php
session_start();
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
        header("location:../index.php?action=no");
        return false;
    }
     $_SESSION['emailUser'] = $emailUser;
    
	if( isset($_SESSION['emailUser']) ){
		header("location:../user_page.php?action=yes");
	}

		
    return true;
}



function CheckLoginInDB($emailUser, $password) {
	global $db;

	$password_hashed = sha1($password);

	$query = "SELECT * FROM User WHERE email='$emailUser' and password = '$password_hashed'";
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


switch ( $_GET['action'] ) {
	case "logout":
		session_destroy();
		header("location:../index.php");
	break;
	case "no":
		echo '<h2>You <strong>NOT</strong> loged in.</h2>';
	break;
	case "yes":
		if(!isset($_SESSION['username'])){
			header("location:../index.php");
		}
		echo '<h2>You <strong>ARE</strong> loged in.</h2>';
	break;
	case "check":
		$username=$_POST['username'];
		$password=$_POST['password'];
		
		$clean_username = strip_tags(stripslashes(mysql_real_escape_string($username)));
		$clean_password = sha1(strip_tags(stripslashes(mysql_real_escape_string($password))));
		
		$sql="SELECT * FROM members WHERE username='$clean_username' and password='$clean_password'";
		$rs = mysql_query($sql) or die ("Query failed");
		
		$numofrows = mysql_num_rows($rs);
		
		if($numofrows==1){
			session_register("username");
			header("location:../index.php?action=yes");
		}
		else {
			header("location:../index.php?action=no");
		}
	default:
		if(isset($_SESSION['username'])){
			header("location:../index.php?action=yes");
		}
	break;
}



?>