<?php
defined('BASEPATH') OR exit('No direct script access allowed');


if(!function_exists('mc_loader')){
	function mc_loader($route,$data){
		$front=optionGet('theme_front');
		$path=locationTheme('path');
		$fullpath=$path."frontend/".$front.'/'.$route.".php";
		if(file_exists($fullpath)){
			include $fullpath;
		}else{
			mc_404();
		}
	}
}

if(!function_exists('mc_404')){
	function mc_404(){
		$front=optionGet('theme_front');
		$path=locationTheme('path');
		$fullpath=$path."frontend/".$front.'/'."404.php";
		if(file_exists($fullpath)){
			include $fullpath;
		}else{
			redirect(base_url());			
		}		
	}
}

if(!function_exists('mc_logo')){
	function mc_logo(){
		$img=optionGet('site_logo');
		//return base_url().imagePath($img);
		$path=FCPATH.imagePath($img);
		if(file_exists($path)){
			return base_url().imagePath($img);
		}else{
			return locationUpload().'minangcms.png';
		}
	}
}

if(!function_exists('mc_favicon')){
	function mc_favicon(){
		$img=optionGet('site_favicon');
		$path=FCPATH.imagePath($img);
		if(file_exists($path)){
			return base_url().imagePath($img);
		}else{
			return locationUpload().'minangcms-favicon.png';
		}
	}
}

if(!function_exists('mc_allpost')){
	function mc_allpost($param=array(),$order='post_date DESC',$group='',$limit=''){
		$CI=& get_instance();
		$CI->load->helper('posts_helper');
		$data=getPosts($param,$order,$group,$limit);
		return $data;
	}
}

if(!function_exists('mc_postCategory')){
	function mc_postCategory($catID,$order='post_date DESC',$limit='5'){
		$CI=& get_instance();
		$CI->load->helper('posts_helper');
		$prefix=$CI->db->dbprefix;
		$sql="SELECT ".$prefix."posts.*
FROM ".$prefix."posts LEFT JOIN ".$prefix."poststaxonomy ON ".$prefix."posts.post_id = ".$prefix."poststaxonomy.post_id Where ".$prefix."poststaxonomy.term_value='$catID' and ".$prefix."term_type='category' order by $order LIMIT $limit";
		$c=$CI->m_database->countQuery($sql);
		if($c > 0){
			$d=$CI->m_database->fetchQuery($sql);
			return $d;
		}else{
			return "null";
		}
		
	}
}

if(!function_exists('mc_imagepost')){
	function mc_imagepost($postid){
	  	$CI=& get_instance();
	  	$CI->load->helper('posts_helper');
	  	$feature=postTaxonomy($postid,"feature_image");
	  	$sanite=imagePath($feature);
	  	$path="./".$sanite;
	  	if(file_exists($path)){
			return base_url().$sanite;
		}else{
			$konten=postInfo($postid,'post_content');
			$img=searchImageString($konten);
			return $img;
		}
	}
}


if(!function_exists('mc_register_sidebar')){
	function mc_register_sidebar($theme,$position,$data=''){
		insertTerms("sidebar",$theme."_sidebar_".$position,$theme."-sidebar-".$position,"","",$data);
	}
}

if(!function_exists('mc_get_sidebar_item')){
	function mc_get_sidebar_item($theme,$position,$dividerClass=''){
		$CI=& get_instance();
		$CI->load->library('m_net');
		$slug=$theme."_sidebar_".$position."_item";
		$s=array(
		'name'=>$slug,
		);
		$d=$CI->m_database->fetchData('terms',$s);
		$c=$CI->m_database->countData('terms',$s);
		if($c > 0){
			foreach($d as $r){
				$wi=$r->term_id;
				$termid=$r->term_parent;	
				$prefix=menuInfoJSON($wi,'prefix');
				$jsondata=dbField('terms','term_id',$wi,'term_data');
				$sb=$CI->m_database->fetchData('terms',array('term_id'=>$wi));				
				$param=array(
				'data'=>$jsondata,
				'widgetdata'=>$sb,
				'parentid'=>$termid,
				'pos'=>$position,
				'theme'=>$theme,
				);				
				
				$j=$CI->m_net->curlNet("get",base_url().'service/widget/'.$prefix.'/generate',$param);
				$div1="";
				$div2="";
				if(!empty($dividerClass)){
					$div1='<div class="'.$dividerClass.'">';
					$div2='</div>';
				}else{
					$div1='';
					$div2='';
				}
				echo $div1;
				echo $j;
				echo $div2;
				//echo base_url().'service/widget/'.$prefix.'/generate';
				//var_dump($param);
			}
		}
	}
}

