<?php
/*
 * Copyright 2018 GPLv3, Zillexplorer by Mike Kilday: http://DragonFrugal.com
 */
?>

      <h3><b>Zilliqa Network Stats</b></h3>
      <h5><span class="glyphicon glyphicon-time"></span> <?=date('Y-m-d h:i:sa')?></h5>
      <h5><!-- <span class="label label-danger">Lorem</span> --> <span class="label label-primary">Stats</span></h5>
      
      
      <?php
      
      $network_id_data = json_request('GetNetworkId', array('') );
      $network_id_results = json_decode( @get_data('array', $network_id_data), TRUE );
      //var_dump( $network_id_results ); // DEBUGGING
      
      $blockchain_data = json_request('GetBlockchainInfo', array('') );
      $blockchain_results = json_decode( @get_data('array', $blockchain_data), TRUE );
      //var_dump( $blockchain_results ); // DEBUGGING
      
      $dsblocks_data = json_request('DSBlockListing', array(1) );
      $dsblocks_results = json_decode( @get_data('array', $dsblocks_data), TRUE );      
      //var_dump( $dsblocks_results ); // DEBUGGING
      
      $txblocks_data = json_request('TxBlockListing', array(1) );
      $txblocks_results = json_decode( @get_data('array', $txblocks_data), TRUE );
      //var_dump( $txblocks_results ); // DEBUGGING
      
      $recent_transaction_data = json_request('GetRecentTransactions', array('') );
      $recent_transaction_results = json_decode( @get_data('array', $recent_transaction_data), TRUE );
      //var_dump( $recent_transaction_results ); // DEBUGGING
      
      ?>
      
          
      
      <table id='stats_table_1' width='auto' height='100%' border='0' class='floating-table'>
      <tr colspan='2'>
      <td valign="top">
    		
    		<table class='stats-tables' height='100%' style='margin-top: 3px; min-width: 300px; max-width: 300px;' border='1'>
  			<tr><th class='table-header'> <h4><b>Network:</b></h4></th></tr>
  		
      		<tr><td valign="top" class='side-borders'><span class='span-block'><b>API Server:</b> <?=$api_server?></a></span></td></tr>
      <?php
      
      	foreach ( $network_id_results as $key => $value ) {
      	
      		if ( $key == 'result' ) {
					      	
      		?>
      					
      		<tr><td class='side-borders'><span class='span-block'><b>Network ID:</b> <?=$network_id_results[$key]?></a></span></td></tr>
      				 
      		<?php
      			
      		}
      	
      	}
      	
      	////////////////////////////////////////////////////////////////
      
      
      	foreach ( $blockchain_results as $key => $value ) {
      	
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
      	
  						<tr><td class='side-borders'><span class='span-block'><b><?=ucfirst($key2)?>:</b></span></td></tr>
  		
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
      	
  								<tr><td class='side-borders-1deep'><span class='span-block'><b> --&gt; <?=ucfirst($key3)?>:</b></span></td></tr>
  		
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
      	
      	////////////////////////////////////////////////////////////////
      	
      	?>
      		</table>
      		
      	</td>      		
      	<td valign="top">
      	
      		<table class='stats-tables' height='100%' style='margin-top: 3px; height: 50%; min-width: 190px; max-width: 190px;' border='1'>
  				<tr><th class='table-header'> <h4><b>Latest DS Blocks:</b></h4></th></tr>
  		
  		<?php
      
      	foreach ( $dsblocks_results as $key => $value ) {
      	
      		if ( $key == 'result' ) {
      			
    				$i = 0;
      			foreach ( $value as $key2 => $value2 ) {
      				
      			// Doesn't reset pointer in foreach loop
      			$num_items = sizeof($value);
    				$i = $i + 1;
      				if($i == $num_items) {
    					$last = 1;
  						}
    				//echo $i.'!';
      				
      		?>
      		
      		<tr><td valign="top" class='<?=( $last == 1 ? 'u-borders' : 'side-borders' )?>'> 
      		
      		<?php		
							$loop = 0;
					      while ( $loop < $stats_max )	{
					      	
					      	if ( $value2[$loop]['BlockNum'] != '' ) {
      					?>
      					
      					<span class='span-block'><a href='/dsblock/<?=$value2[$loop]['BlockNum']?>'>DS Block #<?=$value2[$loop]['BlockNum']?></a></span>
      					
      					<?php
      						}
      					
      					$loop = $loop + 1;
      					}
      					?>
      					
      				 </td></tr>
      				 
      				<?php
      		
      			}
  					$last = NULL;
      			
      		}
      		
      	}
      	$loop = NULL;
      	
      	////////////////////////////////////////////////////////////////
      	
      	?>
      		</table>
      
      		<table class='stats-tables' style='margin-top: 12px; height: auto; min-width: 190px; max-width: 190px;' border='1'>
      	
  				<tr><th class='table-header'> <h4><b>Latest TX Blocks:</b></h4></th></tr>
  		
  		<?php
      	
      
      	foreach ( $txblocks_results as $key => $value ) {
      	
      		if ( $key == 'result' ) {
      			
    				$i = 0;
      			foreach ( $value as $key2 => $value2 ) {
      				
      			// Doesn't reset pointer in foreach loop
      			$num_items = sizeof($value);
    				$i = $i + 1;
      				if($i == $num_items) {
    					$last = 1;
  						}
    				//echo $i.'!';
      				
      		?>
      		
      		<tr><td valign="top" class='<?=( $last == 1 ? 'u-borders' : 'side-borders' )?>'> 
      		
      		<?php		
							$loop = 0;
					      while ( $loop < $stats_max )	{
					      	
					      	if ( $value2[$loop]['BlockNum'] != '' ) {
      						?>
      					
      						<span class='span-block'><a href='/txblock/<?=$value2[$loop]['BlockNum']?>'>TX Block #<?=$value2[$loop]['BlockNum']?></a></span>
      					
      						<?php
      						}
      					
      					$loop = $loop + 1;
      					}
      					?>
      					
      				 </td></tr>
      				 
      				<?php
      		
      			}
  					$last = NULL;
      			
      		}
      	
      	}
      	$loop = NULL;
      	
      	////////////////////////////////////////////////////////////////
      	
      	?>
      		</table>
      		
      
     </td>
      
     </tr></table>		
     
     
      		
      <table id='stats_table_2' width='auto' border='0' style='margin-top: 3px;' class='floating-table'>
      <tr>
      <td valign="top">
      
      		<table width='auto' height='100%' class='stats-tables' border='1'>
      	
  				<tr><th class='table-header'> <h4><b>Latest Transactions:</b></h4></th></tr>
  		
  		<?php
      
      	foreach ( $recent_transaction_results as $key => $value ) {
      	
      		if ( $key == 'result' ) {
      			
      			foreach ( $value as $key2 => $value2 ) {
      				
      				
      				if ( $key2 == 'TxnHashes' ) {
      				?>
      		
      				<tr><td valign="top" class='u-borders'> 
      		
      				<?php		
      				
							$loop = 0;
					      while ( $loop < $stats_max )	{
					      	
      					?>
      					
      					<span class='span-block'><a href='/tx/<?=$value2[$loop]?>'><?=$value2[$loop]?></a></span>
      					
      					<?php
      					
      					$loop = $loop + 1;
      					}
      					?>
      					
      				 </td></tr>
      				 
      				<?php
						}		
      		
      			}
      			
      		}
      	
      	}
      	$loop = NULL;
      
      ?>
      
      	</table>
      		
      </td>
      </tr>
      </table>
      
      <br/ clear='all'>
      <br/ >