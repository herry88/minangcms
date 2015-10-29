<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Category extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        checkAccess();
    }
    
    function index()
    {
        $meta['judul']="Kategori Berita";
        $this->load->view('public/header',$meta);
        $this->load->view('content/categoryview');
        $this->load->view('public/footer');
    }
    
    function getcontent(){
		$this->load->view('content/categorycontent');
	}
	
	function add(){
		$this->load->library('m_security');
		$this->m_security->filterPost('addname','required');
		if($this->m_security->startPost()==TRUE){
			$name=$this->input->post('addname',TRUE);
			$slug="";
			$slugX=$this->input->post('addslug',TRUE);
			if(!empty($slugX)){
				$slug=$slugX;
			}else{
				$slug=stringCreateSlug($name);
			}
			$parent=$this->input->post('addparent',TRUE);
			$desc=$this->input->post('adddescription',TRUE);
			
			$proses=insertTerms("category",$name,$slug,$desc,$parent);
			if($proses==TRUE){
				echo json_encode("ok");
			}else{
				echo json_encode("no");
			}
			
		}else{
			echo json_encode("no");
		}
	}
	
	function getComboCat(){
		$p='';
		$p.='<option value="">None</option>';		
		$dParent=getCategory();		
		if(!empty($dParent)){
		foreach($dParent as $rParent){
			$p.='<option value="'.$rParent->term_id.'">'.$rParent->name.'</option>';
			$dChild=getCategory($rParent->term_id);
			if(!empty($dChild)){									
			foreach($dChild as $rChild){				
				$p.='<option value="'.$rChild->term_id.'">&#8212; '.$rChild->name.'</option>';
			}
			}
		}
		}
		echo $p;
	}
	
	function edit(){
		$id=$this->input->get('id');
		$s=array(
		'term_id'=>$id,
		);
		$d['data']=$this->m_database->fetchData('terms',$s);
		$this->load->view('content/categoryedit',$d);
	}		
    
    function editapply(){
		$this->load->library('m_security');
		$this->m_security->filterPost('termid','required');
		$this->m_security->filterPost('editname','required');
		if($this->m_security->startPost()==TRUE){
			$termid=$this->input->post('termid',TRUE);
			$name=$this->input->post('editname',TRUE);
			$slug=$this->input->post('editslug',TRUE);
			$parent=$this->input->post('editparent',TRUE);
			$desc=$this->input->post('editdescription',TRUE);
			
			$proses=updateCategory($termid,$name,$slug,$desc,$parent);
			if($proses==TRUE){
				redirect(base_url(roleURIUser().'content/category'),'refresh');
			}else{
				redirect(base_url(roleURIUser().'content/category'),'refresh');
			}
			
		}else{
			redirect(base_url(roleURIUser().'content/category'),'refresh');
		}
	}
	
	function delete(){
		$id=$this->input->get('id');
		
		if($id=="1"){
			redirect(base_url(roleURIUser().'content/category'),'refresh');
		}else{
			
			deleteTerm($id);
			redirect(base_url(roleURIUser().'content/category'),'refresh');
		}
	}
    
}