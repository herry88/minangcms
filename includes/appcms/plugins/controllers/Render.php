<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Render extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
    }
    
    function index()
    {
        exit(0);
    }
    
    function createslug(){
		$str=$this->input->get('title');
		$slug=stringCreateSlug($str);
		echo json_encode($slug);
	}
	
	function kcfinderurl(){
		$this->load->helper('mc_helper');
		$img=$this->input->get('img');
		$withBase=$this->input->get('baseurl');
		$newurl=imagePath($img);
		if($withBase==TRUE){
			echo json_encode(array(
			'original'=>urlApp().$img,
			'newurl'=>base_url().$newurl,
			));
		}else{
			echo json_encode(array(
			'original'=>$img,
			'newurl'=>$newurl,
			));
		}
		
	}
    
}