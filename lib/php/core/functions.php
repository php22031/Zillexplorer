<?php
/*
 * Copyright 2018 GPLv3, Zillexplorer by Mike Kilday: http://DragonFrugal.com
 */

/////////////////////////////////////////////////////////

function delete_all_files($dir) {

$files = glob($dir.'*');

	foreach($files as $file){ 
	
 		if( is_file($file) ) {
 	   unlink($file); 
 		}
 		
	}

}

/////////////////////////////////////////////////////////

function update_cache_file($cache_file, $minutes) {

	if ( file_exists($cache_file) && (filemtime($cache_file) > (time() - 60 * $minutes )) ) {
	   return false; 
	} 
	else {
	   // Our cache is out-of-date
	   return true;
	}

}

/////////////////////////////////////////////////////////

function leveldb_all_vars($db) {
	
// Read-only mode
$read_only = $db->getSnapshot();
$data = array("snapshot" => $read_only);
	
$output = $db->getIterator($data);

	$result_array = array();
	foreach($output as $key => $value) {
		$result_array[] = array($key => $value);
	}

return $result_array;

}

/////////////////////////////////////////////////////////

function leveldb_var($db, $key) {
	
// Read-only mode
$read_only = $db->getSnapshot();
$data = array("snapshot" => $read_only);
	
return $db->get($key, $data);

}

/////////////////////////////////////////////////////////

function pagination($current_page, $page_count) {

?>
<nav aria-label="Page navigation">
  <ul class="pagination">
    <li class="page-item <?=( $current_page == 1 ? 'active' : '' )?>"><a class="page-link" href="1">First</a></li>
  <?php
  
  if ( $current_page > 1 )
  {
  ?>
  
    <li class="page-item"><a class="page-link" href="<?=($current_page - 1)?>">Previous</a></li>
    
  <?php
  }
  
  $link_max = 10;
  
  if ( $current_page > $link_max && substr($current_page, -1) == '0' ) {
  	$num_start = $current_page - 9;
  }
  elseif ( $current_page > $link_max ) {
  	$num_start = substr_replace($current_page, 0, -1) + 1;
  }
  else {
  	$num_start = 1;
  }
  
  $loop = 0;
  while( $loop < $link_max ) {
  	
  		if ( $num_start <= $page_count ) {
  ?>
  
    <li class="page-item <?=( $num_start == $current_page ? 'active' : '' )?>"><a class="page-link" href="<?=$num_start?>"> <?=$num_start?> </a></li>
    
  <?php
  		}
  		
  $num_start = $num_start + 1;
  $loop = $loop + 1;
  }
  
  if ( $current_page < $page_count ) {
  ?>
    <li class="page-item"><a class="page-link" href="<?=($current_page + 1)?>">Next</a></li>
  <?php
  }
  ?>
    <li class="page-item <?=( $current_page == $page_count ? 'active' : '' )?>"><a class="page-link" href="<?=$page_count?>">Last</a></li>
  </ul>
</nav> 


<?php

}
 
/////////////////////////////////////////////////////////

function store_dsblock($results) {
	
global $db_connect;

	foreach ( $results as $key => $value ) {
	
	$dsblock_request = json_request('GetDsBlock', array( strval($value['BlockNum']) )  );
	$dsblock_results = json_decode( @get_data('array', $dsblock_request, 0), TRUE );
	//var_dump( $dsblock_results['result']['header'] ); // DEBUGGING
	
	$ds_block_header = $dsblock_results['result']['header'];
	
		// Run checks...
		
		$query = "SELECT * FROM ds_blocks WHERE blocknum = '".intval($ds_block_header['blockNum'])."'";
		
		if ($result = mysqli_query($db_connect, $query)) {
			while ( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ) {
				
			$dsblock_already_stored = 1;
			
			}
		mysqli_free_result($result);
		}
		
		
		if ( !$dsblock_already_stored && $ds_block_header['timestamp'] > 0 ) {
		
		$query = "INSERT INTO ds_blocks (id, blocknum, difficulty, prevhash, timestamp) VALUES ('', '".intval($ds_block_header['blockNum'])."', '".intval($ds_block_header['difficulty'])."', '".$ds_block_header['prevhash']."', '".intval($ds_block_header['timestamp'])."')";
		
		//echo "<p>" . $query . "</p>\n";
		$sql_result = mysqli_query($db_connect, $query);
		
		}
	
	$dsblock_already_stored = NULL;
	}	

}

