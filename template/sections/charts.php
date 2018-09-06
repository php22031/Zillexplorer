<?php
/*
 * Copyright 2018 GPLv3, Zillexplorer by Mike Kilday: http://DragonFrugal.com
 */
?>


	<br/>
  <div id="difficulty_chart" class='chart-border'></div>
  <br/><br/><br/>
  <div id="transaction_chart" class='chart-border'></div>
  <br/><br/><br/>
  <div id="gas_used_chart" class='chart-border'></div>
  <br/><br/><br/>
  <div id="micro_blocks_chart" class='chart-border'></div>
  <br/>
  
  
<script>

  zingchart.render(
			{
          id: "difficulty_chart",
          width: "100%",
          height: "400",
          modules: 'zoom-buttons',
          fullscreen: false,
			 cache:{
      		data:true
		    },
		    dataurl:"/json.php?output=ds-blocks"
		    
			} // render
  ); // end
  

	///////////////////////////////////////////////////////////

  zingchart.render(
			{
          id: "transaction_chart",
          width: "100%",
          height: "400",
          modules: 'zoom-buttons',
          fullscreen: false,
			 cache:{
      		data:true
		    },
		    dataurl:"/json.php?output=tx-blocks-tx"
    
			} // render
  ); // end


	///////////////////////////////////////////////////////////

  zingchart.render(
			{
          id: "gas_used_chart",
          width: "100%",
          height: "400",
          modules: 'zoom-buttons',
          fullscreen: false,
			 cache:{
      		data:true
		    },
		    dataurl:"/json.php?output=tx-blocks-gas"
		    
			} // render
  ); // end
  

	///////////////////////////////////////////////////////////

  zingchart.render(
			{
          id: "micro_blocks_chart",
          width: "100%",
          height: "400",
          modules: 'zoom-buttons',
          fullscreen: false,
			 cache:{
      		data:true
		    },
		    dataurl:"/json.php?output=tx-blocks-microblocks"
		    
			} // render
  ); // end
  
 /////////////////////////////////////////////////////////////
 
 
</script>

