<?php
foreach($data as $row){	
}
$att=array(
'id'=>'forminput',
);
echo form_open(base_url(roleURIUser().'content/category/editapply'),$att);
?>
<input type="hidden" name="termid" value="<?=$row->term_id;?>"/>
<div class="form-group">
	<label for="addname" style="cursor: pointer;">Nama Kategori</label>
	<input type="text" class="form-control" name="editname" id="editname" value="<?=$row->name;?>" required=""/>
</div>
<div class="form-group">
	<label for="addslug" style="cursor: pointer;">Slug</label>
	<input type="text" class="form-control" name="editslug" id="editslug" value="<?=$row->slug;?>"/>
</div>
<div class="form-group">
	<label for="addparent" style="cursor: pointer;">Parent</label>
	<select name="editparent" class="form-control">
	<?php
	$parent=$row->term_parent;
	$nameParent='';
	if($parent=="0"){
		$nameParent="None";
	}else{
		$nameParent=dbField('terms','term_id',$parent,'name');
	}
	?>
	<option value="<?=$parent;?>"><?=$nameParent;?></option>
	<?php
	$p='';	
	$dParent=getCategory('0','name ASC',$parent);
	if(!empty($dParent)){
	foreach($dParent as $rParent){
		$p.='<option value="'.$rParent->term_id.'">'.$rParent->name.'</option>';
		$dChild=getCategory($rParent->term_id);
		if(!empty($dChild)){									
		foreach($dChild as $rChild){				
			$p.='<option value="'.$rChild->term_id.'">&#8212; '.$rChild->name.'</option>';
		}
		}
	}
	}
	echo $p;
	?>
	</select>		
</div>
<div class="form-group">
	<label for="adddescription" style="cursor: pointer;">Deskripsi</label>
	<textarea name="editdescription" class="form-control" id="editdescription" rows="5"><?=getCategoryDescription($row->term_id);?></textarea>
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