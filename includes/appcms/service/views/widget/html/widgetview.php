<?php

foreach($widgetdata as $rWidget){	
}
$widgetID=$rWidget['term_id'];
$source="";
$url=menuInfoJSON($widgetID,'source');
$titleBox="";
$title=menuInfoJSON($widgetID,'title');

if(!empty($title)){
	$titleBox=$title;
}else{
	$titleBox="";
}
if(!empty($url)){
	$source=$url;
}else{
	$source="";
}

?>
<div class="widget-item">
<div class="widget-item-title"><?=$titleBox;?></div>
<div class="widget-item-body" style="word-wrap: break-word;">
<?=$source;?>
</div>
</div>