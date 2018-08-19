<?php
/*
 * Copyright 2018 GPLv3, Zillexplorer by Mike Kilday: http://DragonFrugal.com
 */

//apc_clear_cache(); apcu_clear_cache(); opcache_reset();  // DEBUGGING ONLY

session_start();
$curl_setup = curl_version();

 
$version = '0.0.2';  // 2018/AUGUST/18TH

$zill_node = 'https://api-scilla.zilliqa.com/';

$api_timeout = 10; // Seconds to wait for response from API

$stats_max = '25'; // Front page limit on stats shown per section
 
$user_agent = $_SERVER['SERVER_SOFTWARE'] . ' HTTP Server; PHP v' .phpversion(). ' and Curl v' .$curl_setup["version"]. '; Zillexplorer v' . $version . ' API Parser;';


include('lib/php/functions.php'); 
include('lib/php/cookies.php'); 


if ( $_GET['search'] && trim($_GET['q']) != '' ) {
$dyn_title = '- Search: ' . trim($_GET['q']);
}
elseif ( trim($_GET['ds_block']) != '' ) {
$dyn_title = '- DS Block #' . trim($_GET['ds_block']);
}
elseif ( trim($_GET['tx_block']) != '' ) {
$dyn_title = '- TX Block #' . trim($_GET['tx_block']);
}

 
?>