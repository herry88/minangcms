<?php
$data=optionGet('captcha_data');
?>
<div class="form-group">
<label class="col-sm-2 control-label">Table Name</label>
<div class="col-md-4">
	<input type="text" name="savepath" class="form-control" value="<?=optionGet('captcha_savepath',"cicaptcha");?>" required=""/>
	<h5 class="text-info">Jika ingin mengganti nama table, hapus table sebelumnya secara manual</h5>
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label">Folder Name</label>
<div class="col-md-4">
	<input type="text" name="json[folderci]" class="form-control" value="<?=jsonDataDecode($data,"folderci","captcha");?>" required=""/>
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label">Length</label>
<div class="col-md-2">
	<input type="number" name="json[lengthci]" class="form-control" value="<?=jsonDataDecode($data,"lengthci","4");?>" required=""/>
</div>
</div>