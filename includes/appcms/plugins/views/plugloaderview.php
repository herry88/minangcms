<?php 
$action=$this->input->get('action');
if(empty($action)){
echo modules::run('plugins/'.$plugname.'/plugins/index');
}else{
echo modules::run('plugins/'.$plugname.'/plugins/'.$action); 
}
?>