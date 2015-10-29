<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?=$judul;?></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="<?=locationAsset('url');?>plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=locationAsset('url');?>plugins/fontawesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=locationAsset('url');?>themes/backend/lte/dist/css/default.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=locationAsset('url');?>themes/backend/lte/dist/css/skins/_all-skins.css" rel="stylesheet" type="text/css" /> 
    <link href="<?=locationAsset('url');?>css/dashboard.css" rel="stylesheet" type="text/css" /> 
    <script src="<?=locationAsset('url');?>plugins/jquery/jquery-1.11.3.min.js"></script>
    
    <style>
    	.ui-datepicker-month
		{
		    color: #2a2a2a;
		}

		.ui-datepicker-year
		{
		    color: #2a2a2a;
		}
    </style>
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="skin-black sidebar-mini">
    <div class="wrapper">
      
      <header class="main-header">
        <a href="<?=base_url(roleURIUser().'dashboard');?>" class="logo">
          <span class="logo-mini"><b>C</b>MS</span>
          <span class="logo-lg"><b><?=optionGet('app_name');?></b></span>
        </a>
        <nav class="navbar navbar-static-top" role="navigation">
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="<?=userAvatar('64');?>" class="user-image" alt="User Image"/>
                  <span class="hidden-xs"><?=userInfo('nama');?></span>
                </a>
                <ul class="dropdown-menu">
                  <li class="user-header">
                    <img src="<?=userAvatar('64');?>" class="img-circle" alt="User Image" />
                    <p>
                      <?=userInfo('nama');?> - <?=strtoupper(roleUser());?>
                    </p>
                  </li>                  
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="<?=base_url(roleURIUser().'profil');?>" class="btn btn-default btn-flat"><?=langGet("menu","menu_profile");?></a>
                    </div>
                    <div class="pull-right">
                      <a href="<?=base_url(routeGet('logout'));?>" class="btn btn-default btn-flat"><?=langGet("menu","menu_logout");?></a>
                    </div>
                  </li>
                </ul>
              </li>
              <li>
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      
      <aside class="main-sidebar">
        <section class="sidebar">
          <div class="user-panel" style="display: none;">
            <div class="pull-left image">
              <img src="<?=userAvatar('64');?>" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
              <p><?=userInfo('nama');?></p>              
            </div>
          </div>
          
          <ul class="sidebar-menu">            
            <li><a href="<?=base_url(roleURIUser().'dashboard');?>"><i class="fa fa-dashboard"></i> <span><?=langGet("menu","menu_dashboard");?></span></a></li>
            <?php 
            include(MODPATH."manage/views/nav/navcontainer.php");
            ?>
          </ul>
        </section>
      </aside>

      <div class="content-wrapper">
        <section class="content-header">
          <h1>
            <?=$judul;?>            
          </h1>          
        </section>
        <section class="content">
          
        <div class="box box-primary">
        
        <div class="box-body" id="konten">
        <div class="col-md-12">        