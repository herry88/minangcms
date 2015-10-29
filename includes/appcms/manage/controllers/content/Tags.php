<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tags extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        checkAccess();
    }
    
    function index()
    {
        $meta['judul']="Tags Berita";
        $this->load->view('public/header',$meta);
        $this->load->view('content/tagsview');
        $this->load->view('public/footer');
    }
    
    function getcontent(){
		$this->load->view('content/tagscontent');
	}
	
	function add(){
		$this->load->library('m_security');
		$this->m_security->filterPost('addname','required');
		if($this->m_security->startPost()==TRUE){
			$name=$this->input->post('addname',TRUE);
			$slug=$this->input->post('addslug',TRUE);
			$desc=$this->input->post('adddescription',TRUE);
			
			$proses=insertTags($name,$slug,$desc,'0');
			if($proses==TRUE){
				echo json_encode("ok");
			}else{
				echo json_encode("no");
			}
			
		}else{
			echo json_encode("no");
		}
	}		
	
	function edit(){
		$id=$this->input->get('id');
		$s=array(
		'term_id'=>$id,
		);
		$d['data']=$this->m_database->fetchData('terms',$s);
		$this->load->view('content/tagsedit',$d);
	}		
    
    function editapply(){
		$this->load->library('m_security');
		$this->m_security->filterPost('termid','required');
		$this->m_security->filterPost('editname','required');
		if($this->m_security->startPost()==TRUE){
			$termid=$this->input->post('termid',TRUE);
			$name=$this->input->post('editname',TRUE);
			$slug=$this->input->post('editslug',TRUE);
			$desc=$this->input->post('editdescription',TRUE);
			
			$proses=updateTags($termid,$name,$slug,$desc,'0');
			if($proses==TRUE){
				redirect(base_url(roleURIUser().'content/tags'),'refresh');
			}else{
				redirect(base_url(roleURIUser().'content/tags'),'refresh');
			}
			
		}else{
			redirect(base_url(roleURIUser().'content/tags'),'refresh');
		}
	}
	
	function delete(){
		$id=$this->input->get('id');
		
		if($id=="1"){
			redirect(base_url(roleURIUser().'content/tags'),'refresh');
		}else{
			
			deleteTerm($id);
			redirect(base_url(roleURIUser().'content/tags'),'refresh');
		}
	}
    
}