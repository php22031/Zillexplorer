<?php
/*
 * Copyright 2018 GPLv3, Zillexplorer by Mike Kilday: http://DragonFrugal.com
 */

include('init.php'); 
include('template/base/header.php'); 

      
      // DS Block info
      if ( trim($_GET['dsblock']) != '' ) {
		include('template/sections/ds-blocks.php'); 
      }
      // TX Block info
      elseif ( trim($_GET['txblock']) != '' ) {
		include('template/sections/tx-blocks.php'); 
      }
      // Search query results
      elseif ( trim($_GET['q']) != '' ) {
		include('template/sections/search-results.php'); 
      }
      // Network Stats info
      else {
		include('template/sections/current-stats.php'); 
      }
      

include('template/base/footer.php');

?>

