<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_seo{
	
	private $CI;
	
	function __construct(){
		$this->CI=& get_instance();
	}
	
	function postPermalink($s1,$s2,$s3,$s4){
		
		$s=array();
		$ext=array();
		$p=$this->CI->input->get('p');
		$r="";
		//$catbase=routeGet('category')
		if(!empty($s1) && !empty($s2) && !empty($s3) && !empty($s4)){
			$s=array(
			'YEAR(post_date)'=>$s1,
			'MONTH(post_date)'=>$s2,
			'DAY(post_date)'=>$s3,
			'post_slug'=>$s4,
			);
			$r="post";
		}elseif(!empty($s1) && !empty($s2) && !empty($s3) && empty($s4)){
			$s=array(
			'YEAR(post_date)'=>$s1,
			'MONTH(post_date)'=>$s2,
			'post_slug'=>$s3,
			);
			$r="post";
		}elseif(!empty($s1) && empty($s2) && empty($s3) && empty($s4)){
			$s=array(			
			'post_slug'=>$s1,
			);
			$r="post";
		}elseif(empty($s1) && empty($s2) && empty($s3) && empty($s4) && !empty($p)){
			$s=array(			
			'post_id'=>$p,
			);
			$r="post";
		}elseif(empty($s1) && empty($s2) && empty($s3) && empty($s4) && empty($p)){
			$s=array(
			);
			$r="homepage";
		}
		
		$output['route']=$r;
		$output['data']=$s;
		return $output;
	}
	
	function uripost($postid){
		
		$permdb=optionGet('site_permalink');
		switch($permdb){
			case "default":
				return $this->defaultPermalink($postid);
				break;
			case "dayname":
				return $this->daynamePermalink($postid);
				break;
			case "monthname":
				return $this->monthnamePermalink($postid);
				break;
			case "title":
				return $this->titlePermalink($postid);
				break;
			default:
				return $this->defaultPermalink($postid);
				break;
		}
	}
		
	
	
	private function defaultPermalink($postid){
		return base_url().'?p=';
	}
	
	private function daynamePermalink($postid){
		$dtPost=dbField('posts','post_id',$postid,'post_date');
		$slug=dbField('posts','post_id',$postid,'post_slug');
		$year=date("Y",strtotime($dtPost));
		$month=date("m",strtotime($dtPost));
		$day=date("d",strtotime($dtPost));
		return base_url().$year.'/'.$month.'/'.$day.'/'.$slug;
	}
	
	private function monthnamePermalink($postid){
		$dtPost=dbField('posts','post_id',$postid,'post_date');
		$slug=dbField('posts','post_id',$postid,'post_slug');
		$year=date("Y",strtotime($dtPost));
		$month=date("m",strtotime($dtPost));
		$day=date("d",strtotime($dtPost));
		return base_url().$year.'/'.$month.'/'.$slug;
	}
	
	private function titlePermalink($postid){
		$dtPost=dbField('posts','post_id',$postid,'post_date');
		$slug=dbField('posts','post_id',$postid,'post_slug');		
		return base_url().$slug;
	}
}