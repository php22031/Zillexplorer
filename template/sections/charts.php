<?php
/*
 * Copyright 2018 GPLv3, Zillexplorer by Mike Kilday: http://DragonFrugal.com
 */
?>

  <div id="difficulty_chart"></div>
  <br/><br/>
  <div id="transaction_chart"></div>
  <br/><br/>
  <div id="gas_used_chart"></div>
  <br/><br/>
  <div id="micro_blocks_chart"></div>
  
<?php

use ZingChart\PHPWrapper\ZC;

// Difficulty chart data //////////////////////////

$zc = new ZC("difficulty_chart");

// Get ds data from db...
$diff_array = array('');
$dstime_array = array('');
$query = "SELECT difficulty,timestamp FROM ds_charts ORDER BY timestamp ASC";

if ($result = mysqli_query($db_connect, $query)) {
   while ( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ) {
   	
	 $diff_array[] = $row["difficulty"];
	 $dstime_array[] = date('Y-n-j', substr($row["timestamp"], 0, 10));
	
   }
mysqli_free_result($result);
}
$query = NULL;

$zc->setSeriesData(0, $diff_array);
$zc->setSeriesText( array("Difficulty") );
$zc->setChartType("line");
$zc->setChartTheme("classic");
$zc->setChartWidth("100%");
$zc->setChartHeight("400");
$zc->setTitle("Network Difficulty");
$zc->setScaleYTitle("Difficulty");
$zc->setScaleXLabels( $dstime_array );
$zc->render();

// Transaction chart data //////////////////////////

$zc2 = new ZC("transaction_chart");

// Get tx data from db...
$gas_used_array = array('');
$micro_blocks_array = array('');
$txamount_array = array('');
$txtime_array = array('');
$query = "SELECT gas_used,micro_blocks,transactions,timestamp FROM tx_charts ORDER BY timestamp ASC";

if ($result = mysqli_query($db_connect, $query)) {
   while ( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ) {
   	
	 $gas_used_array[] = $row["gas_used"];
	 $micro_blocks_array[] = $row["micro_blocks"];
	 $txamount_array[] = $row["transactions"];
	 $txtime_array[] = date('Y-n-j', substr($row["timestamp"], 0, 10));
	
   }
mysqli_free_result($result);
}
$query = NULL;

$zc2->setSeriesData(0, $txamount_array);
$zc2->setSeriesText( array("Transactions") );
$zc2->setChartType("line");
$zc2->setChartTheme("classic");
$zc2->setChartWidth("100%");
$zc2->setChartHeight("400");
$zc2->setTitle("Transaction Amounts");
$zc2->setScaleYTitle("Transactions");
$zc2->setScaleXLabels( $txtime_array );
$zc2->render();

// Gas Used chart data //////////////////////////

$zc3 = new ZC("gas_used_chart");
$zc3->setSeriesData(0, $gas_used_array);
$zc3->setSeriesText( array("Gas Used") );
$zc3->setChartType("line");
$zc3->setChartTheme("classic");
$zc3->setChartWidth("100%");
$zc3->setChartHeight("400");
$zc3->setTitle("Transaction Gas Used");
$zc3->setScaleYTitle("Gas Used");
$zc3->setScaleXLabels( $txtime_array );
$zc3->render();

// Gas Used chart data //////////////////////////

$zc4 = new ZC("micro_blocks_chart");
$zc4->setSeriesData(0, $micro_blocks_array);
$zc4->setSeriesText( array("Micro Blocks") );
$zc4->setChartType("line");
$zc4->setChartTheme("classic");
$zc4->setChartWidth("100%");
$zc4->setChartHeight("400");
$zc4->setTitle("Micro Block Amounts");
$zc4->setScaleYTitle("Micro Blocks");
$zc4->setScaleXLabels( $txtime_array );
$zc4->render();

//////////////////////////////////////////////////////

?>