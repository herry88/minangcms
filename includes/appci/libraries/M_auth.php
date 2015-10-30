<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_auth{
	
	private $CI;
	private $ses_role;
	private $ses_user;
	
	function __construct(){
		$this->CI=& get_instance();		
		$this->CI->load->library(array('m_database','m_security','auth/forgedbauth','session'));
		$this->CI->load->helper(array('db_helper'));
		$this->setSession();
	}
	
	
	function login(){
		$token=tokenGenerate();
		$this->CI->m_security->filterPost('muser_'.$token,'trim|required|min_length[1]');
		$this->CI->m_security->filterPost('mpass_'.$token,'trim|required|min_length[1]');
		if($this->CI->m_security->startPost()==TRUE){
			$user=$this->CI->input->post('muser_'.$token,TRUE);
			$pass=$this->CI->input->post('mpass_'.$token,TRUE);
			$remember=$this->CI->input->post('mremember');
			
			$rememberX='0';
			if($remember){
				$rememberX='1';
			}else{
				$rememberX='0';
			}
			
			$this->CI->load->library('auth/abstractauth');
			
			$proses=$this->CI->abstractauth->loginDo($user,$pass,$rememberX);
			
			if($proses==FALSE){
				redirect(base_url(routeGet('login').'?s=2'),'refresh');
			}else{
				runService('login','destroy');
				$checkUser=array(
				'username'=>$user,
				);
				$userid=$this->CI->m_database->fieldRow('userlogin',$checkUser,'user_id');
				$role=taxonomyRead($userid,'role_user');
				$this->createSessionLogin($user,$role,$rememberX);
				redirect(base_url().roleDirectUser(),'refresh');
			}
			
		}else{
			redirect(base_url(routeGet('login').'?s=1'),'refresh');
		}
	}
	
	
	function registerUser($username,$password,$nama,$hp,$email,$role,$status,$sendmail=FALSE){
		$this->CI->load->library('auth/abstractauth');
		$proses=$this->CI->abstractauth->registerDo($username,$password,$nama,$hp,$email,$role,$status,$sendmail);
		if($proses==TRUE){
			return true;
		}else{
			return false;
		}
	}
	
	function isLogin(){
		$opt=optionGet('session_role');
		$opt1=optionGet('session_user');		
		$a=$this->CI->session->userdata($opt);
		$b=$this->CI->session->userdata($opt1);
		$c=$this->CI->session->userdata('remember');
		
		if(!empty($a) && !empty($b) && $c=="1"){
			return true;
		}else{
			return false;
		}
		
	}
	
	private function setSession(){
		$dbrole=optionGet('session_role');
		$dbuser=optionGet('session_user');
		
		if(empty($dbrole)){
			optionSet('session_role','minang_role_session');
			$this->ses_role='minang_role_session';
		}else{
			$this->ses_role=$dbrole;
		}
		
		if(empty($dbuser)){
			optionSet('session_user','minang_user_session');
			$this->ses_user='minang_user_session';
		}else{
			$this->ses_user=$dbuser;
		}
	}
	
	private function createSessionLogin($user,$role,$remember='0'){
		$this->CI->session->set_userdata($this->ses_role,$role);
		$this->CI->session->set_userdata($this->ses_user,$user);
		$this->CI->session->set_userdata('remember',$remember);
	}		
	
	function logoutDo(){
		$this->CI->session->unset_userdata($this->ses_user);
        $this->CI->session->unset_userdata($this->ses_role);
        unset($_SESSION[$this->ses_role]);
        unset($_SESSION[$this->ses_user]);
	}
	
	function addRole($name,$key,$module){
		$d=array(
		'role_name'=>$name,
		'role_key'=>$key,
		'role_module'=>$module,
		);
		if($this->CI->m_database->addRow('userrole',$d)==TRUE){
			return true;
		}else{
			return false;
		}
	}
	
	function editRole($roleid,$name,$key,$module){
		$s=array(
		'role_id'=>$roleid,
		);
		if($this->CI->m_database->isBOF('userrole',$s)==TRUE){
			return false;
		}else{
			$d=array(
			'role_name'=>$name,
			'role_key'=>$key,
			'role_module'=>$module,
			);
			if($this->CI->m_database->editRow('userrole',$d,$s)==TRUE){
				return true;
			}else{
				return false;
			}
		}
	}
	
	function deleteRole($roleid,$name,$key,$module){
		$s=array(
		'role_id'=>$roleid,
		);
		if($this->CI->m_database->isBOF('userrole',$s)==TRUE){
			return false;
		}else{			
			if($this->CI->m_database->deleteRow('userrole',$s)==TRUE){
				return true;
			}else{
				return false;
			}
		}
	}
	
	function changeStatus($userid,$status){
		$s=array(
		'user_id'=>$userid,
		);
		if($this->CI->m_database->isBOF('userlogin',$s)==TRUE){
			return false;
		}else{
			$d=array(
			'status'=>$status,
			);
			if($this->CI->m_database->editRow('userlogin',$d,$s)==TRUE){
				return true;
			}else{
				return false;
			}
		}
	}
	
	function deleteUser($userid){
		$s=array(
		'user_id'=>$userid,
		);
		if($this->CI->m_database->isBOF('userlogin',$s)==TRUE){
			return false;
		}else{
			taxonomyRemove($userid);			
			if($this->CI->m_database->deleteRow('userlogin',$s)==TRUE){
				return true;
			}else{
				return false;
			}
		}
	}
	
	function recoveryUser($userid,$newPass=''){
		$s=array(
		'user_id'=>$userid,
		);
		if($this->CI->m_database->isBOF('userlogin',$s)==TRUE){
			return false;
		}else{
			if(!empty($newPass)){
				$dbpass=$this->CI->m_security->createPassword($newPass);
				$d=array(
				'password'=>$dbpass,
				);
				if($this->CI->m_database->editRow('userlogin',$d,$s)==TRUE){
					return true;
				}else{
					return false;
				}
			}else{
				$this->CI->load->library('auth/abstractauth');
				$email=$this->CI->m_database->fieldRow('userlogin',$s,'email');
				if($this->CI->abstractauth->recoveryDo($email)==TRUE){
					return true;
				}else{
					return false;
				}
			}			
		}
	}
	
}