/////////////////////////////////////////////////////////

function store_txblock($results) {
	
global $db_connect;

	foreach ( $results as $key => $value ) {
	
	// Singular
	$txblock_request = json_request('GetTxBlock', array( strval($value['BlockNum']) )  );
	$txblock_results = json_decode( @get_data('array', $txblock_request, 0), TRUE );
	//var_dump( $txblock_results['result']['header'] ); // DEBUGGING
	
	$tx_block_header = $txblock_results['result']['header'];
	
		// Run checks...
		
		$query = "SELECT * FROM tx_blocks WHERE blocknum = '".intval($tx_block_header['BlockNum'])."'";
		
		if ($result = mysqli_query($db_connect, $query)) {
		   while ( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ) {
			
			$txblock_already_stored = 1;
			
		   }
		mysqli_free_result($result);
		}
		
		
		if ( !$txblock_already_stored && $tx_block_header['Timestamp'] > 0 ) {
		
		$query = "INSERT INTO tx_blocks (id, blocknum, gas_used, micro_blocks, transactions, prevhash, timestamp) VALUES ('', '".intval($tx_block_header['BlockNum'])."', '".intval($tx_block_header['GasUsed'])."', '".intval($tx_block_header['NumMicroBlocks'])."', '".intval($tx_block_header['NumTxns'])."', '".$tx_block_header['prevBlockHash']."', '".intval($tx_block_header['Timestamp'])."')";
		
		//echo "<p>" . $query . "</p>\n";
		$sql_result = mysqli_query($db_connect, $query);
		
		}
	
	$txblock_already_stored = NULL;
	}

}

/////////////////////////////////////////////////////////

function chart_arrays($array1, $array2) {

$format_array = array("");

	foreach ( $array1 as $value ) {
	
		if ( trim($value) != '' ) {
		$format_array[] = ' [' . $value . ', REPLACE]';
		}

	}
	
	$loop = 0;
	foreach ( $array2 as $value ) {
	
		if ( trim($value) != '' ) {
		$format_array[$loop] = preg_replace("/REPLACE/", $value, $format_array[$loop]);
		}
	
	$loop = $loop + 1;
	}
	
	foreach ( $format_array as $value ) {
	
		if ( trim($value) != '' ) {
	
		$format_string .= $value . ',';
		
		}
	
	}
	
return substr($format_string, 0, -1);

}


/////////////////////////////////////////////////////////

function validate_email($email) {


	$address = explode("@",$email);
	
	$domain = $address[1];
	
	// Validate "To" address
	if ( !$email || !preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)+$/", $email) ) {
	return "Please enter a valid email address.";
	}
	elseif (function_exists("getmxrr") && !getmxrr($domain,$mxrecords)) {
	return "The email domain \"$domain\" appears incorrect.";
	}
	else {
	return "valid";
	}
			

}

/////////////////////////////////////////////////////////

function safe_mail($to, $subject, $message) {
	
global $from_email;

// Stop injection vulnerability for PHP < 7.2
$from_email = str_replace("\r\n", "\n", $from_email); // windows -> unix
$from_email = str_replace("\r", "\n", $from_email);   // remaining -> unix

$email_check = validate_email($to);

	if ( $email_check != 'valid' ) {
	return $email_check;
	}
			

	// Use array for safety from header injection >= PHP 7.2 
	if ( PHP_VERSION_ID >= 70200 ) {
	
	$headers = array(
	    					'From' => $from_email
	    					//'From' => $from_email,
	    					//'Reply-To' => $from_email,
	    					//'X-Mailer' => 'PHP/' . phpversion()
							);
	
	}
	else {
	$headers = 'From: ' . $from_email;
	}

return mail($to, $subject, $message, $headers);

}

