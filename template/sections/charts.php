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
      		  			"values": [<?=file_get_contents('cache/charts/ds-blocks.dat')?>],
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
      		  			"values": [<?=file_get_contents('cache/charts/tx-blocks-tx.dat')?>],
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
      		  			"values": [<?=file_get_contents('cache/charts/tx-blocks-gas.dat')?>],
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
      		  			"values": [<?=file_get_contents('cache/charts/tx-blocks-microblocks.dat')?>],
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






