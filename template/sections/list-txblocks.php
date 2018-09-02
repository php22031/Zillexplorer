<?php
/*
 * Copyright 2018 GPLv3, Zillexplorer by Mike Kilday: http://DragonFrugal.com
 */
 
//var_dump($_GET); // DEBUGGING

$current_page = $_GET['url_var'];

// Support /slug/1 page structure
$current_page = ( !$current_page || $current_page < 1 ? 1 : $current_page );

$row_max = 15; // Number of db results per page

$link_max = 10; // Number of pagination links

// TX block row count for pagination
$query = "SELECT COUNT(blocknum) as block_count FROM tx_blocks";
if ($result = mysqli_query($db_connect, $query)) {
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$block_count = $row['block_count'];
mysqli_free_result($result);
}
$query = NULL;

$page_count = ceil($block_count / $row_max);  
  
?>


      
      <h3><b>TX Blocks (<?=number_format($block_count)?> total)</b></h3>
      <h5><!-- <span class="label label-danger">Lorem</span> --> <span class="label label-primary">TX Block</span></h5>
      
      <div class="col-xs-12 col-md-auto border-rounded no-padding zebra-stripe relative-table">

			<div style="padding: 7px;"><h4>TX Blocks</h4></div>
			
			
		<div class="data-row" style='height: 40px; clear: both;'>
			
			<table width='100%' style='min-width: 650px;'>
			<tr>
			
				<th class="row-sections" style='width: 15%;'>
				<b>Number</b>
				</th>
			
				<th class="row-sections" style='width: 15%;'>
				<b>Gas Used</b>
				</th>
				</th>
			
				<th class="row-sections" style='width: 17%;'>
				<b>Microblocks</b>
				</th>
				</th>
			
				<th class="row-sections" style='width: 17%;'>
				<b>Transactions</b>
				</th>
				
				<th class="row-sections" style='width: 36%;'>
				<b>Timestamp</b>
				</th>
			
			
			
			</tr>
			</table>
		</div>
<?php

// TX block data
$query = "SELECT blocknum,gas_used,micro_blocks,transactions,timestamp FROM tx_blocks WHERE blocknum >= '".( ($current_page - 1) * $row_max)."' ORDER BY blocknum ASC limit " . $row_max;

//echo $query; //DEBUGGING

if ($result = mysqli_query($db_connect, $query)) {
   while ( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ) {
   	
   	
		?>
		<div class="data-row" style='height: 45px; clear: both;'>
			
			<table width='100%' style='min-width: 650px;'>
			<tr>
				<td class="row-sections" style='width: 15%;'>
				<a href='/txblock/<?=$row["blocknum"]?>'>#<?=$row["blocknum"]?></a>
				</td>
			
				<td class="row-sections" style='width: 15%;'>
				<?=$row["gas_used"]?>
				</td>
			
				<td class="row-sections" style='width: 17%;'>
				<?=$row["micro_blocks"]?>
				</td>
			
				<td class="row-sections" style='width: 17%;'>
				<?=$row["transactions"]?>
				</td>
				
				<td class="row-sections" style='width: 36%;'>
				<?=$row["timestamp"]?> (<?=date('M jS, Y @ H:i:s T', substr($row["timestamp"], 0, 10))?>)
				</td>
			</tr>
			</table>
		</div>
				
		<?php
	 	
	
   }
mysqli_free_result($result);
}
$query = NULL;

?>
      
      </div>
      
<?=pagination($current_page, $link_max, $page_count)?>

