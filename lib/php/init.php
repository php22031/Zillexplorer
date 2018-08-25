<?php
/*
 * Copyright 2018 GPLv3, Zillexplorer by Mike Kilday: http://DragonFrugal.com
 */
 
session_start();
$curl_setup = curl_version();
$user_agent = $_SERVER['SERVER_SOFTWARE'] . ' HTTP Server; PHP v' .phpversion(). ' and Curl v' .$curl_setup["version"]. '; Zillexplorer v' . $version . ' API Parser;';

include('lib/php/functions.php'); 
include('lib/php/cookies.php'); 
include('lib/php/zingchart/zc.php');


// Dynamic title
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

// ZIL in BTC / USD
$zil_btc = get_trade_price('binance', 'ZILBTC');

$zil_usd = number_format( ( $zil_btc * get_btc_usd($btc_in_usd) ), 8 );  // Convert value to USD;

 
// Connect to DB
$db_connect = @mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$db_connect) {
    echo "Error: " . mysqli_connect_error();
	exit();
}
//echo 'Connected to MySQL'; //DEBUGGING


?>