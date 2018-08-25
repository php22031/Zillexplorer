<!DOCTYPE html>
<html>
<head>
    <title>ZC-PHP Demo</title>
    <script src="//cdn.zingchart.com/zingchart.min.js"></script>

</head>
<body>

<h3>Simple Bar Chart (Database)</h3>
<div id="myChart"></div>

<h3>Simple Area Chart (Hardcoded)</h3>
<div id="myChart2"></div>

<h3>Decent Line Chart (Level 1 Functions)</h3>
<div id="myChart3"></div>

<h3>Beautiful Chord Chart (Level 2 Function)</h3>
<div id="myChart4"></div>

<h3>Powerfull Mixed Chart (Level 3 Function)</h3>
<div id="myChart5"></div>

<?php
include "zc.php";

// you can setup your own local MySQL database too. There is plenty of documentation online. Give it a try.
$host = "127.0.0.1";
$port = 8889;
$username = "root";
$password = "root";
$db = "mydb";

$myQuery  = "SELECT date, unitsSold FROM feed_data";
$myQuery2 = "SELECT date, unitsSold AS 'Units', expected AS 'Expected', anotherMetric AS 'Competitor' FROM feed_data";
$myQuery3 = "SELECT unitsSold AS 'Units', expected AS 'Expected', anotherMetric AS 'Competitor' FROM feed_data";

// ################################ CHART 1 ################################

// This chart will use data pulled from our database
$zc = new ZC("myChart", "bar");

$zc->connect($host, $port, $username, $password, $db);
$data = $zc->query($myQuery2, true);
//$data = $zc->query($myQuery3, false);
$zc->closeConnection();

$zc->setSeriesData($data);
$zc->setSeriesText($zc->getFieldNames());
$zc->render();


// ################################ CHART 2 ################################
// This chart will use data from our app
$zc2 = new ZC("myChart2");// defaults to area type

$zc2->setSeriesData(0, [9,50,6,1,14,12]);
$zc2->setSeriesData(1, [34,24,16,11,44,52]);

$zc2->render();


// ################################ CHART 3 ################################
// This chart will be built using only Level 1 functions.
$zc3 = new ZC("myChart3");

// you can also set the data with an array of arrays
$zc3->setSeriesData( [[9,50,6,1,14,12], [34,24,16,11,44,52], [10,9,8,7,6,5]] );

$zc3->setChartType("line");
$zc3->setChartTheme("dark");
$zc3->setChartWidth("50%");
$zc3->setChartHeight("400");

$zc3->setTitle("Fruits Consumed");
$zc3->setSubtitle("North America");
$zc3->setLegendTitle("Fruits");
$zc3->setScaleXTitle("Year");
$zc3->setScaleYTitle("Bushels");
$zc3->setSeriesText( array("Apples","Oranges","Bananas") );
$zc3->setScaleXLabels( array("2011","2012","2013","2014","2015","2016") );

$zc3->render();


// ################################ CHART 4 ################################
// This chart will be built using the Level 2 function.

$seriesValues = array(
    array(35,42,67,89,35,42,67,89,35,42,67,89,35,42,67,0),
    array(28,40,39,36,35,42,67,89,35,42,67,89,35,42,67,0),
    array(28,40,39,36,35,42,67,89,35,42,67,89,35,42,67,0),
    array(28,40,39,36,35,42,67,89,35,42,67,89,35,42,67,0),
    array(28,40,39,36,35,42,67,89,35,42,67,89,35,42,67,0),
    array(28,40,39,36,35,42,67,89,35,42,67,89,35,42,67,0),
    array(28,40,39,36,35,42,67,89,35,42,67,89,35,42,67,0),
    array(28,40,39,36,35,42,67,89,35,42,67,89,35,42,67,0),
    array(28,40,39,36,35,42,67,89,35,42,67,89,35,42,67,0),
    array(28,40,39,36,35,42,67,89,35,42,67,89,35,42,67,0),
    array(28,40,39,36,35,42,67,89,35,42,67,89,35,42,67,0),
    array(28,40,39,36,35,42,67,89,35,42,67,89,35,42,67,0),
    array(28,40,39,36,35,42,67,89,35,42,67,89,35,42,67,0),
    array(28,40,39,36,35,42,67,89,35,42,67,89,35,42,67,0),
    array(28,40,39,36,35,42,67,89,35,42,67,89,35,42,67,0),
    array(28,40,39,36,35,42,67,89,35,42,67,89,35,42,67,0)
);
$colorPalette = array(
    "#F44336","#E91E63","#9C27B0","#673AB7",
    "#3F51B5","#2196F3","#03A9F4","#00BCD4",
    "#009688","#4CAF50","#8BC34A","#CDDC39",
    "#FFEB3B","#FFC107","#FF9800","#FF5722"
);
$seriesText = array(
    "Major donors","New mixed giver","New COG","Active mixed giver",
    "Active COG","New cash","Lapsing COG active cash","Lapsing COG",
    "Active cash","Active action","Lapsed COG","Lapsed cash",
    "Lapsed action","Emailable","Other","New contact"
);

