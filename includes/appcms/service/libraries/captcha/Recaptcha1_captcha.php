<?php
//RECAPTCHA VERSION 2.0
//https://www.google.com/recaptcha
defined('BASEPATH') OR exit('No direct script access allowed');
class Recaptcha1_captcha
{
	private $CI;
	private $siteKey;
	private $secretKey;
	
	private $url='https://www.google.com/recaptcha/api.js';
    function __construct()
    {
        $this->CI=& get_instance();
        $datajson=optionGet('captcha_data');
		$site=jsonDataDecode($datajson,'sitekey');
		$secret=jsonDataDecode($datajson,'secretkey');
        $this->siteKey=$site;
        $this->secretKey=$secret;
    }
    
    function generate($view=TRUE){
		if($this->siteKey=="")
		{
			die('Recaptcha sitekey not found');
		}elseif($this->secretKey==""){
			die('Recaptcha secretkey not found');
		}else{
			require(dirname(__FILE__).'/recaptchav1/recaptchalib.php');
			echo recaptcha_get_html($this->siteKey);			
		}
	}
	
	function verifyCaptcha(){		
        $method=$_SERVER['REQUEST_METHOD'];
        $sk=$this->step1($method);
        if($sk)
        {
            return true;
        }else{            	
            return false;
        }        
	}
	
	function step1($method){
	  require(dirname(__FILE__).'/recaptchav1/recaptchalib.php');
	  $privatekey = $this->secretKey;
	  $resp='';
	  
	  if($method=="POST"){
	  	$resp = recaptcha_check_answer ($privatekey,
	                                $_SERVER["REMOTE_ADDR"],
	                                $_POST["recaptcha_challenge_field"],
	                                $_POST["recaptcha_response_field"]);
	  }elseif($method=="GET"){
	  	$resp = recaptcha_check_answer ($privatekey,
	                                $_SERVER["REMOTE_ADDR"],
	                                $_GET["recaptcha_challenge_field"],
	                                $_GET["recaptcha_response_field"]);
	  }
	  

	  if (!$resp->is_valid) {
	    return false;
	  } else {
	    return true;
	  }
	}
    
}