<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('getPosts')){
	function getPosts($param='',$order='',$group='',$limit=''){
		$CI=& get_instance();
		$d=$CI->m_database->fetchData('posts',$param,$order,$group,$limit);
		$c=$CI->m_database->countData('posts',$param);
		$output="";
		$output['data']=$d;
		$output['jumlah']=$c;
		return $output;
	}
}

if(!function_exists('getTerms')){
	function getTerms($type,$parent='0',$order="",$kecuali=''){
		$CI=& get_instance();
		$s=array(
		'term_type'=>$type,
		'parent'=>$parent,		
		);
		$c=$CI->m_database->countData('termstaxonomy',$s);
		if($c > 0){
			$d=$CI->m_database->fetchData('termstaxonomy',$s,$order);
			$output='';
			foreach($d as $r){
				$output.=$r->term_id.',';
			}
			$output=substr($output,0,-1);			
			
			$prefix=$CI->db->dbprefix;
			$sql="";
			if(!empty($order)){
				$sql="Select * FROM terms Where term_id IN($output) AND term_id NOT IN('$kecuali') AND term_parent='$parent' ORDER BY $order";
			}else{
				$sql="Select * FROM terms Where term_id IN($output) AND term_id NOT IN('$kecuali') AND term_parent='$parent'";
			}
			
			$c2=$CI->m_database->countQuery($sql);
			if($c2 > 0){				
				$d2=$CI->m_database->fetchQuery($sql);
				return $d2;
			}else{
				return null;
			}
		}else{
			return null;
		}
		
	}
}

if(!function_exists('getCategory')){
	function getCategory($parent='0',$order="",$kecuali=''){
		return getTerms("category",$parent,$order,$kecuali);
	}
}

if(!function_exists('getTag')){
	function getTag($order="",$kecuali=''){
		return getTerms("tag",'0',$order,$kecuali);
	}
}


if(!function_exists('getTermDescription')){
	function getTermDescription($type,$termID){
		$CI=& get_instance();
		$s=array(
		'term_id'=>$termID,
		'term_type'=>$type,
		);
		$item=$CI->m_database->fieldRow('termstaxonomy',$s,'description');
		return $item;
	}
}

if(!function_exists('getCategoryDescription')){
	function getCategoryDescription($termID){
		return getTermDescription('category',$termID);
	}
}

if(!function_exists('getTagDescription')){
	function getTagDescription($termID){
		return getTermDescription('tag',$termID);
	}
}


if(!function_exists('insertTerms')){
	function insertTerms($type,$name,$slugx,$description='',$parent='0',$termdata=''){
		$CI=& get_instance();
		$slug="";
		if(empty($slugx)){
			$slug=stringCreateSlug($name);
		}else{
			$slug=$slugx;
		}
		$s=array(
		'slug'=>$slug,
		);
		if($CI->m_database->isBOF('terms',$s)==TRUE){
			$d=array(
			'name'=>$name,
			'slug'=>$slug,
			'term_parent'=>$parent,
			'term_data'=>$termdata,
			);
			
			if($CI->m_database->addRow('terms',$d)==TRUE){
				$LID=$CI->m_database->lastInsertID();
				$d2=array(
				'term_id'=>$LID,
				'term_type'=>$type,
				'description'=>$description,
				'parent'=>$parent,
				);
				if($CI->m_database->addRow('termstaxonomy',$d2)==TRUE){
					return true;
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
}

if(!function_exists('insertCategory')){
	function insertCategory($name,$slug,$description='',$parent='0',$termdata=''){
		return insertTerms("category",$name,$slug,$description,$parent,$termdata);
	}
}

if(!function_exists('insertTags')){
	function insertTags($name,$slug,$description='',$parent='0',$termdata=''){
		return insertTerms("tag",$name,$slug,$description,'0',$termdata);
	}
}


if(!function_exists('updateTerms')){
	function updateTerms($termid,$type,$name,$slugx,$description='',$parent='0',$termdata=''){
		$CI=& get_instance();
		$slug="";
		if(empty($slugx)){
			$slug=stringCreateSlug($name);
		}else{
			$slug=$slugx;
		}
		$s=array(
		'term_id'=>$termid,
		);
		if($CI->m_database->isBOF('terms',$s)==FALSE){
			$d=array(
			'name'=>$name,
			'slug'=>$slug,
			'term_parent'=>$parent,
			'term_data'=>$termdata,
			);
			
			$s1=array(
			'term_id'=>$termid,
			);
			if($CI->m_database->editRow('terms',$d,$s1)==TRUE){				
				$d2=array(				
				'term_type'=>$type,
				'description'=>$description,
				'parent'=>$parent,
				);
				if($CI->m_database->editRow('termstaxonomy',$d2,$s1)==TRUE){
					return true;
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
}

if(!function_exists('updateCategory')){
	function updateCategory($termid,$name,$slug,$description='',$parent='0',$termdata=''){
		return updateTerms($termid,"category",$name,$slug,$description,$parent,$termdata);
	}
}

if(!function_exists('updateTags')){
	function updateTags($termid,$name,$slug,$description='',$parent='0',$termdata){
		return updateTerms($termid,"tag",$name,$slug,$description,$parent,$termdata);
	}
}

if(!function_exists('deleteTerm')){
	function deleteTerm($termid){
		$CI=& get_instance();
		$s=array(
		'term_id'=>$termid,
		);
		
		$CI->m_database->deleteRow('terms',$s);
		$CI->m_database->deleteRow('termstaxonomy',$s);
		
		$s2=array(
		'term_parent'=>$termid,
		);
		
		$s3=array(
		'parent'=>$termid,
		);
		
		$CI->m_database->deleteRow('terms',$s2);
		$CI->m_database->deleteRow('termstaxonomy',$s3);
		
		return true;
	}
}

if(!function_exists('commentInsert')){
	function commentInsert($postID,$name,$email,$data){
		$CI=& get_instance();
		
		$ipaddress=$CI->input->ip_address();
		
		$jsonData=json_encode(array(
		'ipaddress'=>$ipaddress,		
		));
		$moderator=optionGet('site_comment_moderator');
		$state="";
		$stateMSG="";
		if($moderator=="1"){
			$state="pending";
			$stateMSG="Komentar anda berhasil disimpan, akan tetapi harus disetujui oleh Administrator";
		}else{
			$state="publish";
			$stateMSG="Komentar anda berhasil disimpan dan segera diterbitkan";
		}
		
		$d=array(
		'post_id'=>$postID,
		'comment_date'=>dateNow(TRUE),
		'nama'=>$name,
		'email'=>$email,
		'comment'=>$data,
		'comment_status'=>$state,
		'comment_data'=>$jsonData,
		);
		
		$proses=$CI->m_database->addRow('postcomment',$d);
		$arr=array();
		if($proses==TRUE){
			$arr=array(
			'state'=>true,
			'callback'=>$stateMSG,
			);			
		}else{
			$arr=array(
			'state'=>false,
			'callback'=>"Komentar anda gagal diterbitkan",
			);
		}
		
		return $arr;
	}
}


if(!function_exists('getThemeActive')){
	function getThemeActive(){
		$item=optionGet('theme_front');
		return $item;
	}
}

?>