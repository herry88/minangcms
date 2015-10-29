<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Homepage extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('m_database');
        $this->load->library('m_seo');
        $this->load->helper('loader_helper');
        $this->load->helper('posts_helper');        
    }
    
    function index($s1='',$s2='',$s3='',$s4='')
    {    
		$this->load->library('m_seo');
    	$param=$this->m_seo->postPermalink($s1,$s2,$s3,$s4);
    	$d['data']=$param;
    	$title="";
    	if($param['route']=="post"){
			$title=$this->m_database->FieldRow('posts',$param['data'],'post_title');    		
		}else{
			$title=optionGet('site_title');
		}
		$d['title']=$title;
    	$this->load->view('templateloader',$d);
		
    }
    
    function category($s1=''){
		$d['data']['route']="category";
		$d['data']['data']=$s1;
		
		$title="";
		$CatName=categoryInfo($s1,"name");
    	if(!empty($CatName)){
			$title=$CatName;
		}else{
			$title=optionGet('site_title');
		}
		$d['title']=$title;
		$this->load->view('templateloader',$d);		
	}
	
	function media($s1=''){
		$d['data']['route']="media";
		$d['data']['data']=$s1;
		
		$title="";
		$CatName=dbField('album',"album_id",$s1,"album_title");
    	if(!empty($CatName)){
			$title=$CatName;
		}else{
			$title=optionGet('site_title');
		}
		$d['title']=$title;
		$this->load->view('templateloader',$d);		
	}
	
	function tag($s1=''){
		$d['data']['route']="tag";
		$d['data']['data']=$s1;
		$title="";
		
		$s=array(
		'term_id'=>$s1,
		);
		
		$tagName=$this->m_database->FieldRow('terms',$s,'name');
    	if(!empty($tagName)){
			$title=$tagName;
		}else{
			$title=optionGet('site_title');
		}
		$d['title']=$title;
		$this->load->view('templateloader',$d);		
	}
	
	function error404page(){
		$this->load->view('404');
	}
	
	function search(){
		$s=$this->input->get('s');
		$d['data']['route']="search";
		$d['data']['data']=$s;
		$d['title']="Pencarian ".$s;
		$this->load->view('templateloader',$d);
	}
	
	
	function comment(){
		$j=modules::run('service/login/captcha/service_after');
		var_dump($this->session->all_userdata());
		var_dump($j);
	}
	
	function comment2(){
		$token=tokenGenerate();
		$this->load->library('m_security');
		
		$this->m_security->filterPost('postid','required');
		$this->m_security->filterPost('name','required');
		$this->m_security->filterPost('email','required');
		$this->m_security->filterPost('data','required');
		
		if($this->m_security->startPost()==TRUE){
			$postid=$this->input->post('postid',TRUE);
			$name=$this->input->post('name',TRUE);
			$email=$this->input->post('email',TRUE);
			$data=$this->input->post('data',TRUE);
			$url=permalinkPost($postid);
			$back='<a href="'.$url.'">'."Kembali ke halaman berita".'</a>';			
			$service=modules::run('service/login/captcha/service_after');
			if($service==TRUE){
				$proses=commentInsert($postid,$name,$email,$data);
				exit($proses['callback'].".".$back);
			}else{				
				exit("Komentar anda gagal diterbitkan3 $k.".$back);
			}
			
		}else{
			exit("Komentar anda gagal diterbitkan");
		}
		
	}
    
}