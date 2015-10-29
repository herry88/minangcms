<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Auth extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library(array('m_auth','m_security'));
        $this->load->helper(array('url','form','html_helper','file_helper','session_helper'));
    }
    
    function index()
    {
    	if($this->hasUser()==TRUE){
			if($this->m_auth->isLogin()==TRUE){
				redirect(base_url().roleDirectUser(),'refresh');
			}else{
				$meta['judul']="User Login";
				$this->load->view('header',$meta);
				$this->load->view('loginview');
				$this->load->view('footer');
			}
		}else{
			redirect(base_url(routeGet('freshinstall','route_key')),'refresh');
		}
        
    }
    
    function logindo(){
		return $this->m_auth->login();
	}
	
	function logoutdo(){
		$this->m_auth->logoutDo();
		redirect(base_url(routeGet('login')),'refresh');
	}
	
	private function hasUser(){
		$c=$this->m_database->countData('userlogin');
		if($c > 0){
			return true;
		}else{
			return false;
		}
	}
	
	function freshinstall(){
		if($this->hasUser()==FALSE){
			
			$this->m_security->filterPost('username','required');
			$this->m_security->filterPost('password','required');
			$this->m_security->filterPost('nama','required');
			$this->m_security->filterPost('email','required');
			
			if($this->m_security->startPost()==TRUE){
				$username=$this->input->post('username',TRUE);
				$password=$this->input->post('password',TRUE);
				$nama=$this->input->post('nama',TRUE);
				$email=$this->input->post('email',TRUE);
				
				$this->m_auth->registerUser($username,$password,$nama,'',$email,'1','active');
				
				redirect(base_url(routeGet('login','route_key')),'refresh');
			}else{
				$this->load->view('newuser');
			}						
		}else{
			redirect(base_url(routeGet('login','route_key')),'refresh');
		}
	}
    
}