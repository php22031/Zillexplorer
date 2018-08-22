<?php
/*
 * Copyright 2018 GPLv3, Zillexplorer by Mike Kilday: http://DragonFrugal.com
 */
?>
	<!-- START #sidebar-content -->
    <div id="sidebar-content" class="col-sm-3 sidenav">
      <h4><a href='/'>Zillexplorer</a></h4>
      <ul class="nav nav-pills nav-stacked">
        <li class="active"><a href="#section1">Section #1</a></li>
        <li><a href="#section2">Section #2</a></li>
        <li><a href="#section3">Section #3</a></li>
      </ul><br>
      <div class="input-group">
      <form id='zill_search' method='get' action='#'>
        <input type="text" id='search_input' name='search_input' value='<?=$_GET['q']?>' class="form-control" placeholder="Search address / transaction...">
      </form>
        <span class="input-group-btn">
          <button class="btn btn-default" type="button" onclick='window.location = "/search/" + document.getElementById("search_input").value;'>
            <span class="glyphicon glyphicon-search"></span>
          </button>
        </span>
      </div>
    </div>
    <!-- END #sidebar-content -->