//////////////////////////////////////////////////////////

function json_request($method, $params) {

return array(
      		'id' => '1',
  				'jsonrpc' => '2.0',
      		'method' => $method,
      		'params' => $params,
				);

}

//////////////////////////////////////////////////////////

function strip_0x($request) {
	
return ( substr($request, 0, 2) == '0x' ? substr_replace($request, '', 0, 2) : $request );

}

//////////////////////////////////////////////////////////

function sanitize_array($request) {

	foreach ( $request as $key => $value ) {
	$request[$key] = sanitize_var($value);
	}

return $request;

}

//////////////////////////////////////////////////////////

function sanitize_var($request) {

global $db_connect;

$request = trim($request);
$request = htmlentities( $request , ENT_QUOTES );

	if ( $db_connect ) {
	//$request = mysqli_real_escape_string($request); // Requires a db connection
	}
	
return $request;

}

//////////////////////////////////////////////////////////

function get_data($mode, $request, $ttl) {

global $version, $user_agent, $api_server, $api_timeout;

$cookie_jar = tempnam('/tmp','cookie');
	
// To avoid duplicate requests in current update session, AND cache data
$hash_check = ( $mode == 'array' ? md5(serialize($request)) : md5($request) );


	//if ( !$_SESSION['api_cache'][$hash_check] ) {	
	// Cache API data for 1 minute
	if ( update_cache_file('cache/api/'.$hash_check.'.dat', $ttl) == true && $ttl > 0 || $ttl == 0 ) {	
	
	$ch = curl_init( ( $mode == 'array' ? $api_server : '' ) );
	
		if ( $mode == 'array' ) {
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode($request) );
		}
		elseif ( $mode == 'url' ) {
		curl_setopt($ch, CURLOPT_URL, $request);
		}
	
	curl_setopt($c, CURLOPT_COOKIEJAR, $cookie_jar);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
	curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
	
	curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0); 
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $api_timeout);
	curl_setopt($ch, CURLOPT_TIMEOUT, $api_timeout);
	
	$data = curl_exec($ch);
	
		if ( !$data ) {
		$data = 'no';
		$_SESSION['get_data_error'] .= ' No data returned from ' . ( $mode == 'array' ? 'API server "' . $api_server : 'request "' . $request ) . '" (with timeout configuration setting of ' . $api_timeout . ' seconds). <br /> ' . ( $mode == 'array' ? '<pre>' . print_r($request, TRUE) . '</pre>' : '' ) . ' <br /> ';
		}
		
		if ( preg_match("/coinmarketcap/i", $request) && !preg_match("/last_updated/i", $data) ) {
		$_SESSION['get_data_error'] .= '##REQUEST## data error response from '.( $mode == 'array' ? $api_server : $request ).': <br /> =================================== <br />' . $data . ' <br /> =================================== <br />';
		}
	
	
	curl_close($ch);
	unlink($cookie_jar) or die("Can't unlink $cookie_jar");
	
	
		//$_SESSION['api_cache'][$hash_check] = $data; // Cache API data for this update session
		if ( $data && $ttl > 0 ) {
	
		//echo 'Caching data '; // DEBUGGING ONLY

		file_put_contents('cache/api/'.$hash_check.'.dat', $data, LOCK_EX);
		
		}
		elseif ( !$data ) {
		unlink('cache/api/'.$hash_check.'.dat'); // Delete any existing cache if empty value
		//echo 'Deleted cache file, no data. '; // DEBUGGING ONLY
		}

	
	// DEBUGGING ONLY
	//$_SESSION['get_data_error'] .= '##REQUEST## Requested ' . ( $mode == 'array' ? 'API server "' . $api_server : 'endpoint "' . $request ) . '". <br /> ' . ( $mode == 'array' ? '<pre>' . print_r($request, TRUE) . '</pre>' : '' ) . ' <br /> ';
	
	}
	elseif ( $ttl < 0 ) {
	unlink('cache/api/'.$hash_check.'.dat'); // Delete cache if $ttl flagged to less than zero
	//echo 'Deleted cache file, flagged for deletion. '; // DEBUGGING ONLY
	}
	else {
	
	//$data = $_SESSION['api_cache'][$hash_check];
	$data = file_get_contents('cache/api/'.$hash_check.'.dat');
	
		if ( !$data ) {
		unlink('cache/api/'.$hash_check.'.dat'); // Delete any existing cache if empty value
		echo 'Deleted cache file, no data. ';
		}
		else {
		//echo 'Cached data '; // DEBUGGING ONLY
		}
	
		if ( !preg_match("/coinmarketcap/i", $_SESSION['get_data_error']) && preg_match("/coinmarketcap/i", $request) && !preg_match("/last_updated/i", $data) ) {
		$_SESSION['cmc_error'] = '##REQUEST## data error response from '.( $mode == 'array' ? $api_server : $request ).': <br /> =================================== <br />' . $data . ' <br /> =================================== <br />';
		}
	
	
	// DEBUGGING ONLY
	//$_SESSION['get_data_error'] .= ' ##DUPLICATE## request ignored for ' . ( $mode == 'array' ? 'API server "' . $api_server : 'endpoint "' . $request ) . '". <br /> ' . ( $mode == 'array' ? '<pre>' . print_r($request, TRUE) . '</pre>' : '' ) . ' <br /> ';
	
	
	}
	
	
