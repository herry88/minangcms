<?php
defined('BASEPATH') OR exit('No direct script access allowed');


if(!function_exists('postAuthor')){
	function postAuthor($postid){
		$userid=dbField('posts','post_id',$postid,'post_user');
		$nama=dbField('userlogin','user_id',$userid,'nama');
		
		return $nama;
	}
}

if(!function_exists('postInfo')){
	function postInfo($postid,$output){
		$item=dbField('posts','post_id',$postid,$output);
		return $item;
	}
}

if(!function_exists('postCategory')){
	function postCategory($postid){
		$CI=& get_instance();
		
		$uriCat=optionGet('permalink_category');
		
		$s=array(
		'post_id'=>$postid,
		'term_type'=>'category',
		);
		$p='';		
		$c=$CI->m_database->countData('poststaxonomy',$s);
		if($c > 0){
			$d=$CI->m_database->fetchData('poststaxonomy',$s);
			foreach($d as $r){
				$name=dbField('terms','term_id',$r->term_value,'name');
				$slug=stringCreateSlug($name);
				$uri=base_url().$uriCat.'/'.$slug;				
				$p.='<a href="'.$uri.'" class="btn btn-xs btn-flat btn-success" target="_blank">'.$slug.'</a> ';
			}
		}		
		
		return $p;
	}
}

if(!function_exists('categoryInfo')){
	function categoryInfo($catID,$output){
		$CI=& get_instance();
				
		$s=array(
		'term_id'=>$catID,
		'term_type'=>'category',
		);
		$p='';		
		$c=$CI->m_database->countData('termstaxonomy',$s);
		if($c > 0){
			$s2=array(
			'term_id'=>$catID,
			);			
			$p=$CI->m_database->fieldRow('terms',$s2,$output);
		}else{
			$p='';
		}
		
		return $p;
	}
}

if(!function_exists('postTags')){
	function postTags($postid){
		$CI=& get_instance();
		
		$uriCat=optionGet('permalink_tags');
		
		$s=array(
		'post_id'=>$postid,
		'term_type'=>'tag',
		);
		$p='';		
		$c=$CI->m_database->countData('poststaxonomy',$s);
		if($c > 0){
			$d=$CI->m_database->fetchData('poststaxonomy',$s);
			foreach($d as $r){
				$slug=stringCreateSlug($r->term_value);
				$uri=base_url().$uriCat.'/'.$slug;				
				$p.='<a href="'.$uri.'" class="btn btn-xs btn-flat btn-success" target="_blank">'.$r->term_value.'</a> ';
			}
		}				
		return $p;
	}
}

if(!function_exists('postTaxonomy')){
	function postTaxonomy($postid,$termType){
		$CI=& get_instance();
		$s=array(
		'post_id'=>$postid,
		'term_type'=>$termType,
		);
		if($CI->m_database->countData('poststaxonomy',$s) > 1){
			$d=$CI->m_database->fetchData('poststaxonomy',$s);
			return $d;
		}else{
			$item=$CI->m_database->fieldRow('poststaxonomy',$s,'term_value');
			return $item;
		}
		
	}
}

if(!function_exists('postTaxonomyArr')){
	function postTaxonomyArr($postid,$termType){
		$CI=& get_instance();
		$s=array(
		'post_id'=>$postid,
		'term_type'=>$termType,
		);
		if($CI->m_database->countData('poststaxonomy',$s) > 0){
			$d=$CI->m_database->fetchData('poststaxonomy',$s);
			return $d;
		}else{
			return null;
		}
	}
}


if(!function_exists('postTaxonomyExists')){
	function postTaxonomyExists($postid,$termType,$value){
		$CI=& get_instance();
		$s=array(
		'post_id'=>$postid,
		'term_type'=>$termType,
		'term_value'=>$value
		);
		if($CI->m_database->isBOF('poststaxonomy',$s)==FALSE){
			return true;
		}else{
			return false;
		}
		
	}
}

if(!function_exists('permalinkPost')){
	function permalinkPost($postid){
		$CI=& get_instance();
		$CI->load->library('m_seo');
		$item=$CI->m_seo->uripost($postid);
		return $item;
	}
}

if(!function_exists('permalinkCategory')){
	function permalinkCategory($catID){
		$uriCat=optionGet('permalink_category');		
		$slugCat=categoryInfo($catID,"slug");
		if(!empty($slugCat)){
			return base_url().$uriCat."/".$slugCat;
		}else{
			return base_url();
		}
	}
}

if(!function_exists('commentPost')){
	function commentPost($postid){		
		$url=permalinkPost($postid);
		$title=dbField('posts','post_id',$postid,'post_title');
		$p='<a href="'.$url.'">'.$title.'</a>';
		return $p;
	}
}

if(!function_exists('commentPostAction')){
	function commentPostAction($commentID){
		$p='';
		$rolename=roleURIUser();
		$status=dbField('postcomment','post_comment_id',$commentID,'comment_status');
		if($status=="publish"){			
			$p.='<a class="btn btn-xs btn-warning" href="'.base_url($rolename.'comments/spamthis').'?id='.$commentID.'&token='.tokenGenerate().'">Spam</a> ';
		}elseif($status=="spam"){
			$p.='<a class="btn btn-xs btn-info" href="'.base_url($rolename.'comments/approve').'?id='.$commentID.'&token='.tokenGenerate().'">Publish</a> ';			
		}elseif($status=="pending"){
			$p.='<a class="btn btn-xs btn-info" href="'.base_url($rolename.'comments/approve').'?id='.$commentID.'&token='.tokenGenerate().'">Publish</a> ';
		}
		$p.='<a onclick="return confirm(\'Yakin ingin menghapus komentar ini?\');" class="btn btn-xs btn-danger" href="'.base_url($rolename.'comments/delete').'?id='.$commentID.'&token='.tokenGenerate().'">Delete</a>&nbsp;';        
       
       return $p;
	}
}


?>