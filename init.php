<?php
/*
 * Copyright 2018 GPLv3, Zillexplorer by Mike Kilday: http://DragonFrugal.com
 */

//apc_clear_cache(); apcu_clear_cache(); opcache_reset();  // DEBUGGING ONLY

session_start();
$curl_setup = curl_version();
 
$version = '0.0.4';  // 2018/AUGUST/22ND

$api_server = 'https://api-scilla.zilliqa.com/';
//$api_server = 'https://testnet-l-api.aws.zilliqa.com/';

$api_timeout = 10; // Seconds to wait for response from API

$stats_max = '35'; // Front page limit on stats shown per section
 
$user_agent = $_SERVER['SERVER_SOFTWARE'] . ' HTTP Server; PHP v' .phpversion(). ' and Curl v' .$curl_setup["version"]. '; Zillexplorer v' . $version . ' API Parser;';


include('lib/php/functions.php'); 
include('lib/php/cookies.php'); 


if ( trim($_GET['q']) != '' ) {

	if ( preg_match("/address/i", $_SERVER['REQUEST_URI']) ) {
	$dyn_title = '- Address: ' . trim($_GET['q']);
	}
	elseif ( preg_match("/tx/i", $_SERVER['REQUEST_URI']) ) {
	$dyn_title = '- Transaction: ' . trim($_GET['q']);
	}
	else {
	$dyn_title = '- Search: ' . trim($_GET['q']);
	}

}
elseif ( trim($_GET['dsblock']) != '' ) {
$dyn_title = '- DS Block #' . trim($_GET['dsblock']);
}
elseif ( trim($_GET['txblock']) != '' ) {
$dyn_title = '- TX Block #' . trim($_GET['txblock']);
}

 
?>