<?php
/*
 * Copyright 2018 GPLv3, Zillexplorer by Mike Kilday: http://DragonFrugal.com
 */


// Forbid direct access to config.php
if ( realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME']) ) {
    header('HTTP/1.0 403 Forbidden', TRUE, 403);
    exit;
}

//apc_clear_cache(); apcu_clear_cache(); opcache_reset();  // DEBUGGING ONLY

/////////////////////////////////////////////////////


$version = '0.0.6';  // 2018/AUGUST/25TH

//$api_server = 'https://api.zilliqa.com/';
//$api_server = 'https://api-scilla.zilliqa.com/';
$api_server = 'https://testnet-n-api.aws.zilliqa.com/';

$api_timeout = 10; // Seconds to wait for response from API

$stats_max = '20'; // Front page limit on stats shown per section

$btc_in_usd = 'coinbase'; // Default Bitcoin value in USD: coinbase / bitfinex / gemini / okcoin / bitstamp / kraken / hitbtc / gatecion / livecoin


$db_host = 'localhost';
$db_user = 'zillexplorer';
$db_name = 'zillexplorer';
$db_pass = '';
 

////////////////////////////////////////////////////////

include('lib/php/init.php'); 

?>