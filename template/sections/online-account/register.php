<?php
/*
 * Copyright 2018 GPLv3, Zillexplorer by Mike Kilday: http://DragonFrugal.com
 */
?>
ACCOUNT REGISTER
<?php

if ( $register_allowed ) {
	
// Add user to DB
$query = "INSERT INTO users (id, reset_key, activated, username, password, email, api_key) VALUES ('', '".md5(time().rand(9999999,9999999999))."', 'no', '".trim($_POST['username'])."', '".md5(trim($_POST['password']))."', '".trim($_POST['email'])."', '".md5(time().rand(9999999,9999999999))."')";

mysqli_query($db_connect, $query);

$query = NULL;

}

?>