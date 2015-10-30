<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Posts extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        checkAccess();        
        $this->load->helper('posts_helper');
        $this->load->library('m_security');
        $this->nocat();
        date_default_timezone_set('Asia/Jakarta');
    }
    
    function nocat(){
		$s=array(
		'term_id'=>'1',
		);
		if($this->m_database->isBOF('terms',$s)==TRUE){
			insertCategory('Uncategorized','uncategorized','','0');
		}
	}
    
    function index()
    {    	

        $meta['judul']="Data Berita";
        $this->load->view('public/header',$meta);
        $d['tipe']="posts";
        $d['mod']="Berita";
        $s=array();
        if(roleUser()=="op"){
			$s=array(
	        'post_type'=>'post',
	        'post_status'=>'publish',
	        'post_user'=>userInfo('user_id'),
	        );
		}else{
			$s=array(
	        'post_type'=>'post',
	        'post_status'=>'publish',
	        );
		}
		
		$s2=array();
		if(roleUser()=="op"){
			$s2=array(
	        'post_type'=>'post',
	        'post_status'=>'draft',
	        'post_user'=>userInfo('user_id'),
	        );
		}else{
			$s2=array(
	        'post_type'=>'post',
	        'post_status'=>'draft',
	        );
		}
        
        $d['publishcount']=$this->m_database->countData('posts',$s);
        $d['draftcount']=$this->m_database->countData('posts',$s2);
        $lastStatus='';
        $g=$this->input->get('post_status');
        if($g=="publish"){
			$lastStatus=$g;
		}elseif($g=="draft"){
			$lastStatus=$g;
		}else{
			$lastStatus="publish";
		}
		$d['poststatus']=$lastStatus;
        $this->load->view('content/post/postview',$d);
        $this->load->view('public/footer');
    }
    
    function viewdata(){
		$rolename=roleURIUser();
		$role="";
		$userid=userInfo('user_id');
		$arr=array();
		$prefix=$this->db->dbprefix;		
		$status=$this->input->get('post_status');
        $this->load->library('Datatables');        
        if(roleUser()=="op"){
			$arr=array(
                $prefix.'posts.post_status'=>$status,
                $prefix.'posts.post_type'=>'post',
                $prefix.'posts.post_user'=>$userid,
                );
		}else{
			$arr=array(
                $prefix.'posts.post_status'=>$status,
                $prefix.'posts.post_type'=>'post',
                );
		}
		$this->datatables->select($prefix.'posts.post_id as ii, '.$prefix.'posts.post_title as judul,'.$prefix.'posts.post_date as tanggal')
            ->unset_column('post_id')
            ->add_column('aksi',$this->buttonAksi('$1',$rolename),"ii")
            ->edit_column('penulis','$1','postAuthor(ii)')
            ->edit_column('kategori','$1','postCategory(ii)')
            ->edit_column('tags','$1','postTags(ii)')
            ->from($prefix.'posts')
            ->where($arr);
 
        echo $this->datatables->generate();
	}
	
	function buttonAksi($id,$rolename)
	{
		$p='';
		
		$p.='<a onclick="return confirm(\'Yakin ingin menghapus berita ini?\');" class="btn btn-xs btn-danger" href="'.base_url($rolename.'content/posts/delete').'?id='.$id.'&token='.tokenGenerate().'"><li class="fa fa-trash"></li></a>&nbsp;';        
        $p.='<a class="btn btn-xs btn-info" href="'.base_url($rolename.'content/posts/edit').'?id='.$id.'&token='.tokenGenerate().'"><li class="fa fa-edit"></li></a> ';
        $p.='<a target="_blank" class="btn btn-xs btn-primary" href="'.base_url($rolename.'content/posts/viewpost').'?id='.$id.'&token='.tokenGenerate().'"><li class="fa fa-eye"></li></a>';
       
       return $p;
	}
	
	function add(){		
		$meta['judul']="Tambah Berita";
		$this->load->view('public/header',$meta);
		$d['tipe']="post";
		$d['mod']="Berita";
		$d['uclass']='posts';
		$this->load->view('content/post/postadd',$d);
		$this->load->view('public/footer');
	}
	
	function tagscomplete(){
		$term=$this->input->get('term');
		$prefix=$this->db->dbprefix;
		$sql="SELECT ".$prefix."terms.name FROM ".$prefix."terms LEFT JOIN ".$prefix."termstaxonomy ON ".$prefix."terms.term_id = ".$prefix."termstaxonomy.term_id Where ".$prefix."terms.name LIKE '%$term%' AND ".$prefix."termstaxonomy.term_type='tag'";
		$c=$this->m_database->countQuery($sql);
		if($c>0){
			$d=$this->m_database->fetchQuery($sql);
			$data=array();
			foreach($d as $r){
				$data[]=array(
				'value'=>$r->name,
				);
			}
			echo json_encode($data);			
		}else{
			echo json_encode(array(
			'value'=>'',
			));
		}
	}
	
	
	function addapply(){
		$this->m_security->filterPost('title','required');
		$this->m_security->filterPost('konten','required');
		$this->m_security->filterPost('tipepost','required');
		$this->m_security->filterPost('statpublish','required');
		$this->m_security->filterPost('tanggal','required');
		if($this->m_security->startPost()==TRUE){
			$judul=$this->input->post('title');
			$konten=$this->input->post('konten');
			$tipe=$this->input->post('tipepost');
			$status=$this->input->post('statpublish');
			$tags=json_decode($this->input->post('tagsdata'),TRUE);
			$tanggal=$this->input->post('tanggal');
			$datetime=$tanggal." ".date("H:i:s");
			$keyword=$this->input->post('addkeyword');
			$tampilan=$this->input->post('tampilan');
			$komen=valCheckbox($this->input->post('komen'));
			
			
			$proses=FALSE;
			$this->load->model('post_model','pm');
			if($tipe=="post"){
				$kategori=$this->input->post('kat');
				$featureimage=$this->input->post('featureimage');
				$proses=$this->pm->addPost($judul,$datetime,$konten,$status,$kategori,$tags,$keyword,$komen,$tampilan,$featureimage);
			}elseif($tipe=="page"){
				$proses=$this->pm->addPage($judul,$datetime,$konten,$status,$tags,$keyword,$komen,$tampilan);
			}
			
			if($proses['status']==TRUE){
				$lastid=$proses['lastid'];
				$this->session->set_flashdata('info','<div class="alert alert-info">Berhasil menambah berita</div>');
				redirect(base_url(roleURIUser().'content/posts/edit').'?id='.$lastid,'refresh');
			}else{
				redirect(base_url(roleURIUser().'content/posts/add'),'refresh');
			}
			
		}else{
			redirect(base_url(roleURIUser().'content/posts/add'),'refresh');
		}
	}
	
	function edit(){
		$id=$this->input->get('id',TRUE);
		$s=array(
		'post_id'=>$id,
		);
		if($this->m_database->isBOF('posts',$s)==FALSE){
			$d['tipe']=$this->m_database->fieldRow('posts',$s,'post_type');
			$meta['judul']="Ubah berita";
			$this->load->view('public/header',$meta);
			$d['data']=$this->m_database->fetchData('posts',$s);
			$d['uclass']='posts';
			$this->load->view('content/post/postedit',$d);
			$this->load->view('public/footer');
		}else{
			redirect(base_url(roleURIUser().'content/posts'),'refresh');
		}
		
	}
	
	function editapply(){
		$this->m_security->filterPost('postid','required');
		$this->m_security->filterPost('title','required');
		$this->m_security->filterPost('konten','required');
		$this->m_security->filterPost('tipepost','required');
		$this->m_security->filterPost('statpublish','required');
		$this->m_security->filterPost('tanggal','required');
		if($this->m_security->startPost()==TRUE){
			$postid=$this->input->post('postid');
			$judul=$this->input->post('title');
			$konten=$this->input->post('konten');
			$tipe=$this->input->post('tipepost');
			$status=$this->input->post('statpublish');
			$tags=json_decode($this->input->post('tagsdata'),TRUE);
			$tanggal=$this->input->post('tanggal');
			$datetime=$tanggal." ".date("H:i:s");
			$keyword=$this->input->post('addkeyword');
			$tampilan=$this->input->post('tampilan');
			$komen=valCheckbox($this->input->post('komen'));
			
			
			$proses=FALSE;
			$this->load->model('post_model','pm');
			if($tipe=="post"){
				$kategori=$this->input->post('kat');
				$featureimage=$this->input->post('featureimage');
				$proses=$this->pm->editPost($postid,$judul,$datetime,$konten,$status,$kategori,$tags,$keyword,$komen,$tampilan,$featureimage);
			}elseif($tipe=="page"){
				$proses=$this->pm->editPage($postid,$judul,$datetime,$konten,$status,$tags,$ke,$komen,$tampilan);
			}
			
			if($proses['status']==TRUE){				
				$this->session->set_flashdata('info','<div class="alert alert-info">Berhasil mengubah berita</div>');
				redirect(base_url(roleURIUser().'content/posts/edit').'?id='.$postid,'refresh');
			}else{
				redirect(base_url(roleURIUser().'content/posts/add'),'refresh');
			}
			
		}else{
			redirect(base_url(roleURIUser().'content/posts/add'),'refresh');
		}
	}
	
	function viewpost(){
		$id=$this->input->get('id');
		redirect(permalinkPost($id),'refresh');
	}
	
	function delete(){
		$id=$this->input->get('id');
		$this->load->model('post_model','postmod');
		$this->postmod->deletePost($id);
		redirect(base_url(roleURIUser().'content/posts'),'refresh');
	}
	
	function getcategory(){
		$d['tipe']="post";
		$this->load->view(roleURIUser().'content/post/categoryside',$d);
	}
    
}