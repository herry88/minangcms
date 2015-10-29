<?php
$themeActive=optionGet('theme_front');
$optionFile=locationTheme('path').'frontend/'.$themeActive.'/includes/themeoption.php';        
if(file_exists($optionFile)){
	
	echo form_open(base_url(roleURIUser().'style/templates/updateconfig'));
	
	include $optionFile;
	
	echo form_close();
}
?>