return $data;


}

//////////////////////////////////////////////////////////

function trim_array($data) {

        foreach ( $data as $key => $value ) {
        $data[$key] = trim(remove_formatting($value));
        }
        
return $data;

}

//////////////////////////////////////////////////////////

function remove_formatting($data) {

$data = preg_replace("/ /i", "", $data); // Space
$data = preg_replace("/ /i", "", $data); // Tab
$data = preg_replace("/,/i", "", $data); // Comma
        
return $data;

}

//////////////////////////////////////////////////////////

function get_btc_usd($btc_in_usd) {

  
    if ( strtolower($btc_in_usd) == 'coinbase' ) {
    
    $json_string = 'https://api.coinbase.com/v2/prices/spot?currency=USD';
    
    $jsondata = @get_data('url', $json_string, 5);
    
    $data = json_decode($jsondata, TRUE);
    
    return number_format( $data['data']['amount'], 2, '.', '');
  
    }
  
  
    elseif ( strtolower($btc_in_usd) == 'hitbtc' ) {
  
    $json_string = 'https://api.hitbtc.com/api/1/public/BTCUSD/ticker';
    
    $jsondata = @get_data('url', $json_string, 5);
    
    $data = json_decode($jsondata, TRUE);
    
    return number_format( $data['last'], 2, '.', '');
  
    }
  
  
    elseif ( strtolower($btc_in_usd) == 'bitfinex' ) {
  
    $data = get_trade_price('bitfinex', 'tBTCUSD');
    
    return number_format( $data, 2, '.', '');
  
    }
  

    elseif ( strtolower($btc_in_usd) == 'gemini' ) {
    
    $json_string = 'https://api.gemini.com/v1/pubticker/btcusd';
    
      $jsondata = @get_data('url', $json_string, 5);
      
      $data = json_decode($jsondata, TRUE);
      
    return number_format( $data['last'], 2, '.', '');
      
    }


    elseif ( strtolower($btc_in_usd) == 'okcoin' ) {
  
    $json_string = 'https://www.okcoin.com/api/ticker.do?ok=1';
    
    $jsondata = @get_data('url', $json_string, 5);
    
    $data = json_decode($jsondata, TRUE);
    
    return number_format( $data['ticker']['last'], 2, '.', '');
    
  
    }
  
  
    elseif ( strtolower($btc_in_usd) == 'bitstamp' ) {
 	
    $json_string = 'https://www.bitstamp.net/api/ticker/';
    
    $jsondata = @get_data('url', $json_string, 5);
    
    $data = json_decode($jsondata, TRUE);
    
    return number_format( $data['last'], 2, '.', '');
    
    }
  
 
   elseif ( strtolower($btc_in_usd) == 'gatecoin' ) {
 
      
      $json_string = 'https://api.gatecoin.com/Public/LiveTickers';
      
      $jsondata = @get_data('url', $json_string, 5);
      
      $data = json_decode($jsondata, TRUE);
   
   //var_dump($data);
       if (is_array($data) || is_object($data)) {
         
             foreach ( $data['tickers'] as $key => $value ) {
               
               if ( $data['tickers'][$key]["currencyPair"] == 'BTCUSD' ) {
                
               return $data['tickers'][$key]["last"];
                
                
               }
             
     
             }
             
       }
   
   
   }

   elseif ( strtolower($btc_in_usd) == 'livecoin' ) {
 
 
      $json_string = 'https://api.livecoin.net/exchange/ticker';
      
      $jsondata = @get_data('url', $json_string, 5);
      
      $data = json_decode($jsondata, TRUE);
   
   
   
   //var_dump($data);
       if (is_array($data) || is_object($data)) {
         
             foreach ( $data as $key => $value ) {
               
               if ( $data[$key]['symbol'] == 'BTC/USD' ) {
                
               return $data[$key]["last"];
                
                
               }
             
     
             }
             
       }
   
   
   }

   elseif ( strtolower($btc_in_usd) == 'kraken' ) {
   
   $json_string = 'https://api.kraken.com/0/public/Ticker?pair=XXBTZUSD';
   
   $jsondata = @get_data('url', $json_string, 5);
   
   $data = json_decode($jsondata, TRUE);
   
   //print_r($json_string);print_r($data);
   
      if (is_array($data) || is_object($data)) {
   
       foreach ($data as $key => $value) {
         
         //print_r($key);
         
         if ( $key == 'result' ) {
     
         //print_r($data[$key]);
         
				foreach ($data[$key] as $key2 => $value2) {
				  
				  //print_r($data[$key][$key2]);
				  
				  if ( $key2 == 'XXBTZUSD' ) {
				   
				  return $data[$key][$key2]["c"][0];
				   
				   
				  }
				
	   		   
				}
       
         }
     
       }
       
      }
   
   
   }
  

}

