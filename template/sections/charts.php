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
  
  
<?php

use ZingChart\PHPWrapper\ZC;

// DS chart data //////////////////////////

$diff_array = array('');
$dstime_array = array('');
$query = "SELECT difficulty,timestamp FROM ds_blocks ORDER BY timestamp ASC limit " . $chart_blocks;

if ($result = mysqli_query($db_connect, $query)) {
   while ( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ) {
   	
   	if ( $row["timestamp"] > 1000 ) { // Skip genesis block
		$diff_array[] = intval($row["difficulty"]);
		$dstime_array[] = intval(substr($row["timestamp"], 0, 13));
	 	}
	
   }
mysqli_free_result($result);
}
$query = NULL;

// TX chart data //////////////////////////

$gas_used_array = array('');
$micro_blocks_array = array('');
$txamount_array = array('');
$txtime_array = array('');
$query = "SELECT gas_used,micro_blocks,transactions,timestamp FROM tx_blocks ORDER BY timestamp ASC limit " . $chart_blocks;

if ($result = mysqli_query($db_connect, $query)) {
   while ( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ) {
   	
   	if ( $row["timestamp"] > 1000 ) { // Skip genesis block
	 	$gas_used_array[] = intval($row["gas_used"]);
		$micro_blocks_array[] = intval($row["micro_blocks"]);
		$txamount_array[] = intval($row["transactions"]);
		$txtime_array[] = intval(substr($row["timestamp"], 0, 13));
	 	}
	
   }
mysqli_free_result($result);
}
$query = NULL;


?>

