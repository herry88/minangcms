<?php
$att=array(
'class'=>'form-horizontal',
);
echo form_open(base_url(roleURIUser()).'/config/searchengine',$att);
?>
<div class="form-group">
<label class="col-sm-2 control-label">Google Validate</label>
<div class="col-md-6">
	<input type="text" name="google" value="<?=optionGet('google');?>" class="form-control"/>
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label">Bing Validate</label>
<div class="col-md-6">
	<input type="text" name="bing" value="<?=optionGet('bing');?>" class="form-control"/>
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label">Alexa Validate</label>
<div class="col-md-6">
	<input type="text" name="alexa" value="<?=optionGet('alexa');?>" class="form-control"/>
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label">Alexa Validate</label>
<div class="col-md-6">
	<?php echo inputCheckbox("ogfacebook","",optionGet('ogfacebook'),'Tampilan Thumbnail Facebook saat share');?>
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label">&nbsp;</label>
<div class="col-md-6">
	<button type="submit" class="btn btn-primary btn-flat">Simpan Konfigurasi</button>
</div>
</div>
<?php
echo form_close();
?>