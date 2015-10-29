<?php

foreach($widgetdata as $rWidget){	
}
$widgetID=$rWidget['term_id'];
$source="";
$catID=menuInfoJSON($widgetID,'source');
$titleBox="";
$title=menuInfoJSON($widgetID,'title');
if(!empty($title)){
	$titleBox=$title;
}else{
	$titleBox="Category Widget";
}
if(!empty($catID)){
	$source=$catID;
}else{
	$source=1;
}
$catLink=permalinkCategory($source);
?>
<div class="widget-item">
<div class="widget-item-title"><?=$titleBox;?><span class="widget-item-more"><a href="<?=$catLink;?>">more</a></span></div>
<div class="widget-item-body">
<?php
$g=mc_postCategory($source,"post_date DESC","5");
if(!empty($g)){
	foreach($g as $r){
		$url=permalinkPost($r->post_id);
		?>
		<li><a href="<?=$url;?>"><?=$r->post_title;?></a></li>
		<?php
	}
}

//mc_postCategory
?>
</div>
</div>