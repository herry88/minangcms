<div class="widget widget-info">
<div class="widget-header">
	<h3 class="widget-title"><?=$catName;?></h3>
	<div class="widget-tools pull-right"><a href="<?=permalinkCategory($catID);?>">+ indexs</a></div>
</div>
<div class="widget-body">
<?php
if(!empty($data)){
$i=0;
foreach($data as $row)
{
$i+=1;
$postid=$row->post_id;
$url=permalinkPost($postid);
$img=mc_imagepost($postid);
$title=stringWordLimit($row->post_title,10);
$desc=stringWordLimit($row->post_content,20);
$count=mc_countPostInfo($postid,'comment');
?>
<div class="widget-content">
<a href="<?=$url;?>" class="widget-anchor with-space">
<div class="widget-left">
<span class="widget-number"><?=$i;?></span><?=$title;?>
</div>
</a>
</div>
<?php	
}
}
?>
</div>
</div>