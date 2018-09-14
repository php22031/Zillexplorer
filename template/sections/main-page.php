<?php
/*
 * Copyright 2018 GPLv3, Zillexplorer by Mike Kilday: http://DragonFrugal.com
 */
?>

      <h3><b><?=htmlentities($title)?></b></h3>
      <h5><!-- <span class="label label-danger">Lorem</span> --> <span class="label label-primary">Stats</span></h5>
      
      
      <?php
      
      $network_id_data = json_request('GetNetworkId', array() );
      $network_id_results = json_decode( @get_data('array', $network_id_data, 10), TRUE );
      //var_dump( $network_id_results ); // DEBUGGING
      
      $blockchain_data = json_request('GetBlockchainInfo', array() );
      $blockchain_results = json_decode( @get_data('array', $blockchain_data, 5), TRUE );
      //var_dump( $blockchain_results ); // DEBUGGING
      
      $dsblocks_data = json_request('DSBlockListing', array(1) );
      $dsblocks_results = json_decode( @get_data('array', $dsblocks_data, 10), TRUE );      
      //var_dump( $dsblocks_results ); // DEBUGGING
      
      $txblocks_data = json_request('TxBlockListing', array(1) );
      $txblocks_results = json_decode( @get_data('array', $txblocks_data, 1), TRUE );
      //var_dump( $txblocks_results ); // DEBUGGING
      
      $recent_transaction_data = json_request('GetRecentTransactions', array() );
      $recent_transaction_results = json_decode( @get_data('array', $recent_transaction_data, 1), TRUE );
      //var_dump( $recent_transaction_results ); // DEBUGGING
      
      
      //var_dump(coinmarketcap_api()); // DEBUGGING
      
      ?>
      

<div class="col-xs-2 col-md-auto border-rounded no-padding zebra-stripe relative-table under-650-width" style='min-width: 285px; margin-right: 15px; margin-bottom: 25px;'>

	<div style="padding: 7px;"><h4>Statistics</h4></div>
  		
  		
      		<div class="stats-row"><b>Average Trade (globally):</b> <br /><?=( coinmarketcap_api()['quotes']['USD']['price'] ? '$'.coinmarketcap_api()['quotes']['USD']['price'] : 'API Offline' )?></div>
      		
      		<div class="stats-row"><b>Marketcap<?=( number_format(coinmarketcap_api()['rank']) ? '(ranked #'.number_format(coinmarketcap_api()['rank']).')' : '' )?>:</b> <a href='http://coinmarketcap.com/currencies/zilliqa/' target='_blank'><?=( number_format(coinmarketcap_api()['quotes']['USD']['market_cap']) ? '$'.number_format(coinmarketcap_api()['quotes']['USD']['market_cap']) : 'API Offline' )?></a></div>
      		
      		<div class="stats-row"><b>API Server:</b> <?=$api_server?></a></div>
      <?php
      
      	foreach ( $network_id_results as $key => $value ) {
      	
      		if ( $key == 'result' ) {
					      	
      		?>
      					
      		<div class="stats-row"><b>Network ID:</b> <?=$network_id_results[$key]?></div>
      				 
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
      	
  						<div class="stats-row"><b><?=ucfirst($key2)?>:</b></div>
  		
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
      	
  								<div class="stats-row is-1deep"><b> &equals;&gt;&nbsp; <?=ucfirst($key3)?> (<?=sizeof($value3)?>):</b></div>
  		
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
      						?>
      					
      						<div class="stats-row is-1deep"><b><?=ucfirst($key3)?>:</b> <?=$value3?></div>
      				 
      						<?php
      						}
      				
      					}
  							$last2 = NULL;
      					
      				}
      				else {
					      	
      				?>
      					
      					<div class="stats-row"><b><?=ucfirst($key2)?>:</b> <?=( preg_match("/num/i", $key2) || preg_match("/current/i", $key2) ? number_format($value2) : $value2 )?></div>
      					
      				<?php
      				}
      		
  							
      			}
  					$last = NULL;
      			
      		}
      		
      	
      	}
      	
      	////////////////////////////////////////////////////////////////
      	
      	?>
	
</div>
      
      
<div class="col-xs-2 col-md-auto border-rounded no-padding zebra-stripe relative-table under-650-width" style='min-width: 260px; margin-right: 15px; margin-bottom: 25px;'>

	<div style="padding: 5px;"><h4>Latest DS Blocks <span style="float: right;"><a href="/list-dsblocks/">View All</a></span></h4></div>
	
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
      				
							$loop = 0;
					      while ( $loop < $stats_max )	{
					      	
					      	if ( $value2[$loop]['BlockNum'] != '' ) {
      					?>
      					
      					<div class="stats-row"><a href='/dsblock/<?=$value2[$loop]['BlockNum']?>'>DS Block #<?=$value2[$loop]['BlockNum']?></a></div>
      					
      					<?php
      						}
      					
      					$loop = $loop + 1;
      					}
      		
      			}
  					$last = NULL;
      			
      		}
      		
      	}
      	$loop = NULL;
      	
      	////////////////////////////////////////////////////////////////
      	
      	?>
      		
	<div style="padding: 7px;"><h4>Latest TX Blocks <span style="float: right;"><a href="/list-txblocks/">View All</a></span></h4></div>
  		
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
      				
							$loop = 0;
					      while ( $loop < $stats_max )	{
					      	
					      	if ( $value2[$loop]['BlockNum'] != '' ) {
      						?>
      					
      						<div class="stats-row"><a href='/txblock/<?=$value2[$loop]['BlockNum']?>'>TX Block #<?=$value2[$loop]['BlockNum']?></a></div>
      					
      						<?php
      						}
      					
      					$loop = $loop + 1;
      					}
      		
      			}
  					$last = NULL;
      			
      		}
      	
      	}
      	$loop = NULL;
      	
      	////////////////////////////////////////////////////////////////
      	
      	?>
	
</div>

<div class="col-xs-2 col-md-auto border-rounded no-padding zebra-stripe relative-table under-650-width" style='min-width: 560px; margin-right: 15px; margin-bottom: 25px;'>

	<div style="padding: 7px;"><h4>Recent Transactions <span style="float: right;"><a href="/list-transactions/">View All</a></span></h4></div>
		
	
  		<?php
      
      	foreach ( $recent_transaction_results as $key => $value ) {
      	
      		if ( $key == 'result' ) {
      			
      			foreach ( $value as $key2 => $value2 ) {
      				
      				
      				if ( $key2 == 'TxnHashes' ) {
      				?>
      		
      				<?php		
      				
							$loop = 0;
					      while ( $loop < $stats_max )	{
					      	
      					?>
      					
      					<div class="stats-row"><a href='/tx/<?=$value2[$loop]?>'><?=$value2[$loop]?></a></div>
      					
      					<?php
      					
      					$loop = $loop + 1;
      					}
      					?>
      					
      				 
      				<?php
						}		
      		
      			}
      			
      		}
      	
      	}
      	$loop = NULL;
      
      ?>
	
</div>

      
      <br/ clear='all'>
      <br/ >