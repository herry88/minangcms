<?php
global $install;

if($install->checkinstall()==TRUE){	
?>
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
<?php

$configDB=APPPATH.'config/database.php';
$error="";
if(isset($_POST)){
if(!empty($_POST['hostname']) && !empty($_POST['username']) && !empty($_POST['database'])){
	$host=$_POST['hostname'];
	$username=$_POST['username'];
	$password=$_POST['password'];
	$database=$_POST['database'];
	$proses=$install->executeinstall($host,$username,$password,$database);
	if($proses==TRUE){
		$redir = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
      	$redir .= "://".$_SERVER['HTTP_HOST'];
      	$redir .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
      	
      	header( 'Location: ' . $redir.'login' );
	}
}else{
	$error="Konfigurasi database tidak sesuai";
}
}
if(is_writeable($configDB)){	
?>
    <div class="form-entri">	  
	  <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">	  	
		<h4 class="text-center">Konfigurasi MySQL (MySQLi Support Only)</h4>
		<div class="form-group">
	  		<label>Hostname</label>			  		
	  		<input type="text" id="hostname" name="hostname" class="form-control" required="" value="localhost" placeholder="Contoh localhost,111.111.111.111"/>			  		
	  	</div>
	  	<div class="form-group">
	  		<label>Username</label>			  		
	  		<input type="text" id="username" name="username" class="form-control" required="" value="root" placeholder="Contoh root,usermysql"/>			  		
	  	</div>
	  	<div class="form-group">
	  		<label>Password</label>			  		
	  		<input type="text" id="password" name="password" class="form-control" placeholder="Boleh diisi atau tidak, sesuai password database anda"/>
	  	</div>
	  	<div class="form-group">
	  		<label>Database</label>			  		
	  		<input type="text" id="database" name="database" class="form-control" required="" value="" placeholder="Buat database terlebih dahulu pada mysql anda"/>	  		
	  	</div>
	  	<hr/>	  	
	  	<div class="form-group">	  		
			<button type="submit" class="btn btn-primary btn-block">Install</button>	  		
		</div>
	  </form>
	  </div>
<?php }else{
	die("File config database tidak dapat ditulis. Lakukan pengubahan hak izin menulis file CHMOD 0777");
}
?>
    </div>
  </body>
</html>
<?php }else{
	die("tedeeet");
}