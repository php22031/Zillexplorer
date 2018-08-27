<?php
/*
 * Copyright 2018 GPLv3, Zillexplorer by Mike Kilday: http://DragonFrugal.com
 */


$reset_result = array('');
		
if ( $_GET['key'] != '' ) {
	
		
		// Login if user / pass match
		$query = "SELECT * FROM users WHERE reset_key = '".trim($_GET['key'])."'";
		
		if ($result = mysqli_query($db_connect, $query)) {
			
		   while ( $row = mysqli_fetch_array($result) ) {
				
				if ( $row["activated"] == 'no' ) {
				
				$query = "UPDATE users SET activated = 'yes' WHERE reset_key = '".trim($_GET['key'])."'";
				$sql_result = mysqli_query($db_connect, $query);
				
					if ( $sql_result == true ) {
					$reset_result['success'][] = "Your account has been activated, you can now <a href='/online-account/login/' class='green-underline'>login</a>.";
					}
				
				}
				elseif ( $row["activated"] == 'yes' ) {
					
					
				// Reset password logic here
				
				
				}
				else {
				$reset_result['error'][] = "No matching activation key found. Try <a href='/online-account/reset/' class='red-underline'>resetting your password</a>.";
				}
			
		   //echo $row["username"]." ".$row["email"]."<br />";
		   
		   }
		   
		   
		   
		   
		   
			if ( $result->num_rows < 1 ) {
			$reset_result['error'][] = "No matching activation key found. Try <a href='/online-account/reset/' class='red-underline'>resetting your password</a>.";
			}
	
		mysqli_free_result($result);
		}
		$query = NULL;

	
}
?>

<div style="text-align: center;">

<h3>Activate / Reset Account</h3>


	<div style='font-weight: bold;' id='login_alert'>
<?php
	foreach ( $reset_result['error'] as $error ) {
	echo "<p><b style='color: red;'> $error </b></p>";
	}
	
	foreach ( $reset_result['success'] as $success ) {
	echo "<p><b style='color: green;'> $success </b></p>";
	}
?>
	</div>


    <div style="display: inline-block; text-align: right; width: 350px;">


    </div>
</div>