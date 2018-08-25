<?php
/*
 * Copyright 2018 GPLv3, Zillexplorer by Mike Kilday: http://DragonFrugal.com
 */
?>
ACCOUNT SUMMARY
<?php

if ( $saved_addresses ) {
	
	$query = "SELECT * FROM user_addresses ORDER BY address WHERE user_id = '".$_SESSION['user']['id']."'";
	
	if ($result = mysqli_query($db_connect, $query)) {
		
	   while ( $row = mysqli_fetch_array($result) ) {
			
		echo $row["address"]." ".$row["alerts"]."<br />";
	   
	   }
	
	mysqli_free_result($result);
	}
	$query = NULL;

}

?>