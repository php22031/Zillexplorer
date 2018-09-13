<?php
/*
 * Copyright 2018 GPLv3, Zillexplorer by Mike Kilday: http://DragonFrugal.com
 */
 
     	  if ( substr($_GET['q'], 0, 2) != '0x' && strlen($_GET['q']) > 40 
     	  || strlen($_GET['q']) > 42 ) {
    	  
   	   $search_type = 'transaction';
      	$search_request = json_request( 'GetTransaction' , array( $_GET['q'] )  );
      
  	    
 	     }      
	     elseif ( substr($_GET['q'], 0, 2) == '0x' && strlen($_GET['q']) == 42 
     	  || strlen($_GET['q']) == 40 ) {
     	  	
     	  	$_GET['q'] = strip_0x($_GET['q']); // 0x is depreciated in Zilliqa
    	  
   	   $search_type = 'address';
      	$search_request = json_request( 'GetBalance' , array( $_GET['q'] )  );
      
   	   
   	  }
   	  elseif ( substr($_GET['q'], 0, 2) != '0x' && strlen($_GET['q']) < 40 && is_numeric($_GET['q']) ) {
    	  
			//echo ' Block search '; // DEBUGGING
    	  
      	$search_ds = json_request( 'GetDsBlock' , array( $_GET['q'] )  );
      	$ds_results = json_decode( @get_data('array', $search_ds, 525600), TRUE ); // Cache one year
      	
      		if ( $ds_results['result']['header']['timestamp'] > 0 ) {
      		$search_type = 'block';
      		$ds_exists = 1;
      		}
      		else {
      		$search_ds = json_request( 'GetDsBlock' , array( $_GET['q'] )  );
      		$ds_results = json_decode( @get_data('array', $search_ds, -1), TRUE ); // Delete cache
      		}
      	
      	$search_tx = json_request( 'GetTxBlock' , array( $_GET['q'] )  );
      	$tx_results = json_decode( @get_data('array', $search_tx, 525600), TRUE ); // Cache one year
      	
      		if ( $tx_results['result']['header']['Timestamp'] > 0 ) {  // Timestamp uppercase on API for some reason
      		$search_type = 'block';
      		$tx_exists = 1;
      		}
      		else {
      		$search_tx = json_request( 'GetTxBlock' , array( $_GET['q'] )  );
      		$tx_results = json_decode( @get_data('array', $search_tx, -1), TRUE ); // Delete cache
      		}
			   	  
   	  }
      
