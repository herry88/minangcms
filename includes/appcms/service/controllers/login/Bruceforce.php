<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Bruceforce extends MX_Controller
{
	public $limit;
	private $tourl;
	
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper(array('db_helper','url'));
        $this->limit=optionGet('service_login_bruceforce_limit');
        $this->tourl=optionGet('service_login_bruceforce_direct');
    }
    
    function index(){
		var_dump($this->infoserv());
	}
	
	function service_destroy(){
		$this->session->unset_userdata('bruceforce');
	}
	
	function service_before(){
		return "";
	}
	
            
    function service_after()
    {
    	if($this->checkserv()==TRUE){
			$last=$this->session->userdata('bruceforce');
	        $newhit=0;
	        if(empty($last)){
				$this->session->set_userdata('bruceforce','0');
				$newhit=0;
			}
			$newhit=$last+1;
			$this->session->set_userdata('bruceforce',$newhit);
			if($newhit==$this->limit){
				$this->blocking();
				if($this->tourl='' or empty($this->tourl)){	
					$this->session->unset_userdata('bruceforce');
					//var_dump($this->session->all_userdata());
					//var_dump($this->limit);
					die('You cant Access this Page');					
				}else{
					redirect($this->tourl,'refresh');
				}
			}
		}
    }
    
    function blocking(){
		$ip=$this->input->ip_address();
		$this->load->helper('posts_helper');
		insertTerms("blockip","block_ip_".$ip,"block-ip-".$ip,"","-");
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
		'Requirement'=>'Session,db_helper,url',
		);
		return $arr;
	}
    
    function serview(){
		return "";
	}
	
	function servconfig(){
		$this->load->view('login/bruceforce/configview');
	}
    
}