<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Menus extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        if(roleUser()!='mimin'){
			exit(langGet('global','noaccess'));
		}
		$this->load->helper('posts_helper');
    }
    
    function index()
    {
        $meta['judul']="Menu Manager";
        $this->load->view('public/header',$meta);
        $this->load->view('style/menu/menuview');
        $this->load->view('public/footer');     
    }
    
    
    function addCategory(){
    	$kat=$this->input->post('kat');
    	$menu=$this->input->post('menu');
    	if(!empty($kat)){
			foreach($kat as $k=>$v){
				$json=json_encode(array(
				'create'=>dateNow(TRUE),
				'relasi'=>'category',
				'categoryid'=>$v,
				));
				$catName=categoryInfo($v,'name');
				$catSlug=categoryInfo($v,'slug')."_menu";
				insertTerms("menu_".$menu,$catName,$catSlug,"","",$json);
			}
			echo json_encode('ok');
		}else{
			echo json_encode('no');
		}	
	}
	
	function addAlbum(){
    	$v=$this->input->post('galeri');
    	$menu=$this->input->post('menu');
    	if(!empty($v)){			
				$json=json_encode(array(
				'create'=>dateNow(TRUE),
				'relasi'=>'gallery',
				'galleryid'=>$v,
				));
				$tt=strtotime(dateNow(TRUE));
				insertTerms("menu_".$menu,"gallery-".$v."-".$tt,"gallery-".$tt,"","",$json);
			echo json_encode('ok');
		}else{
			echo json_encode('no');
		}	
	}
	
	function addPage(){
    	$kat=$this->input->post('page');
    	$menu=$this->input->post('menu');
    	if(!empty($kat)){
			foreach($kat as $k=>$v){
				$json=json_encode(array(
				'create'=>dateNow(TRUE),
				'relasi'=>'page',
				'pageid'=>$v,
				));
				$postTitle=postInfo($v,"post_title");
				$postSlug=postInfo($v,"post_slug");
				insertTerms("menu_".$menu,$postTitle,$postSlug."_menu","","",$json);
			}
			echo json_encode('ok');
		}else{
			echo json_encode('no');
		}	
	}
	
	function addLink(){
    	$url=$this->input->post('linkurl');
    	$title=$this->input->post('linktitle');
    	$menu=$this->input->post('menu');
    	if(!empty($url)){
			$slug=stringCreateSlug($title);
			$json=json_encode(array(
			'create'=>dateNow(TRUE),
			'relasi'=>'link',
			'value'=>$url,
			));
			insertterms("menu_".$menu,$title,$slug."_menu","","",$json);			
			echo json_encode('ok');
		}else{
			echo json_encode('no');
		}	
	}
	
	function getmenu(){
		$menu=$this->input->get('menu');
		$menuview=$menu.'menu';
		$this->load->view('style/menu/'.$menuview);
	}
	
	function delete(){
		$id=$this->input->post('id');
		deleteTerm($id);
		echo json_encode('ok');
	}
	
	function editpage(){
		$title=$this->input->post('title');
		$menu=$this->input->post('menu');
		$pos=$this->input->post('pos');
		$parent=$this->input->post('parent');
		$slug=stringCreateSlug($title);
		$jsondata=dbField('terms','term_id',$menu,'term_data');
		updateTerms($menu,'menu_'.$pos,$title,$slug."_menu","",$parent,$jsondata);
		echo json_encode('ok');
	}
	
	function editcategory(){
		$title=$this->input->post('title');
		$menu=$this->input->post('menu');
		$pos=$this->input->post('pos');
		$parent=$this->input->post('parent');
		$slug=stringCreateSlug($title);
		$jsondata=dbField('terms','term_id',$menu,'term_data');
		updateTerms($menu,'menu_'.$pos,$title,$slug."_menu","",$parent,$jsondata);
		echo json_encode('ok');
	}
	
	function editalbum(){
		$title=$this->input->post('title');
		$menu=$this->input->post('menu');
		$pos=$this->input->post('pos');
		$parent=$this->input->post('parent');
		$slug=stringCreateSlug($title);
		$jsondata=dbField('terms','term_id',$menu,'term_data');
		updateTerms($menu,'menu_'.$pos,$title,$slug."_menu","",$parent,$jsondata);
		echo json_encode('ok');
	}
		
	
	function editlink(){
		$title=$this->input->post('title');
		$url=$this->input->post('url');
		$menu=$this->input->post('menu');
		$pos=$this->input->post('pos');
		$parent=$this->input->post('parent');
		$slug=stringCreateSlug($title);
		$jsondata=json_encode(array(
		'create'=>dateNow(TRUE),
		'relasi'=>'link',
		'value'=>$url,
		));
		updateTerms($menu,'menu_'.$pos,$title,$slug."_menu","",$parent,$jsondata);
		echo json_encode('ok');
	}	
	
	function reorder(){
		$menu=$this->input->get('menu');
		$i=0;
		foreach($_POST['menuItem'] as $k=>$v){
			$i+=1;
			$d=array(
			'term_parent'=>$v,
			'order_term'=>$i,
			);
			$s=array(
			'term_id'=>$k,
			);
			
			$this->m_database->editRow('terms',$d,$s);
			
			$d2=array(
			'parent'=>$v,
			'order_term'=>$i,
			);
			$s2=array(
			'term_id'=>$k,
			'term_type'=>'menu_'.$menu,			
			);
			$this->m_database->editRow('termstaxonomy',$d2,$s2);
		}
		
		echo json_encode('ok');
	}
	
}