<?php
$data=optionGet('captcha_data');
?>
<div class="form-group">
<label class="col-sm-2 control-label">Site Key</label>
<div class="col-md-6">
	<input type="text" name="json[sitekey]" class="form-control" value="<?=jsonDataDecode($data,"sitekey");?>" required=""/>
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label">Secret Key</label>
<div class="col-md-6">
	<input type="text" name="json[secretkey]" class="form-control" value="<?=jsonDataDecode($data,"secretkey");?>" required=""/>
</div>
</div>