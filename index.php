<?php
/*
 * Copyright 2018 GPLv3, Zillexplorer by Mike Kilday: http://DragonFrugal.com
 */

include('init.php'); 
include('template/base/header.php'); 

$_GET['mode'] = trim( str_replace("/","", $_GET['mode']) );

 //echo '"'.$_GET['mode'].'"'; exit;  //DEBUGGING
 //echo '"'.$_SERVER['REQUEST_URI'].'"'; exit;  //DEBUGGING
      
      /////////////////////////////////////////
      
      // DS Block info
      if ( $_GET['dsblock'] != '' ) {
		include('template/sections/ds-blocks.php'); 
      }
      // TX Block info
      elseif ( $_GET['txblock'] != '' ) {
		include('template/sections/tx-blocks.php'); 
      }
      // Search query results
      elseif ( trim($_GET['q']) != '' ) {
		include('template/sections/search-results.php'); 
      }
      
      //////////SECTIONS///////////////////////
      
      // Live Stats
      elseif ( $_GET['section'] == 'live-stats' ) {
		include('template/sections/live-stats.php'); 
      }
      // Tokens
      elseif ( $_GET['section'] == 'tokens' ) {
		include('template/sections/tokens.php'); 
      }
      // Charts
      elseif ( $_GET['section'] == 'charts' ) {
		include('template/sections/charts.php'); 
      }
      // Mining Calculator
      elseif ( $_GET['section'] == 'mining-calculator' ) {
		include('template/sections/mining-calculator.php'); 
      }
      // Broadcast Transaction
      elseif ( $_GET['section'] == 'broadcast-transaction' ) {
		include('template/sections/broadcast-transaction.php'); 
      }
      // Top Accounts
      elseif ( $_GET['section'] == 'top-accounts' ) {
		include('template/sections/top-accounts.php'); 
		}
		
		//////ONLINE ACCOUNT/////////////////////////////
      
      // Login
      elseif ( $_GET['section'] == 'online-account' && $_GET['mode'] == 'login' ) {
		include('template/sections/online-account/login.php'); 
      }
      // Logout
      elseif ( $_GET['section'] == 'online-account' && $_GET['mode'] == 'logout' ) {
		include('template/sections/online-account/logout.php'); 
      }
      // Logout
      elseif ( $_GET['section'] == 'online-account' && $_GET['mode'] == 'register' ) {
		include('template/sections/online-account/register.php'); 
      }
      // Main
      elseif ( $_GET['section'] == 'online-account' && $_GET['mode'] == 'summary' ) {
		include('template/sections/online-account/summary.php'); 
      }
      // Alerts
      elseif ( $_GET['section'] == 'online-account' && $_GET['mode'] == 'alerts' ) {
		include('template/sections/online-account/alerts.php'); 
      }
      // API
      elseif ( $_GET['section'] == 'online-account' && $_GET['mode'] == 'api' ) {
		include('template/sections/online-account/api.php'); 
      }

      /////////////////////////////////////////
      
      // Main Page
      else {
		include('template/sections/main-page.php'); 
      }
      

include('template/base/footer.php');

?>