$zc4 = new ZC("myChart4", "chord", "light", "800", "1000");// defaults to light theme

$zc4->setConfig("series", $seriesValues);

for ($i = 0; $i < count($seriesValues); $i++) {
    $seriesIndexValues = "series[$i].values";
    $seriesIndexText = "series[$i].text";
    $zc4->setConfig($seriesIndexValues, $seriesValues[$i]);
    $zc4->setConfig($seriesIndexText, $seriesText[$i]);
}

$zc4->setConfig("options.angle-padding", 1);
$zc4->setConfig("options.color-type", "palette");
$zc4->setConfig("options.palette", $colorPalette);

$zc4->render();


// ################################ CHART 5 ################################
$myChartConfig = <<< EOT
{
    "background-color":"#ecf2f6",
    "graphset":[
        {
            "type":"bar",
            "background-color":"#fff",
            "border-color":"#dae5ec",
            "border-width":"1px",
            "height":"30%",
            "width":"96%",
            "x":"2%",
            "y":"2%",
            "title":{
                "margin-top":"7px",
                "margin-left":"9px",
                "font-family":"Arial",
                "text":"DEPARTMENT PERFORMANCE",
                "background-color":"none",
                "shadow":0,
                "text-align":"left",
                "font-size":"11px",
                "font-weight":"bold",
                "font-color":"#707d94"
            },
            "scale-y":{
                "values":"0:300:100",
                "max-ticks":4,
                "max-items":4,
                "line-color":"none",
                "tick":{
                    "visible":false
                },
                "item":{
                    "font-color":"#8391a5",
                    "font-family":"Arial",
                    "font-size":"10px",
                    "padding-right":"5px"
                },
                "guide":{
                    "rules":[
                        {
                     "rule":"%i == 0",
                     "line-width":0
                        },
                        {
                            "rule":"%i > 0",
                           "line-style":"solid",
                            "line-width":"1px",
                            "line-color":"#d2dae2",
                             "alpha":0.4 
                        }
                    
                    ]
                }
            },
            "scale-x":{
                "items-overlap":true,
                "max-items":9999,
                "values":["Apparel","Drug","Footwear","Gift Card","Home","Jewelry","Garden","Other"],
                "offset-y":"1px",
                "line-color":"#d2dae2",
                "item":{
                    "font-color":"#8391a5",
                    "font-family":"Arial",
                    "font-size":"11px",
                    "padding-top":"2px"
                },
                "tick":{
                    "visible":false,
                    "line-color":"#d2dae2"
                },
                "guide":{
                    "visible":false
                }
            },
            "plotarea":{
                "margin":"45px 20px 38px 45px"
            },
            "plot":{
                "bar-width":"33px",
                "exact":true,
                "hover-state":{
                    "visible":false
                },
                "animation":{
                    "effect":"ANIMATION_SLIDE_BOTTOM"
                },
                "tooltip":{
                    "font-color":"#fff",
                    "font-family":"Arial",
                    "font-size":"11px",
                    "border-radius":"6px",
                    "shadow":false,
                    "padding":"5px 10px"
                }
            },
            "series":[
                {
                    "values":[150,165,173,201,185,195,162,125],
                    "styles":[
                        {
                            "background-color":"#4dbac0"
                        },
                        {
                            "background-color":"#25a6f7"
                        },
                        {
                            "background-color":"#ad6bae"
                        },
                        {
                            "background-color":"#707d94"
                        },
                        {
                            "background-color":"#f3950d"
                        },
                        {
                            "background-color":"#e62163"
                        },
                        {
                            "background-color":"#4e74c0"
                        },
                        {
                            "background-color":"#9dc012"
                        }
                    ]
                }
            ]
        },
        {
            "type":"hbar",
            "background-color":"#fff",
            "border-color":"#dae5ec",
            "border-width":"1px",
            "x":"2%",
            "y":"35.2%",
            "height":"63%",
            "width":"30%",
            "title":{
                "margin-top":"7px",
                "margin-left":"9px",
                "text":"BRAND PERFORMANCE",
                "background-color":"none",
                "shadow":0,
                "text-align":"left",
                "font-family":"Arial",
                "font-size":"11px",
                "font-color":"#707d94"
            },
            "scale-y":{
                "line-color":"none",
                "tick":{
                    "visible":false
                },
                "item":{
                    "visible":false
                },
                "guide":{
                    "visible":false
                }
            },
            "scale-x":{
                "values":["Kenmore","Craftsman","DieHard","Land's End","Laclyn Smith","Joe Boxer"],
                "line-color":"none",
                "tick":{
                    "visible":false
                },
                "item":{
                    "width":200,
                    "text-align":"left",
                    "offset-x":206,
                    "offset-y":-12,
                    "font-color":"#8391a5",
                    "font-family":"Arial",
                    "font-size":"11px",
                    "padding-bottom":"8px"
                },
                "guide":{
                    "visible":false
                }
            },
            "plot":{
                "bars-overlap":"100%",
                "bar-width":"12px",
                "thousands-separator":",",
                "tooltip":{
                    "font-color":"#ffffff",
                    "background-color":"#707e94",
                    "font-family":"Arial",
                    "font-size":"11px",
                    "border-radius":"6px",
                    "shadow":false,
                    "padding":"5px 10px"
                },
                "hover-state":{
                    "background-color":"#707e94"
                },
                "animation":{
                    "effect":"ANIMATION_EXPAND_LEFT"
                }
            },
            "plotarea":{
                "margin":"50px 15px 10px 15px"
            },
            "series":[
                {
                    "values":[103902,112352,121823,154092,182023,263523],
                    "-animation":{
                        "method":0,
                        "effect":4,
                        "speed":2000,
                        "sequence":0
                    },
                    "z-index":2,
                    "styles":[
                        {
                            "background-color":"#4dbac0"
                        },
                        {
                            "background-color":"#4dbac0"
                        },
                        {
                            "background-color":"#4dbac0"
                        },
                        {
                            "background-color":"#4dbac0"
                        },
                        {
                            "background-color":"#4dbac0"
                        },
                        {
                            "background-color":"#4dbac0"
                        }
                    ],
                    "tooltip-text":"$%node-value"
                },
                {
                    "max-trackers":0,
                    "values":[300000,300000,300000,300000,300000,300000],
                    "data-rvalues":[103902,112352,121823,154092,182023,263523],
                    "background-color":"#d9e4eb",
                    "z-index":1,
                    "value-box":{
                        "visible":true,
                        "offset-y":"-12px",
                        "offset-x":"-54px",
                        "text-align":"right",
                        "font-color":"#8391a5",
                        "font-family":"Arial",
                        "font-size":"11px",
                        "text":"$%data-rvalues",
                        "padding-bottom":"8px"
                    }
                }
            ]
        },
        {
            "type":"line",
            "background-color":"#fff",
            "border-color":"#dae5ec",
            "border-width":"1px",
            "width":"64%",
            "height":"63%",
            "x":"34%",
            "y":"35.2%",
            "title":{
                "margin-top":"7px",
                "margin-left":"12px",
                "text":"TODAY'S SALES",
                "background-color":"none",
                "shadow":0,
                "text-align":"left",
                "font-family":"Arial",
                "font-size":"11px",
                "font-color":"#707d94"
            },
            "plot":{
                "animation":{
                    "effect":"ANIMATION_SLIDE_LEFT"
                }
            },
            "plotarea":{
                "margin":"50px 25px 70px 46px"
            },
            "scale-y":{
                "values":"0:100:25",
                "line-color":"none",
                "guide":{
                    "line-style":"solid",
                    "line-color":"#d2dae2",
                    "line-width":"1px",
                    "alpha":0.5
                },
                "tick":{
                    "visible":false
                },
                "item":{
                    "font-color":"#8391a5",
                    "font-family":"Arial",
                    "font-size":"10px",
                    "padding-right":"5px"
                }
            },
            "scale-x":{
                "line-color":"#d2dae2",
                "line-width":"2px",
                "values":["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],
                "tick":{
                    "line-color":"#d2dae2",
                    "line-width":"1px"
                },
                "guide":{
                    "visible":false
                },
                "item":{
                    "font-color":"#8391a5",
                    "font-family":"Arial",
                    "font-size":"10px",
                    "padding-top":"5px"
                }
            },
            "legend":{
                "layout":"x4",
                "background-color":"none",
                "shadow":0,
                "margin":"auto auto 15 auto",
                "border-width":0,
                "item":{
                    "font-color":"#707d94",
                    "font-family":"Arial",
                    "padding":"0px",
                    "margin":"0px",
                    "font-size":"9px"
                },
                "marker":{
                    "show-line":"true",
                    "type":"match",
                    "font-family":"Arial",
                    "font-size":"10px",
                    "size":4,
                    "line-width":2,
                    "padding":"3px"
                }
            },
            "crosshair-x":{
                "lineWidth":1,
                "line-color":"#707d94",
                "plotLabel":{
                    "shadow":false,
                    "font-color":"#000",
                    "font-family":"Arial",
                    "font-size":"10px",
                    "padding":"5px 10px",
                    "border-radius":"5px",
                    "alpha":1
                },
                "scale-label":{
                    "font-color":"#ffffff",
                    "background-color":"#707d94",
                    "font-family":"Arial",
                    "font-size":"10px",
                    "padding":"5px 10px",
                    "border-radius":"5px"
                }
            },
            "tooltip":{
                "visible":false
            },
            "series":[
                {
                    "values":[69,68,54,48,70,74,98,70,72,68,49,69],
                    "text":"Kenmore",
                    "line-color":"#4dbac0",
                    "line-width":"2px",
                    "shadow":0,
                    "marker":{
                        "background-color":"#fff",
                        "size":3,
                        "border-width":1,
                        "border-color":"#36a2a8",
                        "shadow":0
                    },
                    "palette":0
                },
                {
                    "values":[51,53,47,60,48,52,75,52,55,47,60,48],
                    "text":"Craftsman",
                    "line-width":"2px",
                    "line-color":"#25a6f7",
                    "shadow":0,
                    "marker":{
                        "background-color":"#fff",
                        "size":3,
                        "border-width":1,
                        "border-color":"#1993e0",
                        "shadow":0
                    },
                    "palette":1,
                    "visible":1
                },
                {
                    "values":[42,43,30,50,31,48,55,46,48,32,50,38],
                    "text":"DieHard",
                    "line-color":"#ad6bae",
                    "line-width":"2px",
                    "shadow":0,
                    "marker":{
                        "background-color":"#fff",
                        "size":3,
                        "border-width":1,
                        "border-color":"#975098",
                        "shadow":0
                    },
                    "palette":2,
                    "visible":1
                },
                {
                    "values":[25,15,26,21,24,26,33,25,15,25,22,24],
                    "text":"Land's End",
                    "line-color":"#f3950d",
                    "line-width":"2px",
                    "shadow":0,
                    "marker":{
                        "background-color":"#fff",
                        "size":3,
                        "border-width":1,
                        "border-color":"#d37e04",
                        "shadow":0
                    },
                    "palette":3
                }
            ]
        }
    ]
}
EOT;
// This chart will be built using the Level 3 function.
$zc5 = new ZC("myChart5", "area", "classic", "100%", "500");

$zc5->trapdoor($myChartConfig);
$zc5->render();

?>
</body>
</html>
