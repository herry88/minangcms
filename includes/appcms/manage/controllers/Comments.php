<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Comments extends MX_Controller
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
        $meta['judul']='Data Komentar';
        $this->load->view('public/header',$meta);
        $s=array(
        'comment_status'=>'publish',
        );
        $s2=array(
        'comment_status'=>'spam',
        );
        $s3=array(
        'comment_status'=>'pending',
        );
        $d['publishcount']=$this->m_database->countData('postcomment',$s);
        $d['spamcount']=$this->m_database->countData('postcomment',$s2);
        $d['pendingcount']=$this->m_database->countData('postcomment',$s3);
        $lastStatus='';
        $g=$this->input->get('status');
        if($g=="publish"){
			$lastStatus=$g;
		}elseif($g=="spam"){
			$lastStatus=$g;
		}elseif($g=="pending"){
			$lastStatus="pending";
		}else{
			$lastStatus="publish";
		}
		$d['status']=$lastStatus;
        $this->load->view('comment/commentview',$d);
        $this->load->view('public/footer');
    }
    
    function viewdata(){		
        $this->load->library('Datatables');
        $status=$this->input->get('status');
        $prefix=$this->db->dbprefix;
		$this->datatables->select($prefix.'postcomment.post_comment_id as ii, '.$prefix.'postcomment.nama as nama,'.$prefix.'postcomment.email as email,'.$prefix.'postcomment.comment as komentar,'.$prefix.'postcomment.post_id as postid,'.$prefix.'postcomment.comment_date as tanggal')
            ->unset_column('post_comment_id')
            ->edit_column('postinfo','$1','commentPost(postid)')
            ->edit_column('aksi','$1','commentPostAction(ii)')
            ->from($prefix.'postcomment')
            ->where(array(
            	$prefix.'postcomment.comment_status'=>$status,
            )); 
        echo $this->datatables->generate();
	}
    
    function approve(){
		$id=$this->input->get('id');
		$this->load->model('post_model','pm');
		$proses=$this->pm->changeStatusComment($id,"publish");
		redirect(base_url(roleURIUser().'comments'),'refresh');
	}
	
	function spamthis(){
		$id=$this->input->get('id');
		$this->load->model('post_model','pm');
		$proses=$this->pm->changeStatusComment($id,"spam");
		redirect(base_url(roleURIUser().'comments'),'refresh');
	}
	
	function delete(){
		$id=$this->input->get('id');
		$this->load->model('post_model','pm');
		$proses=$this->pm->deleteComment($id);
		redirect(base_url(roleURIUser().'comments'),'refresh');
	}
    
}