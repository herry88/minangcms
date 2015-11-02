<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Menu_model extends MX_Controller
{	
	
	function formatTree($tree, $parent='0'){
        $tree2 = array();
        foreach($tree as $i => $item){
            if($item['parent'] == $parent){
                $tree2[$item['term_id']] = $item;
                $tree2[$item['term_id']]['submenu'] = $this->formatTree($tree, $item['term_id']);
            }
        }

        return $tree2;
    }
    
    function prepareMenu($theme,$pos){
    	$prefix=$this->db->dbprefix;
    	$sec="menu_".$pos."_".$theme;
		$sql="Select term_id,parent FROM ".$prefix."termstaxonomy Where term_type='$sec'";
		$query=$this->db->query($sql);
		if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return null;
		}
	}		
	
	function menuGenerate($theme,$pos){
		$p='';
		$h1=mc_menu($theme,$pos,'0');
		
		if(!empty($h1)){
		foreach($h1 as $r1){
			$hp1=$r1->term_id;	
			$h2=mc_menu($theme,$pos,$hp1);
			if(!empty($h2)){				
				$p.='<li id="menuItem_'.$r1->term_id.'">';
				$p.='<div>';
				$p.=$this->collapseBox($r1->name,$r1->term_id);
				$p.='</div>';
				$p.='<ol>';
				foreach($h2 as $r2){
					$hp2=$r2->term_id;
					$h3=mc_menu($theme,$pos,$hp2);
					if(!empty($h3)){
						$p.='<li id="menuItem_'.$r2->term_id.'">';
						$p.='<div id="parent_id_'.$hp1.'">';
						$p.=$this->collapseBox($r2->name,$r2->term_id,$hp1);
						$p.='</div>';
						$p.='<ol>';
						foreach($h3 as $r3){					
							$p.='<li id="menuItem_'.$r3->term_id.'" parent_id="">';
							$p.='<div id="parent_id_'.$hp2.'">';
							$p.=$this->collapseBox($r3->name,$r3->term_id,$hp2);
							$p.='</div></li>';
						}
						$p.='</ol>';
						$p.='</li>';
					}else{
						$p.='<li id="menuItem_'.$r2->term_id.'">';
						$p.='<div>';
						$p.=$this->collapseBox($r2->name,$r2->term_id,$hp1);
						$p.='</div></li>';
					}
				}
				$p.='</ol>';
				$p.='</li>';
			}else{
				$p.='<ol></ol>';
				$p.='<li id="menuItem_'.$r1->term_id.'">';
				$p.='<div>';
				$p.=$this->collapseBox($r1->name,$r1->term_id,'0');
				$p.='</div></li>';
			}
			
		}	
		}
		
		return $p;
	}
	
	
	function collapseBox($title,$menuID,$parent=''){
		$p='';
		$p.='<div class="panel panel-default">';
    	$p.='<div class="panel-heading">';
      	$p.='<h4 class="panel-title">';
        $p.='<a data-toggle="collapse" data-parent="#accordion" href="#clp_'.$menuID.'">';
        $p.=$title." <small class='pull-right'>ID:".$menuID.",Parent:".$parent."</small>";
        $relasi=menuInfoJSON($menuID,"relasi");
        $p.=' <small><i>'.$relasi.'</i></small>';
        $p.='</a>';
      	$p.='</h4>';
    	$p.='</div>';
    	
    	$p.='<div id="clp_'.$menuID.'" class="panel-collapse collapse">';
    	$p.='<div class="panel-body">';    	
    	if($relasi=="page"){
    		$pageID=menuInfoJSON($menuID,'pageid');
			$p.=$this->pageContent($pageID,$menuID,$title);
		}elseif($relasi=="category"){
			$catID=menuInfoJSON($menuID,"categoryid");
			$p.=$this->categoryContent($catID,$menuID,$title);
		}elseif($relasi=="link"){
			$urlX=menuInfoJSON($menuID,'value');
			$p.=$this->urlContent($urlX,$menuID,$title);
		}elseif($relasi=="gallery"){
			$GID=menuInfoJSON($menuID,"galleryid");
			$p.=$this->GalleryContent($GID,$menuID,$title);
		}
    	$p.='</div>';    	
    	$p.='<div class="panel-footer">';
    	$p.='<a href="javascript:;" class="menudelete btn btn-danger btn-flat btn-xs pull-left" data-id="'.$menuID.'">Delete</a>&nbsp;';
    	$p.='<a href="javascript:;" class="menusave btn btn-primary btn-flat btn-xs" data-parent="'.$parent.'" data-menu="'.$relasi.'" data-id="'.$menuID.'">Ubah</a>';
    	$p.='</div>';
    	$p.='</div>';
    	$p.='</div>';
    	return $p;
	}		
	
	function pageContent($postID,$menuID,$menuTitle){
		$p='';		
		$title=postInfo($postID,'post_title');		
		$urlPage=permalinkPost($postID);
		$p.='<i>Navigation Label</i><br>';
		$p.='<input type="text" class="form-control" id="page_'.$menuID.'" value="'.$menuTitle.'"/>';
		$p.='<small class="form-control">';
		$p.='<i>Original</i> : ';
		$p.='<a href="'.$urlPage.'" target="_blank">'.$title.'</a>';
		$p.='</small>';		
		return $p;
	}
	
	function categoryContent($catID,$menuID,$menuTitle){
		$p='';
		$uriCat=optionGet('permalink_category');
		$slug=categoryInfo($catID,'slug');
		$title=categoryInfo($catID,'name');
		$urlPage=base_url().$uriCat.'/'.$slug;
		$p.='<i>Navigation Label</i><br>';
		$p.='<input type="text" class="form-control" id="category_'.$menuID.'" value="'.$menuTitle.'"/>';
		$p.='<small class="form-control">';
		$p.='<i>Original</i> : ';
		$p.='<a href="'.$urlPage.'" target="_blank">'.$title.'</a>';
		$p.='</small>';		
		return $p;
	}
	
	function urlContent($url,$menuID,$menuTitle){
		$p='';				
		$p.='<i>URL</i><br>';
		$p.='<input type="text" class="form-control" id="linkurl_'.$menuID.'" value="'.$url.'"/>';
		$p.='<i>Navigation Label</i><br>';
		$p.='<input type="text" class="form-control" id="linktitle_'.$menuID.'" value="'.$menuTitle.'"/>';		
		return $p;
	}
	
	function GalleryContent($GalerryID,$menuID,$menuTitle){
		$p='';
		$uriCat="media";
		$galleryName=dbField('album','album_id',$GalerryID,'album_title');
		$urlPage=base_url().$uriCat.'/'.$GalerryID;
		$p.='<i>Navigation Label</i><br>';
		$p.='<input type="text" class="form-control" id="gallery_'.$menuID.'" value="'.$menuTitle.'"/>';
		$p.='<small class="form-control">';
		$p.='<i>Original</i> : ';
		$p.='<a href="'.$urlPage.'" target="_blank">'.$galleryName.'</a>';
		$p.='</small>';		
		return $p;
	}
	
	
	
}