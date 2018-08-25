<?php
/*
 * Copyright 2018 GPLv3, Zillexplorer by Mike Kilday: http://DragonFrugal.com
 */
?>
LOGIN
<?php

if ( $login_success ) {
	
	// User login data stored to session
	$query = "SELECT * FROM users WHERE username = '".trim($_POST['username'])."'";
	
	if ($result = mysqli_query($db_connect, $query)) {
		
	   while ( $row = mysqli_fetch_array($result) ) {
			
		$_SESSION['user'] = $row;
	   //echo $row["username"]." ".$row["email"]."<br />";
	   
	   }
	
	mysqli_free_result($result);
	}
	$query = NULL;

}

?>