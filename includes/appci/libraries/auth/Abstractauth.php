<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Abstractauth{
	
	private $CI;
	
	function __construct(){
		$this->CI=& get_instance();
		$this->CI->load->helper('service_helper');
	}
	
	function loginDo($username,$password,$remember='0'){
		
		$checkUsername=array(
		'username'=>$username,
		);
		if($this->CI->m_database->isBOF('userlogin',$checkUsername)==TRUE){
			return false;
		}else{
			$dbpass=$this->CI->m_database->fieldRow('userlogin',$checkUsername,'password');
			$userid=$this->CI->m_database->fieldRow('userlogin',$checkUsername,'user_id');
			$valPass=$this->CI->m_security->validationPassword($password,$dbpass);
			if($valPass==TRUE){
				$tglSekarang=dateNow(TRUE);
				taxonomyCreate($userid,'login_user',$tglSekarang);
				$service=runService('login','after');
				if($service==TRUE){					
					return true;
				}else{
					runService('login','before');
					return false;
				}
				
			}else{
				runService('login','before');
				return false;
			}
		}		
	}
	
	
	
	
	function registerDo($username,$password,$nama,$hp,$emailx,$role,$status,$sendMail=FALSE){
		$checkUsername=array(
		'username'=>$username,
		);
		if($this->CI->m_database->isBOF('userlogin',$checkUsername)==TRUE){
			
			$checkEmail=array(
			'email'=>$emailx
			);
			
			if($this->CI->m_database->isBOF('userlogin',$checkEmail)==TRUE){
				
				$checkHP=array(
				'hp'=>$hp
				);
				
				if($this->CI->m_database->isBOF('userlogin',$checkHP)==TRUE){
					$dbPass=$this->CI->m_security->createPassword($password);
					$dUser=array(
					'username'=>$username,
					'password'=>$dbPass,
					'nama'=>$nama,
					'hp'=>$hp,
					'email'=>$emailx,
					'status'=>$status,
					);
					
					if($this->CI->m_database->addRow('userlogin',$dUser)==TRUE){
						$IDUser=$this->CI->m_database->lastInsertID();
						taxonomyCreate($IDUser,'role_user',$role);
						$tglSekarang=dateNow(TRUE);
						taxonomyCreate($IDUser,'register_user',$tglSekarang);	
						
						if($sendMail==TRUE){
							$this->CI->load->library('m_net');
							$myMail=optionGet('company_email');
							$myName=optionGet('company_name');
							$subject=optionGet('email_register_subject');
							$message=optionGet('email_register_message');
							$output='';
							$output.=$message.'<br/>';
							$output.='Username : <b>'.$username.'</b><br/>';
							$output.='Password : <b>'.$password.'</b><br/>';
							$output.='<hr/>';
							$output.='Regards,<br/><p>&nbsp;</p>';
							$output.=$myName;
							
							$this->CI->m_net->SendEmail($myMail,$myName,$emailx,$subject,$output,'','');
							return true;
						}else{
							return true;
						}
											
						
					}else{
						return false;
					}
					
				}else{
					return false;
				}
				
			}else{
				return false;
			}
			
		}else{
			return false;
		}
	}
	
	function recoveryDo($email){
		
		$checkEmail=array(
		'email'=>$email,
		);
		
		if($this->CI->m_database->isBOF('userlogin',$checkEmail)==TRUE){
			return false;
		}else{
			$userid=$this->CI->m_database->fieldRow('userlogin',$checkEmail,'user_id');
			$this->CI->load->helper(array('url','string_helper'));
			$hash=stringRandom(40,TRUE);
			taxonomyCreate($userid,'reset_user',$hash,3600);
			$link=base_url().'recovery?email='.$email.'&hash='.$hash;
			$this->CI->load->library('m_net');
			$myMail=optionGet('company_email');
			$myName=optionGet('company_name');
			$subject=optionGet('email_recovery_subject');
			$message=optionGet('email_recovery_message');
			$output='';
			$output.=$message.'<br/>';
			$output.='<blockquote><a href="'.$link.'" target="_blank"><b>Reset Password</b></a></blockquote><br/>';
			$output.='<hr/>';
			$output.='Regards,<br/><p>&nbsp;</p>';
			$output.=$myName;
			
			$this->CI->m_net->SendEmail($myMail,$myName,$email,$subject,$output,'','');
			
			return true;
		}		
	}
	
}