<?php
/*
 * Copyright 2018 GPLv3, Zillexplorer by Mike Kilday: http://DragonFrugal.com
 */
?>

      <br clear='all' />
      <br />
      <br />
      
  	  </div>
    	<!-- END #main-content -->
    
  	</div>
	</div>
</div>

	<footer class="container-fluid" style='padding:15px; width: 100%;'>
	  <p><a href='https://github.com/taoteh1221/Zillexplorer/releases' target='_blank'>Zillexplorer v<?=$version?></a></p>
	</footer>


</body>
</html>
<?php
//var_dump($_SESSION['debugging_printout']);

// Destroy API cache session var / Close DB connection
$_SESSION['api_cache'] = FALSE;
mysqli_close($db_connect);
?>
