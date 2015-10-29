<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('userInfo')){
	function userInfo($output){
		$CI=& get_instance();		
		$sesuserdb=optionGet('session_user');
		$username=$CI->session->userdata($sesuserdb);
		$s=array(
		'username'=>$username,
		'status'=>'active',
		);
		if($CI->m_database->isBOF('userlogin',$s)==TRUE){
			redirect(base_url(routeGet('logout')),'refresh');
		}else{
			$item=$CI->m_database->fieldRow('userlogin',$s,$output);
			if(!empty($item)){
				return $item;
			}else{
				redirect(base_url(routeGet('logout')),'refresh');
			}
		}
	}
}

if(!function_exists('userAvatar')){
	function userAvatar($size="64"){
		$CI=& get_instance();
		$userid=userInfo('user_id');
		$s=array(
		'user_id'=>$userid,
		'taxo_key'=>'avatar_user',
		);
		
		if($CI->m_database->isBOF('usertaxonomy',$s)==TRUE){
			return noPhoto($size);
		}else{
			$ava=$CI->m_database->fieldRow('usertaxonomy',$s,'taxo_val');
			if(!empty($ava)){				
				return $ava;
			}else{
				return noPhoto($size);
			}
		}
	}
}

?>