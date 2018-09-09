<?php
/*
 * Copyright 2018 GPLv3, Zillexplorer by Mike Kilday: http://DragonFrugal.com
 */
 
//print_r($_SESSION['user']); // DEBUGGING

if ( $_SESSION['user']['id'] ) {
?>

<h3>Account Summary</h3>




<p>

	<b>Username / Email:</b> <?=$_SESSION['user']['email']?>

</p>






<?php
}
?>