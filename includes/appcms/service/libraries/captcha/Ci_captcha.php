<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Ci_captcha
{
	private $CI;
	private $tbl;
    function __construct()
    {
        $this->CI=& get_instance();
        $this->tbl=optionGet('savepath','cicaptcha');
        if($this->CI->m_database->toolsTableExits($this->tbl)==false){
			$this->forgeTable();
		}
    }
    
    private function forgeTable(){
		$this->CI->load->dbforge();
		$fields = array(
                'captcha_id' => array(
                              'type' => 'BIGINT',
                              'constraint' => 13,
                              'unsigned' => TRUE,
                              'auto_increment' => TRUE
                          ),
				'captcha_time' => array(
                              'type' => 'INT',
							  'constraint' => '10',
							  'unsigned' => TRUE
                          ),
                'ip_address' => array(
                              'type' => 'VARCHAR',
                              'constraint' => '45'
                          ),
                'word' => array(
                              'type' => 'VARCHAR',
                              'constraint' => '20'
                          )
		);
		
	    $this->CI->dbforge->add_field($fields);
	    $this->CI->dbforge->add_key('captcha_id',TRUE);
	    $this->CI->dbforge->add_key('word');
	    $this->CI->dbforge->create_table($this->tbl, TRUE);
	}
	
	function generate($view){
		if($view==FALSE){
			return $this->generateDo();
		}else{
			$this->CI->load->view('service/login/captcha/ci/captchaview');
		}
	}
    
    function generateDo($view=FALSE){
		$datajson=optionGet('captcha_data');
		$savepath=jsonDataDecode($datajson,'folderci','captchafolder');
		$length=jsonDataDecode($datajson,'lengthci','5');
		$path=locationUpload('path').$savepath;
		fileDirCreate($path);
		
		$this->CI->load->helper('captcha');
		$vals = array(
		        'img_path'      => $path.'/',
		        'img_width'		=> 200,
		        'img_height'	=> 60,
		        'img_url'       => locationUpload('url').$savepath.'/',
		        'word_length'   => $length,
		        'font_path'     => './system/fonts/texb.ttf',
		        'pool'          => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
		        'img_id'        => 'cicaptcha',
		        'font_size'     => 16,
		        'colors'        => array(
	                'background' => array(255, 255, 255),
	                'border' => array(135, 5, 0),
	                'text' => array(0, 0, 0),
	                'grid' => array(255, 255, 255)
        		),
		);

		$cap = create_captcha($vals);
		$data = array(
		        'captcha_time'  => $cap['time'],
		        'ip_address'    => $this->CI->input->ip_address(),
		        'word'          => $cap['word']
		);

		$query = $this->CI->db->insert_string($this->tbl, $data);
		$this->CI->db->query($query);		
		$urlCaptcha=locationUpload('path').$savepath;		
		return $urlCaptcha.'/'.$cap['time'].'.jpg';		
		
	}
	
	function verifyCaptcha(){
		$expiration = time() - 7200;
		$this->CI->db->where('captcha_time < ', $expiration)
		        ->delete($this->tbl);
		$word='';
		$method=$_SERVER['REQUEST_METHOD'];
		if($method=="POST"){
			$word=$this->CI->input->post('cicaptcha');
		}elseif($method=="GET"){
			$word=$this->CI->input->get('cicaptcha');
		}		
		$ip=$this->CI->input->ip_address();
		$sp=array(
		'word'=>$word,
		'ip_address'=>$ip,
		'captcha_time >'=>$expiration,
		);
		
		if($this->CI->h_db->RecordCount($this->tbl,$sp) > 0)
		{			
			return true;
		}else{			
			return false;
		}
	}
}