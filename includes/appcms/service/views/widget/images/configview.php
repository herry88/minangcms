<?php

foreach($widgetdata as $rd){	
}
$widgetid=$rd['term_id'];
$name=$rd['name'];
$slug=$rd['slug'];
$wdTitle=menuInfoJSON($widgetid,'title');
$wdSource=menuInfoJSON($widgetid,'source');
$logo=menuInfoJSON($widgetid,'image');
if(empty($wdTitle)){
	$wdTitle="Image Widget";
}
if(empty($wdSource)){
	$wdSource="http://";
}
?>
<div class="panel panel-default" style="margin-bottom: 5px;">
<div class="panel-heading">
  <h4 class="panel-title">
    <a data-toggle="collapse" data-parent="#accordion" href="#img_<?=$widgetid;?>">
      <?=$wdTitle;?>
    </a>
  </h4>
</div>
<div id="img_<?=$widgetid;?>" class="panel-collapse collapse">
  <div class="panel-body">
    <div class="form-horizontal">    
    <label>Label (boleh kosong)</label>
    <input type="text" id="imgtitle<?=$widgetid;?>" class="form-control" value="<?=$wdTitle;?>"/>
    <label>Gambar <small class="text-warning">(*)Gambar tidak diresize,Gunakan gambar sesuai ukuran yang dikehendaki</small></label>
    <?php
	if(!empty($logo)){
		?>
		<div id="image<?=$widgetid;?>" class="imagediv" onclick="openKCFinder(this,'<?=$widgetid;?>')"><div style="margin:5px"><img id="img<?=$widgetid;?>" src="<?=$logo;?>"/></div></div>
		<?php
	}else{
		?>
		<div id="image<?=$widgetid;?>" class="imagediv" onclick="openKCFinder(this,'<?=$widgetid;?>')"><div style="margin:5px">Pilih Gambar</div></div>
		<?php
	}
	?>
    <label>URL</label>
    <textarea id="imgsource<?=$widgetid;?>" class="form-control" rows="2"><?=$wdSource;?></textarea>
    </div>
  </div>
  <div class="panel-footer">
  	<a href="javascript:;" onclick="widgetImageDelete('<?=$widgetid;?>');" class="btn btn-danger btn-flat btn-xs pull-left" data-id="<?=$widgetid;?>">Delete</a>&nbsp;
  	<a href="javascript:;" class="btn btn-primary btn-flat btn-xs" onclick="widgetImageChange('<?=$widgetid;?>','');" data-id="<?=$widgetid;?>">Ubah</a>
  	<a href="javascript:;" class="btn btn-warning btn-flat btn-xs" onclick="cancelimage(<?=$widgetid;?>)">Cancel</a>
  </div>
</div>
</div>

<script>
$(document).ready(function(){


});

function cancelimage(id){
	$("#image"+id).html("");
}

function widgetImageChange(id){
	var title=$("#imgtitle"+id).val();
	var sourceimg=$("#imgsource"+id).val();
	var img=$("#img"+id).attr('src');
	$.ajax({
		type:'post',
		dataType:'json',
		url:'<?=base_url();?>service/widget/images/update',
		data:'id='+id+"&title="+title+"&source="+sourceimg+"&img="+img,
		beforeSend:function(){
		},
		success:function(){
			getWidget();
		},
	});
}

function widgetImageDelete(did){
	$.ajax({
		type:'post',
		dataType:'json',
		url:'<?=base_url();?>service/widget/images/delete',
		data:'id='+did,
		beforeSend:function(){
		},
		success:function(x){
			getWidget();
		},
	});
}

</script>

<style type="text/css">
.imagediv {
    width: 300px;
    height: 100px;
    overflow: hidden;
    cursor: pointer;
    background: #000;
    color: #fff;
}
<?php
if(empty($logo)){
	?>
	.imagediv img {
    visibility: hidden;
	}
	<?php
}
?>

</style>
 
<script type="text/javascript">
function openKCFinder(div,id) {
    window.KCFinder = {
        callBack: function(url) {
            window.KCFinder = null;
            div.innerHTML = '<div style="margin:5px">Loading...</div>';
            var img = new Image();
            img.src = url;
            img.onload = function() {
                div.innerHTML = '<img id="img'+id+'" src="' + url + '" />';
                var img = document.getElementById('img'+id);
                var o_w = img.offsetWidth;
                var o_h = img.offsetHeight;
                var f_w = div.offsetWidth;
                var f_h = div.offsetHeight;
                if ((o_w > f_w) || (o_h > f_h)) {
                    if ((f_w / f_h) > (o_w / o_h))
                        f_w = parseInt((o_w * f_h) / o_h);
                    else if ((f_w / f_h) < (o_w / o_h))
                        f_h = parseInt((o_h * f_w) / o_w);
                    img.style.width = f_w + "px";
                    img.style.height = f_h + "px";
                } else {
                    f_w = o_w;
                    f_h = o_h;
                }
                img.style.marginLeft = parseInt((div.offsetWidth - f_w) / 2) + 'px';
                img.style.marginTop = parseInt((div.offsetHeight - f_h) / 2) + 'px';
                img.style.visibility = "visible";
            }
        }
    };
    window.open('<?=locationPlugin("url")."kcfinder";?>/browse.php?type=images&dir=assets/uploads/',
        'kcfinder_image', 'status=0, toolbar=0, location=0, menubar=0, ' +
        'directories=0, resizable=1, scrollbars=0, width=800, height=600'
    );
}
</script>