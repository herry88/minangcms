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
	
	
	function generateMeta($route,$data){
		$google=optionGet('google');
		$bing=optionGet('bing');
		$alexa=optionGet('alexa');
		$ogfacebook=optionGet('ogfacebook');
		
		$xGoogle="";
		$xBing="";
		$xAlexa="";
		$xOgFacebook="";
		if($google!=""){
			$xGoogle='<meta name="google-site-verification" content="'.$google.'"/>';
		}else{
			$xGoogle="";
		}
		
		if($bing!=""){
			$xBing='<meta name="msvalidate.01" content="'.$bing.'" />';
		}else{
			$xBing='';
		}
		
		if($alexa!=""){
			$xAlexa='<meta name="alexaVerifyID" content="'.$alexa.'"/>';
		}else{
			$xAlexa='';
		}
		
		
		$output="";
		$SEO=optionGet('site_searchengine');
		if($SEO==1){
			$output.=$xGoogle;
			$output.=$xBing;
			$output.=$xAlexa;			
		}else{
			$output.="<meta name='robots' content='noindex,follow' />";
		}
		if($ogfacebook=='1'){
			$output.=$this->generateOGFB($route,$data);
		}
		$output.='<meta name="geo.country" content="id"/><meta name="geo.placename" content="Indonesia"/>';		
		$output.=$this->generateKeyword($route,$data);
		$output.='<meta name="generator" content="minangCMS"/>';
		return $output;		
	}
	
	function generateOGFB($route,$data){
		$title='';
		$img='';
		$type='';
		$permalink='';		
		if($route=="post"){
			$postid=$this->CI->m_database->fieldRow('posts',$data,'post_id');
			$img=mc_imagepost($postid);
			$title=postInfo($postid,'post_title');
			$type="website";
			$permalink=permalinkPost($postid);
		}else{
			$img=mc_logo();
			$title=optionGet('site_title');
			$type="website";
			$permalink=base_url();
		}
		
		$output="";
		$output.='<meta property="og:title" content="'.$title.'" /><meta property="og:type" content="'.$type.'" /><meta property="og:url" content="'.$permalink.'" /><meta property="og:image" content="'.$img.'" />';
		
		return $output;
	}
	
	function generateKeyword($route,$data){
		$output='';
		
		$desc='';
		$key='';
		
		$titleDefault=strtolower(optionGet('site_title'));
		
		if($route=="post"){
			$postid=$this->CI->m_database->fieldRow('posts',$data,'post_id');			
			$desc=postInfo($postid,'post_title');
			$customKey=postTaxonomy($postid,'keyword_custom');
			if(!empty($customKey)){
				$key=$customKey.",".$titleDefault;
			}else{
				$key=strtoupper($title).",".$titleDefault;
			}
		}else{
			$desc=optionGet('site_description');
			$key=$titleDefault;
			
		}
		
		$output.='<meta name="description" content="'.$desc.'"/><meta name="keywords" content="'.$key.'"/>';
		
		return $output;
	}
	
	
	function generateFeed($type="atom",$view){
		//$this->CI->load->library('ext/feed');
		require_once dirname(__FILE__).'/ext/Feedweb.php';
		$this->CI->load->helper('text');
		$feed=new Feedweb();
		$this->CI->load->library('m_database');
		$maxDate=$this->CI->m_database->maxRow('posts','','post_date');
		
		$feed->title=optionGet('site_title');
		$feed->description=optionGet('site_description');
		$feed->link=base_url();
		$feed->lang="id";
		$feed->pubdate=$maxDate;
		$param=array(
		'post_status'=>'publish',
		);
		
		$dPost=mc_allpost($param,'post_date DESC','',20);
		
		if($dPost['jumlah'] > 0){
			foreach($dPost['data'] as $rPost){
				$title=$rPost->post_title;
				$author="";
				$url=permalinkPost($rPost->post_id);
				$date=$rPost->post_date;
				$desc=word_limiter($rPost->post_content,50);
				if(!empty($rPost->post_user)){
					$author=dbField('userlogin','user_id',$rPost->post_user,'nama');
				}else{
					$author="Administrator";
				}
				$feed->add($title,$author,$url,$date,$desc);
							
			}
		}else{
			$feed->add(optionGet('site_title'),optionGet('site_title'),base_url(),dateNow(TRUE),optionGet('site_description'));
		}
		
		$feed->render($type,$view);
	}
	
	
}