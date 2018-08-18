<?php
/*
 * Copyright 2018 GPLv3, Zillexplorer by Mike Kilday: http://DragonFrugal.com
 */

include('init.php'); 
include('template/base/header.php'); 

?>

      <?php
      
      if ( $_GET['main_search'] && trim($_GET['search_value']) != '' ) {
      
      $sanitize_search = sanitize_request($_GET['search_value']);
      
      $search_type = ( substr($sanitize_search, 0, 2) == '0x' ? 'address' : '' );
      
      ?>
      

      <h2>Search Results For "<?=trim($_GET['search_value'])?>"</h2>
      <h5><span class="glyphicon glyphicon-time"></span> <?=date('Y-m-d h:i:sa')?></h5>
      <h5><!-- <span class="label label-danger">Lorem</span> --> <?=( $search_type == 'address' ? '<span class="label label-primary">Address</span>' : '' )?></h5>
      
      <p>
      
      <?php
      	
      $search_request = array(
      								'id' => '1',
      								'jsonrpc' => '2.0',
      								'method' => 'GetBalance',
      								'params' => array( strip_0x($sanitize_search) ),
      								);
      	
      $search_results = json_decode( zill_node_api($search_request), TRUE );
      
      //var_dump( $search_results ); // DEBUGGING
      
      ?>
      
      <table width='100%' border='2'>
      
      <?php
      
      	if ( $search_type == 'address' ) {
      	?>
      	<tr><td> <b>Address:</b> <?=$sanitize_search?> </td></tr>
      	<?php
      	}
      
      	foreach ( $search_results as $key => $value ) {
      	
      		if ( $key == 'result' ) {
      			
      			foreach ( $value as $key2 => $value2 ) {
      		?>
      		<tr><td> <b><?=ucfirst($key2)?>:</b> <?=$value2?> </td></tr>
      		<?php
      			}
      			
      		}
      	
      	}
      
      ?>
      
      </table>
      
      <?php
      }
      
      ?>
      
      </p>
      <br><br>
      
      
<?php include('template/base/footer.php'); ?>