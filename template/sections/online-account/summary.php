<?php
/*
 * Copyright 2018 GPLv3, Zillexplorer by Mike Kilday: http://DragonFrugal.com
 */
?>

ACCOUNT SUMMARY

<?php
if ( $_SESSION['user']['id'] ) {
?>
	<pre><?=print_r($_SESSION['user'])?></pre>
<?php
}
?>