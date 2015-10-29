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

$(".select2").select2({
	placeholder: "Ketik nama Album"
});
});
</script>
<?php
echo incCSS(locationPlugin().'bootstrapeditor/bootstrap3-wysihtml5.min');
echo incCSS(locationPlugin().'select2/select2');
echo incCSS(locationPlugin().'select2/select2-bootstrap');
echo incJS(locationPlugin().'bootstrapeditor/bootstrap3-wysihtml5.all.min');
echo incJS(locationPlugin().'select2/select2.min');
echo incJS(locationPlugin().'select2/select2_locale_id');

$att=array(
'class'=>'form-horizontal',
);
echo form_open(base_url(roleURIUser().'media/gallery/addapply'),$att);
?>
<div class="col-sm-12" id="btnup">
	<button type="submit" class="btn btn-default btn-flat pull-right" id="submitbtn">Simpan</button>
</div>
<div id="kcfinder_div"></div>
<div class="form-group">
	<label class="col-sm-2 control-label">Nama Galeri</label>
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
	<label class="col-sm-2 control-label">Album</label>
	<div class="col-md-8">
		<select name="album[]" class="form-control select2" multiple="multiple">
			<option value="">-Pilih Album-</option>
			<?php
			$c=$this->m_database->countData('album');
			if($c > 0){
				$d=$this->m_database->fetchData('album','','album_title ASC');
				foreach($d as $r){
					?>
					<option value="<?=$r->album_id;?>"><?=$r->album_title;?></option>
					<?php
				}
			}
			?>
		</select>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label">&nbsp;</label>
	<div class="col-md-8">
		Setelah menyimpan galeri, akan dialihkan ke upload file galeri
	</div>
</div>
<?php
echo form_close();
?>