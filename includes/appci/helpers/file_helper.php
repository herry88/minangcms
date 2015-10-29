<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('fileInfo')){
	/**
	 * [fileInfo Mengambil info metadata dari file]
	 * @param  string $path   [lokasi file. Contoh ./assets/upload/file.php]
	 * @param  string $output [name (string),server_path (string),size (byte),date (int time)]
	 * @return string         [description]
	 */
	function fileInfo($path,$output){
		$CI=& get_instance();
		$CI->load->helper('file');
		$item=get_file_info($path,array($output));
		foreach($item as $ritem){
			return $ritem;
		}
	}
}

if(!function_exists('locationAsset')){	
	function locationAsset($tipe='url',$path='')
	{
		if($tipe=="url")
		{
			if(empty($path))
			{
				return base_url().'assets/';
			}else{
				return base_url().$path.'/';
			}
			
		}elseif($tipe=="path"){
			return  "./assets/".$path.'/';
		}
	}
}

if(!function_exists('locationPlugin')){
	function locationPlugin($tipe='url')
	{
		if($tipe=="url")
		{
			return locationAsset('url').'plugins/';
			
		}elseif($tipe=="path"){
			return  "./assets/plugins/";
		}
	}
}

if(!function_exists('locationAPPlugin')){
	function locationAPPlugin($tipe='url')
	{
		if($tipe=="url")
		{
			return base_url().'modules/plugins/';
			
		}elseif($tipe=="path"){
			return  FCPATH.'modules/plugins/';
		}
	}
}

if(!function_exists('locationTheme')){
	function locationTheme($tipe='url')
	{
		if($tipe=="url")
		{
			return locationAsset('url').'themes/';
			
		}elseif($tipe=="path"){
			return  "./assets/themes/";
		}
	}
}

if(!function_exists('locationUpload')){
	function locationUpload($tipe='url')
	{
		if($tipe=="url")
		{
			return locationAsset('url').'uploads/';
		}elseif($tipe=="path"){
			return "./assets/uploads/";
		}
	}
}

if(!function_exists('incCSS')){
	function incCSS($cssfile)
	{

		$str='<link rel="stylesheet" type="text/css" href="'.$cssfile.'.css">';
		return $str;
	}
}

if(!function_exists('incJS')){
	function incJS($jsfile)
	{
		$str='<script type="text/javascript" src="'.$jsfile.'.js"></script>';
		return $str;
	}
}

if(!function_exists('fileDirCreate')){
	function fileDirCreate($path)
	{
		$CI=& get_instance();
		$CI->load->library('m_file');
		return $CI->m_file->makeDir($path);	     
	}
}

if(!function_exists('fileDirRemove')){
	function fileDirRemove($dir,$recursive=FALSE)
	{
		$CI=& get_instance();
		$CI->load->library('m_file');
		
		return $CI->m_file->remDir($dir,$recursive);		
	}
}

if(!function_exists('ZipExtract')){
	function ZipExtract($archive, $destination) {   
	    $CI=& get_instance();
		$CI->load->library('m_file');
		return $CI->m_file->ZipExtract($archive,$destination);
   }
}

if(!function_exists('noPhoto')){
	function noPhoto($size="64")
	{
	    $file="nophoto.jpg";
	    $path=locationUpload('path');
	    $url=locationUpload('url');
	    
	    if(file_exists($path.'thumbs/'.$size.'/'.$file)){
			return $url.'thumbs/'.$size.'/'.$file;
		}else{
			return $url.$file;
		}
	    
	}
}

if(!function_exists('noImage')){
	function noImage($size="64")
	{	
		$file="noimage.png";
	    $path=locationUpload('path');
	    $url=locationUpload('url');
	    
	    if(file_exists($path.'thumbs/'.$size.'/'.$file)){
			return $url.'thumbs/'.$size.'/'.$file;
		}else{
			return $url.$file;
		}
	}
}

if(!function_exists('noImageBig')){
	function noImageBig()
	{				    
	    $url=locationUpload('url');
	    
	    return $url.'no-image-big.jpg';
	}
}

if(!function_exists('getCheckImage')){
	function getCheckImage($file){
		if(file_exists($file)){
			if(getimagesize($file)){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
}

if(!function_exists('getTheme')){
	function getTheme($type){
		$xPath=locationTheme('path').$type;
		$xUrl=locationTheme('url').$type;
		$path=scandir($xPath);
		$dpath=array_diff($path, array('.', '..'));
		$output=array();
		$thumbFile="thumbnail.jpg";
		foreach($dpath as $key=>$val)
        {
        	$img='';        	
        	if(getCheckImage($xPath.'/'.$val.'/'.$thumbFile)){
				$img=$xUrl.'/'.$val.'/'.$thumbFile;
			}else{
				$img=noImageBig();
			}
			$output[]=array(
			'thumb'=>$img,
			'name'=>$val,			
			);
        }
        return $output;
	}
}

if(!function_exists('themeHasOption')){
	function themeHasOption($themeActive){		
        $optionFile=locationTheme('path').'frontend/'.$themeActive.'/includes/themeoption.php';
        if(file_exists($optionFile)){
			return true;
		}else{
			return false;
		}
	}
}

if(!function_exists('parseKCFinderUrl')){
	function parseKCFinderUrl($img){
		$CI=& get_instance();
		$CI->load->helper('mc_helper');
		$newurl=imagePath($img);
		return base_url().$newurl;		
	}
}


?>
