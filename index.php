<?php
/*
 * Copyright 2018 GPLv3, Zillexplorer by Mike Kilday: http://DragonFrugal.com
 */

include('init.php'); 
include('template/base/header.php'); 

?>

      <?php
      
      if ( trim($_GET['ds_block']) != '' ) {
      

      $ds_block_request = array(
      								'id' => '1',
      								'jsonrpc' => '2.0',
      								'method' => 'GetDsBlock',
      								'params' => array( trim($_GET['ds_block']) ),
      								);
      	
      $ds_block_results = json_decode( zill_node_api($ds_block_request), TRUE );
      
      //var_dump( $ds_block_results ); // DEBUGGING
      

      ?>
      
      <h2>Search Results For DS Block #<?=trim($_GET['ds_block'])?></h2>
      <h5><span class="glyphicon glyphicon-time"></span> <?=date('Y-m-d h:i:sa')?></h5>
      <h5><!-- <span class="label label-danger">Lorem</span> --> <span class="label label-primary">DS Block</span></h5>
      
      <p>
      <table width='100%' border='2'>
      
      <?php

      
      	foreach ( $ds_block_results as $key => $value ) {
      	
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
      
      <?php
      
      }
      elseif ( trim($_GET['tx_block']) != '' ) {
      

      $tx_block_request = array(
      								'id' => '1',
      								'jsonrpc' => '2.0',
      								'method' => 'GetTxBlock',
      								'params' => array( trim($_GET['tx_block']) ),
      								);
      	
      $tx_block_results = json_decode( zill_node_api($tx_block_request), TRUE );
      
      //var_dump( $tx_block_results ); // DEBUGGING
      

      ?>
      
      <h2>Search Results For TX Block #<?=trim($_GET['tx_block'])?></h2>
      <h5><span class="glyphicon glyphicon-time"></span> <?=date('Y-m-d h:i:sa')?></h5>
      <h5><!-- <span class="label label-danger">Lorem</span> --> <span class="label label-primary">TX Block</span></h5>
      
      <p>
      <table width='100%' border='2'>
      
      <?php

      
      	foreach ( $tx_block_results as $key => $value ) {
      	
      		if ( $key == 'result' ) {
      			
      			foreach ( $value as $key2 => $value2 ) { // Results arrays depth 0
      				
      				if ( is_array($value2) ) {
      				?>
      	
  						<tr><th class='table-header'> <h3><?=ucfirst($key2)?>:</h3></th></tr>
  		
  						<?php
      	
      					
      					foreach ( $value2 as $key3 => $value3 ) { // Results arrays depth 1
      						
      						if ( is_array($value3) ) {
      							
      				?>
      	
  		<tr><th class='table-header'> <h3><?=ucfirst($key3)?>:</h3></th></tr>
  		
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
      	?>
      
      </table>
      
      </p>
      
      <?php
      
      
      }
      elseif ( $_GET['search'] && trim($_GET['q']) != '' ) {
      
      
      $sanitize_search = sanitize_request($_GET['q']);
      
      
     	  if ( substr($sanitize_search, 0, 2) != '0x' && strlen($sanitize_search) > 40 
     	  || strlen($sanitize_search) > 42 ) {
    	  
   	   $search_type = 'transaction';
  	    
 	     }      
	     elseif ( substr($sanitize_search, 0, 2) == '0x' && strlen($sanitize_search) <= 42 
     	  || strlen($sanitize_search) <= 40 ) {
    	  
   	   $search_type = 'address';
   	   
   	  }
      
      ?>
      

      <h2>Search Results For "<?=trim($_GET['q'])?>"</h2>
      <h5><span class="glyphicon glyphicon-time"></span> <?=date('Y-m-d h:i:sa')?></h5>
      <h5><!-- <span class="label label-danger">Lorem</span> --> <span class="label label-primary"><?=ucfirst($search_type)?></span></h5>
      
      <p>
      
      <?php
      	
      $search_request = array(
      								'id' => '1',
      								'jsonrpc' => '2.0',
      								'method' => ( $search_type == 'transaction' ? 'GetTransaction' : 'GetBalance' ),
      								'params' => array( strip_0x($sanitize_search) ),
      								);
      	
      $search_results = json_decode( zill_node_api($search_request), TRUE );
      
      //var_dump( $search_results ); // DEBUGGING
      
      ?>
      
      <table width='100%' border='2'>
      
      <?php
      
      	if ( $search_type == 'address' ) {
      	?>
      	<tr><td class='no-border'> <b>Address:</b> <?=$sanitize_search?> </td></tr>
      	<?php
      	}
      
      	foreach ( $search_results as $key => $value ) {
      	
      		if ( $key == 'result' ) {
      			
      			foreach ( $value as $key2 => $value2 ) {
      				
      				if ( $key2 == 'toAddr' ) {
      				?>
      				
      				<tr><td class='no-border'> <b><?=ucfirst($key2)?>:</b> <a href='?search=1&q=<?=$value2?>'><?=$value2?></a> </td></tr>
      		
      				<?php
      				}
      				else {
      				?>
      				
      				<tr><td class='no-border'> <b><?=ucfirst($key2)?>:</b> <?=$value2?> </td></tr>
      		
      				<?php
      				}
      			
      			}
      			
      		}
      	
      	}
      
      
      if ( $search_type == 'address' ) {
      	
     	$contract_data = array(
      								'id' => '1',
      								'jsonrpc' => '2.0',
      								'method' => 'GetSmartContractState',
      								'params' => array( strip_0x($sanitize_search) ),
      								);
     	$contract_results = json_decode( zill_node_api($contract_data), TRUE );
      
      
      //var_dump( $contract_results ); // DEBUGGING
      
      
     	 if ( $search_type == 'address' && $contract_results['result'] != '' ) {
     	 ?>
    		
  			<tr><td class='no-border'> <b>Address Type:</b> Smart Contract </td></tr>
   	 	
  			<?php
 	     }
 	     elseif ( $search_type == 'address' && $contract_results['result'] == '' ) {
 	     ?>
 	   		
 	 		<tr><td class='no-border'> <b>Address Type:</b> Account </td></tr>
 	   	
 	 		<?php
 	     }
 	     
 	     
 	     	foreach ( $contract_results as $key => $value ) {
 	     	
 	     		if ( $key == 'result' && $value != '' ) {
 	     			
 	     			foreach ( $value as $key2 => $value2 ) {
 	     		?>
 	     		<tr><td> <b><?=ucfirst($key2)?>:</b> <pre><?=print_r($value2)?></pre> </td></tr>
 	     		<?php
 	     			}
 	     			
 	     		}
 	     	
 	     	}
 	     	
      }
      ?>
      
      </table>
      
      </p>
      <?php
      }
      else {
      ?>
      

      <h2>Zilliqa Network Stats</h2>
      <h5><span class="glyphicon glyphicon-time"></span> <?=date('Y-m-d h:i:sa')?></h5>
      <h5><!-- <span class="label label-danger">Lorem</span> --> <span class="label label-primary">Stats</span></h5>
      
      <p>
      <?php
      
      $network_id_data = array(
      								'id' => '1',
      								'jsonrpc' => '2.0',
      								'method' => 'GetNetworkId',
      								'params' => array('')
      								);
      $network_id_results = json_decode( zill_node_api($network_id_data), TRUE );
      
      //var_dump( $network_id_results ); // DEBUGGING
      
      
      
      $blockchain_data = array(
      								'id' => '1',
      								'jsonrpc' => '2.0',
      								'method' => 'GetBlockchainInfo',
      								'params' => array('')
      								);
      $blockchain_results = json_decode( zill_node_api($blockchain_data), TRUE );
      
      //var_dump( $blockchain_results ); // DEBUGGING
      
      
      $ds_blocks_data = array(
      								'id' => '1',
      								'jsonrpc' => '2.0',
      								'method' => 'DSBlockListing',
      								'params' => array(1)
      								);
      $ds_blocks_results = json_decode( zill_node_api($ds_blocks_data), TRUE );
      
      //var_dump( $ds_blocks_results ); // DEBUGGING
      
      
      
      $tx_blocks_data = array(
      								'id' => '1',
      								'jsonrpc' => '2.0',
      								'method' => 'TxBlockListing',
      								'params' => array(1)
      								);
      $tx_blocks_results = json_decode( zill_node_api($tx_blocks_data), TRUE );
      
      //var_dump( $tx_blocks_results ); // DEBUGGING
      
      
      
      $recent_transaction_data = array(
      								'id' => '1',
      								'jsonrpc' => '2.0',
      								'method' => 'GetRecentTransactions',
      								'params' => array('')
      								);
      $recent_transaction_results = json_decode( zill_node_api($recent_transaction_data), TRUE );
      
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
      	
  								<tr><th class='table-header'> <h3><?=ucfirst($key3)?>:</h3></th></tr>
  		
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
      
      	foreach ( $ds_blocks_results as $key => $value ) {
      	
      		if ( $key == 'result' ) {
      			
      			foreach ( $value as $key2 => $value2 ) {
      				
      		?>
      		
      		<tr><td class='no-border'> 
      		
      		<?php		
							$loop = 0;
					      while ( $loop < $stats_max )	{
					      	
					      	if ( $value2[$loop]['BlockNum'] != '' ) {
      					?>
      					
      					<span style='padding: 4px; display: block;'><a href='?ds_block=<?=$value2[$loop]['BlockNum']?>'>DS Block #<?=$value2[$loop]['BlockNum']?></a></span>
      					
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
      	
      
      	foreach ( $tx_blocks_results as $key => $value ) {
      	
      		if ( $key == 'result' ) {
      			
      			foreach ( $value as $key2 => $value2 ) {
      				
      		?>
      		
      		<tr><td class='no-border'> 
      		
      		<?php		
							$loop = 0;
					      while ( $loop < $stats_max )	{
					      	
					      	if ( $value2[$loop]['BlockNum'] != '' ) {
      						?>
      					
      						<span style='padding: 4px; display: block;'><a href='?tx_block=<?=$value2[$loop]['BlockNum']?>'>TX Block #<?=$value2[$loop]['BlockNum']?></a></span>
      					
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
      					
      					<span style='padding: 4px; display: block;'><a href='?search=1&q=<?=$value2[$loop]?>'><?=$value2[$loop]?></a></span>
      					
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
      
      <?php
      }
      
      ?>
      
      <br><br>
      
      
<?php include('template/base/footer.php'); ?>

