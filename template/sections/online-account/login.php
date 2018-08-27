<?php
/*
 * Copyright 2018 GPLv3, Zillexplorer by Mike Kilday: http://DragonFrugal.com
 */


$login_result = array('');
		
if ( $_POST['submit_login'] ) {
	
	if ( trim($_POST['email']) == '' )	{
	$login_result['error'][] = "Please enter your email.";
	}
	else {
		
		// Login if user / pass match
		$query = "SELECT * FROM users WHERE email = '".trim($_POST['email'])."'";
		
		if ($result = mysqli_query($db_connect, $query)) {
			
		   while ( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ) {
				
				if ( $row["password"] == md5( trim($_POST['password']) ) && $row["activated"] == 'yes' ) {
				$_SESSION['user'] = $row;
				header("Location: /online-account/summary/");
				mysqli_free_result($result);
				exit;
				}
				elseif ( $row["password"] != md5( trim($_POST['password']) ) ) {
				$login_result['error'][] = "Wrong password.";
				}
				elseif ( $row["activated"] != 'yes' ) {
				$login_result['error'][] = "Please activate <a href='/online-account/reset/' class='red-underline'>or reset your account</a> first.";
				}
				else {
				$login_result['error'][] = "Please check all form fields.";
				}
			
		   //echo $row["username"]." ".$row["email"]."<br />";
		   
		   }
		   
		   
			if ( $result->num_rows < 1 ) {
			$login_result['error'][] = "Please check all form fields.";
			}
	
		mysqli_free_result($result);
		}
		$query = NULL;

	}
	
}

?>

<div style="text-align: center;">

<h3>Account Login</h3>


	<div style='font-weight: bold;' id='login_alert'>
<?php
	foreach ( $login_result['error'] as $error ) {
	echo "<p><b style='color: red;'> $error </b></p>";
	}
?>
	</div>


    <div style="display: inline-block; text-align: right; width: 350px;">

<?php

if ( !$_POST['submit_login'] || sizeof($login_result['error']) > 0 ) {
?>


<form action='' method ='post'>

<p><b>Email:</b> <input type='text' name='email' value='<?=$_POST['email']?>' /></p>

<p><b>Password:</b> <input type='password' name='password' value='' /></p>

<p><input type='submit' value='Login' /></p>

<input type='hidden' name='submit_login' value='1' />

</form>

<p><a href='/online-account/reset/'><b class='red-underline'>Forgot Your Password?</b></a></p>

<?php
}

?>

    </div>
</div>
