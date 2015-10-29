<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('dbGet')){
	function dbGet($table,$where='',$order='',$group='',$limit='')
	{
		$CI=& get_instance();
		$CI->load->library('m_database');
		$d=$CI->m_database->fetchData($table,$where,$order,$group,$limit);
		return $d;
	}
}

if(!function_exists('dbSum')){
	function dbSum($table,$where='',$field)
	{
		$CI=& get_instance();
		$CI->load->library('m_database');
		$d=$CI->m_database->sumRow($table,$where,$field);
		return $d;
	}
}

if(!function_exists('dbCount')){
	function dbCount($table,$where)
	{
		$CI=& get_instance();
		$CI->load->library('m_database');
		$d=$CI->m_database->countData($table,$where);
		return $d;
	}
}

if(!function_exists('dbField')){
	function dbField($table,$key,$keyvalue,$output)
	{
		$CI=& get_instance();
		$CI->load->library('m_database');
		$w=array(
			$key=>$keyvalue,
			);
		$d=$CI->m_database->fieldRow($table,$w,$output);
		return $d;
	}
}

if(!function_exists('optionGet')){
	function optionGet($key,$newVal='')
	{
		$CI=& get_instance();
		$CI->load->library('m_database');
		$skey=array(
			'option_key'=>$key,
			);
		$data=$CI->m_database->fieldRow('options',$skey,'option_val');
		if($data!=''){
			return $data;
		}else{
			if(!empty($newVal)){
				return $newVal;
			}else{
				return "";
			}
		}
	}
}

if(!function_exists('optionSet')){
	function optionSet($key,$value='',$sistem='1',$tipe="text")
	{
		$CI=& get_instance();
		$s=array(
				'option_key'=>$key,
				);
		if($CI->m_database->isBOF('options',$s)==TRUE)
		{
			$d=array(
				'option_key'=>$key,
				'option_val'=>$value,
				'tipe'=>$tipe,
				'sistem'=>$sistem,
				);
			$CI->m_database->addRow('options',$d);
		}else{
			$d=array(				
				'option_val'=>$value,
				);
			$CI->m_database->editRow('options',$d,$s);
		}
	}
}

if(!function_exists('taxonomyCreate')){
	function taxonomyCreate($userID,$Key,$Val,$ExpiredSecond=3600)
	{
	    $CI=& get_instance();
	    $CI->load->library('m_database');
	    $s=array(
	        'user_id'=>$userID,
	        );
	    if($CI->m_database->isBOF('userlogin',$s)==TRUE)
	    {
	        $ss=array(
	            'user_id'=>"0",
	            'taxo_key'=>$Key,
	            );
	        if($CI->m_database->isBOF('usertaxonomy',$ss)==TRUE)
	        {
	            $d=array(
	            'user_id'=>"0",
	            'taxo_key'=>$Key,
	            'taxo_val'=>$Val,
	            'taxo_expired'=>date("Y-m-d h:i:s", strtotime("+$ExpiredSecond seconds")),
	            );
	            $CI->m_database->addRow('usertaxonomy',$d);
	            return true;
	        }else{
	            $d=array(
	            'taxo_val'=>$Val,
	            'taxo_expired'=>date("Y-m-d h:i:s", strtotime("+$ExpiredSecond seconds")),
	            );
	            $CI->m_database->editRow('usertaxonomy',$d,$ss);
	            return true;
	        }
	    }else{
	        $ss=array(
	            'user_id'=>$userID,
	            'taxo_key'=>$Key,
	            );
	        if($CI->m_database->isBOF('usertaxonomy',$ss)==TRUE)
	        {
	            $d=array(
	            'user_id'=>$userID,
	            'taxo_key'=>$Key,
	            'taxo_val'=>$Val,
	            'taxo_expired'=>date("Y-m-d h:i:s", strtotime("+$ExpiredSecond seconds")),
	            );
	            $CI->m_database->addRow('usertaxonomy',$d);
	            return true;
	        }else{
	            $d=array(
	            'taxo_val'=>$Val,
	            'taxo_expired'=>date("Y-m-d h:i:s", strtotime("+$ExpiredSecond seconds")),
	            );
	            $CI->m_database->editRow('usertaxonomy',$d,$ss);
	            return true;
	        }
	        
	    }
	}
}

if(!function_exists('taxonomyRead')){
	function taxonomyRead($userID,$Key)
	{
	    $CI=& get_instance();
	    $s=array(
	        'user_id'=>$userID,
	        'taxo_key'=>$Key,
	    );
	    $output="";
	    if($CI->m_database->isBOF('usertaxonomy',$s)==TRUE)
	    {
	       return "";
	    }else{        
	       return $CI->m_database->FieldRow('usertaxonomy',$s,'taxo_val');        
	    }
	    return $output;
	}
}

if(!function_exists('taxonomyRemove')){
	function taxonomyRemove($userID,$Key='')
	{
	    $CI=& get_instance();
	    $CI->load->library('m_database');
	    $s=array();
	    if(!empty($Key)){
			$s=array(
		        'user_id'=>$userID,
		        'taxo_key'=>$Key,
		    );
		}else{
			$s=array(
		        'user_id'=>$userID,
		    );
		}
	    
	    $output="";
	    if($CI->m_database->isBOF('usertaxonomy',$s)==TRUE)
	    {
	        return false;
	    }else{
	        $CI->m_database->deleteRow('usertaxonomy',$s);
	    }

	}
}

if(!function_exists('routeGet')){
	function routeGet($key,$output='route_key')
	{
		$CI=& get_instance();
		$CI->load->library('m_database');
		$s=array(
		'route_name'=>$key,
		);
		if($CI->m_database->isBOF('route',$s)==TRUE)
		{
			return "";
		}else{
			return $CI->m_database->fieldRow('route',$s,$output);
		}
	}
}


?>