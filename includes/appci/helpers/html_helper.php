<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('authForm')){
	function authForm($field,$secure=TRUE){
		$CI=& get_instance();
		$CI->load->helper(array('session_helper'));
		$token=tokenGenerate();
		if($secure==TRUE){
			return "m".$field."_".$token;
		}else{
			return "m".$field;
		}
		
	}
}

if(!function_exists('menuActive')){
	function menuActive($seg2,$seg3=''){
		$CI=& get_instance();
		$g2=$CI->uri->segment(2);
		$g3=$CI->uri->segment(3);		
		if($seg2==$g2 && empty($seg3)){
			return "active";
		}else{
			if(!empty($seg3)){
				if($seg3==$g3){
					return "active";
				}else{
					return "";
				}
			}else{
				return "";
			}
			
		}
	}
}

if(!function_exists('inputCheckbox')){
	function inputCheckbox($name,$id='',$val,$label){
		$state="";
		if($val=="1"){
			$state='checked="checked"';
		}else{
			$state="";
		}
		
		$p='';
		$p.='<div class="checkbox">';
		$p.='<label>';
		$p.='<input type="checkbox" name="'.$name.'" id="'.$id.'" '.$state.'/> '.$label;
		$p.='</label>';
		$p.='</div>';
		
		return $p;
	}
}

if(!function_exists('valCheckbox')){
	function valCheckbox($str){
		if($str=="on"){
			return "1";
		}else{
			return "0";
		}
	}
}


if(!function_exists('checkState')){
	function checkState($strdb,$str){
		if($strdb==$str){
			return 'checked=""';
		}else{
			return "";
		}
	}
}


if(!function_exists('menuData')){
	function menuData($pos,$parentID='0'){
		$CI=& get_instance();
		$menu=getTerms('menu_'.$pos,$parentID,'order_term ASC');		
		if(!empty($menu)){
			return $menu;
		}else{
			return null;
		}
	}
}

if(!function_exists('menuOutput')){
	function menuOutput($pos){
		$CI=& get_instance();
		$CI->load->model('manage/menu_model','mm');
		return $CI->mm->menuGenerate($pos);
	}
}

if(!function_exists('menuInfoJSON')){
	function menuInfoJSON($menuID,$key){
		$json=dbField('terms','term_id',$menuID,'term_data');
		$dec=jsonDataDecode($json,$key);
		return $dec;
	}
}

if(!function_exists('searchImageString')){
	function searchImageString($content){
		$first_img = '';
	  ob_start();
	  ob_end_clean();
	  $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches);	 
	 	if(isset($matches[1][0]))
	 	{
			$first_img = $matches [1][0];
		}

	  if(empty($first_img) || $first_img==null){ 
	    $first_img = noImageBig();
	  }
	  return $first_img;
	}
}

?>