<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Images extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('mc_helper'));
    }
    
    function index()
    {
        echo "Images Widget";
    }
    
    function generate(){
    	$pos=$this->input->get('pos');
    	$theme=$this->input->get('theme');
    	$param=$this->input->get('divider');
    	$d['pos']=$pos;
    	$d['theme']=$theme;
    	$d['slug']=$theme."_sidebar_".$pos."_item";
    	$d['termdata']=$this->input->get('data');
		$d['widgetdata']=$this->input->get('widgetdata');
		
		$d['parentid']=$this->input->get('parentid');
		$d['divider']=$param;
		$this->load->view('widget/images/widgetview',$d);
	}
	
	function configwidget(){
		$d['termdata']=$this->input->get('data');
		$d['widgetdata']=$this->input->get('widgetdata');		
		$d['parentid']=$this->input->get('parentid');		
		$this->load->view('widget/images/configview',$d);
	}
    
    function delete(){
    	$this->load->library('m_database');
		$did=$this->input->post('id');
		$s=array(
		'term_id'=>$did,
		);
		$this->m_database->deleteRow('terms',$s);
		$this->m_database->deleteRow('termstaxonomy',$s);
		
		echo json_encode('ok');
	}
	
	function update(){
		$this->load->library('m_database');
		$this->load->helper('file_helper');
		$did=$this->input->post('id');
		$source=$this->input->post('source');
		$title=$this->input->post('title');
		$img=$this->input->post('img');
		$name=dbField('terms','term_id',$did,'name');
		$slug=dbField('terms','term_id',$did,'slug');
		$imgX=$img;
		$parent=dbField('terms','term_id',$did,'term_parent');		
			$json=json_encode(array(
			'prefix'=>'images',
			'title'=>$title,
			'source'=>$source,
			'image'=>$imgX,
			));
			updateTerms($did,"sidebar",$name,$slug,"",$parent,$json);
		
		
		
		echo json_encode('ok');
	}
}