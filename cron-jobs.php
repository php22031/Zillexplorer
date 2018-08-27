<?php
/*
 * Copyright 2018 GPLv3, Zillexplorer by Mike Kilday: http://DragonFrugal.com
 */
 

// Forbid direct access to cron.php
if ( realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME']) ) {
  header('HTTP/1.0 403 Forbidden', TRUE, 403);
  exit;
}

include('config.php'); 

// CHARTS ////////////////////////////////////////////////////////////////////////////////


///////DS BLOCKS////////////////

$dsblocks_data = json_request('DSBlockListing', array(1) );
$dsblocks_results = json_decode( @get_data('array', $dsblocks_data), TRUE );      
//var_dump( $dsblocks_results ); // DEBUGGING

foreach ( $dsblocks_results['result']['data'] as $key => $value ) {

// Singular
$dsblock_request = json_request('GetDsBlock', array( strval($value['BlockNum']) )  );
$dsblock_results = json_decode( @get_data('array', $dsblock_request), TRUE );
//var_dump( $dsblock_results['result']['header'] ); // DEBUGGING

$ds_block_header = $dsblock_results['result']['header'];

	// Run checks...
	
	$query = "SELECT * FROM ds_charts WHERE blocknum = '".$ds_block_header['blockNum']."'";
	
	if ($result = mysqli_query($db_connect, $query)) {
	   while ( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ) {
	   	
		$dsblock_already_stored = 1;
		
		 //echo $row["blocknum"]." ".$row["difficulty"]."<br />";
		
	   }
	mysqli_free_result($result);
	}
	$query = NULL;
	
	if ( !$dsblock_already_stored ) {
	
	$query = "INSERT INTO ds_charts (id, blocknum, difficulty, timestamp) VALUES ('', '".$ds_block_header['blockNum']."', '".$ds_block_header['difficulty']."', '".$ds_block_header['timestamp']."')";
	
	//echo "<p>" . $query . "</p>\n";
	$sql_result = mysqli_query($db_connect, $query);
	
	}

$dsblock_already_stored = NULL;
}


////////TX BLOCKS///////////////


// Plural
$txblocks_data = json_request('TxBlockListing', array(1) );
$txblocks_results = json_decode( @get_data('array', $txblocks_data), TRUE );
//var_dump( $txblocks_results ); // DEBUGGING

foreach ( $txblocks_results['result']['data'] as $key => $value ) {

// Singular
$txblock_request = json_request('GetTxBlock', array( strval($value['BlockNum']) )  );
$txblock_results = json_decode( @get_data('array', $txblock_request), TRUE );
//var_dump( $txblock_results['result']['header'] ); // DEBUGGING

$tx_block_header = $txblock_results['result']['header'];

	// Run checks...
	
	$query = "SELECT * FROM tx_charts WHERE blocknum = '".$tx_block_header['BlockNum']."'";
	
	if ($result = mysqli_query($db_connect, $query)) {
	   while ( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ) {
	   	
		$txblock_already_stored = 1;
		
		 //echo $row["blocknum"]." ".$row["transactions"]."<br />";
		
	   }
	mysqli_free_result($result);
	}
	$query = NULL;
	
	if ( !$txblock_already_stored ) {
	
	$query = "INSERT INTO tx_charts (id, blocknum, gas_used, micro_blocks, transactions, timestamp) VALUES ('', '".$tx_block_header['BlockNum']."', '".$tx_block_header['GasUsed']."', '".$tx_block_header['NumMicroBlocks']."', '".$tx_block_header['NumTxns']."', '".$tx_block_header['Timestamp']."')";
	
	//echo "<p>" . $query . "</p>\n";
	$sql_result = mysqli_query($db_connect, $query);
	
	}

$txblock_already_stored = NULL;
}


////////////////////////////////////////////////////////////////////////////////////////////



?>