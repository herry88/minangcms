<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$judul;?></title>    
    <link href="<?=locationPlugin();?>bootstrap/css/bootstrap.min.css" rel="stylesheet">    
    <link href="<?=locationAsset();?>css/style.css" rel="stylesheet">
    <link rel="shortcut icon" href="<?=mc_favicon();?>" type="image/x-icon" />
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
    	@media (min-width:768px){
			.navbar-brand{
				display: none;
			}
		}
		
		.li-social a,		
		.li-social a:active{
			color:#fff;			
		}
		
		.li-social a:hover{
			text-decoration: underline;
		}
		
    </style>
  </head>
  <body>
    <nav class="navbar navbar-inverse navbar-no-bg" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#top-navbar-1">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand"><img src="<?=mc_favicon();?>" width="34px;"/></a>
				</div>
				<div class="collapse navbar-collapse" id="top-navbar-1">
					<ul class="nav navbar-nav navbar-right">
						<span class="li-social">
						<a href="<?=base_url();?>" target="_blank">Website</a> | 
						<a href="herurahmat.my.id/minang-cms-open-source-content-management-system/" target="_blank">Minang CMS</a> | 
						<a href="https://github.com/urangawak/minangcms" target="_blank">Github</a>
						</span>
					</ul>
				</div>
			</div>
		</nav>

        <!-- Top content -->
        <div class="top-content">
        	
            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-7 text">
                        	<img src="<?=mc_logo();?>"/>
                            <h1><strong><?=optionGet('company_name');?></strong></h1>
                            <div class="description">
                            	<p>
                            	
                            	</p>
                            </div>                            
                        </div>
                        <div class="col-sm-5 form-box">