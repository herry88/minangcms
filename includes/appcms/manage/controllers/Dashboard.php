<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        checkAccess();
    }
    
    function index()
    {
        $meta['judul']="Dashboard";
        $this->load->view('public/header',$meta);
        $this->load->view('dashboardview');
        $this->load->view('public/footer');
    }
    
}