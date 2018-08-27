<?php
/*
 * Copyright 2018 GPLv3, Zillexplorer by Mike Kilday: http://DragonFrugal.com
 */
 
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

      <h3><b><?=( preg_match("/address/i", $_SERVER['REQUEST_URI']) ? 'Address' : 'Search Results For' )?> "<?=trim($_GET['q'])?>"</b></h3>
      <h5><span class="glyphicon glyphicon-time"></span> <?=date('Y-m-d h:i:sa')?></h5>
      <h5><span class="label label-primary"><?=ucfirst($search_type)?></span> <span id="sc-label" style="display: none;" class="label label-danger">Smart Contract</span> </h5>
      
      <p>
      <?php
      	
      $search_request = json_request( ( $search_type == 'transaction' ? 'GetTransaction' : 'GetBalance' ) , array( strip_0x($sanitize_search) )  );
      $search_results = json_decode( @get_data('array', $search_request), TRUE );
      //var_dump( $search_results ); // DEBUGGING
      
      ?>
      
      <table class='blockchain-tables' width='100%' border='2'>
      
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
      				elseif ( $key2 == 'balance' || $key2 == 'amount' ) {
      				?>
      				
      				<tr><td class='no-border'> <b><?=ucfirst($key2)?>:</b> <?=$value2?> ZIL</td></tr>
      				
      				<tr><td class='no-border'> <b><i>Current</i> ZIL Value:</b> $<?=number_format( ( $value2 * $zil_usd ), 2 )?> (@ $<?=$zil_usd?> / ZIL)</td></tr>
      		
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
 	 				
 	 					if ( is_array($value) && !$value['Error'] ) { // Skip if the array is an error message
 	 					?>
 	   		
 	 					<tr><td class='no-border'> <b>Smart Contracts Created:</b> (<?=sizeof($value)?>) <p>
 	 					
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
 	 			
 	 		// NOT IMPLEMENTED YET
      	//$transaction_history = json_request('GetTransactionHistory' , array( strip_0x($sanitize_search) )  );
      	//$transaction_history_results = json_decode( get_data('array', $transaction_history), TRUE );
      	//var_dump( $transaction_history_results ); // DEBUGGING
 	 			
 	 		?>
 	 		
 	     	<tr><td>
 	     	
				<ul class='tabs' style='margin-bottom: 0px; padding: 0px;'>
					<li><a href='#transactions'>Account Transactions</a></li>
					<li><a href='#tokentx'>Token Transactions</a></li>
				</ul>
				
				<div id='transactions' class='tabdiv'>
				<h4>Account Transactions:</h4>
				Feature not built yet				</div>
				
				
				<div id='tokentx' class='tabdiv'>
				<h4>Token Transactions:</h4>
				Feature not built yet				</div>
		
		
 	     	</td></tr>
 	     	
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
					<li><a href='#transactions'>Contract Transactions</a></li>
					<li><a href='#state'>Contract State</a></li>
					<li><a href='#code'>Contract Code</a></li>
					<li><a href='#init'>Contract Init</a></li>
				</ul>
				
				<div id='transactions' class='tabdiv'>
				<h4>Contract Transactions:</h4>
				Feature not built yet				</div>
				
				
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
      	
