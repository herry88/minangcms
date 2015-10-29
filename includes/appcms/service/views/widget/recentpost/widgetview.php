<?php

foreach($widgetdata as $rWidget){	
}
$widgetID=$rWidget['term_id'];

$titleBox="";
$title=menuInfoJSON($widgetID,'title');
if(!empty($title)){
	$titleBox=$title;
}else{
	$titleBox="Event Widget";
}
?>
<div class="widget-item">
<div class="widget-item-title"><?=$titleBox;?></div>
<div class="widget-item-body">
<?php
$para=array(
'post_type'=>'post'
);
$g=mc_allpost($para,"post_date DESC","5");
if($g['jumlah'] > 0){		
	foreach($g['data'] as $r){
		$tgl="";
		$jam="";
		$postTitle=$r->post_title;		
		$url=permalinkPost($r->post_id);	
		?>
		<li><a href="<?=$url;?>"><?=$postTitle;?></a></li>
		<?php
	}
}

//mc_postCategory
?>
</div>
</div>