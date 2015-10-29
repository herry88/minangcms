<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Serv extends MX_Controller
{
	private $limit=3;
	private $tourl='';
	
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('db_helper');
    }
    
    function index(){
		echo 'service bruceforce';
	}
    
    function index2()
    {
    	if($this->checkserv()==TRUE){
			$last=$this->session->userdata('bruceforce');
	        $newhit=0;
	        if(empty($last)){
				$this->session->set_userdata('bruceforce','0');
				$newhit=0;
			}
			$newhit+=1;
			if($newhit==$this->limit){
				if($this->tourl=''){
					die('You cant Access this Page');
				}else{
					redirect($this->tourl,'refresh');
				}
			}
		}        
    }
    
    function checkserv(){
		$opt=optionGet('service_login_bruceforce');
		if(empty($opt)){
			return false;
		}else{
			if($opt=="1"){
				return true;
			}else{
				return false;
			}
		}
	}
    
    function infoserv(){
		$arr=array(
		'Service Name'=>'Bruce Force Protector',
		'Version'=>'1.0',
		'Requirement'=>'Session,db_helper',
		);
	}
    
    function serview(){
		return "";
	}
	
	function servconfig(){
		$this->load->view('login/bruceforce/configview');
	}
    
}