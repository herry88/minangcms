<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Post_model extends MX_Controller
{
    function addPost($title,$date,$content,$status='publish',$category=array(),$tags=array(),$keywordAdd='',$komentar,$tampilan,$feature){
    	$xStatus="";
    	if(roleUser()=="op"){
			$xStatus="draft";
		}else{
			$xStatus="publish";
		}
		$d=array(
		'post_title'=>$title,
		'post_date'=>$date,
		'post_type'=>'post',
		'post_content'=>$content,
		'post_user'=>userInfo('user_id'),
		'post_slug'=>stringCreateSlug($title),
		'post_status'=>$xStatus,
		);
		
		$output=array();
		if($this->m_database->addRow('posts',$d)==TRUE){
			$postid=$this->m_database->lastInsertID();
			
			$this->insertCategoryPost($postid,$category);
			$this->insertTagPost($postid,$tags);
			$this->insertTaxonomyPost($postid,"keyword_custom",$keywordAdd);
			$this->insertTaxonomyPost($postid,"comment_system",$komentar);
			$this->insertTaxonomyPost($postid,"view_style",$tampilan);
			$this->insertTaxonomyPost($postid,"feature_image",$feature);
			
			$output['status']=true;
			$output['lastid']=$postid;			
		}else{
			$output['status']=false;
			$output['lastid']="";
		}
		
		return $output;
	}
	
	function addPage($title,$date,$content,$status='publish',$tags=array(),$keywordAdd='',$komentar,$tampilan){
		$d=array(
		'post_title'=>$title,
		'post_date'=>$date,
		'post_type'=>'page',
		'post_content'=>$content,
		'post_user'=>userInfo('user_id'),
		'post_slug'=>stringCreateSlug($title),
		'post_status'=>$status,
		);
		
		if($this->m_database->addRow('posts',$d)==TRUE){
			$postid=$this->m_database->lastInsertID();
						
			$this->insertTagPost($postid,$tags);
			$this->insertTaxonomyPost($postid,"keyword_custom",$keywordAdd);
			$this->insertTaxonomyPost($postid,"comment_system",$komentar);
			$this->insertTaxonomyPost($postid,"view_style",$tampilan);
			
			$output['status']=true;
			$output['lastid']=$postid;
		}else{
			$output['status']=false;
			$output['lastid']="";
		}
		
		return $output;
	}
	
	function addEvent($title,$date,$content,$status='publish',$tags=array(),$keywordAdd='',$komentar,$tampilan='',$tgl,$jam){
		$d=array(
		'post_title'=>$title,
		'post_date'=>$date,
		'post_type'=>'event',
		'post_content'=>$content,
		'post_user'=>userInfo('user_id'),
		'post_slug'=>stringCreateSlug($title),
		'post_status'=>$status,
		);
		
		if($this->m_database->addRow('posts',$d)==TRUE){
			$postid=$this->m_database->lastInsertID();
						
			$this->insertTagPost($postid,$tags);
			$this->insertTaxonomyPost($postid,"keyword_custom",$keywordAdd);
			$this->insertTaxonomyPost($postid,"comment_system",$komentar);
			$this->insertTaxonomyPost($postid,"view_style",$tampilan);
			$this->insertTaxonomyPost($postid,"tanggal_event",$tgl);
			$this->insertTaxonomyPost($postid,"jam_event",$jam);
			
			$output['status']=true;
			$output['lastid']=$postid;
		}else{
			$output['status']=false;
			$output['lastid']="";
		}
		
		return $output;
	}
	
	function editPost($postid,$title,$date,$content,$status='publish',$category=array(),$tags=array(),$keywordAdd='',$komentar,$tampilan,$feature){
		$s=array(
		'post_id'=>$postid,
		);
		$d=array(
		'post_title'=>$title,
		'post_date'=>$date,
		'post_type'=>'post',
		'post_content'=>$content,
		'post_user'=>userInfo('user_id'),
		'post_slug'=>stringCreateSlug($title),
		'post_status'=>$status,
		);
		
		$output=array();
		if($this->m_database->editRow('posts',$d,$s)==TRUE){
			
			$this->deleteCategoryPost($postid);
			$this->insertCategoryPost($postid,$category);
			$this->insertTagPost($postid,$tags);
			$this->insertTaxonomyPost($postid,"keyword_custom",$keywordAdd);
			$this->insertTaxonomyPost($postid,"comment_system",$komentar);
			$this->insertTaxonomyPost($postid,"view_style",$tampilan);
			$this->insertTaxonomyPost($postid,"feature_image",$feature);
			
			$output['status']=true;
			$output['lastid']=$postid;			
		}else{
			$output['status']=false;
			$output['lastid']="";
		}
		
		return $output;
	}
	
	function editPage($postid,$title,$date,$content,$status='publish',$tags=array(),$keywordAdd='',$komentar,$tampilan){
		
		$s=array(
		'post_id'=>$postid,
		);
		$d=array(
		'post_title'=>$title,
		'post_date'=>$date,
		'post_type'=>'page',
		'post_content'=>$content,
		'post_user'=>userInfo('user_id'),
		'post_slug'=>stringCreateSlug($title),
		'post_status'=>$status,
		);
		
		if($this->m_database->editRow('posts',$d,$s)==TRUE){
			
						
			$this->insertTagPost($postid,$tags);
			$this->insertTaxonomyPost($postid,"keyword_custom",$keywordAdd);
			$this->insertTaxonomyPost($postid,"comment_system",$komentar);
			$this->insertTaxonomyPost($postid,"view_style",$tampilan);
			
			$output['status']=true;
			$output['lastid']=$postid;
		}else{
			$output['status']=false;
			$output['lastid']="";
		}
		
		return $output;
	}
	
	
	function editEvent($postid,$title,$date,$content,$status='publish',$tags=array(),$keywordAdd='',$komentar,$tampilan='',$tgl,$jam){
		
		$s=array(
		'post_id'=>$postid,
		);
		$d=array(
		'post_title'=>$title,
		'post_date'=>$date,
		'post_type'=>'event',
		'post_content'=>$content,
		'post_user'=>userInfo('user_id'),
		'post_slug'=>stringCreateSlug($title),
		'post_status'=>$status,
		);
		
		if($this->m_database->editRow('posts',$d,$s)==TRUE){
			
						
			$this->insertTagPost($postid,$tags);
			$this->insertTaxonomyPost($postid,"keyword_custom",$keywordAdd);
			$this->insertTaxonomyPost($postid,"comment_system",$komentar);
			$this->insertTaxonomyPost($postid,"view_style",$tampilan);
			$this->insertTaxonomyPost($postid,"tanggal_event",$tgl);
			$this->insertTaxonomyPost($postid,"jam_event",$jam);
			
			$output['status']=true;
			$output['lastid']=$postid;
		}else{
			$output['status']=false;
			$output['lastid']="";
		}
		
		return $output;
	}
	
	function insertTaxonomyPost($postid,$type,$value){
		
		$s=array(
			'post_id'=>$postid,
			'term_type'=>$type,
			);
		$d=array(
			'post_id'=>$postid,
			'term_type'=>$type,
			'term_value'=>$value,
			);
		if($this->m_database->isBOF('poststaxonomy',$s)==TRUE){
			$this->m_database->addRow('poststaxonomy',$d);
		}else{
			$this->m_database->deleteRow('poststaxonomy',$s);
			$this->m_database->addRow('poststaxonomy',$d);
		}
	}
	
	function insertCategoryPost($postid,$category){
		
		if(!empty($category)){
			foreach($category as $k=>$v){
				$slug=dbField('terms','term_id',$v,'slug');
				$d=array(
					'post_id'=>$postid,
					'term_type'=>'category',
					'term_value'=>$v,
					);
				if($this->m_database->isBOF('poststaxonomy',$d)==TRUE){
					$this->m_database->addRow('poststaxonomy',$d);
					insertCategory($v,$slug,"","0");
				}				
			}
		}else{			
			$d=array(
				'post_id'=>$postid,
				'term_type'=>'category',
				'term_value'=>'1',
				);
			if($this->m_database->isBOF('poststaxonomy',$d)==TRUE){
				$this->m_database->addRow('poststaxonomy',$d);
			}
			
		}
	}
	
	function deleteCategoryPost($postid){
		$s=array(
		'post_id'=>$postid,
		'term_type'=>'category',
		);
		
		$this->m_database->deleteRow('poststaxonomy',$s);
	}
	
	function insertTagPost($postid,$tags){
		$p='';
		if(!empty($tags)){
			foreach($tags as $row)
			{
				$p.= $row['text'].",";
				$slug=stringCreateSlug($row['text']);
				$s=array(					
				'term_type'=>'tag',
				'term_value'=>$row['text'],
				);
				if($this->m_database->isBOF('poststaxonomy',$s)==TRUE)
				{
					$d=array(
						'post_id'=>$postid,
						'term_type'=>'tag',
						'term_value'=>$row['text'],
						);
					$this->m_database->addRow('poststaxonomy',$d);
					insertTags($row['text'],$slug,"","0");
				}
			}
		}
	}
	
	function deletePost($postid){
		$s=array(
		'post_id'=>$postid,
		);
		$this->m_database->deleteRow('posts',$s);
		$this->m_database->deleteRow('poststaxonomy',$s);
		return true;
	}
	
	function changeStatusComment($commentID,$status){
		$s=array(
		'post_comment_id'=>$commentID,
		);
		if($this->m_database->isBOF('postcomment',$s)==TRUE){
			return false;
		}else{
			$d=array(
			'comment_status'=>$status,
			);
			if($this->m_database->editRow('postcomment',$d,$s)==TRUE){
				return true;
			}else{
				return false;
			}
		}
	}
	
	function deleteComment($commentID){
		$s=array(
		'post_comment_id'=>$commentID,
		);
		if($this->m_database->isBOF('postcomment',$s)==TRUE){
			return false;
		}else{			
			if($this->m_database->deleteRow('postcomment',$s)==TRUE){
				return true;
			}else{
				return false;
			}
		}
	}
    
}