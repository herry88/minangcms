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
<div class="widget widget-info">
<div class="widget-header">
	<h3 class="widget-title"><?=$titleBox;?></h3>
	<div class="widget-tools pull-right"><a href="<?=base_url(routeGet('events','route_key'));?>">+ indexs</a></div>
</div>
<div class="widget-body">
<?php
$para=array(
'post_type'=>'event'
);
$g=mc_allpost($para,"post_date DESC","5");
if($g['jumlah'] > 0){		
	foreach($g['data'] as $r){
		$tgl="";
		$jam="";
		$tglEvent=postTaxonomy($r->post_id,'tanggal_event');
		$jamEvent=postTaxonomy($r->post_id,'jam_event');
		if(!empty($tglEvent)){
			$tgl=$tglEvent;
		}else{
			$tgl="";
		}
		if(!empty($jamEvent)){
			$jam=$jamEvent;
		}else{
			$jam="";
		}
		$url=permalinkPost($r->post_id);
		$merge=$tgl." ".$jam.":00";
		$konversi=date("d-M-Y H:i",strtotime($merge));		
		$jadwalNama='<span class="widget-item-calendar">'.$konversi.'</span>';
		$day=date("d",strtotime($merge));
		$month=date("M",strtotime($merge));
		?>
		<div class="widget-content">
		<a href="<?=$url;?>" class="widget-anchor">
		<div class="widget-left">
			<div class="event-day"><?=$day;?></div>
			<div class="event-month"><?=$month;?></div>
		</div>
		<div class="widget-right">
			<div class="event-title"><?=$r->post_title;?> adklakjkjkjsdlkjalksjdkljalksdjalkkasjdlkajlksdjklajsd</div>
		</div>
		</a>
		</div>
		<?php
	}
}

//mc_postCategory
?>
</div>
</div>