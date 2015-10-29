<?php
$info=$this->session->flashdata('info');
if(!empty($info)){
	echo $info;
}
?>
<style>
#btnup{
	margin-bottom: 30px;
}
</style>
<?php
foreach($data as $row){	
}
$att=array(
'id'=>'formentri',
);
echo form_open(base_url(roleURIUser().'content/'.$uclass.'/editapply'),$att);
?>
<div class="col-sm-12" id="btnup">
	<button type="submit" class="btn btn-default btn-flat pull-right" id="submitbtn">Publish</button>
</div>
<input type="hidden" name="postid" value="<?=$row->post_id;?>"/>
<input type="hidden" name="tipepost" value="<?=$tipe;?>"/>
<div class="row">
<div class="col-md-8">
	<?php $this->load->view('content/post/leftentryedit');?>
</div>
<div class="col-md-4">
	<?php $this->load->view('content/post/rightentryedit');?>
</div>
</div>
<?php
echo form_close();
?>