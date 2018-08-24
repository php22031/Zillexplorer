<?php
/*
 * Copyright 2018 GPLv3, Zillexplorer by Mike Kilday: http://DragonFrugal.com
 */
?>
	<!-- START #topnav-content -->
    <nav id="topnav-content" class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand<?=( $_SERVER['REQUEST_URI'] == '/' ? ' active' : '' )?>" href="/">Zillexplorer</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li<?=( preg_match("/live-stats/i", $_SERVER['REQUEST_URI']) ? ' class="active"' : '' )?>><a href="/live-stats/">Stats <span class="sr-only">(current)</span></a></li>
        <li<?=( preg_match("/tokens/i", $_SERVER['REQUEST_URI']) ? ' class="active"' : '' )?>><a href="/tokens/">Tokens</a></li>        
        <?php
        $more_menu = array(
        							'/charts/',
        							'/mining-calculator/',
        							'/broadcast-transaction/',
        							'/top-accounts/'
       							 );
        ?>
        <li class="dropdown <?=( in_array($_SERVER['REQUEST_URI'], $more_menu) ? 'active' : '' )?>">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">More <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li<?=( preg_match("/charts/i", $_SERVER['REQUEST_URI']) ? ' class="active"' : '' )?>><a href="/charts/">Charts</a></li>
            <li role="separator" class="divider"></li>
            <li<?=( preg_match("/mining-calculator/i", $_SERVER['REQUEST_URI']) ? ' class="active"' : '' )?>><a href="/mining-calculator/">Mining Calculator</a></li>
            <li role="separator" class="divider"></li>
            <li<?=( preg_match("/broadcast-transaction/i", $_SERVER['REQUEST_URI']) ? ' class="active"' : '' )?>><a href="/broadcast-transaction/">Broadcast Transaction</a></li>
            <li role="separator" class="divider"></li>
            <li<?=( preg_match("/top-accounts/i", $_SERVER['REQUEST_URI']) ? ' class="active"' : '' )?>><a href="/top-accounts/">Top Accounts</a></li>
          </ul>
        </li>
      </ul>
      <form class="navbar-form navbar-left">
        <div class="form-group">
          <input id='search_input' type="text" value='<?=$_GET['q']?>' class="form-control" placeholder="Address / Transaction...">
        </div>
        <button type="button" class="btn btn-default" onclick='window.location = "/search/" + document.getElementById("search_input").value;'>Search</button>
      </form>
      <ul class="nav navbar-nav navbar-right">
        <!-- <li><a href="#">Link</a></li> -->
        <li class="dropdown <?=( preg_match("/online-account/i", $_SERVER['REQUEST_URI']) ? 'active' : '' )?>">
          <a id='login-nav' href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src='/images/login.png' width='30' border='0' /><span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li<?=( preg_match("/online-account\/summary/i", $_SERVER['REQUEST_URI']) ? ' class="active"' : '' )?>><a href="/online-account/summary/">Summary</a></li>
            <li<?=( preg_match("/online-account\/alerts/i", $_SERVER['REQUEST_URI']) ? ' class="active"' : '' )?>><a href="/online-account/alerts/">Alerts</a></li>
            <li<?=( preg_match("/online-account\/api/i", $_SERVER['REQUEST_URI']) ? ' class="active"' : '' )?>><a href="/online-account/api/">API</a></li>
            <li role="separator" class="divider"></li>
            <li<?=( preg_match("/online-account\/login/i", $_SERVER['REQUEST_URI']) ? ' class="active"' : '' )?>><a href="/online-account/login/">Login</a></li>
            <li><a href="/online-account/logout/">Logout</a></li>
            <li<?=( preg_match("/online-account\/register/i", $_SERVER['REQUEST_URI']) ? ' class="active"' : '' )?>><a href="/online-account/register/">Register</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
    <!-- END #topnav-content -->
    
    