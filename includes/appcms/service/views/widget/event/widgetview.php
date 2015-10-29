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
		?>
		<li><a href="<?=$url;?>"><?=$r->post_title;?></a><?=$jadwalNama;?></li>
		<?php
	}
}

//mc_postCategory
?>
</div>
</div>