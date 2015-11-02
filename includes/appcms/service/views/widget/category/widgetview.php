<?php

foreach($widgetdata as $rWidget){	
}
$widgetID=$rWidget['term_id'];
$source="";
$catID=menuInfoJSON($widgetID,'source');
$titleBox="";
$title=menuInfoJSON($widgetID,'title');
$limit=menuInfoJSON($widgetID,'limit');
$style=menuInfoJSON($widgetID,'style');
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
$catName=$titleBox;
?>


<?php
$output='';
$g=mc_postCategory($source,"post_date DESC",$limit);
$d['data']=$g;
$d['catLink']=$catLink;
$d['catName']=$catName;
$d['catID']=$source;
if($style=="thumbnail"){
	$this->load->view('service/widget/category/thumbnailview',$d);
}elseif($style=="list"){
	$this->load->view('service/widget/category/listview',$d);
}
?>