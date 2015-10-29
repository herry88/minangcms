<?php

foreach($widgetdata as $rd){	
}
$widgetid=$rd['term_id'];
$name=$rd['name'];
$slug=$rd['slug'];
$wdTitle=menuInfoJSON($widgetid,'title');
$wdSource=menuInfoJSON($widgetid,'source');
if(empty($wdTitle)){
	$wdTitle="HTML Widget";
}
if(empty($wdSource)){
	$wdSource="";
}
?>
<div class="panel panel-default" style="margin-bottom: 5px;">
<div class="panel-heading">
  <h4 class="panel-title">
    <a data-toggle="collapse" data-parent="#accordion" href="#html_<?=$widgetid;?>">
      <?=$wdTitle;?>
    </a>
  </h4>
</div>
<div id="html_<?=$widgetid;?>" class="panel-collapse collapse">
  <div class="panel-body">
    <div class="form-horizontal">
    <label>Label</label>
    <input type="text" id="htmltitle<?=$widgetid;?>" class="form-control" value="<?=$wdTitle;?>"/>
    <label>HTML/Text/Javascript/CSS</label>
    <textarea id="htmlsource<?=$widgetid;?>" class="form-control" rows="5"><?=$wdSource;?></textarea>
    </div>
  </div>
  <div class="panel-footer">
  	<a href="javascript:;" onclick="widgetHTMLDelete('<?=$widgetid;?>');" class="btn btn-danger btn-flat btn-xs pull-left" data-id="<?=$widgetid;?>">Delete</a>&nbsp;
  	<a href="javascript:;" class="btn btn-primary btn-flat btn-xs" onclick="widgetHTMLChange('<?=$widgetid;?>','');" data-id="<?=$widgetid;?>">Ubah</a>
  </div>
</div>
</div>

<script>
$(document).ready(function(){

});

function widgetHTMLChange(id){
	var title=$("#htmltitle"+id).val();
	var sourcehtml=$("#htmlsource"+id).val();
	$.ajax({
		type:'post',
		dataType:'json',
		url:'<?=base_url();?>service/widget/html/update',
		data:'id='+id+"&title="+title+"&source="+sourcehtml,
		beforeSend:function(){
		},
		success:function(){
			getWidget();
		},
	});
}

function widgetHTMLDelete(did){
	$.ajax({
		type:'post',
		dataType:'json',
		url:'<?=base_url();?>service/widget/html/delete',
		data:'id='+did,
		beforeSend:function(){
		},
		success:function(x){
			getWidget();
		},
	});
}

</script>