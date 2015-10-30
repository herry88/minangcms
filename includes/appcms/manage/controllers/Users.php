<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Users extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        if(roleUser()!='mimin'){
			exit(langGet('global','noaccess'));
		}
		$this->load->library(array('m_security','m_auth'));
		
		$this->create_operator();
    }
    
    function index()
    {
        $meta['judul']=langGet('user','title');
        $this->load->view('public/header',$meta);
        $this->load->view('userview');
        $this->load->view('public/footer');
    }
    
    
    function create_operator(){		
		$s=array(
		'role_name'=>'Operator',
		'role_key'=>'op',
		'role_module'=>'manage/dashboard',
		);
		
		if($this->m_database->isBOF('userrole',$s)==TRUE){
			$this->m_database->addRow('userrole',$s);
		}
	}
    
    function viewdata(){
		$rolename=roleURIUser();
        $this->load->library('Datatables');
        $prefix=$this->db->dbprefix;
		$this->datatables->select('userlogin.user_id as ii, userlogin.username as user, userlogin.nama as nama,userlogin.status as status, userlogin.email,usertaxonomy.taxo_val')
            ->unset_column('user_id')
            ->add_column('aksi',$this->buttonAksi('$1',$rolename),"ii")
            ->edit_column('akses','$1','roleUserCustom(ii)')
            ->edit_column('login','$1','lastLoginUser(ii)')
            ->from('(userlogin LEFT JOIN usertaxonomy ON userlogin.user_id = usertaxonomy.user_id)')
            ->where(array(
                'usertaxonomy.taxo_key'=>'role_user',
                'usertaxonomy.taxo_val !='=>'1',
                ));
 
        echo $this->datatables->generate();
	}
	
	function buttonAksi($id,$rolename)
	{
		$p='';
		
		$p.='<a onclick="return confirm(\'Yakin ingin menghapus user ini?\');" class="btn btn-xs btn-danger" href="'.base_url($rolename.'users/delete').'?id='.$id.'&token='.tokenGenerate().'"><li class="fa fa-trash"></li></a>&nbsp;';
        $p.='<a onclick="return confirm(\'Yakin ingin banned user ini?\');" class="btn btn-xs btn-warning" href="'.base_url($rolename.'users/banned').'?id='.$id.'&token='.tokenGenerate().'"><li class="fa fa-lock"></li></a> ';
        $p.='<a onclick="return confirm(\'Yakin ingin aktifkan user ini?\');" class="btn btn-xs btn-success" href="'.base_url($rolename.'users/removebanned').'?id='.$id.'&token='.tokenGenerate().'"><li class="fa fa-check"></li></a> ';
        $p.='<a onclick="return confirm(\'Yakin ingin reset user ini?\');" class="btn btn-xs btn-info" href="'.base_url($rolename.'users/reset').'?id='.$id.'&token='.tokenGenerate().'"><li class="fa fa-refresh"></li></a>';
       
       return $p;
	}
	
	function add(){
		$meta['judul']=langGet('menu','menu_users_add');
        $this->load->view('public/header',$meta);
        $this->load->view('useradd');
        $this->load->view('public/footer');
	}
	
	function addapply(){
		
		$this->m_security->filterPost('nama','required');
        $this->m_security->filterPost('username','required');
        $this->m_security->filterPost('password','required');
        $this->m_security->filterPost('email','required');
        $this->m_security->filterPost('hp','required');
        $this->m_security->filterPost('akses','required');
        if($this->m_security->startPost()==TRUE)
        {
            $nama=$this->input->post('nama',TRUE);
            $username=$this->input->post('username',TRUE);
            $password=$this->input->post('password',TRUE);
            $email=$this->input->post('email',TRUE);
            $hp=$this->input->post('hp',TRUE);
            $role=$this->input->post('akses',TRUE);
            if($this->m_auth->registerUser($username,$password,$nama,$hp,$email,$role,'active',FALSE)==TRUE)
            {
                redirect(base_url(roleURIUser().'users'),'refresh');
            }else{
                redirect(base_url(roleURIUser().'users/add'),'refresh');
            }
        }else{
            redirect(base_url(roleURIUser().'users/add'),'refresh');
        }
	}
	
	function delete()
    {
        $id=$this->input->get('id',TRUE);
		$s=array(
		'user_id'=>$id,
		);
		if($this->m_database->isBOF('userlogin',$s)==TRUE)
		{
			redirect(base_url(roleURIUser().'users'),'refresh');
		}else{
        	if($this->m_auth->deleteUser($id)==TRUE){
				redirect(base_url(roleURIUser().'users'),'refresh');
			}else{
				redirect(base_url(roleURIUser().'users'),'refresh');
			}
        }
    }
    
    function reset()
    {
        $id=$this->input->get('id',TRUE);
		$s=array(
		'user_id'=>$id,
		);
		if($this->m_database->isBOF('userlogin',$s)==TRUE)
		{
			redirect(base_url(roleURIUser().'users'),'refresh');
		}else{
        	if($this->m_auth->recoveryUser($id,'1234')==TRUE){
				redirect(base_url(roleURIUser().'users'),'refresh');
			}else{
				redirect(base_url(roleURIUser().'users'),'refresh');
			}
        }
    }
    
    function banned()
    {
    	
    	$id=$this->input->get('id',TRUE);
		$s=array(
		'user_id'=>$id,
		'status'=>'active'
		);
		if($this->m_database->isBOF('userlogin',$s)==TRUE)
		{
			redirect(base_url(roleURIUser().'users'),'refresh');
		}else{
			$d=array(
			'status'=>'banned',
			);
			$this->m_database->editRow('userlogin',$d,$s);
			redirect(base_url(roleURIUser().'users'),'refresh');
		}
	}
	
	function removebanned()
    {
    	$id=$this->input->get('id',TRUE);
		$s=array(
		'user_id'=>$id,
		'status'=>'banned'
		);
		if($this->m_database->isBOF('userlogin',$s)==TRUE)
		{
			redirect(base_url(roleURIUser().'users'),'refresh');
		}else{
			$d=array(
			'status'=>'active',
			);
			$this->m_database->editRow('userlogin',$d,$s);
			redirect(base_url(roleURIUser().'users'),'refresh');
		}
	}
	
	function role(){
		$meta['judul']='Access Management';
        $this->load->view('header',$meta);
        $d['data']=$this->m_database->fetchData('userrole');
        $this->load->view(roleUser().'/user/roleview',$d);
        $this->load->view('footer');
	}
	
	function addroleapply()
    {
        $this->m_security->filterPost('roleidentify','required');
        $this->m_security->filterPost('rolename','required');
        $this->m_security->filterPost('rolemodule','required');
        if($this->m_security->startPost()==TRUE)
        {
            $identify=$this->input->post('roleidentify',TRUE);
            $nama=$this->input->post('rolename',TRUE);
            $module=$this->input->post('rolemodule',TRUE);
            $s=array(
                'role_module'=>$module,
                );
            if($this->m_database->isBOF('userrole',$s)==FALSE)
            {
                redirect(base_url(roleURIUser().'users/role'),'refresh');
            }else{
                $d=array(
                	'role_key'=>$identify,
                    'role_name'=>$nama,
                    'role_module'=>$module,
                    );
                $this->m_database->addRow('userrole',$d);
                redirect(base_url(roleURIUser().'users/role'),'refresh');
            }
        }else{
            redirect(base_url(roleURIUser().'users/role'),'refresh');
        }
    }
    
    
    
    function deleteroleapply()
    {
        $id=$this->input->get('id');
        if($id=="1")
        {
            redirect(base_url(roleURIUser().'users/role'),'refresh');
        }else{
            $s=array(
                'role_id'=>$id,
                );
            if($this->m_database->deleteRow('userrole',$s)==TRUE)
            {
                redirect(base_url(roleURIUser().'users/role'),'refresh');
            }else{
                redirect(base_url(roleURIUser().'users/role'),'refresh');
            }
        }
    }
    
}