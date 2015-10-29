<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Simple_captcha
{
	private $CI;
    function __construct()
    {
    	$this->CI=& get_instance();
    }        
    
    function generate($view=FALSE){
		if($view==FALSE){
			echo $this->generateDo();			
		}else{
			$d['img']=$this->generateDo();
			$this->CI->load->view('service/login/captcha/simple/captchaview',$d);
		}
	}
    
    function generateDo(){		
		ob_start();
		$text = rand(10000,99999);
		$sesCaptcha=$this->CI->session->userdata('simplecaptcha');
		if(empty($sesCaptcha)){
		$this->CI->session->set_userdata('simplecaptcha',$text);	
		}		
		$height = 22;
		$width = 60;
		$image_p = imagecreate($width, $height);
		$black = imagecolorallocate($image_p, 0, 0, 0);
		$white = imagecolorallocate($image_p, 255, 255, 255);
		$font_size = 12; 
		imagestring($image_p, $font_size, 5, 3, $text, $white);
		imagejpeg($image_p, null, 80);
		imagedestroy($image_p);
		$i=ob_get_clean();
		return 'data:image/jpeg;base64,'.base64_encode($i);
	}
    
    
    function verifyCaptcha(){
		$respon='';
		$method=$_SERVER['REQUEST_METHOD'];
		if($method=="POST"){
			$respon=$this->CI->input->post('simplecaptchainput');
		}elseif($method=="GET"){
			$respon=$this->CI->input->get('simplecaptchainput');
		}
		
		if(!empty($respon)){
			$sesCaptcha=$this->CI->session->userdata('simplecaptcha');
			if($respon==$sesCaptcha){
				$this->CI->session->unset_userdata('simplecaptcha');
				var_dump('OK');
				//return true;
			}else{
				var_dump('NO 1 '.$respon." ".$sesCaptcha);
				//return false;
			}
		}else{
			var_dump('NO 2');
			//return false;
		}
	}
    
}