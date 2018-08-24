<?php
/*
 * Copyright 2018 GPLv3, Zillexplorer by Mike Kilday: http://DragonFrugal.com
 */
?>
      
      <h3><b>DS Block #<?=trim($_GET['dsblock'])?></b></h3>
      <h5><span class="glyphicon glyphicon-time"></span> <?=date('Y-m-d h:i:sa')?></h5>
      <h5><!-- <span class="label label-danger">Lorem</span> --> <span class="label label-primary">DS Block</span></h5>
      
      <p>
      <table class='blockchain-tables' width='100%' border='2'>
      
      <?php

		$dsblock_request = json_request('GetDsBlock', array( trim($_GET['dsblock']) ) );
      $dsblock_results = json_decode( @get_data('array', $dsblock_request), TRUE );
      //var_dump( $dsblock_results ); // DEBUGGING

      
      	foreach ( $dsblock_results as $key => $value ) {
      	
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
      	
  						<tr><th class='table-header'> <h4><b><?=ucfirst($key2)?></b></h4></th></tr>
  		
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
      					?>
      					
      					<tr><td class='<?=( $last2 == 1 ? 'u-borders-1deep' : 'side-borders-1deep' )?>'><span class='span-block'><b><?=ucfirst($key3)?>:</b> <?=$value3?></a></span></td></tr>
      				<?php
      					}
      					$last2 = NULL;
      					
      				}
      				else {
      				?>
      					
      				<tr><td class='<?=( $last == 1 ? 'u-borders' : 'side-borders' )?>'><span class='span-block'><b><?=ucfirst($key2)?>:</b> <?=$value2?></a></span></td></tr>
      				<?php
      				}
      		
      			}
      			$last = NULL;
      			
      		}
      	
      	}
      	?>
      
      </table>
      
      </p>
      