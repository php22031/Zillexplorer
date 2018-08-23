<?php
/*
 * Copyright 2018 GPLv3, Zillexplorer by Mike Kilday: http://DragonFrugal.com
 */
?>
      
      <h3>TX Block #<?=trim($_GET['txblock'])?></h3>
      <h5><span class="glyphicon glyphicon-time"></span> <?=date('Y-m-d h:i:sa')?></h5>
      <h5><!-- <span class="label label-danger">Lorem</span> --> <span class="label label-primary">TX Block</span></h5>
      
      <p>
      <table width='100%' border='2'>
      
      <?php

      $txblock_request = json_request('GetTxBlock', array( trim($_GET['txblock']) )  );
      $txblock_results = json_decode( @get_data('array', $txblock_request), TRUE );
      //var_dump( $txblock_results ); // DEBUGGING

      
      	foreach ( $txblock_results as $key => $value ) {
      	
      		if ( $key == 'result' ) {
      			
      			foreach ( $value as $key2 => $value2 ) { // Results arrays depth 0
      				
      				if ( is_array($value2) ) {
      				?>
      	
  						<tr><th class='table-header'> <h3><?=ucfirst($key2)?>:</h3></th></tr>
  		
  						<?php
      					
      					foreach ( $value2 as $key3 => $value3 ) { // Results arrays depth 1
      						
      						if ( is_array($value3) ) {
      							
      				?>
      	
  		<tr><th class='table-header'> <h4><?=ucfirst($key3)?>:</h4></th></tr>
  		
  		<?php
  									foreach ( $value3 as $key4 => $value4 ) { // Results arrays depth 2
      							?>
      					
      							<tr><td class='no-border'><span style='padding: dsblock4px; display: block;'><b><?=ucfirst($key4)?>:</b> <?=$value4?></a></span></td></tr>
      							<?php
  									}
      	
      						}
      						else {
					      	
      					?>
      					
      					<tr><td class='no-border'><span style='padding: 4px; display: block;'><b><?=ucfirst($key3)?>:</b> <?=$value3?></a></span></td></tr>
      				 
      				<?php
      						}
      						
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
      