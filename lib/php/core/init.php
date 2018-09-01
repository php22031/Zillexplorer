<?php
/*
 * Copyright 2018 GPLv3, Zillexplorer by Mike Kilday: http://DragonFrugal.com
 */


session_start();
date_default_timezone_set('UTC');

include('lib/php/core/functions.php'); 
include('lib/php/core/cookies.php'); 
include('lib/php/zingchart/zc.php');
include('lib/php/securimage/securimage.php');


// Sanitize GET and POST input from users
if ( sizeof($_GET) > 0 ) {

$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
$_GET = sanitize_array($_GET);
}

if ( sizeof($_POST) > 0 ) {
$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
$_POST = sanitize_array($_POST);
}

//var_dump($_GET); // DEBUGGING

$_GET['mode'] = str_replace("/","", $_GET['mode']);
$_GET['key'] = str_replace("/","", $_GET['key']);


// Logout
if ( $_GET['section'] == 'online-account' && $_GET['mode'] == 'logout' ) {
// Delete user login session data
$_SESSION['user'] = FALSE;
header("Location: /");
exit;
}


$curl_setup = curl_version();
$user_agent = $_SERVER['SERVER_SOFTWARE'] . ' HTTP Server; PHP v' .phpversion(). ' and Curl v' .$curl_setup["version"]. '; Zillexplorer v' . $version . ' API Parser;';

$securimage = new Securimage(); // Captcha

// Dynamic title
if ( $_GET['q'] != '' ) {

	if ( preg_match("/address/i", $_SERVER['REQUEST_URI']) ) {
	$dyn_title = '- Address: ' . $_GET['q'];
	}
	elseif ( preg_match("/tx/i", $_SERVER['REQUEST_URI']) ) {
	$dyn_title = '- Transaction: ' . $_GET['q'];
	}
	else {
	$dyn_title = '- Search: ' . $_GET['q'];
	}

}
elseif ( $_GET['dsblock'] != '' ) {
$dyn_title = '- DS Block #' . $_GET['dsblock'];
}
elseif ( $_GET['txblock'] != '' ) {
$dyn_title = '- TX Block #' . $_GET['txblock'];
}
elseif ( $_GET['section'] == 'live-stats' ) {
$dyn_title = '- Live Stats';
}
elseif ( $_GET['section'] == 'tokens' ) {
$dyn_title = '- Tokens';
}
elseif ( $_GET['section'] == 'charts' ) {
$dyn_title = '- Charts';
}
elseif ( $_GET['section'] == 'mining-calculator' ) {
$dyn_title = '- Mining Calculator';
}
elseif ( $_GET['section'] == 'broadcast-transaction' ) {
$dyn_title = '- Broadcast Transaction';
}
elseif ( $_GET['section'] == 'list-accounts' ) {
$dyn_title = '- List Accounts';
}
elseif ( $_GET['section'] == 'list-transactions' ) {
$dyn_title = '- List Transactions';
}
elseif ( $_GET['section'] == 'online-account' ) {
$dyn_title = '- Online Account' . ( $_GET['mode'] ? ' - ' . ucfirst($_GET['mode']) : '' );
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