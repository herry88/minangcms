<?php
foreach($data as $row){	
}
?>
<input type="text" name="title" class="form-control" required="" placeholder="Tulis judul berita" value="<?=$row->post_title; ?>"/>
<p>&nbsp;</p>
<?php
$this->load->view('content/post/editoredit');
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
		<input type="text" class="form-control" name="addkeyword" id="addkeyword" placeholder="keyword1,keyword2,keyword3" value="<?=postTaxonomy($row->post_id,'keyword_custom');?>"/>
	</div>
	<div class="form-group">
		<label for="komen">Komentar</label>
		<?php echo inputCheckbox("komen","komen",postTaxonomy($row->post_id,'comment_system'),'Aktifkan sistem Komentar pada berita ini.Jika konfigurasi global dinonaktifkan maka komentar tidak terlihat');?>	
	</div>
	<div class="form-group">
		<label></label>
		<?php
		$c1='';
		$c2='';
		$optStyle=postTaxonomy($row->post_id,'view_style');
		echo $optStyle;
		if($optStyle=="sidebar"){
			$c1='checked=""';
			$c2='';
		}elseif($optStyle=="full"){
			$c2='checked=""';
			$c1='';
		}
		?>
		<div class="radio" style="display: none;">
			<label class="radio-inline">
			<input type="radio" name="tampilan" value="sidebar" <?=$c1;?>/> Dengan Sidebar
			</label>
			<label class="radio-inline">
			<input type="radio" name="tampilan" value="full" <?=$c2;?>/> Tampilan penuh
			</label>			
		</div>
	</div>
</div>
</div>