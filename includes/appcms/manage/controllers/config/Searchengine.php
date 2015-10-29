<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Searchengine extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        if(roleUser()!='mimin'){
			exit(langGet('global','noaccess'));
		}
		
		$this->insertFirst();
    }
    
    function index()
    {
        $meta['judul']="Search Engine Optimization";
        $this->load->view('public/header',$meta);
        $this->load->view(roleURIUser().'config/seoview');
        $this->load->view('public/footer');
    }
    
    function insertFirst(){
		optionSet('google','',1,'text');
		optionSet('bing','',1,'text');
		optionSet('alexa','',1,'text');
		optionSet('ogfacebook','1',1,'text');
	}
    
}