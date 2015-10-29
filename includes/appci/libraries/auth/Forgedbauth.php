<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forgedbauth{
	
	
	private $CI;
	
	
	function __construct(){
		$this->CI=& get_instance();
		$this->CI->load->library(array('m_database','m_security'));
		$this->CI->load->helper('db_helper');
		
	}
	
	private function FirstUser(){
		$a=$this->CI->m_database->toolsTableExits('userrole');
		$b=$this->CI->m_database->toolsTableExits('userlogin');
		$c=$this->CI->m_database->toolsTableExits('usertaxonomy');
				
		$c=$this->CI->m_database->isBOF('userlogin');
		if($c==TRUE){
			$this->createAdmin('admin','admin','Administrator','admin@locahost','123456789');
		}
	}
	
	function FirstRoute(){
		$c=$this->CI->m_database->isBOF('route');
		if($c==TRUE){
			$this->createRoute();
		}
	}
	
	function createRoute(){
		$data=array(
	    	array(
	    	'route_name'=>'logout',
	    	'route_key'=>'logout',
	    	'route_val'=>'authentication/auth/logoutdo'
	    	),
	    	array(
	    	'route_name'=>'login',
	    	'route_key'=>'login',
	    	'route_val'=>'authentication/auth'
	    	),
	    	array(
	    	'route_name'=>'loginproccess',
	    	'route_key'=>'logindo',
	    	'route_val'=>'authentication/auth/logindo'
	    	),
	    	array(
	    	'route_name'=>'register',
	    	'route_key'=>'register',
	    	'route_val'=>'authentication/auth/register'
	    	),
	    	array(
	    	'route_name'=>'registerprocess',
	    	'route_key'=>'registerdo',
	    	'route_val'=>'authentication/auth/registerdo'
	    	),
	    	array(
	    	'route_name'=>'forgot',
	    	'route_key'=>'forgot',
	    	'route_val'=>'authentication/auth/forgot'
	    	),
	    	array(
	    	'route_name'=>'forgotproccess',
	    	'route_key'=>'forgotdo',
	    	'route_val'=>'authentication/auth/forgotdo'
	    	),
	    );
	    	    
	    $this->CI->m_database->addRowBatch('route',$data);
	}
	
	private function createAdmin($user,$pass,$name,$email,$phone){
		
		$dRole=array(
		'role_id'=>'1',
		'role_name'=>'Administrator',
		'role_key'=>'mimin',
		'role_module'=>'backend/mimin/dashboard',
		);
				
		$this->CI->m_database->addRow('userrole',$dRole);
		
		$dbpass=$this->CI->m_security->createPassword($pass);
		$dUser=array(
		'user_id'=>'3',
		'username'=>$user,
		'password'=>$dbpass,
		'nama'=>$name,
		'user_email'=>$email,
		'hp'=>$phone,
		'status'=>'active',
		);
		
		$this->CI->m_database->addRow('userlogin',$dUser);
		$IDuser=$this->CI->m_database->lastInsertID();
		
		$dTaxo=array(
		'user_id'=>$IDuser,
		'taxo_key'=>'role_user',
		'taxo_val'=>'1',
		);
		
		$this->CI->m_database->addRow('usertaxonomy',$dTaxo);
		
		
		optionSet('company_email',$email);
		optionSet('company_name',$name);
		optionSet('company_phone',$phone);
		optionSet('company_fax','');
		optionSet('app_name','Minang Igniter');
		optionSet('app_basename','MinangCI');
		optionSet('app_version','1.0');
		optionSet('email_register_subject','Registrasi Email');
		optionSet('email_register_message','Terima Kasih telah mendaftar pada website kami. Berikut login detail anda');
		optionSet('email_recovery_subject','Permintaan Reset Password');
		optionSet('email_recovery_message','Anda telah meminta untuk me-reset password anda. Silahkan klik tautan di bawah ini');
		
		optionSet('service_login_captcha','1');		
		optionSet('service_login_bruceforce','0');
		optionSet('captcha_savepath','');
		optionSet('captcha_type','simple');
		optionSet('captcha_data','');
				
		optionSet('cookie_app','minangci');
		optionSet('encrypt_app',md5('minangci'));
		optionSet('app_register','0');
		
		optionSet('theme_backend','gentella');
		optionSet('theme_front','');
		optionSet('site_offline','0');
		
		
		
	}
	
	private function forgeUserlogin(){
		$this->CI->load->dbforge();
		$fields = array(
                'user_id' => array(
                              'type' => 'BIGINT',
                              'constraint' => 13,
                              'unsigned' => TRUE,
                              'auto_increment' => TRUE
                          ),
				'username' => array(
                              'type' => 'VARCHAR',
							  'constraint' => '60'
                          ),
                'password' => array(
                              'type' => 'VARCHAR',
                              'constraint' => '125'
                          ),
                'nama' => array(
                              'type' => 'VARCHAR',
                              'constraint' => '120'
                          ),
                'hp' => array(
                              'type' => 'VARCHAR',
                              'constraint' => '30'
                          ),
                'status' => array(
                              'type' => 'VARCHAR',
                              'constraint' => '10'
                          ),
                'email' => array(
                              'type' => 'VARCHAR',
                              'constraint' => '60'
                          )
		);
		
	    $this->CI->dbforge->add_field($fields);
	    $this->CI->dbforge->add_key('user_id',TRUE);
	    $this->CI->dbforge->add_key('username');
	    $this->CI->dbforge->create_table("userlogin", TRUE);
	}
	
	
	private function forgeRole(){
		$this->CI->load->dbforge();
		$fields = array(
                'role_id' => array(
                              'type' => 'INT',
                              'constraint' => 4,
                              'auto_increment' => TRUE
                          ),
				'role_name' => array(
                              'type' => 'VARCHAR',
							  'constraint' => '60'
                          ),
                'role_key' => array(
                              'type' => 'VARCHAR',
							  'constraint' => '60'
                          ),
                'role_module' => array(
                              'type' => 'VARCHAR',
                              'constraint' => '125'
                          )
		);
		
	    $this->CI->dbforge->add_field($fields);
	    $this->CI->dbforge->add_key('role_id',TRUE);
	    $this->CI->dbforge->add_key('role_name');
	    $this->CI->dbforge->create_table("userrole", TRUE);
	}
	
	private function forgeTaxonomy(){
		$this->CI->load->dbforge();
		$fields = array(
                'taxo_id' => array(
                              'type' => 'BIGINT',
                              'constraint' => 13,
                              'unsigned' => TRUE,
                              'auto_increment' => TRUE
                          ),
                'user_id' => array(
                              'type' => 'BIGINT',
                              'constraint' => 13,
                              'unsigned' => TRUE
                          ),
				'taxo_key' => array(
                              'type' => 'VARCHAR',
							  'constraint' => '60'
                          ),
                'taxo_val' => array(
                              'type' => 'TEXT'
                          ),
                'taxo_expired' => array(
                              'type' => 'DATETIME',
                              'null'=>TRUE
                          )
		);
		
	    $this->CI->dbforge->add_field($fields);
	    $this->CI->dbforge->add_key('taxo_id',TRUE);
	    $this->CI->dbforge->create_table("usertaxonomy", TRUE);
	}
	
	private function forgeOption(){
		$this->CI->load->dbforge();
		$fields = array(
                'option_id' => array(
                              'type' => 'BIGINT',
                              'constraint' => 13,
                              'unsigned' => TRUE,
                              'auto_increment' => TRUE
                          ),
				'option_key' => array(
                              'type' => 'VARCHAR',
							  'constraint' => '60'
                          ),
                'option_val' => array(
                              'type' => 'TEXT'
                          ),
                'tipe' => array(
                              'type' => 'VARCHAR',
                              'constraint' => '20'
                          ),
                'sistem' => array(
                              'type' => 'TINYINT',
                              'constraint' => '1'
                          ),
		);
		
	    $this->CI->dbforge->add_field($fields);
	    $this->CI->dbforge->add_key('option_id',TRUE);
	    $this->CI->dbforge->add_key('option_key');
	    $this->CI->dbforge->create_table("options", TRUE);
	}
	
	private function forgeRoute(){
		$this->CI->load->dbforge();
		$fields = array(
                'route_id' => array(
                              'type' => 'BIGINT',
                              'constraint' => 13,
                              'unsigned' => TRUE,
                              'auto_increment' => TRUE
                          ),
				'route_name' => array(
                              'type' => 'VARCHAR',
							  'constraint' => '60'
                          ),
                'route_key' => array(
                              'type' => 'VARCHAR',
							  'constraint' => '200'
                          ),
                'route_val' => array(
                              'type' => 'VARCHAR',
                              'constraint' => '200'
                          )
		);
		
	    $this->CI->dbforge->add_field($fields);
	    $this->CI->dbforge->add_key('route_id',TRUE);
	    $this->CI->dbforge->add_key('route_key');
	    $this->CI->dbforge->create_table("route", TRUE);
	    
	    
	    
	}
	
}