<?php
/*
 * Copyright 2018 GPLv3, Zillexplorer by Mike Kilday: http://DragonFrugal.com
 */

include('config.php'); 
include('template/base/header.php'); 

 //echo '"'.$_GET['url_var'].'"'; exit;  //DEBUGGING
 //echo '"'.$_SERVER['REQUEST_URI'].'"'; exit;  //DEBUGGING
      
      /////////////////////////////////////////
      
      // DS Block info
      if ( $_GET['dsblock'] != '' ) {
		include('template/sections/ds-block.php'); 
      }
      // TX Block info
      elseif ( $_GET['txblock'] != '' ) {
		include('template/sections/tx-block.php'); 
      }
      // Search query results
      elseif ( $_GET['q'] != '' ) {
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
      // List Accounts
      elseif ( $_GET['section'] == 'list-accounts' ) {
		include('template/sections/list-accounts.php'); 
		}
      // List Transactions
      elseif ( $_GET['section'] == 'list-transactions' ) {
		include('template/sections/list-transactions.php'); 
		}
      // List DS Blocks
      elseif ( $_GET['section'] == 'list-dsblocks' ) {
		include('template/sections/list-dsblocks.php'); 
		}
      // List TX Blocks
      elseif ( $_GET['section'] == 'list-txblocks' ) {
		include('template/sections/list-txblocks.php'); 
		}
		
		//////ONLINE ACCOUNT/////////////////////////////
      
      // Login (no logout page due to header redirect needed)
      elseif ( $_GET['section'] == 'online-account' && $_GET['url_var'] == 'login' ) {
		include('template/sections/online-account/login.php'); 
      }
      // Register
      elseif ( $_GET['section'] == 'online-account' && $_GET['url_var'] == 'register' ) {
		include('template/sections/online-account/register.php'); 
      }
      // Reset
      elseif ( $_GET['section'] == 'online-account' && $_GET['url_var'] == 'reset' ) {
		include('template/sections/online-account/reset.php'); 
		}
		//Activate
      elseif ( $_GET['section'] == 'online-account' && $_GET['url_var'] == 'activate' ) {
		include('template/sections/online-account/activate.php'); 
      }
      // Main
      elseif ( $_GET['section'] == 'online-account' && $_GET['url_var'] == 'summary' ) {
		include('template/sections/online-account/summary.php'); 
      }
      // Alerts
      elseif ( $_GET['section'] == 'online-account' && $_GET['url_var'] == 'alerts' ) {
		include('template/sections/online-account/alerts.php'); 
      }
      // API
      elseif ( $_GET['section'] == 'online-account' && $_GET['url_var'] == 'api' ) {
		include('template/sections/online-account/api.php'); 
      }

      /////////////////////////////////////////
      
      // Main Page
      else {
		include('template/sections/main-page.php'); 
      }
      

include('template/base/footer.php');

?>

