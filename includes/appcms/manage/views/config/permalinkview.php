<style>
.no-box{
	display: list-item;
}
</style>
<?php
$permalink=optionGet('site_permalink');
$att=array(
'class'=>'form-horizontal',
);
echo form_open(base_url(roleURIUser().'config/permalink/updateconfig'),$att);
?>
<h3 class="heading-a">Common Setting</h3>
<div class="row">
<div class="col-md-3">
<div class="radio">
<label>
  <input type="radio" name="common" value="default" <?=checkState($permalink,'default');?>>Default
</label>
</div>
</div>
<div class="col-md-9">
	<p class="form-control-static"><?=base_url();?>?p=123</p>
</div>
</div>

<div class="row">
<div class="col-md-3">
<div class="radio">
<label>
  <input type="radio" name="common" value="dayname" <?=checkState($permalink,'dayname');?>>Tanggal dan Judul
</label>
</div>
</div>
<div class="col-md-9">
	<p class="form-control-static"><?=base_url();?><?=date("Y");?>/<?=date("m");?>/<?=date("d");?>/judulposting</p>
</div>
</div>

<div class="row">
<div class="col-md-3">
<div class="radio">
<label>
  <input type="radio" name="common" value="monthname" <?=checkState($permalink,'monthname');?>>Bulan dan Judul
</label>
</div>
</div>
<div class="col-md-9">
	<p class="form-control-static"><?=base_url();?><?=date("Y");?>/<?=date("m");?>/judulposting</p>
</div>
</div>

<div class="row">
<div class="col-md-3">
<div class="radio">
<label>
  <input type="radio" name="common" value="title" <?=checkState($permalink,'title');?>>Judul
</label>
</div>
</div>
<div class="col-md-9">
	<p class="form-control-static"><?=base_url();?>judulposting</p>
</div>
</div>

<h3 class="heading-a">Optional</h3>
<div class="form-group">
	<label class="col-sm-2 control-label">Base Kategori</label>
	<div class="col-md-6">
		<input type="text" name="catbase" class="form-control" value="<?=optionGet('permalink_category');?>"/>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label">Base Tags</label>
	<div class="col-md-6">
		<input type="text" name="tagbase" class="form-control" value="<?=optionGet('permalink_tags');?>"/>
	</div>
</div>
<hr/>
<div class="form-group">
	<label class="col-sm-2 control-label">&nbsp;</label>
	<div class="col-md-6">
		<button type="submit" class="btn btn-primary btn-flat btn-md">Simpan</button>
	</div>
</div>
<?php
echo form_close();
?>