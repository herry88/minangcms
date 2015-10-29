<?php
foreach($data as $row){	
}
$att=array(
'id'=>'forminput',
);
echo form_open(base_url(roleURIUser().'content/tags/editapply'),$att);
?>
<input type="hidden" name="termid" value="<?=$row->term_id;?>"/>
<div class="form-group">
	<label for="addname" style="cursor: pointer;">Nama Tags</label>
	<input type="text" class="form-control" name="editname" id="editname" value="<?=$row->name;?>" required=""/>
</div>
<div class="form-group">
	<label for="addslug" style="cursor: pointer;">Slug</label>
	<input type="text" class="form-control" name="editslug" id="editslug" value="<?=$row->slug;?>"/>
</div>
<div class="form-group">
	<label for="adddescription" style="cursor: pointer;">Deskripsi</label>
	<textarea name="editdescription" class="form-control" id="editdescription" rows="5"><?=getTagDescription($row->term_id);?></textarea>
</div>
<button type="submit" class="btn btn-primary btn-flat btn-md">Simpan</button>
<?php
echo form_close();
?>
<script>
$(document).ready(function(){
$("#editname").blur(function(){
	var g=$(this).val();
	if(g!=''){
		$.ajax({
			type:'get',
			dataType:'json',
			url:'<?=base_url();?>plugins/render/createslug',
			data:'title='+g,
			success:function(x){
				$("#editslug").val(x);
			},
		});
	}else{
		$("#editslug").val("");
	}	
});
});
</script>