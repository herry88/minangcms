<?php

foreach($widgetdata as $rd){	
}
$widgetid=$rd['term_id'];
$name=$rd['name'];
$slug=$rd['slug'];
$wdTitle=menuInfoJSON($widgetid,'title');
if(empty($wdTitle)){
	$wdTitle="Recent Post Widget";
}
if(empty($wdSource)){
	$wdSource="1";
}
if(empty($wdLimit)){
	$wdLimit="5";
}
?>
<div class="panel panel-default" style="margin-bottom: 5px;">
<div class="panel-heading">
  <h4 class="panel-title">
    <a data-toggle="collapse" data-parent="#accordion" href="#recentpost<?=$widgetid;?>">
      <?=$wdTitle;?>
    </a>
  </h4>
</div>
<div id="recentpost<?=$widgetid;?>" class="panel-collapse collapse">
  <div class="panel-body">
    <div class="form-horizontal">
    <label>Label</label>
    <input type="text" id="recentposttitle<?=$widgetid;?>" class="form-control" value="<?=$wdTitle;?>"/>
    <label>Menampilakn 5 Recent Post terbaru</label>        
  </div>
  <div class="panel-footer">
  	<a href="javascript:;" onclick="widgetCatDelete('<?=$widgetid;?>');" class="btn btn-danger btn-flat btn-xs pull-left" data-id="<?=$widgetid;?>">Delete</a>&nbsp;
  	<a href="javascript:;" class="btn btn-primary btn-flat btn-xs" onclick="widgetCatChange('<?=$widgetid;?>','');" data-id="<?=$widgetid;?>">Ubah</a>
  </div>
</div>
</div>

<script>
$(document).ready(function(){

});

function widgetCatChange(id){
	var title=$("#recentposttitle"+id).val();
	var sourcehtml=$("#recentpostsource"+id).val();
	var sourcelimit=$("#recentpostlimit"+id).val();
	$.ajax({
		type:'post',
		dataType:'json',
		url:'<?=base_url();?>service/widget/recentpost/update',
		data:'id='+id+"&title="+title+"&source="+sourcehtml+"&limit="+sourcelimit,
		beforeSend:function(){
		},
		success:function(){
			getWidget();
		},
	});
}

function widgetCatDelete(did){
	$.ajax({
		type:'post',
		dataType:'json',
		url:'<?=base_url();?>service/widget/recentpost/delete',
		data:'id='+did,
		beforeSend:function(){
		},
		success:function(x){
			getWidget();
		},
	});
}

</script>