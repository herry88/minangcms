<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Konfigurasi extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        if(roleUser()!='mimin'){
			exit(langGet('global','noaccess'));
		}
		$this->load->library(array('m_security','m_auth'));
    }
    
    function index()
    {   
    
        $meta['judul']="Konfigurasi";
        $this->load->view('public/header',$meta);
        $this->load->view('config/konfigurasiview');
        $this->load->view('public/footer');
    }
    
    function updateconfig(){
		$sitetitle=$this->input->post('sitetitle');
		optionSet('site_title',$sitetitle,0,"text");
		$sitedesc=$this->input->post('sitedescription');
		optionSet('site_description',$sitedesc,0,"text");
		$komen=valCheckbox($this->input->post('komen'));
		optionSet('site_comment',$komen,0,"option");
		$komenmoderator=valCheckbox($this->input->post('komenmoderator'));
		optionSet('site_comment_moderator',$komenmoderator,0,"option");
		
		$fpPost=$this->input->post('frontpagepost');
		$state="";
		if($fpPost){
			$state="post";
		}else{
			$state="page";
			$pagefront=$this->input->post('pagefont');
			optionSet('site_frontpage_page',$pagefront,0,"text");
		}
		optionSet('site_frontpage',$state,0,"text");
		
		
		$searchengine=valCheckbox($this->input->post('searchengine'));
		optionSet('site_searchengine',$searchengine,0,"option");
		$bruceforce=valCheckbox($this->input->post('bruceforce'));
		optionSet('service_login_bruceforce',$bruceforce,1,"text");
		$bruceforcelimit=$this->input->post('bruceforcelimit');
		optionSet('service_login_bruceforce_limit',$bruceforcelimit,1,"text");
		$bruceforcedirect=$this->input->post('bruceforcedirect');
		optionSet('service_login_bruceforce_direct',$bruceforcedirect,1,"text");
		
		$this->savecaptcha();
		
		redirect(base_url(roleURIUser().'config/konfigurasi'),'refresh');
	}
    
    private function savecaptcha(){
				
		$jdata=$this->input->post('json');
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
	}
}