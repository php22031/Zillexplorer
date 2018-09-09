<?php
/*
 * Copyright 2018 GPLv3, Zillexplorer by Mike Kilday: http://DragonFrugal.com
 */
 
//print_r($_SESSION['user']); // DEBUGGING

if ( $_SESSION['user']['id'] ) {
?>

<h3>Account Alerts</h3>


<?php

	$query = "SELECT * FROM user_addresses ORDER BY address WHERE user_id = '".$_SESSION['user']['id']."'";
	
	if ($result = @mysqli_query($db_connect, $query)) {
		
	   while ( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ) {
			
		echo $row["address"]." ".$row["alerts"]."<br />";
	   
	   }
	
	mysqli_free_result($result);
	}
	
	if ( $result->num_rows < 1 ) {
	echo 'No address alerts created yet.';
	}
	
	

?>




<?php
}
?>