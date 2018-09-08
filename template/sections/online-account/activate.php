<?php
/*
 * Copyright 2018 GPLv3, Zillexplorer by Mike Kilday: http://DragonFrugal.com
 */


$reset_result = array();
		
if ( $_GET['key'] != '' && !$_POST['submit_pass_change'] ) {
		
		// Login if user / pass match
		$query = "SELECT * FROM users WHERE reset_key = '".$_GET['key']."'";
		
		if ($result = mysqli_query($db_connect, $query)) {
		
			
		   while ( $row = mysqli_fetch_array($result) ) {
				
				if ( $row["activated"] == 'no' ) {
				
				$query = "UPDATE users SET activated = 'yes' WHERE reset_key = '".$_GET['key']."'";
				$sql_result = mysqli_query($db_connect, $query);
				
					if ( $sql_result == true ) {
					$reset_result['success'][] = "Your account is now confirmed, <a href='/online-account/login/' class='green-underline'>logging in</a> or <a href='/online-account/reset/' class='green-underline'>resetting your password</a> is now enabled (if you just attempted to reset your password and are seeing this, it's because you never confirmed your account until now...you may now reset your password).";
		
				   // Generate new reset key
					$reset_key = md5(time().rand(9999999,9999999999));
					$query = "UPDATE users SET reset_key = '".$reset_key."' WHERE reset_key = '".$_GET['key']."'";
					mysqli_query($db_connect, $query);
					}
				
				}
				elseif ( $row["activated"] == 'yes' ) {
					
				$valid_reset = 1;
				
				}
				else {
				$reset_result['error'][] = "No matching activation key found.";
				}
			
		   
			
		   }
		   
		   
			if ( $result->num_rows < 1 ) {
			$reset_result['error'][] = "No matching activation key found.";
			}
	
		mysqli_free_result($result);
		}
		

	
}

if ( $_POST['submit_pass_change'] ) {

	// Run checks...
	
	if ( $securimage->check( $_POST['captcha_code'] ) == false )	{
	$reset_result['error'][] = "Captcha code was not correct.";
	}
	
	////////////////
	
	
	if ( strlen( $_POST['password'] ) < 12 || strlen( $_POST['password'] ) > 40 ) {
		
	$reset_result['error'][] = "Password must be between 12 and 40 characters long. Please choose a different password.";
		
	}
	
	////////////////
	
	// See if key matches, and account already activated
	$query = "SELECT * FROM users WHERE reset_key = '".$_POST['key']."'";
	
	if ($result = mysqli_query($db_connect, $query)) {
	   while ( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ) {
	   	
	   	if ( $row["activated"] == 'yes' ) {
			$valid_reset = 1;
			}
			else {
			$reset_result['error'][] = "Reset key not valid.";
			}
			
	   }
	mysqli_free_result($result);
	}
				

	// Checks cleared, update DB ////////
	if ( sizeof($reset_result['error']) < 1 && $valid_reset ) {

	$query = "UPDATE users SET password = '".md5($_POST['password'])."' WHERE reset_key = '".$_POST['key']."'";
	$sql_result = mysqli_query($db_connect, $query);
		
		if ( $sql_result == true ) {
		$reset_result['success'][] = "Your password has been updated, you can now <a href='/online-account/login/' class='green-underline'>login with your new password</a>.";
		
	   // Generate new reset key
		$reset_key = md5(time().rand(9999999,9999999999));
		$query = "UPDATE users SET reset_key = '".$reset_key."' WHERE reset_key = '".$_POST['key']."'";
		mysqli_query($db_connect, $query);
		}
				
	
	}


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

<?php

if ( !$_POST['submit_pass_change'] && $valid_reset || sizeof($reset_result['error']) > 0 && $valid_reset ) {
?>

								
				<form action='' method ='post' onsubmit='return check_pass("pass_alert", "password", "password2", this.value);'>
				
				<p><b>Create New Password:</b> <input type='password' id='password' name='password' value='' onblur='check_pass("pass_alert", "password", "password2", this.value);' /></p>
				
				<p><b>Repeat Password:</b> <input type='password' id='password2' name='password2' value='' onblur='check_pass("pass_alert", "password", "password2", this.value);' /></p>
				
				
				  <div>
				    <?php
					// Captcha
				      $options = array();
				      $options['input_name'] = 'captcha_code'; // change name of input element for form post
				      $options['disable_flash_fallback'] = false; // allow flash fallback
				
				      if (!empty($_SESSION['ctform']['captcha_error'])) {
					// error html to show in captcha output
					$options['error_html'] = $_SESSION['ctform']['captcha_error'];
				      }
				
				      echo "<div id='captcha_container_1'>\n";
				      echo Securimage::getCaptchaHtml($options);
				      echo "\n</div>\n";
				
				    ?>
				  </div>
				  
				<p style='padding: 20px;'><input type='submit' value='Change Password' /></p>
				
				<input type='hidden' name='key' value='<?=$_GET['key']?>' />
				
				<input type='hidden' name='submit_pass_change' value='1' />
				
				</form>
				
				
<?php
}
?>				

    </div>
    

	<div style='font-weight: bold; color: red;' id='pass_alert'></div>

    
</div>