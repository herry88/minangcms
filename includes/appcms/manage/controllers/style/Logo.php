<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Logo extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        if(roleUser()!='mimin'){
			exit(langGet('global','noaccess'));
		}
    }
    
    function index()
    {    	
        $meta['judul']="Logo & Favicon";
        $this->load->view('public/header',$meta);
        $this->load->view('style/logoview');
        $this->load->view('public/footer');
    }
    
    function updateapply(){
		$logo=$this->input->post('logo');
		$favicon=$this->input->post('favicon');
		optionSet('site_logo',$logo,0,"text");
		optionSet('site_favicon',$favicon,0,"text");
		
		redirect(base_url(roleURIUser().'style/logo'),'refresh');
	}
	
	private function imagePath($img){
		if(ENVIRONMENT=="development"){
			$foldeSite= $img;
			$Ex=explode("/",$foldeSite);
			$siteFolder=$Ex[1];
			$count=strlen($siteFolder);
			$remCount=$count+2;
			$asset=substr($foldeSite,$remCount);			
			return $asset;
		}else{
			return $img;
		}
	}
    
}