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
<script type="text/javascript">
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
            saniteUrl(url);
            //$("#"+field).val(saniteUrl(url));
            div.style.display = 'none';
            div.innerHTML = '';
        }
    };
    div.innerHTML = '<iframe name="kcfinder_iframe" src="<?=locationPlugin("url")."kcfinder";?>/browse.php?type=images&dir=assets/uploads/" ' +
        'frameborder="0" width="100%" height="100%" marginwidth="0" marginheight="0" scrolling="no" />';
    div.style.display = 'block';
}
function saniteUrl(url){
	$.ajax({
		type:'get',
		dataType:'json',
		url:'<?=base_url();?>plugins/render/kcfinderurl',
		data:'img='+url+"&baseurl=true",
		success:function(x){
			$("#featureimage").val(x.newurl);
			$("#imageuser").attr("src",x.newurl);
		},
	});
}
</script>

<?php
$att=array(
'class'=>'form-horizontal',
);

echo form_open(base_url(roleURIUser().'profil/update'),$att);
?>
<div class="box box-info">
<div class="box-body">
<div id="kcfinder_div"></div>
<div class="col-md-9">
<div class="form-group">
	<label class="col-sm-2 control-label">Username</label>
	<div class="col-md-3">
		<input type="text" name="username" class="form-control" readonly="" required="" value="<?=userInfo('username');?>"/>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label">Nama</label>
	<div class="col-md-6">
		<input type="text" name="nama" class="form-control" required="" value="<?=userInfo('nama');?>"/>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label">Handphone</label>
	<div class="col-md-3">
		<input type="text" name="hp" class="form-control" required="" value="<?=userInfo('hp');?>"/>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label">Email</label>
	<div class="col-md-5">
		<input type="email" name="email" class="form-control" required="" value="<?=userInfo('email');?>"/>
	</div>
</div>
<hr/>
<div class="form-group">
	<label class="col-sm-2 control-label">Password Lama</label>
	<div class="col-md-4">
		<input type="password" name="pwold" class="form-control"/>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label">Ulangi Password Baru</label>
	<div class="col-md-4">
		<input type="password" name="pwnew" class="form-control"/>
	</div>
</div>
</div>
<div class="col-md-3">

	<?php
  
  $feature=userAvatar(200);
  if(!empty($feature)){
  	?>
  	<img src="<?=$feature;?>" class="thumbnail img-responsive" id="imageuser" style="height: 200px"/>
  	<?php
  }else{
  	?>
  	<img src="" class="thumbnail img-responsive" id="imageuser" style="height: 200px"/>
  	<?php
  }
  ?>
  <a href="javascript:;" onclick="openKCFinder('featureimage')">Tukar Photo Profil</a>
  <input type="hidden" name="featureimage" id="featureimage" value="<?=$feature;?>"/>
</div>
</div>
<div class="box-footer">
	<button type="submit" class="btn btn-primary btn-md">Update Profil</button>
</div>
</div>
<?php
echo form_close();
?>