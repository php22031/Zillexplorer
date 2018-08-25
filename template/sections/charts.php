<?php
/*
 * Copyright 2018 GPLv3, Zillexplorer by Mike Kilday: http://DragonFrugal.com
 */
?>

  <div id="difficulty_chart"></div>
  <br/><br/>
  <div id="transaction_chart"></div>
<?php

use ZingChart\PHPWrapper\ZC;

// Difficulty chart data //////////////////////////
$zc = new ZC("difficulty_chart");
$zc->setSeriesData( [ [9,50,6,1,14,12] ] );
$zc->setSeriesText( array("Difficulty") );
$zc->setChartType("line");
$zc->setChartTheme("classic");
$zc->setChartWidth("100%");
$zc->setChartHeight("400");
$zc->setTitle("Network Difficulty (demo only)");
$zc->setScaleYTitle("Difficulty");
$zc->setScaleXLabels( array("2011","2012","2013","2014","2015","2016") );
$zc->render();
//////////////////////////////////////////////////////


// Transaction chart data //////////////////////////
$zc2 = new ZC("transaction_chart");
$zc2->setSeriesData( [ [30,60,33,54,68,72] ] );
$zc2->setSeriesText( array("Transactions") );
$zc2->setChartType("line");
$zc2->setChartTheme("classic");
$zc2->setChartWidth("100%");
$zc2->setChartHeight("400");
$zc2->setTitle("Transactions Daily (demo only)");
$zc2->setScaleYTitle("Transactions");
$zc2->setScaleXLabels( array("1/01/18","1/08/18","1/15/18","1/22/18","1/29/18","2/05/18") );
$zc2->render();
//////////////////////////////////////////////////////

?>