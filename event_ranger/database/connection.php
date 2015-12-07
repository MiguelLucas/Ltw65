<?php
	try {
		$path = "";
		if(isset($PATH_OVERRIDE))
			$path = $PATH_OVERRIDE;
		
	    $db = new PDO('sqlite:' . $path . 'ltw.db');
	    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 
	    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $e) {
	    die($e->getMessage());
  }
  
 
?>