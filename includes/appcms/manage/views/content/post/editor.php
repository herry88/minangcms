<?php
echo incJS(locationPlugin('url').'ckeditor/ckeditor');
$token=md5(sha1(md5(userInfo('user_id'))));
?>
<textarea id="editor1" name="konten" class="form-control" placeholder="Tulis Konten berita" required="">
	<?php echo set_value('konten'); ?>
</textarea>
<div id="kcfinder_div"></div>
<script>
CKEDITOR.replace( 'editor1', {
    language: 'en',
    filebrowserBrowseUrl: '<?=locationPlugin("url")."kcfinder/";?>browse.php?opener=ckeditor&type=files&token=<?=$token;?>',
   	filebrowserImageBrowseUrl: '<?=locationPlugin("url")."kcfinder/";?>browse.php?opener=ckeditor&type=images&token=<?=$token;?>',
   	filebrowserFlashBrowseUrl: '<?=locationPlugin("url")."kcfinder/";?>browse.php?opener=ckeditor&type=flash&token=<?=$token;?>',
   	filebrowserUploadUrl: '<?=locationPlugin("url")."kcfinder/";?>upload.php?opener=ckeditor&type=files&token=<?=$token;?>',
   	filebrowserImageUploadUrl: '<?=locationPlugin("url")."kcfinder/";?>upload.php?opener=ckeditor&type=images&token=<?=$token;?>',
   	filebrowserFlashUploadUrl: '<?=locationPlugin("url")."kcfinder/";?>upload.php?opener=ckeditor&type=flash&token=<?=$token;?>',
});
</script>