<?php
$lastmenu=$this->input->get('open');
$lastmenu=isset($lastmenu) ? $lastmenu : "top";
?>
<div class="panel-group" id="accordion">

<?php
$at1=array(
'id'=>'entriPage',
);
echo form_open('#',$at1);
?>
<div class="panel panel-default">
<div class="panel-heading">
  <h4 class="panel-title">
    <a data-toggle="collapse" data-parent="#accordion" href="#c1">
      Halaman
    </a>
  </h4>
</div>
<div id="c1" class="panel-collapse collapse">
  <div class="panel-body" style="overflow: auto;height:200px;">
  <?php
  $sPost=array(
  'post_type'=>'page',
  );
  $poutput='';
  $dPage=getPosts($sPost,'post_title ASC');
  if($dPage['jumlah'] > 0){
  	foreach($dPage['data'] as $rPage){
		$poutput.='<div class="checkbox">';
		$poutput.='<label>';
		$poutput.='<input type="checkbox" name="page[]" id="page" value="'.$rPage->post_id.'"/>'.$rPage->post_title;
		$poutput.='</label>';
		$poutput.='</div>';
	}
	echo $poutput;
  }  
  ?>        
  </div>
  <input type="hidden" name="menu" value="<?=$lastmenu;?>"/>
  <div class="panel-footer">
  	<button type="submit" id="btnPage" class="btn btn-flat btn-default">Tambah ke Menu</button>
  </div>
</div>
</div>
<?php echo form_close();?>

<?php
$at2=array(
'id'=>'entriLink',
);
echo form_open('#',$at2);
?>
<div class="panel panel-default">
<div class="panel-heading">
  <h4 class="panel-title">
    <a data-toggle="collapse" data-parent="#accordion" href="#c2">
      Custom Link
    </a>
  </h4>
</div>
<div id="c2" class="panel-collapse collapse">
  <div class="panel-body">
  <label>Link</label><br/>
  <input type="text" name="linkurl" class="form-control" required="" placeholder="http://"/><br/>
  <label>Link Teks</label><br/>
  <input type="text" name="linktitle" class="form-control" required=""/><br/>
  </div>
  <input type="hidden" name="menu" value="<?=$lastmenu;?>"/>
  <div class="panel-footer">
  	<button type="submit" id="btnLink" class="btn btn-flat btn-default">Tambah ke Menu</button>
  </div>
</div>
</div>
<?php echo form_close();?>


<?php
$at3=array(
'id'=>'entriKategori',
);
echo form_open('#',$at3);
?>
<div class="panel panel-default">
<div class="panel-heading">
  <h4 class="panel-title">
    <a data-toggle="collapse" data-parent="#accordion" href="#c3">
      Kategori
    </a>
  </h4>
</div>
<div id="c3" class="panel-collapse collapse">
  <div class="panel-body" style="overflow: auto;height:200px;">
  <?php
  $p='';
  $dParent=getCategory();		
	if(!empty($dParent)){
	foreach($dParent as $rParent){
		$p.='<div class="checkbox">';
		$p.='<label>';
		$p.='<input type="checkbox" name="kat[]" class="getkat" value="'.$rParent->term_id.'"/>'.$rParent->name;
		$p.='</label>';
		$p.='</div>';		
		$dChild=getCategory($rParent->term_id);
		if(!empty($dChild)){									
		foreach($dChild as $rChild){				
			$p.='<div class="checkbox">';
			$p.='<label>';
			$p.='<span style="padding-left:10px;"><input type="checkbox" name="kat[]" class="getkat" value="'.$rChild->term_id.'"/>'.$rChild->name.'</style>';
			$p.='</label>';
			$p.='</div>';
		}
		}
	}
	}
	echo $p;
  ?>
  </div>
  <input type="hidden" name="menu" value="<?=$lastmenu;?>"/>
  <div class="panel-footer">
  	<button type="submit" id="btnKategori" class="btn btn-flat btn-default">Tambah ke Menu</button>
  </div>
</div>
</div>
<?php echo form_close();?>


<?php
$at4=array(
'id'=>'entriGallery',
);
echo form_open('#',$at4);
?>
<div class="panel panel-default">
<div class="panel-heading">
  <h4 class="panel-title">
    <a data-toggle="collapse" data-parent="#accordion" href="#c4">
      Album
    </a>
  </h4>
</div>
<div id="c4" class="panel-collapse collapse">
  <div class="panel-body" style="overflow: auto;height:200px;">
  <select name="galeri" class="form-control">
  <?php
  $p='';  
  $cGaleri=$this->m_database->fetchData('album','','album_title ASC');  
	if($cGaleri > 0){
		$dGaleri=$this->m_database->fetchData('album','','album_title ASC');
	foreach($dGaleri as $rGaleri){
		?>
		<option value="<?=$rGaleri->album_id;?>"><?=$rGaleri->album_title;?></option>
		<?php
	}
	}
	echo $p;
  ?>
  </select>
  </div>
  <input type="hidden" name="menu" value="<?=$lastmenu;?>"/>
  <div class="panel-footer">
  	<button type="submit" id="btnKategori" class="btn btn-flat btn-default">Tambah ke Menu</button>
  </div>
</div>
</div>
<?php echo form_close();?>
  
  
</div>

<script>
$(document).ready(function(){
	
var h=$("#menuposition").val();	

$("#entriPage").submit(function(e){
	e.preventDefault();
	
	$.ajax({
		type:'post',
		dataType:'json',
		url:'<?=base_url(roleURIUser()."style/menus/addPage");?>',
		data:$(this).serialize(),
		beforeSend:function(){
		},
		success:function(x){
			getMenu();
		},
	});
})

$("#entriKategori").submit(function(e){
	e.preventDefault();
	
	$.ajax({
		type:'post',
		dataType:'json',
		url:'<?=base_url(roleURIUser()."style/menus/addCategory");?>',
		data:$(this).serialize(),
		beforeSend:function(){
		},
		success:function(x){
			getMenu();
		},
	});
});

$("#entriGallery").submit(function(e){
	e.preventDefault();
	
	$.ajax({
		type:'post',
		dataType:'json',
		url:'<?=base_url(roleURIUser()."style/menus/addAlbum");?>',
		data:$(this).serialize(),
		beforeSend:function(){
		},
		success:function(x){
			getMenu();
		},
	});
});

$("#entriLink").submit(function(e){
	e.preventDefault();
	
	$.ajax({
		type:'post',
		dataType:'json',
		url:'<?=base_url(roleURIUser()."style/menus/addLink");?>',
		data:$(this).serialize(),
		beforeSend:function(){
		},
		success:function(x){
			$("#linkurl").val("");
			$("#linktitle").val("");
			getMenu();
		},
	});
});

});
</script>