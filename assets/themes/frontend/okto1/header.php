<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?=$title;?></title>
<link href="<?=locationTheme();?>frontend/okto1/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="<?=locationTheme();?>frontend/okto1/dist/css/style.css" rel="stylesheet">
<link href="<?=locationTheme();?>frontend/okto1/dist/css/reset.css" rel="stylesheet">
<link rel="shortcut icon" href="<?=mc_favicon();?>" type="image/x-icon" />
</head>
<body>
<div class="container body-wrapper">
<!--- MENU HEADER -->
<div class="top">
<div class="row">
	<div class="col-md-3">
		<a class="top-logo" href="<?=base_url();?>"><img src="<?=mc_logo();?>"/></a>
	</div>
	<div class="col-md-6">
		<div class="site-title">
		<?=optionGet('site_title');?>
		</div>
		<div class="site-description">
		<?=optionGet('site_description');?>
		</div>
	</div>
	<div class="col-md-3">
		<form class="search-box" method="get" action="<?=base_url();?>search">
			<input type="text" name="s" class="form-control" placeholder="cari.."/>
		</form>
	</div>
</div>
</div>
<div class="menu-header">
<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?=base_url();?>"><img src="<?=mc_favicon();?>"/></a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">      	      
        <?php echo menuTop();?>
      </ul>
    </div>
  </div>
</nav>
</div>
<!--- END HEADER -->