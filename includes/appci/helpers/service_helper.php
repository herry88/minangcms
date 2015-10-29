<?php
defined('BASEPATH') OR exit('No direct script access allowed');


if(!function_exists('runService')){
	function runService($module,$state){
	  $CI=& get_instance();
	  $CI->load->library('m_database');
      $w=array(
      "option_key LIKE "=>"service_".$module."_%",
      'option_val'=>'1',
      );
      
      $d=$CI->m_database->fetchData('options',$w);
      $c=$CI->m_database->countData('options',$w);
      $x="";
      foreach($d as $r){
      	$san=str_replace("service_".$module."_","",$r->option_key);
      	$sname='service_'.$state;
	  	$x= modules::run('service/'.$module.'/'.$san.'/'.$sname);
	  }
	  return $x;
	}
}

if(!function_exists('urlApp')){
	function urlApp(){		
  		$server=$_SERVER['SERVER_NAME'];
  		$jbase=base_url();
	  	$exjbase=explode("/",$jbase);
	  	if(ENVIRONMENT=="production"){
			return base_url();
		}elseif(ENVIRONMENT=="development"){
			return $exjbase[0].'//'.$server;
		}
	}
}

if(!function_exists('galleryAlbum')){
	function galleryAlbum($galleryID){
		$CI=& get_instance();
		$s=array(
		'term_key'=>'gallery_list',
		'term_value'=>$galleryID,
		);
		$p='';
		$c=$CI->m_database->countData('albumtaxonomy',$s);
		if($c > 0){
			$d=$CI->m_database->fetchData('albumtaxonomy',$s,'album_id ASC');
			foreach($d as $r){
				$albumTitle=dbField('album','album_id',$r->album_id,'album_title');
				$slug=stringCreateSlug($albumTitle);
				$url=base_url().'media/album/'.$slug;				
				$p.='<a target="_blank" href="'.$url.'" class="btn btn-xs btn-success btn-flat">'.$albumTitle.'</a> ';
			}
		}else{
			$p.='';
		}
		
		return $p;
	}
}

if(!function_exists('widgetAdd')){
	function widgetAdd($name,$description=''){
		$CI=& get_instance();
		$CI->load->helper('posts_helper');
		$ssName=$name."_widget";
		$nameWidget=$name."-widget";
		$slugname=stringCreateSlug($name);
		$jsonData=json_encode(array(
		'service'=>strtolower($name),
		'description'=>$description,
		));
		insertTerms($ssName,$slugname,$slugname);
		
	}
}


?>