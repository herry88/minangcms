<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Gallery extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        checkAccess();
        $this->load->helper('file');
    }
    
    function index()
    {
        $meta['judul']="Semua Galeri";
        $this->load->view('public/header',$meta);
        $this->load->view('media/galeriview');
        $this->load->view('public/footer');
    }
    
    function viewdata(){
		$rolename=roleURIUser();
        $this->load->library('Datatables');
        $prefix=$this->db->dbprefix;
		$this->datatables->select($prefix.'gallery.gallery_id as ii, '.$prefix.'gallery.gallery_title as judul,'.$prefix.'gallery.gallery_description as keterangan,'.$prefix.'gallery.gallery_date as tanggal')
            ->unset_column('gallery_id')
            ->add_column('aksi',$this->buttonAksi('$1',$rolename),"ii")
            ->edit_column('album','$1','galleryAlbum(ii)')
            ->from($prefix.'gallery');
 
        echo $this->datatables->generate();
	}
	
	function buttonAksi($id,$rolename)
	{
		$p='';
		
		$p.='<a onclick="return confirm(\'Yakin ingin menghapus galeri ini?\');" class="btn btn-xs btn-danger" href="'.base_url($rolename.'media/gallery/delete').'?id='.$id.'&token='.tokenGenerate().'"><li class="fa fa-trash"></li></a>&nbsp;';        
        $p.='<a class="btn btn-xs btn-info" href="'.base_url($rolename.'media/gallery/edit').'?id='.$id.'&token='.tokenGenerate().'"><li class="fa fa-edit"></li></a> ';
        $p.='<a class="btn btn-xs btn-primary" href="'.base_url($rolename.'media/gallery/uploadgallery').'?gallery='.$id.'&token='.tokenGenerate().'"><li class="fa fa-eye"></li></a> ';        
       
       return $p;
	}
	
	function add(){
		$meta['judul']="Tambah Galeri";
		$this->load->view('public/header',$meta);
		$this->load->view('media/galeri/galeriadd');
		$this->load->view('public/footer');
	}
		
    
    function addapply(){
		$this->load->library('m_security');
		$this->m_security->filterPost('nama','required');
		if($this->m_security->startPost()==TRUE){
			$nama=$this->input->post('nama');
			$keterangan=$this->input->post('keterangan');
			$cover=$this->input->post('featureimage');
			$album=$this->input->post('album');			
			$this->load->model('media_model','mm');
			$proses=$this->mm->addGallery($nama,$keterangan);
			if($proses['status']==TRUE){
				$galleryID=$proses['galleryid'];
				if(!empty($album)){
					foreach($album as $k=>$v){
						$this->mm->addAlbumTaxonomy($v,"gallery_list",$galleryID);
					}					
				}								
				redirect(base_url(roleURIUser().'media/gallery/uploadgallery').'?gallery='.$galleryID,'refresh');
			}else{
				redirect(base_url(roleURIUser().'media/gallery/add'),'refresh');
			}
			
		}else{
			redirect(base_url(roleURIUser().'media/gallery/add'),'refresh');
		}		
	}
	
	function uploadgallery(){
		$galeri=$this->input->get('gallery');
		$s=array(
		'gallery_id'=>$galeri,
		);
		if($this->m_database->isBOF('gallery',$s)==TRUE){
			redirect(base_url(roleURIUser().'media/gallery'),'refresh');
		}else{
			$d['data']=$this->m_database->fetchData('gallery',$s);
			$meta['judul']="Upload File Galeri";
			$this->load->view('public/header',$meta);
			$this->load->view('media/galeri/galeriupload',$d);
			$this->load->view('public/footer');
		}
	}
    
    function uploadimages(){
		$gambar=$_FILES['photo']['name'];
        $ext=pathinfo($gambar,PATHINFO_EXTENSION);        
        
        $fileName=$gambar;
        $mime=$_FILES['photo']['type'];
        $galleryid=$this->input->post('galleryid');
        $altinfo=$this->input->post('altinfo');
        $galleryslug=$this->input->post('galleryslug');
        $path=locationUpload('path').'gallery/'.$galleryslug.'/';
        $this->load->library('m_file');
        $type="jpeg|jpg|png|jpe|bmp|gif";
        $sizelimit=(int)(ini_get('upload_max_filesize'));        
		$proses=$this->m_file->uploadImageSingle(TRUE,TRUE,$gambar,$path,$type,$sizelimit,0,0,'photo');
		if($proses==TRUE){
			$this->load->model('media_model','mm');
        	$this->mm->addGalleryFile($galleryid,$fileName,$mime,$altinfo);
		}        
        redirect(base_url(roleURIUser().'media/gallery/uploadgallery').'?gallery='.$galleryid,'refresh');
	}
	
	function deletefile(){
		$id=$this->input->get('id');
		$gallery=$this->input->get('gallery');
		$s=array(
		'gallery_images_id'=>$id,
		);
		if($this->m_database->isBOF('gallery_images',$s)==TRUE){
			redirect(base_url(roleURIUser().'media/gallery/uploadgallery').'?gallery='.$gallery,'refresh');
		}else{
			$this->load->model('media_model','mm');
			$this->mm->deleteGalleryFile($id,$gallery);
			redirect(base_url(roleURIUser().'media/gallery/uploadgallery').'?gallery='.$gallery,'refresh');
		}
	}
	
	function delete(){
		$id=$this->input->get('id');
		$s=array(
		'gallery_id'=>$id,
		);
		if($this->m_database->isBOF('gallery',$s)==TRUE){
			redirect(base_url(roleURIUser().'media/gallery'),'refresh');
		}else{
			$this->load->model('media_model','mm');
			$this->mm->deleteGallery($id);
			redirect(base_url(roleURIUser().'media/gallery'),'refresh');
		}
	}
    
}