<?php
/*
 * Copyright 2018 GPLv3, Zillexplorer by Mike Kilday: http://DragonFrugal.com
 */


// Basic inits
session_start();
date_default_timezone_set('UTC');


/////CHECKS///////////////////////////////////////////////////////////

// Make sure we have a PHP version id
if (!defined('PHP_VERSION_ID')) {
    $version = explode('.', PHP_VERSION);

    define('PHP_VERSION_ID', ($version[0] * 10000 + $version[1] * 100 + $version[2]));
}

// Check for curl
if ( !function_exists('curl_version') ) {
echo "Curl for PHP (version ID ".PHP_VERSION_ID.") is not installed yet. Curl is required to run this application.";
exit;
}

if ( !function_exists("imagepng") ) {
echo "GD for PHP (version ID ".PHP_VERSION_ID.") is not installed yet. GD is required to run this application.";
exit;
} 

// IF ENABLED IN config.php, check that php-leveldb has been added as a php extension in php.ini
if ( $leveldb_support == 'yes' && !class_exists('LevelDB') ) {
echo 'The PHP extension "php-leveldb" is not installed yet. The package can be found here: <a href="https://github.com/reeze/php-leveldb" target="_blank">https://github.com/reeze/php-leveldb</a>, OR you can disable php-leveldb support in config.php.';
exit;
}

// Connect to DB
$db_connect = @mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$db_connect) {
    echo "Error: " . mysqli_connect_error();
	exit();
}
//echo 'Connected to MySQL'; //DEBUGGING

//CHECKS -END-//////////////////////////////////////////////////////////////


$curl_setup = curl_version();
$user_agent = $_SERVER['SERVER_SOFTWARE'] . ' HTTP Server; PHP v' .phpversion(). ' and Curl v' .$curl_setup["version"]. '; Zillexplorer v' . $version . ' API Parser;';


include('lib/php/core/functions.php'); 
include('lib/php/core/cookies.php'); 


// ZIL in BTC / USD
$zil_btc = get_trade_price('binance', 'ZILBTC');

$zil_usd = number_format( ( $zil_btc * get_btc_usd($btc_in_usd) ), 8 );  // Convert value to USD;

 

////////////////////IS THIS A CRON JOB RUNNING, OR NOT/////////////////////////////////////////////////
if ( $cron_running != 1 ) {

include('lib/php/securimage/securimage.php');

$securimage = new Securimage(); // Captcha


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
	
	$_GET['url_var'] = str_replace("/","", $_GET['url_var']);
	$_GET['key'] = str_replace("/","", $_GET['key']);
	
	
	// Logout
	if ( $_GET['section'] == 'online-account' && $_GET['url_var'] == 'logout' ) {
	// Delete user login session data
	$_SESSION['user'] = FALSE;
	header("Location: /");
	exit;
	}
	
	
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
	$dyn_title = '- Online Account' . ( $_GET['url_var'] ? ' - ' . ucfirst($_GET['url_var']) : '' );
	}


}
elseif ( $cron_running == 1 ) {


	if ( $leveldb_support == 'yes' && class_exists('LevelDB') ) {
		
	/* default open options */
	$leveldb_options = array(
		'create_if_missing' => false,	// if the specified database didn't exist will create a new one
		'error_if_exists'	=> false,	// if the opened database exsits will throw exception
		'paranoid_checks'	=> false,
		//'block_cache_size'	=> 8 * (2 << 20),
		//'write_buffer_size' => 4<<20,
		//'block_size'		=> 4096,
		'max_open_files'	=> 1000,
		//'block_restart_interval' => 16,
		//'compression'		=> LEVELDB_SNAPPY_COMPRESSION,
		//'comparator'		=> NULL,   // any callable parameter which returns 0, -1, 1
	);
	/* default readoptions */
	$leveldb_readoptions = array(
		'verify_check_sum'	=> false,
		'fill_cache'		=> true,
		'snapshot'			=> null
	);
	
	/* default write options */
	$leveldb_writeoptions = array(
		'sync' => false
	);
		
	$leveldb = new LevelDB($leveldb_data, $leveldb_options, $leveldb_readoptions, $leveldb_writeoptions);
	
	}
	

}
///////////////END CRON DETECT////////////////////////////////////////////////



?>