?>

      <h3><b><?=( $search_type != '' ? ucfirst($search_type) . ' Search Results' : 'Search Results For' )?> "<?=$_GET['q']?>"</b></h3>
      <h5><span class="label label-primary"><?=ucfirst($search_type)?></span> <span id="sc-label" style="display: none;" class="label label-danger">Smart Contract</span> </h5>
      
      <p>
      <?php
      
      if ( $search_type != 'block' ) {
      	
      $search_results = json_decode( @get_data('array', $search_request, 5), TRUE );
      //var_dump( $search_results ); // DEBUGGING
      
      }
      
      ?>
      
     <div class="col-xs-12 col-md-auto border-rounded no-padding zebra-stripe relative-table">

       
      <?php
      
      	if ( $search_type == 'address' ) {
      	?>
      	
			<div style="padding: 7px;"><h4>Address</h4></div>
			
      	<div class="stats-row"><b>Address:</b> <a href='/address/<?=$_GET['q']?>'><?=$_GET['q']?></a> </div>
      	
      	<?php
      	}
      	elseif ( $search_type == 'transaction' ) {
      	?>
      	
			<div style="padding: 7px;"><h4>Transaction</h4></div>
			
      	<div class="stats-row"><b>Transaction:</b> <a href='/tx/<?=$_GET['q']?>'><?=$_GET['q']?></a> </div>
      	
      	<?php
      	}
      	elseif ( $search_type == 'block' ) {
      	?>
      	
			<div style="padding: 7px;"><h4>Block</h4></div>
				
				<?php
				if ( $ds_exists ) {
				?>
      		<div class="stats-row"><b>DS Block:</b> <a href='/dsblock/<?=$_GET['q']?>'>DS Block #<?=$_GET['q']?></a> </div>
				<?php
				}
				if ( $tx_exists ) {
				?>
      		<div class="stats-row"><b>TX Block:</b> <a href='/txblock/<?=$_GET['q']?>'>TX Block #<?=$_GET['q']?></a> </div>
				<?php
				}
				?>
      	
      	<?php
      	}
      	else {
      	?>
      	
			<div style="padding: 7px;"><h4>Search Result</h4></div>
			
      	<div class="stats-row"><b>No search results found.</b></div>
      	
      	<?php
      	}
      	
      	
      	
     if ( $search_type != '' ) {
      	
      
      	foreach ( $search_results as $key => $value ) {
      	
      		if ( $key == 'result' ) {
      			
      			foreach ( $value as $key2 => $value2 ) {
      				
      				if ( $key2 == 'toAddr' ) {
      				?>
      				
      				<div class="stats-row"><b><?=ucfirst($key2)?>:</b> <a href='/address/<?=$value2?>'><?=$value2?></a> </div>
      		
      				<?php
      				}
      				elseif ( $key2 == 'senderPubKey' ) {
      				?>
      				
      				<div class="stats-row"><b><?=ucfirst($key2)?>:</b> <?=$value2?></div>
      				
      				<div class="stats-row"><b>FromAddr:</b> <a href='/address/<?=discover_address($value2)?>'><?=discover_address($value2)?></a> </div>
      		
      				<?php
      				}
      				elseif ( $key2 == 'balance' || $key2 == 'amount' ) {
      				?>
      				
      				<div class="stats-row"><b><?=ucfirst($key2)?>:</b> <?=number_format($value2)?> ZIL</div>
      				
      				<div class="stats-row"><b><i>Current</i> ZIL Value:</b> $<?=number_format( ( $value2 * $zil_usd ), 2 )?> (@ $<?=$zil_usd?> / ZIL)</div>
      		
      				<?php
      				}
      				else {
      				?>
      				
      				<div class="stats-row"><b><?=ucfirst($key2)?>:</b> <?=$value2?> </div>
      		
      				<?php
      				}
      			
      			}
      			
      		}
      	
      	}
      
      
      if ( $search_type == 'address' ) {
      	
     	$contract_state = json_request('GetSmartContractState', array( strip_0x($_GET['q']) )  );
     	$contract_state_results = json_decode( get_data('array', $contract_state, 5), TRUE );
      //var_dump( $contract_state_results ); // DEBUGGING
      
      	// Is this a smart contract
     	  if ( $search_type == 'address' && $contract_state_results['result'][0] != '' ) {
     	 ?>
    		
  			<div class="stats-row"><b>Address Type:</b> Smart Contract </div>
   	 	
  			<?php
 	     }
 	     elseif ( $search_type == 'address' && $contract_state_results['result'][0] == '' ) {
 	     	
 	     	// SEEMS only accounts can create smart contracts, so only check for created smart contracts on accounts
      	if ( $search_results['result'] != '' ) {
      	$created_contracts = json_request('GetSmartContracts' , array( strip_0x($_GET['q']) )  );
      	$contract_results = json_decode( get_data('array', $created_contracts, 5), TRUE );
      	//var_dump( $contract_results ); // DEBUGGING
      	}
      
 	     ?>
 	   		
 	 		<div class="stats-row"><b>Address Type:</b> User Account </div>
 	   	
 	 		<?php
 	 		
 	 			foreach ( $contract_results as $key => $value ) {
 	 			
 	 				if ( $key == 'result' ) {
 	 				
 	 					if ( is_array($value) && !$value['Error'] ) { // Skip if the array is an error message
 	 					?>
 	   		
 	 					<div class="stats-row"><b>Smart Contracts Created:</b> (<?=sizeof($value)?>) 
 	 					<p>
 	 					
 	 					<?php
 	 						foreach ( $value as $key2 => $value2 ) {
 	 							
 	 							if ( $value2['address'] != '' ) {
 	 					?>
 	   		
 	 					<span class='span-block'><a href='/address/<?=$value2['address']?>'><?=$value2['address']?></a> </span>
 	 					
 	 					<?php
 	 							}
 	 							
 	 						}
 	 						?>
 	   					</p>
 	 						</div>
 	 					
 	 						<?php
 	 						
 	 					}
 	 					else {
 	 					?>
 	   		
 	 					<div class="stats-row"><b>Smart Contracts Created:</b> None </div>
 	 					
 	 					<?php
 	 					}
 	 				
 	 				}
 	 			
 	 			}
 	 			
 	 		// NOT IMPLEMENTED YET
      	//$transaction_history = json_request('GetTransactionHistory' , array( strip_0x($_GET['q']) )  );
      	//$transaction_history_results = json_decode( get_data('array', $transaction_history, 5), TRUE );
      	//var_dump( $transaction_history_results ); // DEBUGGING
 	 			
 	 		?>
 	 		
 	     	<div class="stats-row">
 	     	
				<ul class='tabs' style='margin-bottom: 0px; padding: 0px;'>
					<li class='tabli'><a href='#transactions'>Account Transactions</a></li>
					<li class='tabli'><a href='#tokentx'>Token Transactions</a></li>
				</ul>
				
				<div id='transactions' class='tabdiv'>
				<h4>Account Transactions:</h4>
				
				
Feature not possible yet. Waiting on <a href='https://github.com/Zilliqa/Zilliqa/issues/538' target='_blank'>https://github.com/Zilliqa/Zilliqa/issues/538</a> to be implemented, or testnet to be public instead of private (for leveldb block parsing access).
								</div>
				
				
				<div id='tokentx' class='tabdiv'>
				<h4>Token Transactions:</h4>
				
				
Feature not possible yet. Waiting on <a href='https://github.com/Zilliqa/Zilliqa/issues/538' target='_blank'>https://github.com/Zilliqa/Zilliqa/issues/538</a> to be implemented, or testnet to be public instead of private (for leveldb block parsing access).
								</div>
		
		
 	     	</div>
 	     	
 	 		<?php
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
 	     		
 	     	
     		$contract_code = json_request('GetSmartContractCode', array( strip_0x($_GET['q']) )  );
     		$contract_code_results = json_decode( get_data('array', $contract_code, 60), TRUE );
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
 	     		
 	     	
     		$contract_init = json_request('GetSmartContractInit', array( strip_0x($_GET['q']) )  );
     		$contract_init_results = json_decode( get_data('array', $contract_init, 60), TRUE );
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
 	     	<div class="stats-row">
 	     	
				<ul class='tabs' style='margin-bottom: 0px; padding: 0px;'>
					<li class='tabli'><a href='#transactions'>Contract Transactions</a></li>
					<li class='tabli'><a href='#state'>Contract State</a></li>
					<li class='tabli'><a href='#code'>Contract Code</a></li>
					<li class='tabli'><a href='#init'>Contract Init</a></li>
				</ul>
				
				<div id='transactions' class='tabdiv'>
				<h4>Contract Transactions:</h4>
				
				
Feature not possible yet. Waiting on <a href='https://github.com/Zilliqa/Zilliqa/issues/538' target='_blank'>https://github.com/Zilliqa/Zilliqa/issues/538</a> to be implemented, or testnet to be public instead of private (for leveldb block parsing access).
								</div>
				
				
				<div id='state' class='tabdiv'>
				<h4>Contract State:</h4>
				<?=$cstate?>				</div>
				
				<div id='code' class='tabdiv'>
				<h4>Contract Code:</h4>
				<?=$ccode?>				</div>
				
				<div id='init' class='tabdiv'>
				<h4>Contract Init:</h4>
				<?=$cinit?>				</div>
		
		
 	     	</div>
 	     	<?php
 	     	
 	     	}
 	     	
      }
      
      
    }
      ?>
      
      </div>
      
      <?php
      
      	if ( $iscontract == 1 ) {
      	?>
      	<script>
      	document.getElementById("sc-label").style.display = 'inline';
      	</script>
      	<?php
      	}
      	
