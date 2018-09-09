<?php
/*
 * Copyright 2018 GPLv3, Zillexplorer by Mike Kilday: http://DragonFrugal.com
 */
 
//print_r($_SESSION['user']); // DEBUGGING

if ( $_SESSION['user']['id'] ) {
?>

<h3>Account API</h3>


<p>

	<b>API Key:</b> <?=$_SESSION['user']['api_key']?>

</p>






<?php
}
?>