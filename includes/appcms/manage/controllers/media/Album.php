<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Album extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        checkAccess();
    }
    
    function index()
    {
        $meta['judul']="Semua Album";
        $this->load->view('public/header',$meta);
        $this->load->view('media/albumview');
        $this->load->view('public/footer');
    }
    
    function viewdata(){
		$rolename=roleURIUser();
        $this->load->library('Datatables');
        $prefix=$this->db->dbprefix;
		$this->datatables->select($prefix.'album.album_id as ii, '.$prefix.'album.album_title as judul,'.$prefix.'album.album_description as keterangan,'.$prefix.'album.album_date as tanggal,'.$prefix.'album.album_cover as cover')
            ->unset_column('album_id')
            ->edit_column('cover',$this->coverImage('$1',$rolename),"cover")
            ->add_column('aksi',$this->buttonAksi('$1',$rolename),"ii")
            ->from($prefix.'album')
            ->where(array(
                $prefix.'album.status'=>'publish',
                ));
 
        echo $this->datatables->generate();
	}
	
	function coverImage($img){
		$imgurl=urlApp().$img;
		return '<img src="'.$imgurl.'" style="width:64px"/>';
	}
	
	function buttonAksi($id,$rolename)
	{
		$p='';
		
		$p.='<a onclick="return confirm(\'Yakin ingin menghapus album ini?\');" class="btn btn-xs btn-danger" href="'.base_url($rolename.'media/album/delete').'?id='.$id.'&token='.tokenGenerate().'"><li class="fa fa-trash"></li></a>&nbsp;';        
        $p.='<a class="btn btn-xs btn-info" href="'.base_url($rolename.'media/album/edit').'?id='.$id.'&token='.tokenGenerate().'"><li class="fa fa-edit"></li></a> ';        
       
       return $p;
	}
	
	function add(){
		$meta['judul']="Tambah Album";
		$this->load->view('public/header',$meta);
		$this->load->view('media/album/albumadd');
		$this->load->view('public/footer');
	}
	
	function edit(){
		$id=$this->input->get('id');
		$s=array(
		'album_id'=>$id,
		);
		if($this->m_database->isBOF('album',$s)==TRUE){
			redirect(base_url(roleURIUser().'media/album'),'refresh');
		}else{
			$d['data']=$this->m_database->fetchData('album',$s);
			$meta['judul']="Ubah Album";
			$this->load->view('public/header',$meta);
			$this->load->view('media/album/albumedit',$d);
			$this->load->view('public/footer');
		}
		
	}
	
	function addapply(){
		$this->load->library('m_security');
		$this->m_security->filterPost('nama','required');
		if($this->m_security->startPost()==TRUE){
			$nama=$this->input->post('nama');
			$keterangan=$this->input->post('keterangan');
			$cover=$this->input->post('featureimage');
			
			$this->load->model('media_model','mm');
			$proses=$this->mm->addAlbum($nama,$keterangan,"",'publish');
			if($proses==TRUE){
				redirect(base_url(roleURIUser().'media/album'),'refresh');
			}else{
				redirect(base_url(roleURIUser().'media/album/add'),'refresh');
			}
			
		}else{
			redirect(base_url(roleURIUser().'media/album/add'),'refresh');
		}		
	}
	
	function editapply(){
		$this->load->library('m_security');
		$this->m_security->filterPost('albumid','required');
		$this->m_security->filterPost('nama','required');
		if($this->m_security->startPost()==TRUE){
			$albumid=$this->input->post('albumid');
			$nama=$this->input->post('nama');
			$keterangan=$this->input->post('keterangan');
			$cover=$this->input->post('featureimage');
			
			$this->load->model('media_model','mm');
			$proses=$this->mm->editAlbum($albumid,$nama,$keterangan,"",'publish');
			if($proses==TRUE){
				redirect(base_url(roleURIUser().'media/album'),'refresh');
			}else{
				redirect(base_url(roleURIUser().'media/album/add'),'refresh');
			}
			
		}else{
			redirect(base_url(roleURIUser().'media/album/add'),'refresh');
		}		
	}
	
	function delete(){
		$id=$this->input->get('id');
		$s=array(
		'album_id'=>$id,
		);
		if($this->m_database->isBOF('album',$s)==TRUE){
			redirect(base_url(roleURIUser().'media/album'),'refresh');
		}else{
			$this->load->model('media_model','mm');
			if($this->mm->deleteAlbum($id)==TRUE){
				redirect(base_url(roleURIUser().'media/album'),'refresh');
			}else{
				redirect(base_url(roleURIUser().'media/album'),'refresh');
			}
		}
	}
	
}