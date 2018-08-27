<?php
/*
 * Copyright 2018 GPLv3, Zillexplorer by Mike Kilday: http://DragonFrugal.com
 */


$register_result = array('');

if ( $_POST['submit_registration'] ) {

	// Run checks...
	
	if ( $securimage->check( trim($_POST['captcha_code']) ) == false )	{
	$register_result['error'][] = "Captcha code was not correct.";
	}
	
	//////////////

	$query = "SELECT * FROM users WHERE email = '".trim($_POST['email'])."'";
	
	if ($result = mysqli_query($db_connect, $query)) {
	   while ( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ) {
	   	
		$register_result['error'][] = "An account already exists with the email address '".trim($_POST['email'])."'. Please <a href='/online-account/reset/' class='red-underline'>reset your password</a>.";
		
		 //echo $row["email"]." ".$row["api_key"]."<br />";
		 
	   }
	mysqli_free_result($result);
	}
	$query = NULL;
	
	
	////////////////
	
	
	if ( strlen( trim($_POST['password']) ) < 12 || strlen( trim($_POST['password']) ) > 40 ) {
		
	$register_result['error'][] = "Password must be between 12 and 40 characters long. Please choose a different password.";
		
	}
	
	
	///////////////
	
	
	$email_check = validate_email( trim($_POST['email']) );
	if ( $email_check != 'valid' ) {
		
	$register_result['error'][] = $email_check;
	
	}


	// Checks cleared, add user to DB ////////
	if ( sizeof($register_result['error']) < 1 ) {
		
	$reset_key = md5(time().rand(9999999,9999999999));
	
	$query = "INSERT INTO users (id, reset_key, activated, email, password, api_key) VALUES ('', '".$reset_key."', 'no', '".trim($_POST['email'])."', 	'".md5( trim($_POST['password']) )."', '".md5(time().rand(9999999,9999999999))."')";
	
	
	$sql_result = mysqli_query($db_connect, $query);
	
	
		if ( $sql_result == true ) {
		$send_email = 1;
		}
	$query = NULL;
	
	//////////////////////////
	
		if ( $send_email ) {
		
		$message = "

Please confirm your recent new account creation for the email address ".trim($_POST['email']).". To activate your account, please visit this link below:
https://".$_SERVER['SERVER_NAME']."/activate-account/".$reset_key."

If you did NOT create this account, you can ignore this message, and the account WILL NOT BE ACTIVATED.

Thanks,
-".$_SERVER['SERVER_NAME']." Support <".$from_email.">

";
		
		// Mail activation link
		$mail_result = safe_mail( trim($_POST['email']), "Please Confirm To Activate Your Account", $message);
		
		
			if ( $mail_result == true ) {
			$register_result['success'][] = "An email has been sent to you for account activation. Please check your inbox (or spam folder and mark as 'not spam').";
			}
			elseif ( $mail_result['error'] != '' ) {
			$register_result['error'][] = "Email validation error: " . $mail_result['error'];
			}
		
		
		}
		else {
		$register_result['error'][] = "Sorry, an unknown error has occurred and you're account could not be created. Please contact ".$_SERVER['SERVER_NAME']." support at: " . $from_email . " for assistance.";
		}
	
	
	}


}
?>

<div style="text-align: center;">

<h3>Account Creation</h3>

	<div style='font-weight: bold;' id='login_alert'>
<?php
	foreach ( $register_result['error'] as $error ) {
	echo "<p><b style='color: red;'> $error </b></p>";
	}


	foreach ( $register_result['success'] as $success ) {
	echo "<p><b style='color: green;'> $success </b></p>";
	}
?>
	</div>


    <div style="display: inline-block; text-align: right; width: 350px;">

<?php

if ( !$_POST['submit_registration'] || sizeof($register_result['error']) > 0 ) {
?>

<form action='' method ='post' onsubmit='return check_pass("pass_alert", "password", "password2", this.value);'>

<p><b>Email:</b> <input type='text' name='email' value='<?=$_POST['email']?>' /></p>

<p><b>Password:</b> <input type='password' id='password' name='password' value='' onblur='check_pass("pass_alert", "password", "password2", this.value);' /></p>

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
  
<p style='padding: 20px;'><input type='submit' value='Create New Account' /></p>

<input type='hidden' name='submit_registration' value='1' />

</form>

<?php
}

?>

    </div>
    	
	<div style='font-weight: bold; color: red;' id='pass_alert'></div>

</div>