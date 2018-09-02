<?php
/*
 * Copyright 2018 GPLv3, Zillexplorer by Mike Kilday: http://DragonFrugal.com
 */
 
//var_dump($_GET); // DEBUGGING

// Support /slug/1 page structure
$current_page = ( !$_GET['url_var'] || $_GET['url_var'] < 1 ? 1 : $_GET['url_var'] );

// DS block row count for pagination
$query = "SELECT COUNT(blocknum) as block_count FROM ds_blocks";
if ($result = mysqli_query($db_connect, $query)) {
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

$block_count = $row['block_count'];

mysqli_free_result($result);
}
$query = NULL;

$page_count = ceil($block_count / $paginated_rows);  
  
?>


      
      <h3><b>DS Blocks (<?=number_format($block_count)?> total)</b></h3>
      <h5><!-- <span class="label label-danger">Lorem</span> --> <span class="label label-primary">DS Block</span></h5>
      
      <?php

// Find first / oldest block
$query = "SELECT * FROM ds_blocks ORDER BY timestamp ASC limit 1";

if ($result = mysqli_query($db_connect, $query)) {
	
		while ( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ) {
				
		$first_dsblock = intval($row["blocknum"]);

		}

mysqli_free_result($result);
}
$query = NULL;


if ( $first_dsblock > 0 ) {
?>

			<div style="padding: 7px;"><b style='color: red;'>Server is currently re-caching all <i>older</i> DS blocks a couple times per hour. Some older blocks will be missing from the cache until this is completed (current oldest block cached is block #<?=$first_dsblock?>). You can still use the search feature to lookup detailed block information <i>on any block</i>.</b></div>
			
<?php
}
      
      ?>
      
<?=pagination($current_page, $page_count)?>

      <div class="col-xs-12 col-md-auto border-rounded no-padding zebra-stripe relative-table">

			<div style="padding: 7px;"><h4>DS Blocks</h4></div>
			
			
		<div class="data-row" style='height: 40px; clear: both;'>
			
			<table width='100%' style='min-width: 400px;'>
			<tr>
			
				<th class="row-sections" style='width: 20%;'>
				<b>Number</b>
				</th>
			
				<th class="row-sections" style='width: 20%;'>
				<b>Difficulty</b>
				</th>
				
				<th class="row-sections" style='width: 60%;'>
				<b>Timestamp</b>
				</th>
			
			
			
			</tr>
			</table>
		</div>
<?php


// Find newest block
$query = "SELECT * FROM ds_blocks ORDER BY timestamp DESC limit 1";

if ($result = mysqli_query($db_connect, $query)) {
	
		while ( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ) {
				
		$last_dsblock = intval($row["blocknum"]);

		}

mysqli_free_result($result);
}
$query = NULL;


// DS block data
$query = "SELECT blocknum,difficulty,timestamp FROM ds_blocks WHERE blocknum > '".( $last_dsblock - ( $current_page * $paginated_rows ) )."' AND blocknum <= '".( $last_dsblock - ( $current_page * $paginated_rows ) + $paginated_rows )."' ORDER BY blocknum DESC limit " . $paginated_rows;

//echo $query; // DEBUGGING

if ($result = mysqli_query($db_connect, $query)) {
   while ( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ) {
   	
   	
		?>
		<div class="data-row" style='height: 45px; clear: both;'>
			
			<table width='100%' style='min-width: 400px;'>
			<tr>
				<td class="row-sections" style='width: 20%;'>
				<a href='/dsblock/<?=$row["blocknum"]?>'>#<?=$row["blocknum"]?></a>
				</td>
			
				<td class="row-sections" style='width: 20%;'>
				<?=$row["difficulty"]?>
				</td>
				
				<td class="row-sections" style='width: 60%;'>
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
      
<?=pagination($current_page, $page_count)?>

