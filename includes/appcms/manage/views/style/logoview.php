<?php
$logo=optionGet('site_logo');
$favicon=optionGet('site_favicon');
$att=array(
'class'=>'form-horizontal',
);
echo form_open(base_url(roleURIUser().'style/logo/updateapply'),$att);
?>
<div id="kcfinder_div"></div>
<div class="form-group">
	<label class="col-sm-2 control-label">Logo</label>
	<div class="col-md-3">
		<?php
		if(!empty($logo)){
			?>
			<img src="<?=$logo;?>" id="imglogo" class="thumbnail img-responsive" style="height: 120px;"/>
		  	<a href="javascript:;" onclick="openKCFinder('logo')" class="form-control" id="addlogo" style="display: none;">Pilih Gambar</a>
		  	<a href="javascript:;" id="remlogo">Hapus Logo</a>
		  	<input type="hidden" name="logo" id="logo" value="<?=$logo;?>"/>
			<?php
		}else{
			?>
			<img src="" id="imglogo" class="thumbnail img-responsive" style="height: 120px;display: none;"/>
		  	<a href="javascript:;" onclick="openKCFinder('logo')" class="form-control" id="addlogo">Pilih Gambar</a>
		  	<a href="javascript:;" id="remlogo" style="display: none;">Hapus Logo</a>
		  	<input type="hidden" name="logo" id="logo" value="<?=set_value('logo');?>"/>
			<?php
		}
		?>		
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label">Favicon</label>
	<div class="col-md-3">
		<?php
		if(!empty($favicon)){
			?>
			<img src="<?=$favicon;?>" id="imgfavicon" class="thumbnail img-responsive" style="height: 32px;"/>
		  	<a href="javascript:;" onclick="openKCFinder('favicon')" class="form-control" id="addfavicon" style="display: none;">Pilih Gambar</a>
		  	<a href="javascript:;" id="remfavicon">Hapus Favicon</a>
		  	<input type="hidden" name="favicon" id="favicon" value="<?=$favicon;?>"/>
			<?php
		}else{
			?>
			<img src="" id="imgfavicon" class="thumbnail img-responsive" style="height: 32px;display: none;"/>
		  	<a href="javascript:;" onclick="openKCFinder('favicon')" class="form-control" id="addfavicon">Pilih Gambar</a>
		  	<a href="javascript:;" id="remfavicon" style="display: none;">Hapus Favicon</a>
		  	<input type="hidden" name="favicon" id="favicon" value="<?=set_value('favicon');?>"/>
			<?php
		}
		?>		
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label">&nbsp;</label>
	<div class="col-md-3">
		<button type="submit" class="btn btn-primary btn-flat">Simpan</button>
	</div>
</div>
<?php
echo form_close();
?>
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
	
$("#remlogo").click(function(){
	$("#logo").val("");
	$("#imglogo").attr('src','');
	$("#imglogo").hide();
	$("#addlogo").show();
	$(this).hide();
});

$("#remfavicon").click(function(){
	$("#favicon").val("");
	$("#imgfavicon").attr('src','');
	$("#imgfavicon").hide();
	$("#addfavicon").show();
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
            $("#img"+field).attr('src','<?=urlApp();?>'+url);
            $("#img"+field).show();
            $("#rem"+field).show();
            div.style.display = 'none';
            div.innerHTML = '';
            if(url!=''){
				$("#add"+field).hide();
			}
        }
    };
    div.innerHTML = '<iframe name="kcfinder_iframe" src="<?=locationPlugin("url")."kcfinder";?>/browse.php?type=images&dir=assets/uploads/" ' +
        'frameborder="0" width="100%" height="100%" marginwidth="0" marginheight="0" scrolling="no" />';
    div.style.display = 'block';
}
</script>