<?php
/*
 * Copyright 2018 GPLv3, Zillexplorer by Mike Kilday: http://DragonFrugal.com
 */
?>
      
      <h3><b>TX Block #<?=trim($_GET['txblock'])?></b></h3>
      <h5><span class="glyphicon glyphicon-time"></span> <?=date('Y-m-d h:i:sa')?></h5>
      <h5><!-- <span class="label label-danger">Lorem</span> --> <span class="label label-primary">TX Block</span></h5>
      
      <p>
      <table class='blockchain-tables' width='100%' border='2'>
      
      <?php

      $txblock_request = json_request('GetTxBlock', array( trim($_GET['txblock']) )  );
      $txblock_results = json_decode( @get_data('array', $txblock_request), TRUE );
      //var_dump( $txblock_results ); // DEBUGGING

      
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
      	
  						<tr><th class='table-header'> <h4><b><?=ucfirst($key2)?>:</b></h4></th></tr>
  		
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
      	
  								<tr><th class='table-header-1deep'><span class='span-block'><b><?=ucfirst($key3)?>:</b></span></th></tr>
  		
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
      					
      							<tr><td class='<?=( $last3 == 1 && $last2 == 1 && $last == 1 ? 'u-borders-2deep' : 'side-borders-2deep' )?>'><span class='span-block'><b> --&gt; <?=ucfirst($key4)?>:</b> <?=$value4?></a></span></td></tr>
      							
      							<?php
      								}
      								
  									}
  									$last3 = NULL;
      	
      						}
      						else {
					      	
      					?>
      					
      					<tr><td class='<?=( $last2 == 1 && $last == 1 ? 'u-borders-1deep' : 'side-borders-1deep' )?>'><span class='span-block'><b><?=ucfirst($key3)?>:</b> <?=$value3?></a></span></td></tr>
      				 
      				<?php
      						}
      						
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
      