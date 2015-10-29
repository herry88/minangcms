<style>
#btnup{
	margin-bottom: 30px;
}
</style>
<?php
$att=array(
'id'=>'formentri',
);
echo form_open(base_url(roleURIUser().'content/'.$uclass.'/addapply'),$att);
?>
<div class="col-sm-12" id="btnup">
	<button type="submit" class="btn btn-default btn-flat pull-right" id="submitbtn">Publish</button>
</div>
<input type="hidden" name="tipepost" value="<?=$tipe;?>"/>
<div class="row">
<div class="col-md-8">
	<?php $this->load->view('content/post/leftentry');?>
</div>
<div class="col-md-4">
	<?php $this->load->view('content/post/rightentry');?>
</div>
</div>
<?php
echo form_close();
?>