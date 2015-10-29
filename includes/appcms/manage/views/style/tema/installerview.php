<?php

$info=$this->session->flashdata('info');
if(!empty($info)){
	echo $info;
}
?>
<div class="row">
<div class="col-md-4">
<?php
echo form_open_multipart(base_url(roleURIUser().'style/templates/installtheme'));
?>
<div class="form-group">
	<label>Upload file</label>
	<input type="file" name="file" class="form-control"/>
</div>
<div class="form-group">	
	<button type="submit" class="btn btn-md btn-default">Upload & Install</button>
</div>
<?php
echo form_close();
?>
</div>
</div>