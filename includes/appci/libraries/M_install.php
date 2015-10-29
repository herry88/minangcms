<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_install{
	
	
	private $CI;
	private $dirInstall="installer";
	private $isInstall=false;
	private $isConfig=false;
	public $step=0;
	function __construct(){
				
		
		if($this->checkConnection()==false){
			$this->isConfig=false;
		}else{
			$this->isConfig=true;
		}
	}
	
	
	function checkinstall(){
		if($this->isConfig==false){
			return true;
		}else{
			
			return false;
		}
	}
	
	function executeinstall($host,$user,$pass,$db){
		
		if($this->installDBConfig($host,$user,$pass,$db)==TRUE){
			if($this->dumpDB($host,$user,$pass,$db)==TRUE){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	function installDBConfig($host,$user,$pass,$dbname){
		$template=APPPATH.'config/databasetemplate.php';
		$output=APPPATH.'config/database.php';
		
		$getFile=file_get_contents($template);
		$new  = str_replace("%HOST%",$host,$getFile);
		$new  = str_replace("%USER%",$user,$new);
		$new  = str_replace("%PASS%",$pass,$new);
		$new  = str_replace("%DB%",$dbname,$new);
		
		$handle = fopen($output,'w+');
		@chmod($output,0777);
		if(is_writable($output)) {
			if(fwrite($handle,$new)) {
				return true;
			} else {
				return false;
			}

		} else {
			return false;
		}
	}
	
	function dumpDB($host,$user,$pass='',$db){
		$sqlFile=APPPATH.'config/dumpdb.sqlz';
		$mysqli = new mysqli($host,$user,$pass,$db);

		// Check for errors
		if(mysqli_connect_errno())
			return false;

		// Open the default SQL file
		$query = file_get_contents($sqlFile);

		// Execute a multi query
		$mysqli->multi_query($query);
		
		// Close the connection
		$mysqli->close();

		return true;
	}
	
	function installAdmin($host,$user,$pass='',$db,$username,$password,$email){				
		require_once APPPATH.'libraries/hash/pbkdf2.php';
		$passdb=create_hash($password);
		$nama=ucfirst($username);
		$sql1="insert into userlogin (user_id,username,password,nama,email,status) values ('3','$username','$passdb','$nama','$email','active'); insert into usertaxonomy values(user_id,taxo_key,taxo_val) values ('3','role_user','1');";
		
		$mysqli = new mysqli($host,$user,$pass,$db);

		// Check for errors
		if(mysqli_connect_errno())
			return false;

		// Execute a multi query
		$mysqli->multi_query($sql1);
		
		// Close the connection
		$mysqli->close();

		return true;
		
	}
	
	
	
	function checkConnection(){
		require_once APPPATH.'config/database.php';
		$host=isset($db['default']['hostname']) ? $db['default']['hostname'] : "";
		$user=isset($db['default']['username']) ? $db['default']['username'] : "";
		$pass=isset($db['default']['password']) ? $db['default']['password'] : "";
		$dbnm=isset($db['default']['database']) ? $db['default']['database'] : "";
				
		if(empty($host) or empty($user) or empty($dbnm)){
			return false;
		}else{
			$mysqli = new mysqli($host,$user,$pass,$dbnm);		
			if(mysqli_connect_errno()){
				$mysqli->close();
				return false;
			}else{
				$sqlTable="SELECT * FROM options";
				$j=$mysqli->query($sqlTable)->num_rows;				
				if($j < 1){
					return false;
				}else{
					return true;
				}				
			}
		}		
	}
	
}

?>