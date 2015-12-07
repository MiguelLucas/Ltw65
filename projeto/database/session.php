<?php
session_start();
require_once('connection.php');

function loginUser(){
	
    if(empty($_POST['email'])){
		header("location:../index.php?action=fail");
		return false;
	}
        

    if(empty($_POST['password'])){
		header("location:../index.php?action=fail");
		return false;
	}
        
	global $db;
     
	$emailUser = $_POST['email'];
	$password = $_POST['password'];
	
	$password_hashed = sha1($password);

	$query = "SELECT idUser FROM User WHERE email='$emailUser' and password = '$password_hashed'";
	$stmt = $db->prepare($query);
	$stmt->execute();  
	$result = $stmt->fetchAll();
	
	$numRows = count ($result);
	if ( $numRows != 1){
		header("location:../index.php?action=fail");
        return false;

	}

	
    $idUser = $result[0]["idUser"];
    $_SESSION["idUser"] = $idUser;
    
	if( isset($_SESSION['idUser']) ){
		header("location:../user_page.php?action=yes");
	}

		
    return true;	
}



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	loginUser();
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

	if (!array_key_exists("action", $_GET)) {
		echo "An error has occurred";
	} else {
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
	}
}


?>