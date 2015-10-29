<?php
echo incCSS(locationPlugin('url').'datatables/dataTables.bootstrap');
echo incCSS(locationPlugin('url').'datatables/extensions/responsive/css/dataTables.responsive');
echo incJS(locationPlugin('url').'datatables/jquery.dataTables');
echo incJS(locationPlugin('url').'datatables/dataTables.bootstrap');
echo incJS(locationPlugin('url').'datatables/extensions/responsive/js/dataTables.responsive');
?>
<script>
$(document).ready(function(){
	
$('.data-render').dataTable({
    "sPaginationType": "full_numbers",
    "iDisplayLength": 10,
    "oLanguage": {
        "sLengthMenu": "<span class='lenghtMenu'> _MENU_</span><span class='lengthLabel'>Entries per page:</span>",
    },
    "sDom": '<"tbl-searchbox clearfix"fl<"clear">>,<"table_content"t>,<"widget-bottom"p<"clear">>'

});
$("div.tbl-searchbox select").addClass('tbl_length');

$(".editbtn").each(function(){
	$(this).click(function(){
		var did=$(this).attr('data-id');
		$.ajax({
			type:'get',
			dataType:'html',
			url:'<?=base_url(roleURIUser()."content/category/edit");?>',
			data:"id="+did,
			beforeSend:function(){
				$("#myModal").modal("show");
				$(".modal-body").html("loading...");
			},
			success:function(x){
				$(".modal-body").html(x);
			}
		});
	});
});


});
</script>
<table class="table table-bordered table-hover data-render">
<thead>
	<th>
		#
	</th>
	<th>Nama</th>
	<th>Deskripsi</th>
	<th>Slug</th>
</thead>
<tbody>
<?php
$dParentView=getCategory('0','term_id ASC');
if(!empty($dParentView)){
	foreach($dParentView as $rParentView){
		?>
		<tr>
			<td>
				<?php
				if($rParentView->term_id!='1'){
					?>
					<a data-id="<?=$rParentView->term_id;?>" href="javascript:;" class="btn btn-xs btn-info editbtn"><i class="fa fa-edit"></i></a>
					<a href="<?=base_url(roleURIUser());?>/content/category/delete?id=<?=$rParentView->term_id;?>" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
					<?php
				}
				?>				
			</td>
			<td><?=$rParentView->name;?></td>
			<td><?=getCategoryDescription($rParentView->term_id);?></td>
			<td><?=$rParentView->slug;?></td>			
		</tr>
		<?php
		$dChildView=getCategory($rParentView->term_id);
		if(!empty($dChildView)){					
		foreach($dChildView as $rChildView){
			?>
			<tr>
				<td>
					<a data-id="<?=$rChildView->term_id;?>" href="javascript:;" class="btn btn-xs btn-info editbtn"><i class="fa fa-edit"></i></a>
					<a href="<?=base_url(roleURIUser());?>/content/category/delete?id=<?=$rChildView->term_id;?>" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
				</td>
				<td>&#8212; <?=$rChildView->name;?></td>
				<td><?=getCategoryDescription($rChildView->term_id);?></td>
				<td><?=$rChildView->slug;?></td>				
			</tr>
			<?php
		}
		}
	}
}
?>
</tbody>
</table>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Edit Kategori</h4>
      </div>
      <div class="modal-body">        
      </div>      
    </div>
  </div>
</div>