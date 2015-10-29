<div class="panel-group" id="accordion">
<?php
$this->load->library('m_net');
$data=getTerms("sidebar",$termid,"order_term ASC");
if(!empty($data)){
foreach($data as $row){
	$wi=$row->term_id;	
	$prefix=menuInfoJSON($wi,'prefix');
	$jsondata=dbField('terms','term_id',$wi,'term_data');
	$sb=$this->m_database->fetchData('terms',array('term_id'=>$wi));
	$param=array(
	'data'=>$jsondata,
	'widgetdata'=>$sb,
	'parentid'=>$termid,
	);	
	$j=$this->m_net->curlNet("get",base_url().'service/widget/'.$prefix.'/configwidget',$param);
	echo $j;
}
}else{
	echo "Tidak ada widget";
}
?>
</div>
<input type="hidden" id="widgetpos" value="<?=$pos;?>"/>
<input type="hidden" id="widgetid" value="<?=$termid;?>"/>