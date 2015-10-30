<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('stringRandom')){
	function stringRandom($length=20,$huruf=FALSE)
	{
		$idformat='';
		if(empty($huruf) || $huruf==FALSE)
		{
			$idformat= substr(str_shuffle("0123456789"), 0, $length);
		}else{
			$idformat= substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
		}

		return $idformat;
	}
}

if(!function_exists('stringCreateSlug')){
	function stringCreateSlug($text)
	{

	  $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
	  $text = trim($text, '-');
	  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
	  $text = strtolower($text);
	  $text = preg_replace('~[^-\w]+~', '', $text);
	  if (empty($text))
	  {
		return 'n-a';
	  }
	  return $text;
	}
}

if(!function_exists('stringEncrypt')){
	function stringEncrypt($str)
	{
	    $CI=& get_instance();
	    $CI->load->library('m_security');
	    return $CI->m_security->strEncrypt($str);
	}
}

if(!function_exists('stringDecrypt')){
	function stringDecrypt($hash)
	{
	    $CI=& get_instance();
	    $CI->load->library('m_security');
	    return $CI->m_security->strDecrypt($hash);
	}
}

if(!function_exists('jsonDataDecode')){
	function jsonDataDecode($data,$key,$newVal=''){
		$dec=json_decode($data);
		if(empty($dec)){
			if(!empty($newVal)){
				return $newVal;
			}else{
				return "";
			}
		}else{
			if(!property_exists($dec,$key)){
				if(!empty($newVal)){
					return $newVal;
				}else{
					return "";
				}
			}else{
				$item=$dec->$key;
				return $item;
			}
		}
		
	}
}

if(!function_exists('langGet')){
	function langGet($file,$key,$nullValue=''){
		$CI=& get_instance();
		$setlang=taxonomyRead(userInfo('user_id'),'language_user');
		$lang='';
		if(!empty($setlang)){
			$lang=$setlang;
		}else{
			$lang="indonesia";
		}
		
		$CI->lang->load($file,$lang);
		$item=$CI->lang->line($key);
		if(!empty($item)){
			return $item;
		}else{
			if(!empty($nullValue)){
				return $nullValue;
			}else{
				return "";
			}
		}
	}
}



?>