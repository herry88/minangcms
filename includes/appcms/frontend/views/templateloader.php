<?php
$get=$this->input->get('preview');
$theme="";
if(!empty($get)){
	$theme=$get;
}else{
	$theme=optionGet('theme_front');
}
include(locationTheme('path').'frontend/'.$theme.'/template.php');
?>