if(!function_exists('mc_menu')){
	function mc_menu($position='top',$parentID='0'){
		$CI=& get_instance();
		$menu=getTerms('menu_'.$position,$parentID,'order_term ASC');		
		if(!empty($menu)){
			return $menu;
		}else{
			return null;
		}
	}
}

if(!function_exists('mc_menu_link')){
	function mc_menu_link($termid){
		$CI=& get_instance();
		$CI->load->helper('posts_helper');
		$relasi=menuInfoJSON($termid,"relasi");
		
		switch($relasi){
			case "page":
				$pageid=menuInfoJSON($termid,"pageid");
				if(!empty($pageid)){
					return permalinkPost($pageid);
				}else{
					return base_url();
				}
				break;
			case "link":
				return menuInfoJSON($termid,"value");
			case "category":
				$uriCat=optionGet('permalink_category');
				$catid=menuInfoJSON($termid,"categoryid");
				$slugCat=categoryInfo($catid,"slug");
				if(!empty($slugCat)){
					return base_url().$uriCat."/".$slugCat;
				}else{
					return base_url();
				}
				break;
			case "gallery":
				$gID=menuInfoJSON($termid,"galleryid");
				return base_url()."media/".$gID;
			default:
				return base_url();
				break;
		}
		
		
	}
}

if(!function_exists('mc_commentPost')){
	function mc_commentPost($postid){
		$CI=& get_instance();
		$opt=optionGet('site_comment');
		if($opt=="1"){
			$CI->load->library('m_net');
			$param=array(
			'id'=>$postid,
			);
			$j=$CI->m_net->curlNet("get",base_url().'service/post/comment/generate',$param);
			echo $j;
		}else{
			echo "Comment System Disabled";
		}
	}
}

if(!function_exists('mc_themeConfigGet')){
	function mc_themeConfigGet($theme,$key){
		$CI=& get_instance();
		$s=array(
		'name'=>$theme."-template",
		);
		$termid=$CI->m_database->FieldRow('terms',$s,'term_id');
		$item=menuInfoJSON($termid,$key);
		if(!empty($item)){
			return $item;
		}else{
			return "";
		}
	}
}

if(!function_exists('mc_requestUpdateTheme')){
	function mc_requestUpdateTheme(){
		return base_url(roleURIUser().'style/templates/updateconfig');
	}
}

if(!function_exists('mc_themeConfigSet')){
	function mc_themeConfigSet($theme,$data){
		$CI=& get_instance();
		$CI->load->helper('posts_helper');
		insertTerms('template',$theme."-template",$theme."-template","","",$data);
	}
}

if(!function_exists('mc_gallery')){
	function mc_gallery($id,$thumbsize=200){
		$CI=& get_instance();
		$s=array(
		'album_id'=>$id,
		'term_key'=>"gallery_list",
		);
		$item=$CI->m_database->fieldRow('albumtaxonomy',$s,'term_value');
		$s2=array(
		'gallery_id'=>$item,
		);
				
		$dG=$CI->m_database->fetchData('gallery_images',$s2);		
		
		$j=array();
		$galName=dbField('gallery','gallery_id',$item,'gallery_title');
		foreach($dG as $rG){
			$j[]=array(
			'image_id'=>$rG->gallery_images_id,
			'image_file'=>locationUpload('url').'gallery/'.$galName.'/'.$rG->gallery_file,
			'image_file_thumb'=>locationUpload('url').'gallery/'.$galName.'/thumbs/'.$thumbsize.'/'.$rG->gallery_file,
			);
		}
		
		return $j;
	}
}

if(!function_exists('mc_galleryimage')){
	function mc_galleryimage($id){
		$CI=& get_instance();
		$s2=array(
		'gallery_id'=>$item,
		);
		
		return $CI->m_database->fieldRow('gallery_images',$s2,'gallery_file');
	}
}

function imagePath($img){
	if(!empty($img)){
		if(ENVIRONMENT=="development"){
		$foldeSite= $img;
		$Ex=explode("/",$foldeSite);
		$siteFolder=$Ex[1];
		$count=strlen($siteFolder);
		$remCount=$count+2;
		$asset=substr($foldeSite,$remCount);			
		return $asset;
		}else{
			return $img;
		}
	}else{
		return noImageBig();
	}	
}


?>