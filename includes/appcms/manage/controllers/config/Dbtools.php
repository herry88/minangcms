<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dbtools extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        if(roleUser()!='mimin')
        {
			sesLogout();
		}
		$this->load->dbutil();
		$this->load->library('m_security');
    }
    
    function index()
    {
    	$meta['judul']="Database Tools";
    	$this->load->view('public/header',$meta);
    	$d['autoname']="dbbackup".date("dmy");
        $this->load->view('config/dbtoolsview',$d);
        $this->load->view('public/footer');
    }
    
    function backupdb()
    {
		$this->m_security->filterPost('nama','required');
		$this->m_security->filterPost('tipe','required');
		if($this->m_security->startPost()==TRUE)
		{
			$nama=$this->input->post('nama',TRUE).'-'.stringRandom(3,TRUE);
			$tipe=$this->input->post('tipe',TRUE);
			$addinsert=$this->input->post('addinsert',TRUE);
			$adddrop=$this->input->post('adddrop',TRUE);
			
			$refinsert=FALSE;
			$refdrop=FALSE;
			if($addinsert=="on")
			{
				$refinsert=TRUE;
			}else{
				$refinsert=FALSE;
			}
			if($adddrop=="on")
			{
				$refdrop=TRUE;
			}else{
				$refdrop=FALSE;
			}
			
			$prefs = array(                
			        'format'        => $tipe,
			        'filename'      => $nama.'.sql',
			        'add_drop'      => $refdrop,
			        'add_insert'    => $refinsert,
			        'newline'       => "\n"
			);
			
			
        	$backup =$this->dbutil->backup($prefs);
        	$this->load->helper('download');
        	force_download($nama.'.'.$tipe, $backup);
		}else{
			redirect(base_url(roleUser().'config/dbtools'),'refresh');
		}
	}
	
	function optimizedb()
	{
		$result = $this->dbutil->optimize_database();

		if ($result !== FALSE)
		{
		    echo json_encode('Berhasil Optimasi Database');
		}else{
			echo json_encode('Gagal Optimasi Database');
		}
				
	}
    
    function repairtable()
    {
		$table=$this->input->get('table',TRUE);
		if ($this->dbutil->repair_table($table))
		{
		    echo json_encode('Berhasil Repair Table '.$table);
		}else{
			echo json_encode('Gagal Repair Table '.$table);
		}
	}
}