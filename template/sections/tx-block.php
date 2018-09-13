<?php
/*
 * Copyright 2018 GPLv3, Zillexplorer by Mike Kilday: http://DragonFrugal.com
 */
 
 
$next_block = $_GET['txblock'] + 1;
$txblock_request = json_request('GetTxBlock', array( (string)$next_block )  );
$txblock_results = json_decode( @get_data('array', $txblock_request, 0), TRUE );
//var_dump( $txblock_results ); // DEBUGGING
if ( $txblock_results['result']['header']['Timestamp'] == 0 ) {
$no_next_block = 1;
}

$prev_block = $_GET['txblock'] - 1;
if ( $prev_block < 0 ) {
$no_prev_block = 1;
}

?>
      
      <h3><b>TX Block #<?=$_GET['txblock']?></b></h3>
      <h5><!-- <span class="label label-danger">Lorem</span> --> <span class="label label-primary">TX Block</span></h5>
      

<nav aria-label="Page navigation">
  <ul class="pagination">
    <li class="page-item"><a class="page-link" href="/list-txblocks/">All Blocks</a></li>
    <li class="page-item"><a class="page-link <?=( $no_prev_block ? 'disabled' : '' )?>" href="<?=( $no_prev_block ? '#' : ($_GET['txblock'] - 1) )?>">Previous Block</a></li>
    <li class="page-item"><a class="page-link <?=( $no_next_block ? 'disabled' : '' )?>" href="<?=( $no_next_block ? '#' : ($_GET['txblock'] + 1) )?>">Next Block</a></li>
  </ul>
</nav> 

      
		<div class="col-xs-12 col-md-auto border-rounded no-padding zebra-stripe relative-table">

			<div style="padding: 7px;"><h4>TX Block</h4></div>
      
      <?php

      $txblock_request = json_request('GetTxBlock', array( $_GET['txblock'] )  );
      $txblock_results = json_decode( @get_data('array', $txblock_request, 525600), TRUE ); // Cache one year
      //var_dump( $txblock_results ); // DEBUGGING


		if ( $txblock_results['result']['header']['Timestamp'] == 0 ) { // Timestamp uppercase on API for some reason
		
      $txblock_request = json_request('GetTxBlock', array( $_GET['txblock'] )  );
      $txblock_results = json_decode( @get_data('array', $txblock_request, -1), TRUE ); // Delete cache
      
		?>
		<div class="stats-row"><b>Block #<?=$_GET['txblock']?> does not exist.</b></div>
		<?php
		}
		else {
      
      
      	foreach ( $txblock_results as $key => $value ) {
      	
      		if ( $key == 'result' ) {
      			
    				$i = 0;
      			foreach ( $value as $key2 => $value2 ) { // Results arrays depth 0
      				
      			// Doesn't reset pointer in foreach loop
      			$num_items = sizeof($value);
    				$i = $i + 1;
      				if($i == $num_items) {
    					$last = 1;
  						}
    				//echo $i.'!';
      				
      				if ( is_array($value2) ) {
      				?>
      	
  						<div class="stats-row"><h4><b><?=ucfirst($key2)?>:</b></h4></div>
  		
  						<?php
      					
    						$i2 = 0;
      					foreach ( $value2 as $key3 => $value3 ) { // Results arrays depth 1
      					
      					// Doesn't reset pointer in foreach loop
      					$num_items2 = sizeof($value2);
    						$i2 = $i2 + 1;
      						if($i2 == $num_items2) {
    							$last2 = 1;
  								}
    						//echo $i2.'!';
      						
      						if ( is_array($value3) ) {
      							
      						?>
      	
  								<div class="stats-row is-1deep"><b><?=ucfirst($key3)?>:</b></span></div>
  		
  								<?php
  								
    								$i3 = 0;
  									foreach ( $value3 as $key4 => $value4 ) { // Results arrays depth 2
      					
      							// Doesn't reset pointer in foreach loop
      							$num_items3 = sizeof($value3);
    								$i3 = $i3 + 1;
      								if($i3 == $num_items3) {
    									$last3 = 1;
  										}
    								//echo $i3.'!';
      							
    									if ( is_array($value4) ) {	
      								echo 'Code array parsing needed here.';
      								}
      								else {
      								?>
      					
      							<div class="stats-row is-2deep"><b> &equals;&gt;&nbsp; <?=ucfirst($key4)?>:</b> <?=$value4?></div>
      							
      							<?php
      								}
      								
  									}
  									$last3 = NULL;
      	
      						}
      						else {
					      	
					      	 	if ( strtolower($key3) == 'timestamp' ) {
      							?>
      					
      							<div class="stats-row is-1deep"><b><?=ucfirst($key3)?>:</b> <?=$value3?> (<?=date('M jS, Y @ H:i:s T', substr($value3, 0, 10))?>)</div>
      				 
      							<?php
					      	 	} 
					      	 	else {
      					?>
      					
      							<div class="stats-row is-1deep"><b><?=ucfirst($key3)?>:</b> <?=( preg_match("/num/i", $key3) ? number_format($value3) : $value3 )?></div>
      				 
      				<?php
      							}
      						}
      						
      					}
  							$last2 = NULL;
      					
      				}
      				else {
      				?>
      					
      					<div class="stats-row"><b><?=ucfirst($key2)?>:</b> <?=$value2?></div>
      				 
      				<?php
      				}
      		
      			}
  					$last = NULL;
      			
      		}
      	
      	}
      	
      	
      	
      }
      	?>
      	
      </div>
      