//////////////////////////////////////////////////////////

function get_trade_price($chosen_market, $market_pairing) {

global $btc_in_usd, $coins_array;
 

  if ( strtolower($chosen_market) == 'gemini' ) {
  
  $json_string = 'https://api.gemini.com/v1/pubticker/' . $market_pairing;
  
    $jsondata = @get_data('url', $json_string, 5);
    
    $data = json_decode($jsondata, TRUE);
    
    return number_format( $data['last'], 8, '.', '');
    
  
  }


  elseif ( strtolower($chosen_market) == 'bitstamp' ) {
  	
  
  $json_string = 'https://www.bitstamp.net/api/v2/ticker/' . $market_pairing;
  
    $jsondata = @get_data('url', $json_string, 5);
    
    $data = json_decode($jsondata, TRUE);
    
    return number_format( $data['last'], 8, '.', '');
    
  
  }



  elseif ( strtolower($chosen_market) == 'okex' ) {
  	
  	// Available markets listed here: https://www.okex.com/v2/markets/products
  
  $json_string = 'https://www.okex.com/api/v1/ticker.do?symbol=' . $market_pairing;
  
    $jsondata = @get_data('url', $json_string, 5);
    
    $data = json_decode($jsondata, TRUE);
    
    return number_format( $data['ticker']['last'], 8, '.', '');
    
  
  }



  elseif ( strtolower($chosen_market) == 'binance' ) {
  
  $json_string = 'https://www.binance.com/api/v1/ticker/24hr?symbol=' . $market_pairing;
  
    $jsondata = @get_data('url', $json_string, 5);
    
    $data = json_decode($jsondata, TRUE);
    
    return number_format( $data['lastPrice'], 8, '.', '');
    
  
  }


  elseif ( strtolower($chosen_market) == 'coinbase' ) {
  
     $json_string = 'https://api.coinbase.com/v2/exchange-rates?currency=' . $market_pairing;
     
     $jsondata = @get_data('url', $json_string, 5);
     
     $data = json_decode($jsondata, TRUE);
     
     return $data['data']['rates']['BTC'];
   
  }
  

  elseif ( strtolower($chosen_market) == 'cryptofresh' ) {
  
  $json_string = 'https://cryptofresh.com/api/asset/markets?asset=' . $market_pairing;
  
    $jsondata = @get_data('url', $json_string, 5);
    
    $data = json_decode($jsondata, TRUE);
	
		if ( preg_match("/BRIDGE/", $market_pairing) ) {
		return number_format( $data['BRIDGE.BTC']['price'], 8, '.', '');
		}
		elseif ( preg_match("/OPEN/", $market_pairing) ) {
		return number_format( $data['OPEN.BTC']['price'], 8, '.', '');
		}
  
  }


  elseif ( strtolower($chosen_market) == 'bittrex' ) {
     
     $json_string = 'https://bittrex.com/api/v1.1/public/getmarketsummaries';
     
     $jsondata = @get_data('url', $json_string, 5);
     
     $data = json_decode($jsondata, TRUE);
   
  
  $data = $data['result'];
  //print_r($data);
     if (is_array($data) || is_object($data)) {
  
		foreach ($data as $key => $value) {
		  
		  //print_r($key);
		  
		  if ( $data[$key]['MarketName'] == $market_pairing ) {
		   
		  return $data[$key]["Last"];
		   
		   
		  }
		
	  
		}
      
     }
  
  
  }


  elseif ( strtolower($chosen_market) == 'tradesatoshi' ) {

     $json_string = 'https://tradesatoshi.com/api/public/getmarketsummaries';
     
     $jsondata = @get_data('url', $json_string, 5);
     
     $data = json_decode($jsondata, TRUE);
  
  $data = $data['result'];
  //print_r($data);
     if (is_array($data) || is_object($data)) {
  
		foreach ($data as $key => $value) {
		  
		  //print_r($key);
		  
		  if ( $data[$key]['market'] == $market_pairing ) {
		   
		  return $data[$key]["last"];
		   
		   
		  }
		
	  
		}
      
     }
  
  
  }

  elseif ( strtolower($chosen_market) == 'liqui' ) {
  
  $json_string = 'https://api.liqui.io/api/3/ticker/' . $market_pairing;
  
  $jsondata = @get_data('url', $json_string, 5);
  
  $data = json_decode($jsondata, TRUE);
  
  //print_r($data);
     if (is_array($data) || is_object($data)) {
  
		foreach ($data as $key => $value) {
		  
		  //print_r($key);
		  
		  if ( $key == $market_pairing ) {
		   
		  return $data[$key]["last"];
		   
		   
		  }
		
	  
		}
      
     }
  
  }

  elseif ( strtolower($chosen_market) == 'poloniex' ) {

     $json_string = 'https://poloniex.com/public?command=returnTicker';
     
     $jsondata = @get_data('url', $json_string, 5);
     
     $data = json_decode($jsondata, TRUE);
   
  
  //print_r($data);
     if (is_array($data) || is_object($data)) {
  
		foreach ($data as $key => $value) {
		  
		  //print_r($key);
		  
		  if ( $key == $market_pairing ) {
		   
		  return $data[$key]["last"];
		   
		   
		  }
		
	  
		}
      
     }
  
  
  }

  elseif ( strtolower($chosen_market) == 'kucoin' ) {

     $json_string = 'https://api.kucoin.com/v1/open/tick';
     
     $jsondata = @get_data('url', $json_string, 5);
     
     $data = json_decode($jsondata, TRUE);
   
  
  $data = $data['data'];
  //print_r($data);
     if (is_array($data) || is_object($data)) {
  
		foreach ($data as $key => $value) {
		  
		  //print_r($key);
		  
		  if ( $data[$key]['symbol'] == $market_pairing ) {
		   
		  return $data[$key]["lastDealPrice"];
		   
		   
		  }
		
	  
		}
      
     }
  
  
  }

  elseif ( strtolower($chosen_market) == 'livecoin' ) {

     $json_string = 'https://api.livecoin.net/exchange/ticker';
     
     $jsondata = @get_data('url', $json_string, 5);
     
     $data = json_decode($jsondata, TRUE);
     
  //print_r($data);
     if (is_array($data) || is_object($data)) {
  
		foreach ($data as $key => $value) {
		  
		  //print_r($key);
		  
		  if ( $data[$key]['symbol'] == $market_pairing ) {
		   
		  return $data[$key]["last"];
		   
		   
		  }
		
	  
		}
      
     }
  
  
  }
  
  elseif ( strtolower($chosen_market) == 'cryptopia' ) {

     $json_string = 'https://www.cryptopia.co.nz/api/GetMarkets';
     
     $jsondata = @get_data('url', $json_string, 5);
     
     $data = json_decode($jsondata, TRUE);
  
  $data = $data['Data'];
  
  //print_r($data);
      if (is_array($data) || is_object($data)) {
  
            foreach ($data as $key => $value) {
        
			//print_r($key);
			
			if ( $data[$key]['Label'] == $market_pairing ) {
			 
			return $data[$key]["LastPrice"];
			 
			 
			}
		  
		
		  }
      
      }
  
  
  }

  elseif ( strtolower($chosen_market) == 'hitbtc' ) {

     $json_string = 'https://api.hitbtc.com/api/1/public/ticker';
     
     $jsondata = @get_data('url', $json_string, 5);
     
     $data = json_decode($jsondata, TRUE);
     
  //print_r($data);
     if (is_array($data) || is_object($data)) {
  
		foreach ($data as $key => $value) {
		  
		  //print_r($key);
		  
		  if ( $key == $market_pairing ) {
		   
		  return $data[$key]["last"];
		   
		   
		  }
		
	  
		}
      
     }
  
  
  }

  elseif ( strtolower($chosen_market) == 'bter' ) {

     $json_string = 'http://data.bter.com/api/1/marketlist';
     
     $jsondata = @get_data('url', $json_string, 5);
     
     $data = json_decode($jsondata, TRUE);
     
  //print_r($data);
     if (is_array($data) || is_object($data)) {
  
		foreach ($data as $key => $value) {
		  
		  //var_dump($data);
		  
		  if ( $data[$key]['pair'] == $market_pairing ) {
		   
		  return $data[$key]['rate'];
		   
		   
		  }
		
	  
		}
      
     }
  
  
  }
  
  
  elseif ( strtolower($chosen_market) == 'graviex' ) {

     $json_string = 'https://graviex.net//api/v2/tickers.json';
     
     $jsondata = @get_data('url', $json_string, 5);
     
     $data = json_decode($jsondata, TRUE);
     
  //print_r($data);
     if (is_array($data) || is_object($data)) {
  
		foreach ($data as $key => $value) {
		  
		  //var_dump($data);
		  
		  if ( $data[$market_pairing] != '' ) {
		   
		  return $data[$market_pairing]['ticker']['last'];
		   
		   
		  }
		
	  
		}
      
     }
  
  
  }


  elseif ( strtolower($chosen_market) == 'kraken' ) {
  
  $json_string = 'https://api.kraken.com/0/public/Ticker?pair=' . $market_pairing;
  
  $jsondata = @get_data('url', $json_string, 5);
  
  $data = json_decode($jsondata, TRUE);
  
  //print_r($json_string);print_r($data);
  
     if (is_array($data) || is_object($data)) {
  
      foreach ($data as $key => $value) {
        
        //print_r($key);
        
        if ( $key == 'result' ) {
    
        //print_r($data[$key]);
        
			foreach ($data[$key] as $key2 => $value2) {
			  
			  //print_r($data[$key][$key2]);
			  
			  if ( $key2 == $market_pairing ) {
			   
			  return $data[$key][$key2]["c"][0];;
			   
			   
			  }
			
		  
			}
      
        }
    
      }
      
     }
  
  
  }



  elseif ( strtolower($chosen_market) == 'gatecoin' ) {

     $json_string = 'https://api.gatecoin.com/Public/LiveTickers';
     
     $jsondata = @get_data('url', $json_string, 5);
     
     $data = json_decode($jsondata, TRUE);
  
  //var_dump($data);
     if (is_array($data) || is_object($data)) {
  
		foreach ( $data['tickers'] as $key => $value ) {
		  
		  if ( $data['tickers'][$key]["currencyPair"] == $market_pairing ) {
		   
		  return $data['tickers'][$key]["last"];
		   
		   
		  }
		
	  
		}
      
     }
  
  
  }



  elseif ( strtolower($chosen_market) == 'upbit' ) {
  	
  	
  		foreach ( $coins_array as $markets ) {
  		
  			foreach ( $markets['market_pairing'] as $exchange_pairs ) {
  			
  				if ( $exchange_pairs['upbit'] != '' ) {
				
				$upbit_pairs .= 'CRIX.UPBIT.' . $exchange_pairs['upbit'] . ',';
				  				
  				}
  			
  			}
  			
  		}


     $json_string = 'https://crix-api-endpoint.upbit.com/v1/crix/recent?codes=' . $upbit_pairs;
     
     $jsondata = @get_data('url', $json_string, 5);
     
     $data = json_decode($jsondata, TRUE);
  
  //var_dump($data);
     if (is_array($data) || is_object($data)) {
  
		foreach ( $data as $key => $value ) {
		  
		  if ( $data[$key]["code"] == 'CRIX.UPBIT.' . $market_pairing ) {
		   
		  return $data[$key]["tradePrice"];
		   
		   
		  }
		
	  
		}
      
     }
  
  
  }


  elseif ( strtolower($chosen_market) == 'ethfinex' || strtolower($chosen_market) == 'bitfinex' ) {
  	
  	
  		foreach ( $coins_array as $markets ) {
  		
  			foreach ( $markets['market_pairing'] as $exchange_pairs ) {
  			
  				if ( $exchange_pairs['ethfinex'] != '' ) {
				
				$finex_pairs .= $exchange_pairs['ethfinex'] . ',';
				  				
  				}
  				
  				if ( $exchange_pairs['bitfinex'] != '' ) {
				
				$finex_pairs .= $exchange_pairs['bitfinex'] . ',';
				  				
  				}
  			
  			}
  			
  		}


     $json_string = 'https://api.bitfinex.com/v2/tickers?symbols=' . $finex_pairs;
     
     $jsondata = @get_data('url', $json_string, 5);
     
     $data = json_decode($jsondata, TRUE);
  
  //var_dump($data);
  
     if (is_array($data) || is_object($data)) {
  
		foreach ( $data as $object ) {
		  
		  if ( $object[0] == $market_pairing ) {
			  
		   //var_dump($object);
		   
		  return $object[( sizeof($object) - 4 )];
		   
		   
		  }
		
	  
		}
      
     }
  
  
  }



  
}

//////////////////////////////////////////////////////////

function coinmarketcap_api() {
	
	
     	$json_string = 'https://api.coinmarketcap.com/v2/ticker/2469/';
     	     
	  	$jsondata = @get_data('url', $json_string, 10);
	   
   	$cmc_data = json_decode($jsondata, TRUE);
    
 	   
 	   $_SESSION['cmc_data'] = $cmc_data;
		

	     	

     if ( is_array($cmc_data) || is_object($cmc_data) ) {
  		
  	   	foreach ($cmc_data as $key => $value) {
     	  	
  	     	
        		if ( $cmc_data[$key]['symbol'] == 'ZIL' ) {
  	      		
        		return $cmc_data[$key];
        
        
     	  		}
    	 
    
  	   	}
      	
     
     	}
		  
  
}

//////////////////////////////////////////////////////////




?>