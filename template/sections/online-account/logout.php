<?php
/*
 * Copyright 2018 GPLv3, Zillexplorer by Mike Kilday: http://DragonFrugal.com
 */

// Delete user login session data
$_SESSION['user'] = FALSE;
header("Location: " . $_SERVER['PHP_SELF']);
exit;

?>