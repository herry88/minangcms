<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Captcha extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
    }
    
    function index()
    {
    	var_dump($this->infoserv());
    }        
    
    function service_before(){
		$this->generate(TRUE);
	}
	
	function service_after(){
		return $this->verify();
	}
    
    function serview(){
		$this->load->view('configview');
	}
    
    function checkserv(){
		$service=optionGet('service_login_captcha');
		if(empty($service)){
			return false;
		}else{
			if($service=="1"){
				return true;
			}else{
				return false;
			}
		}
	}
	
	function checkType(){
		$type=optionGet('captcha_type');
		if(empty($type)){
			exit('Please configuration captcha first');
		}else{
			return $type;
		}
	}
    
    function generate($view=FALSE){		
		if($this->checkserv()==TRUE){
			$type=$this->checkType();
			$className=$type.'_captcha';
			$this->load->library('service/captcha/'.$type.'_captcha');
			return $this->$className->generate($view);
			//require MODPATH.'service/libraries/captcha/'.$className.'.php';
			//$c=new $className();
			//return $c->generate($view);
		}		
	}
	
	function captcha(){		
		$imgfile=$this->generate(TRUE);
		echo $imgfile;
	}
   	
    function refreshCaptcha(){		
		header("Content-type: image/jpeg");
		$imgfile=$this->generate(FALSE);
  		readfile($imgfile);
		exit(0);
	}
		
	
	function verify(){
		
		if($this->checkserv()==TRUE){
			$type=$this->checkType();
			$className=$type.'_captcha';
			$this->load->library('service/captcha/'.$className);
			$proses=$this->$className->verifyCaptcha();
			//require MODPATH.'service/libraries/captcha/'.$className.'.php';
			//$c=new $className();
			//$proses=$c->verifyCaptcha();
			/*
			if($proses==TRUE){
				return true;
			}else{
				$this->session->set_flashdata('catpchaerror','Captcha tidak valid');
				return false;
			}
			*/
			return $proses;
		}		
	}
    
    function infoserv(){
		$arr=array(
		'Service Name'=>'Captcha Service',
		'Version'=>'1.0',
		'Requirement'=>'Session,db_helper,url',
		);
		return $arr;
	}
    
}