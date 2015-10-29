<?php

foreach($widgetdata as $rWidget){	
}
$widgetID=$rWidget['term_id'];
$source="";
$url=menuInfoJSON($widgetID,'source');
$titleBox="";
$title=menuInfoJSON($widgetID,'title');
$image="";
$imageX=menuInfoJSON($widgetID,'image');
if(!empty($title)){
	$titleBox=$title;
}else{
	$titleBox="";
}
if(!empty($url)){
	$source=$url;
}else{
	$source=1;
}

if(!empty($imageX)){
	$image=$imageX;
}else{
	$image=noImage();
}
?>
<div class="widget-item">
<div class="widget-item-title"><?=$titleBox;?></div>
<div class="widget-item-body">
<a href="<?=$source;?>" target="_blank"><img src="<?=$imageX;?>"/></a>
</div>
</div>