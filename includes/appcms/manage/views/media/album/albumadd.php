<style type="text/css">
#kcfinder_div {
    display: none;
    position: absolute;
    width: 670px;
    height: 400px;
    background: #e0dfde;
    border: 2px solid #3687e2;
    border-radius: 6px;
    -moz-border-radius: 6px;
    -webkit-border-radius: 6px;
    padding: 1px;
    z-index: 1;
}
</style>
<script>
$(document).ready(function(){
if($(".textarea-editor").length){
	$(".textarea-editor").wysihtml5();
}

$("#remFeature").click(function(){
	$("#featureimage").val("");
	$("#imgfeature").attr('src','');
	$("#imgfeature").hide();
	$("#addFeature").show();
	$(this).hide();
});

});
function openKCFinder(field) {
    var div = document.getElementById('kcfinder_div');
    if (div.style.display == "block") {
        div.style.display = 'none';
        div.innerHTML = '';
        return;
    }
    window.KCFinder = {
        callBack: function(url) {
            window.KCFinder = null;
            //field.value = url;
            $("#"+field).val(url);
            $("#imgfeature").attr('src','<?=urlApp();?>'+url);
            $("#imgfeature").show();
            $("#remFeature").show();
            div.style.display = 'none';
            div.innerHTML = '';
            if(url!=''){
				$("#addFeature").hide();
			}
        }
    };
    div.innerHTML = '<iframe name="kcfinder_iframe" src="<?=locationPlugin("url")."kcfinder";?>/browse.php?type=images&dir=assets/uploads/" ' +
        'frameborder="0" width="100%" height="100%" marginwidth="0" marginheight="0" scrolling="no" />';
    div.style.display = 'block';
}
</script>
<?php
echo incCSS(locationPlugin().'bootstrapeditor/bootstrap3-wysihtml5.min');
echo incJS(locationPlugin().'bootstrapeditor/bootstrap3-wysihtml5.all.min');

$att=array(
'class'=>'form-horizontal',
);
echo form_open(base_url(roleURIUser().'media/album/addapply'),$att);
?>
<div class="col-sm-12" id="btnup">
	<button type="submit" class="btn btn-default btn-flat pull-right" id="submitbtn">Simpan</button>
</div>
<div id="kcfinder_div"></div>
<div class="form-group">
	<label class="col-sm-2 control-label">Nama Album</label>
	<div class="col-md-6">
		<input type="text" name="nama" class="form-control" required="" value="<?=set_value('nama');?>"/>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label">Deskripsi</label>
	<div class="col-md-8">
		<textarea name="keterangan" class="form-control textarea-editor" rows="8"><?=set_value('keterangan');?></textarea>
	</div>
</div>

<div class="form-group">
	<label class="col-sm-2 control-label">Cover Album</label>
	<div class="col-md-3">
		<img src="" id="imgfeature" class="thumbnail img-responsive" style="height: 300px;display: none;"/>
	  	<a href="javascript:;" onclick="openKCFinder('featureimage')" class="form-control" id="addFeature">Pilih Gambar</a>
	  	<a href="javascript:;" id="remFeature" style="display: none;">Hapus Cover Gambar</a>
	  	<input type="hidden" name="featureimage" id="featureimage" value="<?=set_value('featureimage');?>"/>
	</div>
</div>
<?php
echo form_close();
?>