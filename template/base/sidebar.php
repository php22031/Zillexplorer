<?php
/*
 * Copyright 2018 GPLv3, Zillexplorer by Mike Kilday: http://DragonFrugal.com
 */
?>
	<!-- START #sidebar-content -->
    <div id="sidebar-content" class="col-sm-3 sidenav">
      <h4>Zillexplorer</h4>
      <ul class="nav nav-pills nav-stacked">
        <li class="active"><a href="#section1">Section #1</a></li>
        <li><a href="#section2">Section #2</a></li>
        <li><a href="#section3">Section #3</a></li>
      </ul><br>
      <div class="input-group">
      <form id='zill_search' method='get' action='./'>
      <input type='hidden' name='main_search' value='1' />
        <input type="text" name='search_value' value='<?=$_GET['search_value']?>' class="form-control" placeholder="Search...">
      </form>
        <span class="input-group-btn">
          <button class="btn btn-default" type="button" onclick='document.getElementById("zill_search").submit();'>
            <span class="glyphicon glyphicon-search"></span>
          </button>
        </span>
      </div>
    </div>
    <!-- END #sidebar-content -->