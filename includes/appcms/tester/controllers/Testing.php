<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Testing extends MX_Controller
{
    function __construct()
    {
        parent::__construct();        
        $this->load->helper(array('url','db_helper'));
    }
    
    function index()
    {
    	//$this->load->library('m_auth');
          //$this->load->view('testingview');
          redirect(base_url(routeGet('login')));
		  
		  //echo $this->session->userdata('bruceforce');
    }
    
}