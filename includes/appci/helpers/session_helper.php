<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('secToken')){
	function tokenGenerate()
	{
		$CI=& get_instance();		
		$tok= $CI->security->get_csrf_hash();
	    if(empty($tok))
	    {
	        return $CI->session->session_id;
	    }else{
	        return $tok;
	    }
	}
}

if(!function_exists('secTokenVerify')){
	function tokenVerify($str)
	{

	    $CI=& get_instance();
		$tok= $CI->security->get_csrf_hash();
		$sesid=$CI->session->session_id;
	    if(empty($tok))
	    {
	    	if($str==$sesid)
	    	{
				return true;
			}else{
				return false;
			}	        
	    }else{
	        if($CI->security->get_csrf_hash()==$str)
	    	{
	    		return true;
	    	}else{
	    		return false;
	    	}
	    }
	}
}


if(!function_exists('roleUser')){
	function roleUser(){
		$CI=& get_instance();
		$CI->load->helper('db_helper');
		$CI->load->library('session');
		$opt=optionGet('session_role');
		$item=$CI->session->userdata($opt);
		if(!empty($item)){
			$rolename=dbField('userrole','role_id',$item,'role_key');
			if(!empty($rolename)){
				return $rolename;
			}else{
				return "";
			}
		}else{
			return "";
		}
	}
}

if(!function_exists('roleUserCustom')){
	function roleUserCustom($userid){
		$CI=& get_instance();
		$CI->load->helper('db_helper');		
		$role=taxonomyRead($userid,'role_user');
		if(!empty($role)){
			$rolename=dbField('userrole','role_id',$role,'role_key');
			if(!empty($rolename)){
				return ucfirst($rolename);
			}else{
				return "";
			}
		}else{
			return "";
		}
	}
}

if(!function_exists('lastLoginUser')){
	function lastLoginUser($userid){
		$CI=& get_instance();
		$CI->load->helper('db_helper');		
		$role=taxonomyRead($userid,'login_user');
		if(!empty($role)){
			return $role;
		}else{
			return "Belum ada";
		}
	}
}

if(!function_exists('roleDirectUser')){
	function roleDirectUser(){
		$CI=& get_instance();
		$CI->load->helper('db_helper');
		$CI->load->library('session');
		$opt=optionGet('session_role');
		$item=$CI->session->userdata($opt);
		if(!empty($item)){
			$rolename=dbField('userrole','role_id',$item,'role_module');
			if(!empty($rolename)){
				return $rolename;
			}else{
				return "";
			}
		}else{
			return "";
		}
	}
}


if(!function_exists('roleURIUser')){
	function roleURIUser(){
		$CI=& get_instance();
		$CI->load->helper('db_helper');
		$CI->load->library('session');
		$opt=optionGet('session_role');
		$item=$CI->session->userdata($opt);
		if(!empty($item)){
			$rolename=dbField('userrole','role_id',$item,'role_module');
			if(!empty($rolename)){
				return str_replace("dashboard","",$rolename);
			}else{
				return "";
			}
		}else{
			return "";
		}
	}
}

if(!function_exists('checkAccess')){
	function checkAccess(){
		$CI=& get_instance();
		$CI->load->helper(array('db_helper','url'));
		$ses=roleUser();
		if(empty($ses)){
			redirect(base_url(routeGet('logout')),'refresh');
		}			
	}
}

if(!function_exists('BlockIP')){
	function BlockIP()
	{
		$CI=& get_instance();
		$CI->load->library('m_database');
		$ip=$CI->input->ip_address();
		$s=array(
		'name'=>"block_ip_".$ip,
		);
		if($CI->m_database->isBOF('terms',$s)==FALSE){
			header("location: http://www.google.com/");
			exit();
		}		
	}
}


?>