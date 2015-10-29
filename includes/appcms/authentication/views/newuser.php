<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Minang CMS Installer</title>
    <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
		body {
		  padding-top: 40px;
		  padding-bottom: 40px;
		  background-color: #eee;
		}
		.form-entri {
		  max-width: 768px;
		  padding: 15px;
		  margin: 0 auto;
		}
	</style>
  </head>
  <body>
    <div class="container">
    <div class="form-entri">	  
	  <form method="post" action="<?=base_url(routeGet('freshinstall','route_key'));?>">	  	
		<h4 class="text-center">New Administrator</h4>
		<div class="form-group">
	  		<label>Nama</label>			  		
	  		<input type="text" id="nama" name="nama" class="form-control" required="" value="" placeholder="Nama Akun Anda"/>			  		
	  	</div>
	  	<div class="form-group">
	  		<label>Username</label>			  		
	  		<input type="text" id="username" name="username" class="form-control" required="" value="" placeholder="Username untuk login"/>			  		
	  	</div>
	  	<div class="form-group">
	  		<label>Password</label>			  		
	  		<input type="password" id="password" name="password" class="form-control" required="" value="" placeholder="password untuk login"/>			  		
	  	</div>
	  	<div class="form-group">
	  		<label>Email</label>			  		
	  		<input type="email" id="email" name="email" class="form-control" required="" value="" placeholder="Email yang digunakan harus valid, agar nantinya reset password mudah"/>
	  	</div>
	  	<hr/>	  	
	  	<div class="form-group">	  		
			<button type="submit" class="btn btn-primary btn-block">Install</button>	  		
		</div>
	  </form>
	  </div>
    </div>
  </body>
</html>