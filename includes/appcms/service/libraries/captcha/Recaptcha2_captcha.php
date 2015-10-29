<?php
//RECAPTCHA VERSION 2.0
//https://www.google.com/recaptcha
defined('BASEPATH') OR exit('No direct script access allowed');
class Recaptcha2_captcha
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
    
    function generate(){
		if($this->siteKey=="")
		{
			die('Recaptcha sitekey not found');
		}elseif($this->secretKey==""){
			die('Recaptcha secretkey not found');
		}else{
			$p='';
			$p.="<script src='".$this->url."'></script>";
			$p.='<div class="g-recaptcha" data-sitekey="'.$this->siteKey.'"></div>';
			echo $p;
		}
	}
	
	function verifyCaptcha(){
		$respon='';
		$method=$_SERVER['REQUEST_METHOD'];
		if($method=="POST"){
			$respon=$this->CI->input->post('g-recaptcha-response');
		}elseif($method=="GET"){
			$respon=$this->CI->input->get('g-recaptcha-response');
		}
        if($respon!="")
        {
            $sk=$this->step1($respon);
            if($sk)
            {
                return true;
            }else{            	
                return false;
            }
        }else{        	
            return false;
        }
	}
	
	function step1($response){		
		$google_url = "https://www.google.com/recaptcha/api/siteverify";
        $secret = $this->secretKey;
        $url = $google_url."?secret=".$secret.
               "&response=".$response;
 
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_TIMEOUT, 15);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); 
        $curlData = curl_exec($curl);
 
        curl_close($curl);
 
        $res = json_decode($curlData, TRUE);
        if($res['success'] == 'true') 
            return true;
        else
            return false;
	}
    
}