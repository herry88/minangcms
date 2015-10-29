<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Math_captcha
{
	private $CI;
    function __construct()
    {
    	$this->CI=& get_instance();            
    }
    
    function generate($view=FALSE){
		if($view==FALSE){
			return $this->generateDo();
		}else{
			$d['img']=$this->generateDo();
			$this->CI->load->view('service/login/captcha/math/captchaview',$d);
		}
	}
        
    function generateDo(){		
		ob_start();
		$n1=rand(1,10);
		$n2=rand(11,20);
		$text = $n1."x".$n2;
		$answer=$n1*$n2;
		$this->CI->session->set_userdata('mathcaptcha',$text);
		$this->CI->session->set_userdata('mathcaptchaanswer',$answer);
		$height = 25;
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
			$respon=$this->CI->input->post('mathcaptchainput');
		}elseif($method=="GET"){
			$respon=$this->CI->input->get('mathcaptchainput');
		}
		
		if(!empty($respon)){
			$sesCaptcha=$this->CI->session->userdata('mathcaptchaanswer');
			if($respon==$sesCaptcha){
				$this->CI->session->unset_userdata('mathcaptchaanswer');
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
    
}