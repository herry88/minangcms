<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Feed extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('m_seo');
    }
    
    function index()
    {
        echo $this->m_seo->generateFeed("atom",'frontend');
    }
    
    function atom(){
		echo $this->m_seo->generateFeed("atom",'frontend');
	}
    
    function rss(){
		echo $this->m_seo->generateFeed("rss",'frontend');
	}
	
	function rss2(){
		echo $this->m_seo->generateFeed("rss2",'frontend');
	}
}