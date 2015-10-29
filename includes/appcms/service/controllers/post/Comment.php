<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Comment extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('m_database');
        $this->load->helper('db_helper');
        $this->load->helper('posts_helper');
        $this->load->library('session');
    }
    
    function index()
    {
        
        echo "COMMENT SYSTEM";
    }
    
    function generate(){
		$postid=$this->input->get('id');
		$d['postid']=$postid;
		$this->load->view('post/comment/commentview',$d);
	}
    
}