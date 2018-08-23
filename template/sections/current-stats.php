<?php
/*
 * Copyright 2018 GPLv3, Zillexplorer by Mike Kilday: http://DragonFrugal.com
 */
?>

      <h2>Zilliqa Network Stats</h2>
      <h5><span class="glyphicon glyphicon-time"></span> <?=date('Y-m-d h:i:sa')?></h5>
      <h5><!-- <span class="label label-danger">Lorem</span> --> <span class="label label-primary">Stats</span></h5>
      <p>
      
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
      
      <table width='100%' border='2'>
    		
  		<tr><th class='table-header'> <h3>Network:</h3></th></tr>
  		
      		<tr><td class='no-border'><span style='padding: 4px; display: block;'><b>API Server:</b> <?=$api_server?></a></span></td></tr>
      <?php
      
      	foreach ( $network_id_results as $key => $value ) {
      	
      		if ( $key == 'result' ) {
					      	
      		?>
      					
      		<tr><td class='no-border'><span style='padding: 4px; display: block;'><b>Network ID:</b> <?=$network_id_results[$key]?></a></span></td></tr>
      				 
      		<?php
      			
      		}
      	
      	}
      	
      	////////////////////////////////////////////////////////////////
      
      
      	foreach ( $blockchain_results as $key => $value ) {
      	
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
      					
      							<tr><td class='no-border'><span style='padding: 4px; display: block;'><b><?=ucfirst($key4)?>:</b> <?=$value4?></a></span></td></tr>	
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
      	
      	////////////////////////////////////////////////////////////////
      	
      	?>
      	
  		<tr><th class='table-header'> <h3>Latest DS Blocks:</h3></th></tr>
  		
  		<?php
      
      	foreach ( $dsblocks_results as $key => $value ) {
      	
      		if ( $key == 'result' ) {
      			
      			foreach ( $value as $key2 => $value2 ) {
      				
      		?>
      		
      		<tr><td class='no-border'> 
      		
      		<?php		
							$loop = 0;
					      while ( $loop < $stats_max )	{
					      	
					      	if ( $value2[$loop]['BlockNum'] != '' ) {
      					?>
      					
      					<span style='padding: 4px; display: block;'><a href='/dsblock/<?=$value2[$loop]['BlockNum']?>'>DS Block #<?=$value2[$loop]['BlockNum']?></a></span>
      					
      					<?php
      						}
      					
      					$loop = $loop + 1;
      					}
      					?>
      					
      				 </td></tr>
      				 
      				<?php
      		
      			}
      			
      		}
      		
      	}
      	$loop = NULL;
      	
      	////////////////////////////////////////////////////////////////
      	
      	?>
      	
  		<tr><th class='table-header'> <h3>Latest TX Blocks:</h3></th></tr>
  		
  		<?php
      	
      
      	foreach ( $txblocks_results as $key => $value ) {
      	
      		if ( $key == 'result' ) {
      			
      			foreach ( $value as $key2 => $value2 ) {
      				
      		?>
      		
      		<tr><td class='no-border'> 
      		
      		<?php		
							$loop = 0;
					      while ( $loop < $stats_max )	{
					      	
					      	if ( $value2[$loop]['BlockNum'] != '' ) {
      						?>
      					
      						<span style='padding: 4px; display: block;'><a href='/txblock/<?=$value2[$loop]['BlockNum']?>'>TX Block #<?=$value2[$loop]['BlockNum']?></a></span>
      					
      						<?php
      						}
      					
      					$loop = $loop + 1;
      					}
      					?>
      					
      				 </td></tr>
      				 
      				<?php
      		
      			}
      			
      		}
      	
      	}
      	$loop = NULL;
      	
      	////////////////////////////////////////////////////////////////
      	
      	?>
      	
  		<tr><th class='table-header'> <h3>Latest Transactions:</h3></th></tr>
  		
  		<?php
      
      	foreach ( $recent_transaction_results as $key => $value ) {
      	
      		if ( $key == 'result' ) {
      			
      			foreach ( $value as $key2 => $value2 ) {
      				
      				if ( $key2 == 'TxnHashes' ) {
      				?>
      		
      				<tr><td class='no-border'> 
      		
      				<?php		
      				
							$loop = 0;
					      while ( $loop < $stats_max )	{
					      	
      					?>
      					
      					<span style='padding: 4px; display: block;'><a href='/tx/<?=$value2[$loop]?>'><?=$value2[$loop]?></a></span>
      					
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
      </p>