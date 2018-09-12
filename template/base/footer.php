<?php
/*
 * Copyright 2018 GPLv3, Zillexplorer by Mike Kilday: http://DragonFrugal.com
 */
?>

      <br clear='all' />
      <div style='font-weight: bold; color: red;'><?=( $_SESSION['get_data_error'] ? $_SESSION['get_data_error'] . $_SESSION['cmc_error'] : $_SESSION['cmc_error'] )?></div>
      <br />
      <br />
      
  	  </div>
    	<!-- END #main-content -->
    
  	</div>
	</div>
</div>

	<footer id='site-footer' class="container-fluid" style='width: 100%; height: 50px; padding: 0px; position: relative; z-index: 1;'>
	
	  <div style='padding: 15px;'>
	  
	  <a href='https://github.com/taoteh1221/Zillexplorer/releases' target='_blank'>Zillexplorer v<?=$version?></a>
	  
	  </div>
	  
	</footer>

</body>
</html>
<?php
//var_dump($_SESSION['debugging_printout']);

// Destroy API cache session var and error alert var / Close DB connection
//$_SESSION['api_cache'] = FALSE;
$_SESSION['get_data_error'] = FALSE;
$_SESSION['cmc_error'] = FALSE;
mysqli_close($db_connect);
?>
