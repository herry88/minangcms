<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Plugloader extends MX_Controller
{       
    function index()
    {
        $this->load->view('plugloaderview');
    }
    
}