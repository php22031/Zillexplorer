<?php
/*
 * Copyright 2018 GPLv3, Zillexplorer by Mike Kilday: http://DragonFrugal.com
 */

// Forbid direct access to config.php
if ( realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME']) ) {
    header('HTTP/1.0 403 Forbidden', TRUE, 403);
    exit;
}

error_reporting(1); // Turn off all error reporting (0), or enable (1)
//apc_clear_cache(); apcu_clear_cache(); opcache_reset();  // DEBUGGING ONLY

/////////////////////////////////////////////////////


$version = '0.1.1';  // 2018/SEPTEMBER/4TH

$btc_in_usd = 'coinbase'; // Default Bitcoin value in USD: coinbase / bitfinex / gemini / okcoin / bitstamp / kraken / hitbtc / gatecion / livecoin

$from_email = '';  // "From" address for email sent by website...MUST BE SET FOR EMAIL SENDING TO WORK.

//$api_server = 'https://api.zilliqa.com/'; // API server to connect to
$api_server = 'https://api-scilla.zilliqa.com/'; // API server to connect to
//$api_server = 'https://testnet-n-api.aws.zilliqa.com/'; // API server to connect to

$leveldb_support = 'no'; // 'yes' OR 'no' ...php-leveldb MUST BE INSTALLED in php.ini as a PHP extension

$leveldb_data = 'emulate_zilliqa_block_dir'; // Zilliqa data directory where blocks are stored

$api_timeout = 10; // Seconds to wait for response from API

$paginated_rows = 40; // Number of rows of data on pagination-split result pages

$stats_max = 22; // Front page limit on stats shown per section

$chart_blocks = 100000; // Number of blocks used to calculate charts

$error_scan = 10000; // Number of data rows to scan in website database for missing blockchain data


$db_host = 'localhost';
$db_user = 'zillexplorer';
$db_name = 'zillexplorer';
$db_pass = '';
 

////////////////////////////////////////////////////////

include('lib/php/core/init.php'); 

?>