<?php

foreach($widgetdata as $rWidget){	
}
$widgetID=$rWidget['term_id'];

$titleBox="";
$title=menuInfoJSON($widgetID,'title');
$limit=menuInfoJSON($widgetID,'limit');
if(!empty($title)){
	$titleBox=$title;
}else{
	$titleBox="Recent Post";
}
?>
<div class="widget widget-info">
<div class="widget-header">
	<h3 class="widget-title"><?=$titleBox;?></h3>
	<div class="widget-tools pull-right"><a href="<?=base_url(routeGet('postall','route_key'));?>">+ indexs</a></div>
</div>
<div class="widget-body">
<?php
$para=array(
'post_type'=>'post'
);
$g=mc_allpost($para,"post_date DESC","",$limit);
if($g['jumlah'] > 0){		
foreach($g['data'] as $row){
$postid=$row->post_id;
$url=permalinkPost($postid);
$img=mc_imagepost($postid);
$title=stringWordLimit($row->post_title,10);
$desc=stringWordLimit($row->post_content,20);
$count=mc_countPostInfo($postid,'comment');	
?>
<div class="widget-content">
<a href="<?=$url;?>" class="widget-anchor">
<div class="widget-left">
	<div class="image-thumbnail">
	<img src="<?=$img;?>" alt="<?=$desc;?>" class="widget-image"/>
	<div class="image-thumbnail-title"><?=$title;?></div>
	</div>
</div>
</a>
</div>
<?php
}
}
?>
</div>
</div>