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
    	if(!empty($kat) && !empty($menu)){
			foreach($kat as $k=>$v){
				$json=json_encode(array(
				'create'=>dateNow(TRUE),
				'relasi'=>'category',
				'categoryid'=>$v,
				'theme'=>getThemeActive(),
				));
				$catName=categoryInfo($v,'name');
				$catSlug=categoryInfo($v,'slug')."-".getThemeActive()."-menu";
				insertTerms("menu_".$menu."_".getThemeActive(),$catName,$catSlug,"","",$json);
			}
			echo json_encode('ok');
		}else{
			echo json_encode('no');
		}	
	}
	
	function addAlbum(){
    	$v=$this->input->post('galeri');
    	$menu=$this->input->post('menu');
    	if(!empty($v) && !empty($menu)){			
				$json=json_encode(array(
				'create'=>dateNow(TRUE),
				'relasi'=>'gallery',
				'galleryid'=>$v,
				'theme'=>getThemeActive(),
				));
				$tt=strtotime(dateNow(TRUE));
				insertTerms("menu_".$menu."_".getThemeActive(),"gallery-".$v."-".$tt,"gallery-".getThemeActive()."-".$tt,"","",$json);
			echo json_encode('ok');
		}else{
			echo json_encode('no');
		}	
	}
	
	function addPage(){
    	$kat=$this->input->post('page');
    	$menu=$this->input->post('menu');
    	if(!empty($kat) && !empty($menu)){
    		$output='';
			foreach($kat as $k=>$v){
				$json=json_encode(array(
				'create'=>dateNow(TRUE),
				'relasi'=>'page',
				'pageid'=>$v,
				'theme'=>getThemeActive(),
				));
				$postTitle=postInfo($v,"post_title");
				$postSlug=postInfo($v,"post_slug");
				insertTerms("menu_".$menu."_".getThemeActive(),$postTitle,$postSlug."-".getThemeActive()."-menu","","",$json);
				$output.=$postSlug;
			}
			echo json_encode('ok');
			//echo json_encode($output);
		}else{
			echo json_encode('no');
		}	
	}
	
	function addLink(){
    	$url=$this->input->post('linkurl');
    	$title=$this->input->post('linktitle');
    	$menu=$this->input->post('menu');
    	if(!empty($url) && !empty($menu)){
			$slug=stringCreateSlug($title);
			$json=json_encode(array(
			'create'=>dateNow(TRUE),
			'relasi'=>'link',
			'value'=>$url,
			'theme'=>getThemeActive(),
			));
			insertterms("menu_".$menu."_".getThemeActive(),$title,$slug."-".getThemeActive()."-menu","","",$json);			
			echo json_encode('ok');
		}else{
			echo json_encode('no');
		}	
	}
	
	function getmenu(){
		$menu=$this->input->get('menu');		
		$d['ismenu']=$menu;
		$this->load->view('style/menu/menutheme',$d);
	}
	
	function delete(){
		$id=$this->input->post('id');
		$s=array(
		'term_pareng'=>$id,
		);
		$this->m_database->deleteRow('terms',$s);
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
		$tipe="menu_".$pos."_".getThemeActive();
		$catSlug=dbField('terms','term_id',$menu,'slug');
		updateTerms($menu,$tipe,$title,$catSlug,"",$parent,$jsondata);
		//updateTerms($menu,'menu_'.$pos,$title,$slug."_menu","",$parent,$jsondata);
		echo json_encode('ok');
	}
	
	function editcategory(){
		$title=$this->input->post('title');
		$menu=$this->input->post('menu');
		$pos=$this->input->post('pos');
		$parent=$this->input->post('parent');
		$slug=stringCreateSlug($title);
		$jsondata=dbField('terms','term_id',$menu,'term_data');
		//updateTerms($menu,'menu_'.$pos,$title,$slug."_menu","",$parent,$jsondata);
		//insertTerms("menu_".$menu."_".getThemeActive(),$catName,$catSlug,"","",$json);
		$tipe="menu_".$pos."_".getThemeActive();
		$catSlug=dbField('terms','term_id',$menu,'slug');
		updateTerms($menu,$tipe,$title,$catSlug,"",$parent,$jsondata);
		
		echo json_encode('ok');
	}
	
	function editalbum(){
		$title=$this->input->post('title');
		$menu=$this->input->post('menu');
		$pos=$this->input->post('pos');
		$parent=$this->input->post('parent');
		$slug=stringCreateSlug($title);
		$jsondata=dbField('terms','term_id',$menu,'term_data');
		$tipe="menu_".$pos."_".getThemeActive();
		$catSlug=dbField('terms','term_id',$menu,'slug');
		updateTerms($menu,$tipe,$title,$catSlug,"",$parent,$jsondata);
		//updateTerms($menu,'menu_'.$pos,$title,$slug."_menu","",$parent,$jsondata);
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
		//updateTerms($menu,'menu_'.$pos,$title,$slug."_menu","",$parent,$jsondata);
		$tipe="menu_".$pos."_".getThemeActive();
		$catSlug=dbField('terms','term_id',$menu,'slug');
		updateTerms($menu,$tipe,$title,$catSlug,"",$parent,$jsondata);
		echo json_encode('ok');
	}	
	
	function reorder(){
		$j=$_POST['menuItem'];
		$theme=optionGet('theme_front');
		$menu=$this->input->get('menu');
		$output=array();
		$i=0;
		$i2=0;
		foreach($j as $k=>$v){
			
			if($v=="null"){
				$i+=1;
				$output[]=array(
				'number'=>$k,
				'parent'=>'0',
				'order'=>$i,
				);
				
				$d=array(
				'order_term'=>$i,
				'term_parent'=>'0',
				);
				$s=array(
				'term_id'=>$k,
				);
				
				
				$d2=array(
				'order_term'=>$i,
				'parent'=>'0',
				);
				$s2=array(
				'term_id'=>$k,
				'term_type'=>'menu_'.$menu.'_'.$theme,			
				);
				$this->m_database->editRow('terms',$d,$s);
				$this->m_database->editRow('termstaxonomy',$d2,$s2);
				
			}else{
				$i2+=1;
				$output[]=array(
				'number'=>$k,
				'parent'=>$v,
				'order'=>$i2,
				);
				
				$d=array(
				'term_parent'=>$v,
				'order_term'=>$i2,
				);
				$s=array(
				'term_id'=>$k,
				);
				
				
				$d2=array(
				'parent'=>$v,
				'order_term'=>$i2,
				);
				$s2=array(
				'term_id'=>$k,
				'term_type'=>'menu_'.$menu.'_'.$theme,			
				);
				$this->m_database->editRow('terms',$d,$s);
				$this->m_database->editRow('termstaxonomy',$d2,$s2);
			}						
		}
		echo json_encode("ok");
	}
	
	function reorder2(){
		
		$i=0;
		$theme=optionGet('theme_front');
		$menu=$this->input->get('menu');
		foreach($_POST['menuItem'] as $k=>$v){
			$i+=1;
			$index = array_search($k,array_values($_POST['menuItem']));
			
			if($v=='null'){
				$d=array(
				'order_term'=>$index,
				'term_parent'=>'0',
				);
				$s=array(
				'term_id'=>$k,
				);
				
				
				$d2=array(
				'order_term'=>$index,
				'parent'=>'0',
				);
				$s2=array(
				'term_id'=>$k,
				'term_type'=>'menu_'.$menu.'_'.$theme,			
				);
				$this->m_database->editRow('terms',$d,$s);
				$this->m_database->editRow('termstaxonomy',$d2,$s2);
			}else{
				$d=array(
				'term_parent'=>$v,
				'order_term'=>$index,
				);
				$s=array(
				'term_id'=>$k,
				);
				
				
				$d2=array(
				'parent'=>$v,
				'order_term'=>$index,
				);
				$s2=array(
				'term_id'=>$k,
				'term_type'=>'menu_'.$menu.'_'.$theme,			
				);
				$this->m_database->editRow('terms',$d,$s);
				$this->m_database->editRow('termstaxonomy',$d2,$s2);
			}
						
		}
		
		echo json_encode('ok');
	}
	
}