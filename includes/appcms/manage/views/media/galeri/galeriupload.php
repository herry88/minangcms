<?php
echo incCSS(locationPlugin('url').'pretty/css/prettyPhoto');
echo incJS(locationAsset('url').'js/lazyload');
echo incJS(locationPlugin('url').'pretty/js/jquery.prettyPhoto');

echo incCSS(locationPlugin('url').'datatables/dataTables.bootstrap');
echo incCSS(locationPlugin('url').'datatables/extensions/responsive/css/dataTables.responsive');
echo incJS(locationPlugin('url').'datatables/jquery.dataTables');
echo incJS(locationPlugin('url').'datatables/dataTables.bootstrap');
echo incJS(locationPlugin('url').'datatables/extensions/responsive/js/dataTables.responsive');
?>
<script>
$(document).ready(function(){
$("img.lazy").lazyload();
$("a[rel^='prettyPhoto']").prettyPhoto({
	social_tools:'',
});

$('.data-render').dataTable({
    "sPaginationType": "full_numbers",
    "iDisplayLength": 10,
    "oLanguage": {
        "sLengthMenu": "<span class='lenghtMenu'> _MENU_</span><span class='lengthLabel'>Entries per page:</span>",
    },
    "sDom": '<"tbl-searchbox clearfix"fl<"clear">>,<"table_content"t>,<"widget-bottom"p<"clear">>'

});
$("div.tbl-searchbox select").addClass('tbl_length');

});
</script>
<?php
foreach($data as $row){	
}
$galleryID=$row->gallery_id;

$att=array(
'class'=>'form-horizontal',
);
echo form_open_multipart(base_url(roleURIUser().'media/gallery/uploadimages'),$att);
$slug=stringCreateSlug($row->gallery_title);
?>
<input type="hidden" name="galleryid" value="<?=$galleryID;?>"/>
<input type="hidden" name="galleryslug" value="<?=$slug;?>"/>
<div class="form-group">
	<label class="col-sm-2 control-label">Tambah File</label>
	<div class="col-md-5">
		<input type="file" name="photo" class="form-control" required=""/>
		<small>Extension Allow : <?php echo "jpeg|jpg|png|jpe|bmp|gif";?></small><br/>
		<small>Limit upload file : <?php echo (int)(ini_get('upload_max_filesize'));?> MB</small>
	</div>
</div>
		<input type="hidden" name="altinfo" class="form-control"/>	
<div class="form-group">
	<label class="col-sm-2 control-label">&nbsp;</label>
	<div class="col-md-5">
		<button type="submit" class="btn btn-primary btn-flat">Tambah</button>
	</div>
</div>

<?php
echo form_close();
?>

<div class="col-md-12">
<div class="panel panel-default">
<div class="panel-body">
<table class="table table-bordered table-hover data-render">
<thead>
	<th>File</th>
	<th>Tanggal</th>
	<th>Alt</th>
	<th>Tipe</th>
	<th>#</th>
</thead>
<tbody>
<?php
$s=array(
'gallery_id'=>$galleryID,
);
$c=$this->m_database->countData('gallery_images',$s);
if($c > 0){
	$d=$this->m_database->fetchData('gallery_images',$s,'gallery_date DESC');
	foreach($d as $r){
		$slugFolder=stringCreateSlug($row->gallery_title);
		$path=locationUpload('url').'gallery/'.$slugFolder.'/'.$r->gallery_file;
		$pathX=locationUpload('path').'gallery/'.$slugFolder.'/'.$r->gallery_file;		
		$url=locationUpload('url').'gallery/'.$slugFolder.'/thumbs/64/'.$r->gallery_file;
		?>
		<tr>
			<td width="64px">
			<a href="<?=$path;?>" rel="prettyPhoto[<?=$r->gallery_images_id;?>]">
			<img class="lazy" data-original="<?=$url;?>" style="height: 64px;width:64px;"/>
			</a>
			</td>
			<td width="120px"><?=$r->gallery_date;?></td>
			<td><?=$r->gallery_alt;?></td>
			<td width="120px"><?=$r->gallery_mime;?></td>
			<td width="64px">
				<a onclick="return confirm('Yakin ingin menghapus file ini?');" href="<?=base_url(roleURIUser()).'/media/gallery/deletefile';?>?id=<?=$r->gallery_images_id;?>&gallery=<?=$row->gallery_id;?>" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></a>
			</td>
		</tr>
		<?php
	}
}
?>
</tbody>
</table>
</div>
</div>
</div>