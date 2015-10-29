<?php

foreach($widgetdata as $rd){	
}
$widgetid=$rd['term_id'];
$name=$rd['name'];
$slug=$rd['slug'];
$wdTitle=menuInfoJSON($widgetid,'title');
$wdSource=menuInfoJSON($widgetid,'source');
$wdLimit=menuInfoJSON($widgetid,'limit');
if(empty($wdTitle)){
	$wdTitle="Category Widget";
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
    <a data-toggle="collapse" data-parent="#accordion" href="#category<?=$widgetid;?>">
      <?=$wdTitle;?>
    </a>
  </h4>
</div>
<div id="category<?=$widgetid;?>" class="panel-collapse collapse">
  <div class="panel-body">
    <div class="form-horizontal">
    <label>Label</label>
    <input type="text" id="categorytitle<?=$widgetid;?>" class="form-control" value="<?=$wdTitle;?>"/>
    <label>Category</label>    
    <select id="categorysource<?=$widgetid;?>" class="form-control">    			
		<?php
		$gb=dbField('terms','term_id',$wdSource,"name");
		echo '<option value="'.$wdSource.'">'.$gb.'</option>';
		$p='';
		$db=getCategory('0','',$wdSource);
		if(!empty($db)){
		foreach($db as $rParent){
			$p.='<option value="'.$rParent->term_id.'">'.$rParent->name.'</option>';
			$dChild=getCategory($rParent->term_id);
			if(!empty($dChild)){									
			foreach($dChild as $rChild){				
				$p.='<option value="'.$rChild->term_id.'">&#8212; '.$rChild->name.'</option>';
			}
			}
		}
		}		
		echo $p;
		?>
    </select>
    <label>Jumlah Tampil</label>
    <input type="text" id="categorylimit<?=$widgetid;?>" class="form-control" value="<?=$wdLimit;?>"/>
    </div>
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
	var title=$("#categorytitle"+id).val();
	var sourcehtml=$("#categorysource"+id).val();
	var sourcelimit=$("#categorylimit"+id).val();
	$.ajax({
		type:'post',
		dataType:'json',
		url:'<?=base_url();?>service/widget/category/update',
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
		url:'<?=base_url();?>service/widget/category/delete',
		data:'id='+did,
		beforeSend:function(){
		},
		success:function(x){
			getWidget();
		},
	});
}

</script>