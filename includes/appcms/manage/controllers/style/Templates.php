<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Templates extends MX_Controller
{
	var $folderTemp;
	
    function __construct()
    {
        parent::__construct();
        if(roleUser()!='mimin'){
			exit(langGet('global','noaccess'));
		}
		
		$this->load->library('m_file');
		$this->folderTemp="temp";
		$path=locationUpload('path').$this->folderTemp.'/';
		$this->m_file->makeDir($path);
    }
    
    function index()
    {
        $meta['judul']="Semua Tema";
    	$this->load->view('public/header',$meta);
		$this->load->view('style/tema/themeview');
		$this->load->view('public/footer');
    }
    
    function preview(){
    	$this->load->library('m_seo');
    	$param=$this->m_seo->postPermalink("","","","");
    	$d['data']=$param;
    	$title="";
    	if($param['route']=="post"){
			$title=$this->m_database->FieldRow('posts',$param['data'],'post_title');    		
		}else{
			$title=optionGet('site_title');
		}
		$d['title']=$title;
		$this->load->view('frontend/templateloader',$d);
	}
	
	function active(){
		$v=$this->input->get('v');
		optionSet('theme_front',$v,'1','text');
		redirect(base_url(roleURIUser().'style/templates'),'refresh');
	}
    
    function konfigurasi(){
    	$meta['judul']="Konfigurasi Tema";
    	$this->load->view('public/header',$meta);
		$this->load->view('style/tema/konfigurasiview');
		$this->load->view('public/footer');
	}
	
	function updateconfig(){
		
		$arr="";
		foreach($_POST as $k=>$v){
			$arr.='"'.$k.'"'.":".'"'.$v.'",';
		}				
		$jsonSanite=substr($arr,0,-1);
		$jsonData= "{".$jsonSanite."}";
		$theme=$this->input->post('theme');
		$s=array(
		'name'=>$theme."-template",
		);
		$termid=$this->m_database->FieldRow('terms',$s,'term_id');
		
		updateTerms($termid,"template",$theme."-template",$theme."-template","","",$jsonData);
		redirect(base_url(roleURIUser().'style/templates/konfigurasi').'?v='.$theme,'refresh');
	}
    
    function installer(){
		$meta['judul']="Konfigurasi Tema";
    	$this->load->view('public/header',$meta);
		$this->load->view('style/tema/installerview');
		$this->load->view('public/footer');
	}
	
	function installtheme(){
		
		
		$file=$_FILES['file']['name'];
        $ext=pathinfo($file,PATHINFO_EXTENSION);
        
        $zipname=pathinfo($file,PATHINFO_FILENAME);
        
        if($ext!="zip"){
			$this->session->set_flashdata('info','File tidak berekstensi Zip!!');
			redirect(base_url(roleURIUser().'style/templates/installer'),'refresh');
		}else{
			$path=locationUpload('path').$this->folderTemp.'/';
			
			
			$this->m_file->uploadFile($path,"zip",10000,"file");
			$zip = new ZipArchive();
			$fileZip=$path.$file;
			if($zip->open($fileZip) === TRUE )
			{
				$step=0;
								
				$f1=$zip->locateName($zipname.'/template.php');				
				
				if($f1==TRUE){
					$zip->close();
					$pathTheme=locationTheme('path').'frontend/';
					$proses=$this->m_file->ZipExtract($fileZip,$pathTheme);
					if($proses==TRUE){						
						$this->deleteTempFile($file);
						$this->session->set_flashdata('info','SUKSES!!');					
						redirect(base_url(roleURIUser().'style/templates'),'refresh');
					}else{						
						$this->deleteTempFile($file);
						$this->session->set_flashdata('info','Gagal install tema!!');					
						redirect(base_url(roleURIUser().'style/templates/installer'),'refresh');
					}
										
				}else{
					$zip->close();
					$this->deleteTempFile($file);
					$this->session->set_flashdata('info','File tidak sesuai dengan format template!!');
					redirect(base_url(roleURIUser().'style/templates/installer'),'refresh');
				}
			}
			else {
				$zip->close();
				$this->deleteTempFile($file);
			    $this->session->set_flashdata('info','File tidak berekstensi Zip!!');
				redirect(base_url(roleURIUser().'style/templates/installer'),'refresh');
			}
		}
	}
	
	function deleteTempFile($file){		
		unlink(locationUpload('path').$this->folderTemp.'/'.$file);
	}
	
	function delete(){
		
		$file=$this->input->get('v');
		$lokasi=locationTheme('path').'frontend/'.$file;
		if(!empty($file)){
			$proses=$this->m_file->remDir($lokasi,TRUE);
			if($proses==TRUE){
				$this->session->set_flashdata('info','Berhasil hapus tema');					
				redirect(base_url(roleURIUser().'style/templates'),'refresh');
			}else{
				$this->session->set_flashdata('info','Gagal hapus tema');					
				redirect(base_url(roleURIUser().'style/templates'),'refresh');
			}
		}else{
			$this->session->set_flashdata('info','Gagal hapus tema');					
			redirect(base_url(roleURIUser().'style/templates'),'refresh');
		}
	}
    
}