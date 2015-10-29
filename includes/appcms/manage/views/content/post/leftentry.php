<input type="text" name="title" class="form-control" required="" placeholder="Tulis judul <?=$mod;?>" value="<?php echo set_value('title'); ?>"/>
<p>&nbsp;</p>
<?php
$this->load->view('content/post/editor');
?>
<hr/>
<div class="box box-primary collapsed-box">
<div class="box-header with-border">
  <h5 class="box-title">Tambahan</h5>
  <div class="box-tools pull-right">
    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
  </div>
</div>
<div class="box-body">
  	<div class="form-group">
		<label for="addkeyword">Keyword Tambahan.<small>Pisahkan dengan koma</small></label>
		<input type="text" class="form-control" name="addkeyword" id="addkeyword" placeholder="keyword1,keyword2,keyword3" value="<?php echo set_value('addkeyword'); ?>"/>
	</div>
	<div class="form-group">
		<label for="komen">Komentar</label>
		<?php echo inputCheckbox("komen","komen",optionGet('site_comment'),'Aktifkan sistem Komentar pada '.$mod.' ini.Jika konfigurasi global dinonaktifkan maka komentar tidak terlihat');?>	
	</div>
	<div class="form-group">
		<label></label>
		<div class="radio" style="display: none;">
			<label class="radio-inline">
			<input type="radio" name="tampilan" value="sidebar" checked=""/> Dengan Sidebar
			</label>
			<label class="radio-inline">
			<input type="radio" name="tampilan" value="full"/> Tampilan penuh
			</label>			
		</div>
	</div>
</div>
</div>