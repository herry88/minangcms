<?php

foreach($widgetdata as $rWidget){	
}
$widgetID=$rWidget['term_id'];

$titleBox="";
$title=menuInfoJSON($widgetID,'title');
if(!empty($title)){
	$titleBox=$title;
}else{
	$titleBox="Search Widget";
}
?>
<div class="widget-item" style="margin-bottom: 20px;">
<div class="widget-item-title"><?=$titleBox;?></div>
<div class="widget-item-body">
<form method="get" action="<?=routeGet('search','route_key');?>">
	<input type="text" name="s" class="form-control"/>
</form>
</div>
</div>