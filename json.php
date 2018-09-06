<?php
/*
 * Copyright 2018 GPLv3, Zillexplorer by Mike Kilday: http://DragonFrugal.com
 */
 
if ( $_GET['output'] == 'ds-blocks' ) {
?>
						{
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
     		   			
     		   			
        				}
<?php
}
elseif ( $_GET['output'] == 'tx-blocks-tx' ) {
?>
						{
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
     		   			
     		   			
        				}
<?php
}
elseif ( $_GET['output'] == 'tx-blocks-gas' ) {
?>
						{
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
     		   			
     		   			
        				}
<?php
}
elseif ( $_GET['output'] == 'tx-blocks-microblocks' ) {
?>
						{
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
     		   			
     		   			
        				}
<?php
}
?>