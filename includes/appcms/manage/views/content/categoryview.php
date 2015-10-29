<div class="row">
<div class="col-md-4">
	<h5 class="heading-a">Tambah Kategori</h5>
	<?php
	$att=array(
	'id'=>'forminput',
	);
	echo form_open(base_url(roleURIUser().'content/category/add'),$att);
	?>
	<div class="form-group">
		<label for="addname" style="cursor: pointer;">Nama Kategori</label>
		<input type="text" class="form-control" name="addname" id="addname" required=""/>
	</div>
	<div class="form-group">
		<label for="addslug" style="cursor: pointer;">Slug</label>
		<input type="text" class="form-control" name="addslug" id="addslug"/>
	</div>
	<div class="form-group">
		<label for="addparent" style="cursor: pointer;">Parent</label>
		<select name="addparent" id="addparent" class="form-control">		
		</select>		
	</div>
	<div class="form-group">
		<label for="adddescription" style="cursor: pointer;">Deskripsi</label>
		<textarea name="adddescription" class="form-control" id="adddescription" rows="5"></textarea>
	</div>
	<button type="submit" class="btn btn-primary btn-flat btn-md">Simpan</button>
	<?php
	echo form_close();
	?>
</div>
<div class="col-md-8" id="contentdiv">
</div>
</div>
<script>
function getCombo(){
	$.ajax({
		type:'post',
		dataType:'html',
		url:'<?=base_url(roleURIUser()."content/category/getcombocat");?>',
		data:'once=1',
		success:function(x){
			$("#addparent").html(x);
		},
	});
}
function getContent(){
	$.ajax({
		type:'post',
		dataType:'html',
		url:'<?=base_url(roleURIUser()."content/category/getcontent");?>',
		data:'once=1',
		success:function(x){
			$("#contentdiv").html(x);
		},
	});
}
$(document).ready(function(){

setTimeout(function(){getContent();getCombo();},1);

$("#addname").blur(function(){
	var g=$(this).val();
	if(g!=''){
		$.ajax({
			type:'get',
			dataType:'json',
			url:'<?=base_url();?>plugins/render/createslug',
			data:'title='+g,
			success:function(x){
				$("#addslug").val(x);
			},
		});
	}else{
		$("#addslug").val("");
	}	
});

$("#forminput").submit(function(e){
	e.preventDefault();
	$.ajax({
		type:'post',
		dataType:'json',
		url:'<?=base_url(roleURIUser()."content/category/add");?>',
		data:$(this).serialize(),
		beforeSend:function(){
		},
		success:function(x){
			getContent();
			getCombo();
			$("#addname").val("");
			$("#addslug").val("");
			$("#adddescription").val("");
		},
	});
});




});
</script>