<?php
/*
 * Copyright 2018 GPLv3, Zillexplorer by Mike Kilday: http://DragonFrugal.com
 */
?>
      
      <h3>DS Block #<?=trim($_GET['dsblock'])?></h3>
      <h5><span class="glyphicon glyphicon-time"></span> <?=date('Y-m-d h:i:sa')?></h5>
      <h5><!-- <span class="label label-danger">Lorem</span> --> <span class="label label-primary">DS Block</span></h5>
      
      <p>
      <table width='100%' border='2'>
      
      <?php

		$dsblock_request = json_request('GetDsBlock', array( trim($_GET['dsblock']) ) );
      $dsblock_results = json_decode( @get_data('array', $dsblock_request), TRUE );
      //var_dump( $dsblock_results ); // DEBUGGING

      
      	foreach ( $dsblock_results as $key => $value ) {
      	
      		if ( $key == 'result' ) {
      			
      			foreach ( $value as $key2 => $value2 ) { // Results arrays depth 0
      				
      				if ( is_array($value2) ) {			
      				?>
      	
  						<tr><th class='table-header'> <h3><?=ucfirst($key2)?></h3></th></tr>
  		
  						<?php
      					
      					foreach ( $value2 as $key3 => $value3 ) { // Results arrays depth 1
      					
      					?>
      					
      					<tr><td class='no-border'><span style='padding: 4px; display: block;'><b><?=ucfirst($key3)?>:</b> <?=$value3?></a></span></td></tr>
      				<?php
      					}
      					
      				}
      				else {
      				?>
      					
      					<tr><td class='no-border'><span style='padding: 4px; display: block;'><b><?=ucfirst($key2)?>:</b> <?=$value2?></a></span></td></tr>
      				<?php
      				}
      		
      			}
      			
      		}
      	
      	}
      	?>
      
      </table>
      
      </p>
      