<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Media_model extends MX_Controller
{
    function addAlbum($judul,$keterangan,$cover,$status='publish'){
		$d=array(
		'album_title'=>$judul,
		'album_description'=>$keterangan,
		'album_cover'=>$cover,
		'album_date'=>dateNow(TRUE),
		'album_user'=>userInfo('user_id'),
		'status'=>$status,
		);
		
		if($this->m_database->addRow('album',$d)==TRUE){
			return true;
		}else{
			return false;
		}
	}
	
	function addAlbumTaxonomy($albumID,$termKey,$termValue){
		$s=array(
		'album_id'=>$albumID,
		'term_key'=>$termKey,
		);
		
		if($this->m_database->isBOF('albumtaxonomy',$s)==TRUE){
			$d=array(
			'album_id'=>$albumID,
			'term_key'=>$termKey,
			'term_value'=>$termValue,
			);
			if($this->m_database->addRow('albumtaxonomy',$d)==TRUE){
				return true;
			}else{
				return false;
			}			
		}else{
			return false;
		}
	}
	
	function editAlbum($albumid,$judul,$keterangan,$cover,$status='publish'){
		
		$s=array(
		'album_id'=>$albumid,
		);
		if($this->m_database->isBOF('album',$s)==FALSE){					
			$d=array(
			'album_title'=>$judul,
			'album_description'=>$keterangan,
			'album_cover'=>$cover,
			'album_date'=>dateNow(TRUE),
			'album_user'=>userInfo('user_id'),
			'status'=>$status,
			);
			
			if($this->m_database->editRow('album',$d,$s)==TRUE){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	function deleteAlbum($albumid){
		
		$s=array(
		'album_id'=>$albumid,
		);
		if($this->m_database->isBOF('album',$s)==FALSE){					
			
			if($this->m_database->deleteRow('album',$s)==TRUE){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	
	function addGallery($judul,$keterangan){
		$d=array(
		'gallery_title'=>$judul,
		'gallery_description'=>$keterangan,
		'gallery_date'=>dateNow(TRUE),
		'gallery_user'=>userInfo('user_id'),
		);
		$output=array();
		$slug=stringCreateSlug($judul);
		if($this->m_database->addRow('gallery',$d)==TRUE){
			$galeriid=$this->m_database->lastInsertID();
			fileDirCreate(locationUpload('path').'gallery/'.$judul);
			$output['galleryid']=$galeriid;
			$output['status']=true;
		}else{
			$output['galleryid']='';
			$output['status']=false;
		}
		return $output;
	}
	
	function deleteGallery($galleryID){
		$s=array(
		'gallery_id'=>$galleryID,
		);
		if($this->m_database->isBOF('gallery',$s)==TRUE){
			return false;
		}else{
			$name=$this->m_database->fieldRow('gallery',$s,'gallery_title');
			$slug=stringCreateSlug($name);
			$path=locationUpload('path').'gallery/'.$slug;
			fileDirRemove($path,TRUE);
			$this->m_database->deleteRow('gallery_images',$s);
			$this->m_database->deleteRow('gallery',$s);
			
			return true;
		}
	}
	
	function addGalleryFile($galleryID,$file,$mime,$alt=''){
		$d=array(
		'gallery_id'=>$galleryID,
		'gallery_date'=>dateNow(TRUE),
		'gallery_file'=>$file,
		'gallery_mime'=>$mime,
		'gallery_alt'=>$alt,
		);
		
		if($this->m_database->addRow('gallery_images',$d)==TRUE){
			return true;
		}else{
			return false;
		}
	}
	
	function deleteGalleryFile($imgID,$galleryID){
		$s=array(
		'gallery_images_id'=>$imgID,
		'gallery_id'=>$galleryID,
		);
		
		if($this->m_database->isBOF('gallery_images',$s)==TRUE){
			return false;
		}else{
			$img=$this->m_database->fieldRow('gallery_images',$s,'gallery_file');
			$galleryName=dbField('gallery','gallery_id',$galleryID,'gallery_title');
			$slug=stringCreateSlug($galleryName);
			$this->load->library('m_file');
			$path=locationUpload('path').'gallery/'.$slug.'/';
			$this->m_file->deleteImage($path,$img);
			$this->m_database->deleteRow('gallery_images',$s);
			return true;
		}
	}
	
    
}