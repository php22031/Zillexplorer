<?php
/*
 * Copyright 2018 GPLv3, Zillexplorer by Mike Kilday: http://DragonFrugal.com
 */

include('init.php'); 
include('template/base/header.php'); 

      
      // DS Block info
      if ( trim($_GET['dsblock']) != '' ) {

      $dsblock_request = json_request('GetDsBlock', array( trim($_GET['dsblock']) ) );
      $dsblock_results = json_decode( get_data('array', $dsblock_request), TRUE );
      //var_dump( $dsblock_results ); // DEBUGGING

      ?>
      
      <h2>DS Block #<?=trim($_GET['dsblock'])?></h2>
      <h5><span class="glyphicon glyphicon-time"></span> <?=date('Y-m-d h:i:sa')?></h5>
      <h5><!-- <span class="label label-danger">Lorem</span> --> <span class="label label-primary">DS Block</span></h5>
      
      <p>
      <table width='100%' border='2'>
      
      <?php
      
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
      
      <?php
      
      }
      // TX Block info
      elseif ( trim($_GET['txblock']) != '' ) {

      $txblock_request = json_request('GetTxBlock', array( trim($_GET['txblock']) )  );
      $txblock_results = json_decode( get_data('array', $txblock_request), TRUE );
      //var_dump( $txblock_results ); // DEBUGGING

      ?>
      
      <h2>TX Block #<?=trim($_GET['txblock'])?></h2>
      <h5><span class="glyphicon glyphicon-time"></span> <?=date('Y-m-d h:i:sa')?></h5>
      <h5><!-- <span class="label label-danger">Lorem</span> --> <span class="label label-primary">TX Block</span></h5>
      
      <p>
      <table width='100%' border='2'>
      
      <?php
      
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
      
      <?php
      }
      // Search query results
      elseif ( trim($_GET['q']) != '' ) {
      
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

      <h2><?=( preg_match("/address/i", $_SERVER['REQUEST_URI']) ? 'Address' : 'Search Results For' )?> "<?=trim($_GET['q'])?>"</h2>
      <h5><span class="glyphicon glyphicon-time"></span> <?=date('Y-m-d h:i:sa')?></h5>
      <h5><span class="label label-primary"><?=ucfirst($search_type)?></span> <span id="sc-label" style="display: none;" class="label label-danger">Smart Contract</span> </h5>
      
      <p>
      <?php
      	
      $search_request = json_request( ( $search_type == 'transaction' ? 'GetTransaction' : 'GetBalance' ) , array( strip_0x($sanitize_search) )  );
      $search_results = json_decode( get_data('array', $search_request), TRUE );
      //var_dump( $search_results ); // DEBUGGING
      
      ?>
      
      <table width='100%' border='2'>
      
      <?php
      
      	if ( $search_type == 'address' ) {
      	?>
      	
      	<tr><td class='no-border'> <b>Address:</b> <a href='/address/<?=$sanitize_search?>'><?=$sanitize_search?></a> </td></tr>
      	
      	<?php
      	}
      
      	foreach ( $search_results as $key => $value ) {
      	
      		if ( $key == 'result' ) {
      			
      			foreach ( $value as $key2 => $value2 ) {
      				
      				if ( $key2 == 'toAddr' ) {
      				?>
      				
      				<tr><td class='no-border'> <b><?=ucfirst($key2)?>:</b> <a href='/address/<?=$value2?>'><?=$value2?></a> </td></tr>
      		
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
      	
     	$contract_state = json_request('GetSmartContractState', array( strip_0x($sanitize_search) )  );
     	$contract_state_results = json_decode( get_data('array', $contract_state), TRUE );
      //var_dump( $contract_state_results ); // DEBUGGING
      
      	// Is this a smart contract
     	  if ( $search_type == 'address' && $contract_state_results['result'][0] != '' ) {
     	 ?>
    		
  			<tr><td class='no-border'> <b>Address Type:</b> Smart Contract </td></tr>
   	 	
  			<?php
 	     }
 	     elseif ( $search_type == 'address' && $contract_state_results['result'][0] == '' ) {
 	     	
 	     	// SEEMS only accounts can create smart contracts, so only check for created smart contracts on accounts
      	if ( $search_results['result'] != '' ) {
      	$created_contracts = json_request('GetSmartContracts' , array( strip_0x($sanitize_search) )  );
      	$contract_results = json_decode( get_data('array', $created_contracts), TRUE );
      	//var_dump( $contract_results ); // DEBUGGING
      	}
      
 	     ?>
 	   		
 	 		<tr><td class='no-border'> <b>Address Type:</b> Account </td></tr>
 	   	
 	 		<?php
 	 		
 	 			foreach ( $contract_results as $key => $value ) {
 	 			
 	 				if ( $key == 'result' ) {
 	 				
 	 					if ( is_array($value) ) {
 	 					?>
 	   		
 	 					<tr><td class='no-border'> <b>Smart Contracts Created:</b> (<?=sizeof($value)?>) <p>
 	 					
 	 					<?php
 	 						foreach ( $value as $key2 => $value2 ) {
 	 							
 	 							if ( $value2['address'] != '' ) {
 	 					?>
 	   		
 	 					<span style='padding: 4px; display: block;'><a href='/address/<?=$value2['address']?>'><?=$value2['address']?></a> </span>
 	 					
 	 					<?php
 	 							}
 	 							
 	 						}
 	 						?>
 	   					</p>
 	 						</td></tr>
 	 					
 	 						<?php
 	 						
 	 					}
 	 					else {
 	 					?>
 	   		
 	 					<tr><td class='no-border'> <b>Smart Contracts Created:</b> None </td></tr>
 	 					
 	 					<?php
 	 					}
 	 				
 	 				}
 	 			
 	 			}
 	 		
 	     }
 	     
 	     
 	     	foreach ( $contract_state_results as $key => $value ) {
 	     	
 	     		if ( $key == 'result' && $contract_state_results[$key][0] != '' ) {
 	     			
 	     		$iscontract = 1; // Register that this is a smart contract for further logic
 	     		
 	     			$cstate = '<table width="100%">';
 	     			
 	     			foreach ( $value as $key2 => $value2 ) {
 	     			$cstate .= '<tr><td> <b>'.ucfirst($key2).':</b> <pre>'.print_r($value2, TRUE).'</pre> </td></tr>';
 	     			}
 	     			
 	     			$cstate .= '</table>';
 	     			
 	     		}
 	     		else {
 	     		$iscontract = NULL;
 	     		}
 	     	
 	     	}
 	     	
 	     	
 	     	// Get contract data if this address is a contract
 	     	if ( $iscontract == 1 ) {
 	     		
 	     	
     		$contract_code = json_request('GetSmartContractCode', array( strip_0x($sanitize_search) )  );
     		$contract_code_results = json_decode( get_data('array', $contract_code), TRUE );
    	   //var_dump( $contract_code_results ); // DEBUGGING
 	     	
 	  	  		foreach ( $contract_code_results as $key => $value ) {
 	  	  	 	
 	 	 	   		if ( $key == 'result' ) {
 			     			
 			     			$ccode = '<table width="100%">';
 			     			
 			     			foreach ( $value as $key2 => $value2 ) {
 			     			$ccode .= '<tr><td> <b>'.ucfirst($key2).':</b> <br/ ><pre>'.$value2.'</pre> </td></tr>';
 			     			}
 			     			
 			     			$ccode .= '</table>';
 			     			
 			     		}
 			     	
 	   	  	}
 	     		
 	     	
     		$contract_init = json_request('GetSmartContractInit', array( strip_0x($sanitize_search) )  );
     		$contract_init_results = json_decode( get_data('array', $contract_init), TRUE );
    	   //var_dump( $contract_init_results ); // DEBUGGING
 	     	
 	  	  		foreach ( $contract_init_results as $key => $value ) {
 	  	  	 	
 	 	 	   		if ( $key == 'result' ) {
 			     			
 			     			$cinit = '<table width="100%">';
 			     			
 			     			foreach ( $value as $key2 => $value2 ) {
							$cinit .= '<tr><td> <b>'.ucfirst($key2).':</b> <pre>'.print_r($value2, TRUE).'</pre> </td></tr>';
 			     			}
 			     			
 			     			$cinit .= '</table>';
 			     			
 			     		}
 			     	
 	   	  	}
 	     	
 	     	?>
 	     	<tr><td>
 	     	
				<ul class='tabs' style='margin-bottom: 0px; padding: 0px;'>
					<li><a href='#state'>Contract State</a></li>
					<li><a href='#code'>Contract Code</a></li>
					<li><a href='#init'>Contract Init</a></li>
				</ul>
				
				<div id='state' class='tabdiv'>
				<h4>Contract State:</h4>
				<?=$cstate?>				</div>
				
				<div id='code' class='tabdiv'>
				<h4>Contract Code:</h4>
				<?=$ccode?>				</div>
				
				<div id='init' class='tabdiv'>
				<h4>Contract Init:</h4>
				<?=$cinit?>				</div>
		
		
 	     	</td></tr>
 	     	<?php
 	     	
 	     	}
 	     	
      }
      ?>
      
      </table>
      </p>
      
      <?php
      
      	if ( $iscontract == 1 ) {
      	?>
      	<script>
      	document.getElementById("sc-label").style.display = 'inline';
      	</script>
      	<?php
      	}
      	
      }
      // Network Stats info
      else {
      ?>
      

      <h2>Zilliqa Network Stats</h2>
      <h5><span class="glyphicon glyphicon-time"></span> <?=date('Y-m-d h:i:sa')?></h5>
      <h5><!-- <span class="label label-danger">Lorem</span> --> <span class="label label-primary">Stats</span></h5>
      <p>
      
      <?php
      
      $network_id_data = json_request('GetNetworkId', array('') );
      $network_id_results = json_decode( get_data('array', $network_id_data), TRUE );
      //var_dump( $network_id_results ); // DEBUGGING
      
      $blockchain_data = json_request('GetBlockchainInfo', array('') );
      $blockchain_results = json_decode( get_data('array', $blockchain_data), TRUE );
      //var_dump( $blockchain_results ); // DEBUGGING
      
      $dsblocks_data = json_request('DSBlockListing', array(1) );
      $dsblocks_results = json_decode( get_data('array', $dsblocks_data), TRUE );      
      //var_dump( $dsblocks_results ); // DEBUGGING
      
      $txblocks_data = json_request('TxBlockListing', array(1) );
      $txblocks_results = json_decode( get_data('array', $txblocks_data), TRUE );
      //var_dump( $txblocks_results ); // DEBUGGING
      
      $recent_transaction_data = json_request('GetRecentTransactions', array('') );
      $recent_transaction_results = json_decode( get_data('array', $recent_transaction_data), TRUE );
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
      
      <?php
      }
      
      ?>
      
      <br><br>
      
      
<?php include('template/base/footer.php'); ?>

