<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Permalink extends MX_Controller
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
        $meta['judul']="Permalink Konfigurasi";
        $this->load->view('public/header',$meta);
        $this->load->view('config/permalinkview');
        $this->load->view('public/footer');
    }
    
    function updateconfig(){
		$common=$this->input->post('common');
		optionSet('site_permalink',$common,1,"text");
		$catbase=$this->input->post('catbase');
		optionSet('permalink_category',$catbase,1,"text");
		$tagbase=$this->input->post('tagbase');
		optionSet('permalink_tags',$tagbase,1,"text");
		
		$format='';
		$module='';
		if($common=="dayname"){
			$format="(:num)/(:num)/(:num)/(:any)";
			$module="$1/$2/$3/$4";
		}elseif($common=="monthname"){
			$format="(:num)/(:num)/(:any)";
			$module="$1/$2/$3";
		}elseif($common=="title"){
			$format="(:any)";
			$module="$1";
		}else{
			$format="";
		}
		
		$s=array(
		'route_name'=>'post',
		);
		
		$d=array();
		if($this->m_database->isBOF('route',$s)==TRUE){
			if(!empty($format)){
				$d=array(
				'route_name'=>'post',
				'route_key'=>$format,
				'route_val'=>'frontend/homepage/index/'.$module,
				);
				$this->m_database->addRow('route',$d);
			}else{
				$this->m_database->deleteRow('route',$s);
			}
		}else{
			if(!empty($format)){
				$d=array(			
				'route_key'=>$format,
				'route_val'=>'frontend/homepage/index/'.$module,
				);
				$this->m_database->editRow('route',$d,$s);
			}else{
				$this->m_database->deleteRow('route',$s);
			}
		}
		
		
		$this->catPermalink($catbase);
		$this->tagPermalink($tagbase);
		
		redirect(base_url(roleURIUser().'config/permalink'),'refresh');
	}
	
	function catPermalink($slug){
		$s=array(
		'route_name'=>'category',
		);
		
		$d=array();
		if($this->m_database->isBOF('route',$s)==TRUE){			
				$d=array(
				'route_name'=>'category',
				'route_key'=>$slug."/(:any)",
				'route_val'=>'frontend/homepage/category/$1',
				);
				$this->m_database->addRow('route',$d);			
		}else{			
				$d=array(			
				'route_key'=>$slug."/(:any)",
				'route_val'=>'frontend/homepage/category/$1',
				);
				$this->m_database->editRow('route',$d,$s);			
		}
	}
	
	function tagPermalink($slug){
		$s=array(
		'route_name'=>'tag',
		);
		
		$d=array();
		if($this->m_database->isBOF('route',$s)==TRUE){			
				$d=array(
				'route_name'=>'tag',
				'route_key'=>$slug."/(:any)",
				'route_val'=>'frontend/homepage/tag/$1',
				);
				$this->m_database->addRow('route',$d);			
		}else{			
				$d=array(			
				'route_key'=>$slug."/(:any)",
				'route_val'=>'frontend/homepage/tag/$1',
				);
				$this->m_database->editRow('route',$d,$s);			
		}
	}
    
}