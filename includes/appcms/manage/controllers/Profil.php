<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Profil extends MX_Controller
{
    
    function __construct()
    {
        parent::__construct();
        checkAccess();
        $this->load->library(array('m_database','m_security'));
    }

    function index()
    {
        $meta['judul']="Profil";
        $this->load->view('public/header',$meta);
        $this->load->view('profilview');
        $this->load->view('public/footer');
    }
    

    function update()
    {
        $this->m_security->filterPost('username','required');
        $this->m_security->filterPost('nama','required');
        $this->m_security->filterPost('email','required');
        if($this->m_security->startPost()==TRUE)
        {
            $username=$this->input->post('username',TRUE);
            $nama=$this->input->post('nama',TRUE);
            $email=$this->input->post('email',TRUE);
            $hp=$this->input->post('hp',TRUE);
            $pwold=$this->input->post('pwold',TRUE);
            $pwnew=$this->input->post('pwnew',TRUE);
            
            $d=array();
            $pesan='';
						
            if($pwold!="" and $pwnew!="")
            {
                $pwdb=userInfo('password');
                if($this->m_security->validationPassword($pwold,$pwdb)==TRUE)
                {
                    $d=array(
                    'nama'=>$nama,
                    'email'=>$email,
                    'hp'=>$hp,
                    'password'=>$this->m_security->createPassword($pwnew),
                    );
                    $pesan="Update profil dan password berhasil";
                }else{
                    redirect(base_url(roleURIUser().'profil'),'refresh');
                }

            }else{
                $d=array(
                    'nama'=>$nama,
                    'email'=>$email,
                    'hp'=>$hp,
                );
            }
            $sUser=array(
                'user_id'=>userInfo('user_id'),
                );
            $this->m_database->editRow('userlogin',$d,$sUser);
            
            
            $img=$this->input->post('featureimage');
            if(!empty($img)){
				$sT=array(
				'user_id'=>userInfo('user_id'),
				'taxo_key'=>'avatar_user',
				);
				$dT=array(
				'taxo_val'=>$img,
				);
				
				if($this->m_database->isBOF('usertaxonomy',$sT)==TRUE){
					$sT=array(
					'user_id'=>userInfo('user_id'),
					'taxo_key'=>'avatar_user',
					'taxo_val'=>$img,					
					);
					$this->m_database->addRow('usertaxonomy',$sT);
				}else{
					$this->m_database->editRow('usertaxonomy',$dT,$sT);
				}
								
								
			}
            
            redirect(base_url(roleURIUser().'profil'),'refresh');
        }else{
            redirect(base_url(roleURIUser().'profil'),'refresh');
        }

    }
}
?>
