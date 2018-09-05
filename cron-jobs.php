<?php
/*
 * Copyright 2018 GPLv3, Zillexplorer by Mike Kilday: http://DragonFrugal.com
 */
 
// Forbid direct access to cron.php
if ( realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME']) ) {
header('HTTP/1.0 403 Forbidden', TRUE, 403);
exit;
}

$cron_running = 1; // Helps avoid running logic later, which is not related to the cron jobs

include('config.php'); 

// IF FETCHING BLOCKS VIA LEVELDB ////////////////////////////////////////////////////////////////////////////////
if ( $leveldb_support == 'yes' && class_exists('LevelDB') ) {


//$leveldb->put("Test_Key", "Test_Value"); // DEBUGGING
//$leveldb->put("Test_Key2", "Test_Value2"); // DEBUGGING
//$leveldb->put("Test_Key3", "Test_Value3"); // DEBUGGING


//var_dump( leveldb_all_vars($leveldb) ); // DEBUGGING
//var_dump( leveldb_var($leveldb, 'Test_Key') ); // DEBUGGING


// We're done, close the connection
$leveldb->close();
}
//LEVELDB -END-///////////////////////////////////////////////////////////////////////////////////////////////////
// IF FETCHING BLOCKS VIA API (JSON-RPC) /////////////////////////////////////////////////////////////////////////
else {


///////GET RECENT DS BLOCKS////////////////

$ds_data = json_request('DSBlockListing', array(1) );
$ds_results = json_decode( @get_data('array', $ds_data), TRUE );      
//var_dump( $ds_results['result']['data'] ); // DEBUGGING

store_dsblock($ds_results['result']['data']);


////////GET RECENT TX BLOCKS///////////////

$tx_data = json_request('TxBlockListing', array(1) );
$tx_results = json_decode( @get_data('array', $tx_data), TRUE );
//var_dump( $tx_results['result']['data'] ); // DEBUGGING

store_txblock($tx_results['result']['data']);


///////////////////////////////////////////////////////


	// Add any older DS blocks not already in the DB 150 per session, near top of hour AND bottom of hour (first sync etc)...
	
	if ( date(i) > 0 && date(i) < 15 || date(i) > 30 && date(i) < 45 ) {
		
		// Find first / oldest block
		$query = "SELECT * FROM ds_blocks ORDER BY timestamp ASC limit 1";
		
		if ($result = mysqli_query($db_connect, $query)) {
					while ( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ) {
						
			$first_dsblock = intval($row["blocknum"]);
			
					}
		
		mysqli_free_result($result);
		}
		$query = NULL;
		
		//echo $first_dsblock; // DEBUGGING
		
		if ( $first_dsblock > 0 ) {
		
			$dsblocks_fetch = array();
			$loop = 0;
			$get_block = $first_dsblock - 1;
			while ( $loop <= 150 && $get_block >= 0 ) {
			
			$dsblocks_fetch[] = array('BlockNum' => $get_block);
			
			$loop = $loop + 1;
			$get_block = $get_block - 1;
			}
								
		//var_dump( $dsblocks_fetch ); // DEBUGGING
		
		store_dsblock($dsblocks_fetch);
			
		}
	
	
	}
	
	///////////////////////////////////////////////////////
	
	
	// Add any older TX blocks not already in the DB 300 per session, near top of hour AND bottom of hour (first sync etc)...
	
	if ( date(i) > 0 && date(i) < 15 || date(i) > 30 && date(i) < 45 ) {
	
		// Find first / oldest block
		$query = "SELECT * FROM tx_blocks ORDER BY timestamp ASC limit 1";
		
		if ($result = mysqli_query($db_connect, $query)) {
					while ( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ) {
						
			$first_txblock = intval($row["blocknum"]);
			
					}
		
		mysqli_free_result($result);
		}
		$query = NULL;
		
		//echo $first_txblock; // DEBUGGING
		
		if ( $first_txblock > 0 ) {
		
			$txblocks_fetch = array();
			$loop = 0;
			$get_block = $first_txblock - 1;
			while ( $loop <= 300 && $get_block >= 0 ) {
			
			$txblocks_fetch[] = array('BlockNum' => $get_block);
			
			$loop = $loop + 1;
			$get_block = $get_block - 1;
			}
								
		//var_dump( $txblocks_fetch ); // DEBUGGING
		
		store_txblock($txblocks_fetch);
			
		}
	
	
	}
	
	///////////////////////////////////////////////////////
	
	
	// Search for any DS blocks sequentially missing near top and bottom of the hour...
	
	//echo date(i);  // DEBUGGING
	
	if ( date(i) > 45 && date(i) < 0 || date(i) > 15 && date(i) < 30 ) {
	
		// Find first / oldest block
		$query = "SELECT * FROM ds_blocks ORDER BY blocknum ASC limit 1";
		
		if ($result = mysqli_query($db_connect, $query)) {
					while ( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ) {
						
					$first_dsblock = intval($row["blocknum"]);
			
					}
		
		mysqli_free_result($result);
		}
		$query = NULL;
		
		// Scan for sequentially missing...
		$query = "SELECT * FROM ds_blocks ORDER BY blocknum ASC limit " . $error_scan;
		
		$missing_dsblocks = array();
		$loop = $first_dsblock;
		if ($result = mysqli_query($db_connect, $query)) {
					while ( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ) {
						
						if ( $row["blocknum"] > 0 && $row["blocknum"] != $loop ) {
							
						$missing = $row["blocknum"] - $loop;
						
							//echo $missing . '   ';  // DEBUGGING
							
							$seq = $missing;
							while ( $seq > 0 ) {
							$missing_dsblocks[] = array('BlockNum' => intval($row["blocknum"] - $seq));
							$seq = $seq - 1;
							}
							
						$loop = $loop + $missing; // Get back on proper loop number scanning
						}
			
					$loop = $loop + 1;
					}
		
		mysqli_free_result($result);
		}
		$query = NULL;
		
		//var_dump($missing_dsblocks); // DEBUGGING
		
		if ( sizeof($missing_dsblocks) > 0 ) {
		
		store_dsblock($missing_dsblocks);
			
		}
	
	
	}
	
	///////////////////////////////////////////////////////
	
	
	// Search for any TX blocks sequentially missing near top and bottom of the hour...
	
	//echo date(i);  // DEBUGGING
	
	if ( date(i) > 45 && date(i) < 0 || date(i) > 15 && date(i) < 30 ) {
	
		// Find first / oldest block
		$query = "SELECT * FROM tx_blocks ORDER BY blocknum ASC limit 1";
		
		if ($result = mysqli_query($db_connect, $query)) {
					while ( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ) {
						
					$first_txblock = intval($row["blocknum"]);
			
					}
		
		mysqli_free_result($result);
		}
		$query = NULL;
		
		// Scan for sequentially missing...
		$query = "SELECT * FROM tx_blocks ORDER BY blocknum ASC limit " . $error_scan;
		
		$missing_txblocks = array();
		$loop = $first_txblock;
		if ($result = mysqli_query($db_connect, $query)) {
					while ( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ) {
						
						if ( $row["blocknum"] > 0 && $row["blocknum"] != $loop ) {
							
						$missing = $row["blocknum"] - $loop;
						
							//echo $missing . '   ';  // DEBUGGING
							
							$seq = $missing;
							while ( $seq > 0 ) {
							$missing_txblocks[] = array('BlockNum' => intval($row["blocknum"] - $seq));
							$seq = $seq - 1;
							}
							
						$loop = $loop + $missing; // Get back on proper loop number scanning
						}
			
					$loop = $loop + 1;
					}
		
		mysqli_free_result($result);
		}
		$query = NULL;
		
		//var_dump($missing_txblocks); // DEBUGGING
		
		if ( sizeof($missing_txblocks) > 0 ) {
		
		store_txblock($missing_txblocks);
			
		}
	
	
	}


}
//API (JSON-RPC) -END-//////////////////////////////////////////////////////////////////


?>