<script>


  zingchart.render(
			{
          id: "difficulty_chart",
          width: "100%",
          height: "400",
          modules: 'zoom-buttons',
          fullscreen: false,
          data: {
						"globals":{
        					"font-family":"Lucida Sans Unicode"
    						},
          			"type":"area",
		        		"plotarea":{
      		  			"margin":"80 45 40 55"
      		  			},
						"preview":{
      					"border-width":1,
     						"handle":{
            				"line-width":0,
           					"height":20
        						},
							"adjust-layout":true
							},
      		  		"crosshair-x":{
      		  			"visible":true
      		  			},
      		  		"plot":{
      		  			"tooltip":{
      		  				"visible":true
      		  				}
      		  			},
      		  		"series": [{
      		  			"values": [<?=chart_arrays($dstime_array, $diff_array)?>],
      		  			"text":"Difficulty"
      		  			}],
      		  		"title":{
      		  			"text":"Network Difficulty",
      		  			"adjust-layout":false
      		  			},
    					"scroll-x":{},
    					"scale-x" : {
						  	//"values":"0:100", //Min/Max
						  	//"values":"0:100:10", //Min/Max/Step
        					"transform" : {
            				"type" : "date"
        						},
    					   "item" : {
   					        "font-size" : 10
      						},
        					"zooming" : true
        					},
    					"scale-y":{
    					   "autoFit":true,
    					   "min-value":"auto",
    					   "short":true,
    					   "label":{
    					       "text":"Difficulty"
    					   	},
    					   "item":{
    					       "fontSize":10
    					    	},
    					   "guide":{
    					       "lineStyle":"solid"
    					    	}
    						}
     		   			
     		   			
        				}  // data
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
          data: {
						"globals":{
        					"font-family":"Lucida Sans Unicode"
    						},
          			"type":"area",
		        		"plotarea":{
      		  			"margin":"80 45 40 55"
      		  			},
						"preview":{
      					"border-width":1,
     						"handle":{
            				"line-width":0,
           					"height":20
        						},
							"adjust-layout":true
							},
      		  		"crosshair-x":{
      		  			"visible":true
      		  			},
      		  		"plot":{
      		  			"tooltip":{
      		  				"visible":true
      		  				}
      		  			},
      		  		"series": [{
      		  			"values": [<?=chart_arrays($txtime_array, $txamount_array)?>],
      		  			"text":"Transactions"
      		  			}],
      		  		"title":{
      		  			"text":"Transaction Amounts",
      		  			"adjust-layout":false
      		  			},
    					"scroll-x":{},
    					"scale-x" : {
						  	//"values":"0:100", //Min/Max
						  	//"values":"0:100:10", //Min/Max/Step
        					"transform" : {
            				"type" : "date"
        						},
    					   "item" : {
   					        "font-size" : 10
      						},
        					"zooming" : true
        					},
    					"scale-y":{
    					   "autoFit":true,
    					   "min-value":"auto",
    					   "short":true,
    					   "label":{
    					       "text":"Transactions"
    					   	},
    					   "item":{
    					       "fontSize":10
    					    	},
    					   "guide":{
    					       "lineStyle":"solid"
    					    	}
    						}
     		   			
     		   			
        				}  // data
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
          data: {
						"globals":{
        					"font-family":"Lucida Sans Unicode"
    						},
          			"type":"area",
		        		"plotarea":{
      		  			"margin":"80 45 40 55"
      		  			},
						"preview":{
      					"border-width":1,
     						"handle":{
            				"line-width":0,
           					"height":20
        						},
							"adjust-layout":true
							},
      		  		"crosshair-x":{
      		  			"visible":true
      		  			},
      		  		"plot":{
      		  			"tooltip":{
      		  				"visible":true
      		  				}
      		  			},
      		  		"series": [{
      		  			"values": [<?=chart_arrays($txtime_array, $gas_used_array)?>],
      		  			"text":"Gas Used"
      		  			}],
      		  		"title":{
      		  			"text":"Transaction Gas Used",
      		  			"adjust-layout":false
      		  			},
    					"scroll-x":{},
    					"scale-x" : {
						  	//"values":"0:100", //Min/Max
						  	//"values":"0:100:10", //Min/Max/Step
        					"transform" : {
            				"type" : "date"
        						},
    					   "item" : {
   					        "font-size" : 10
      						},
        					"zooming" : true
        					},
    					"scale-y":{
    					   "autoFit":true,
    					   "min-value":"auto",
    					   "short":true,
    					   "label":{
    					       "text":"Gas Used"
    					   	},
    					   "item":{
    					       "fontSize":10
    					    	},
    					   "guide":{
    					       "lineStyle":"solid"
    					    	}
    						}
     		   			
     		   			
        				}  // data
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
          data: {
						"globals":{
        					"font-family":"Lucida Sans Unicode"
    						},
          			"type":"area",
		        		"plotarea":{
      		  			"margin":"80 45 40 55"
      		  			},
						"preview":{
      					"border-width":1,
     						"handle":{
            				"line-width":0,
           					"height":20
        						},
							"adjust-layout":true
							},
      		  		"crosshair-x":{
      		  			"visible":true
      		  			},
      		  		"plot":{
      		  			"tooltip":{
      		  				"visible":true
      		  				}
      		  			},
      		  		"series": [{
      		  			"values": [<?=chart_arrays($txtime_array, $micro_blocks_array)?>],
      		  			"text":"Micro Blocks"
      		  			}],
      		  		"title":{
      		  			"text":"Micro Block Amounts",
      		  			"adjust-layout":false
      		  			},
    					"scroll-x":{},
    					"scale-x" : {
						  	//"values":"0:100", //Min/Max
						  	//"values":"0:100:10", //Min/Max/Step
        					"transform" : {
            				"type" : "date"
        						},
    					   "item" : {
   					        "font-size" : 10
      						},
        					"zooming" : true
        					},
    					"scale-y":{
    					   "autoFit":true,
    					   "min-value":"auto",
    					   "short":true,
    					   "label":{
    					       "text":"Micro Blocks"
    					   	},
    					   "item":{
    					       "fontSize":10
    					    	},
    					   "guide":{
    					       "lineStyle":"solid"
    					    	}
    						}
     		   			
     		   			
        				}  // data
			} // render
  ); // end
  
 /////////////////////////////////////////////////////////////
 
 
</script>






