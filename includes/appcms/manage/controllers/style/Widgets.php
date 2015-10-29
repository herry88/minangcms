<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Widgets extends MX_Controller
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
        $meta['judul']="Data Widget";
        $this->load->view('public/header',$meta);
        $this->load->view('style/widget/widgetview');
        $this->load->view('public/footer');
    }
    
    function loaderitem(){
		$pos=$this->input->get('pos');
		$ex=explode(":",$pos);
		$d['pos']=$ex[0];
		$d['termid']=$ex[1];
		$this->load->view('style/widget/widgetitemloader',$d);
	}
	
	function addwidget(){
		//insertTerms();
		$termid=$this->input->post('id');
		$pos=$this->input->post('pos');
		$widget=$this->input->post('widget');
		$s=array(
		'term_id'=>$termid,
		);
		$name=$this->m_database->fieldRow('terms',$s,'name');
		$slug=$this->m_database->fieldRow('terms',$s,'slug');
		$data=json_encode(array(
		'prefix'=>$widget,
		));
		$time=strtotime(dateNow(TRUE));
		insertTerms("sidebar",$name."_item",$slug."-item-".$time,"",$termid,$data);
		
		echo json_encode('ok');
	}
    
}