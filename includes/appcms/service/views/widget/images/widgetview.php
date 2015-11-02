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
	$titleBox="Image Widget";
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
<div class="widget widget-info">
<div class="widget-header">
	<h3 class="widget-title"><?=$titleBox;?></h3>
	<div class="widget-tools pull-right"></div>
</div>
<div class="widget-body">
<div class="widget-content">
<a href="<?=$source;?>" target="_blank">
<div class="widget-left">
<div class="image-thumbnail">
<img src="<?=$imageX;?>" class="widget-image-original"/>
</div>
</div>
</a>
</div>
</div>
</div>