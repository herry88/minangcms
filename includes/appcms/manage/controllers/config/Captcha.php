<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Captcha extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        if(roleUser()!='mimin'){
			exit(langGet('global','noaccess'));
		}
		$this->load->library(array('m_security','m_auth'));
    }
        
    
    function showconfig(){
		$id=$this->input->get('tipe');
		$this->load->view('service/login/captcha/'.$id.'/configview');
	}
    
    function savecaptcha(){		
		$jdata=$_POST['json'];
		$json='';
		foreach($jdata as $key=>$val){
			$json.='"'.$key.'":"'.$val.'",';
		}
		$hjson=substr($json,0,-1);
		$datajson=("{".$hjson."}");
		
		$service=$this->input->post('service');
		$tipe=$this->input->post('tipe');
		$savepath=$this->input->post('savepath');
		
		$optService='';
		if($service=="on"){
			$optService="1";
		}else{
			$optService="0";
		}
		optionSet('captcha_enable',$optService);
		if($optService=="1"){
			optionSet('captcha_savepath',$savepath);
			optionSet('captcha_type',$tipe);
			optionSet('captcha_data',$datajson);
		}else{
			optionSet('captcha_savepath',"");
			optionSet('captcha_type',"");
			optionSet('captcha_data',"");
		}
		
		
		
		redirect(base_url(roleUser().'/captcha'),'refresh');
	}
}