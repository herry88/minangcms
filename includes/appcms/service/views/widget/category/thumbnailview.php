<div class="widget widget-info">
<div class="widget-header">
	<h3 class="widget-title"><?=$catName;?></h3>
	<div class="widget-tools pull-right"><a href="<?=permalinkCategory($catID);?>">+ indexs</a></div>
</div>
<div class="widget-body">
<?php
if(!empty($data)){
foreach($data as $row)
{
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