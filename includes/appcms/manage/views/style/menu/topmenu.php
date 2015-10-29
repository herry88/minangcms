<?php
echo incCSS(locationPlugin().'jqueryui/jquery-ui.min');
echo incJS(locationPlugin().'jqueryui/jquery-ui.min');
echo incJS(locationAsset('url').'js/nestedmenu');
echo incCSS(locationAsset().'css/nestedmenu');
?>
<script>
$(document).ready(function(){
    var ns = $('ol.sortable').nestedSortable({
		forcePlaceholderSize: true,
		handle: 'div',
		helper:	'clone',
		items: 'li',
		opacity: .6,
		placeholder: 'placeholder',
		revert: 250,
		tabSize: 25,
		tolerance: 'pointer',
		toleranceElement: '> div',
		maxLevels: 3,
		isTree: true,
		expandOnHover: 700,
		startCollapsed: false,
		update: function(){			
			serialized = $('ol.sortable').nestedSortable('serialize');
			$.ajax({
				type:"post",
				dataType:"json",
				url:'<?=site_url(roleURIUser());?>/style/menus/reorder?menu=top',
				data:serialized,
				success:function(x){
					getMenu();					
				}
			});
		}
	});	
	$('#serialize').click(function(){
		serialized = $('ol.sortable').nestedSortable('serialize');
		$('#serializeOutput').html(serialized+'\n\n');
	})
	
	$(".menudelete").each(function(){
		$(this).click(function(){
			var did=$(this).attr('data-id');
			$.ajax({
				type:'post',
				dataType:'json',
				url:'<?=base_url(roleURIUser());?>/style/menus/delete',
				data:'id='+did,
				success:function(x){
					getMenu();
				}
			});
		});
	});
	
	$(".menusave").each(function(){
		$(this).click(function(){
			var menu=$(this).attr('data-menu');
			var menuid=$(this).attr('data-id');
			var menuparent=$(this).attr('data-parent');
			if(menu=="page"){				
				savePage(menuid,menuparent);
			}else if(menu=="link"){
				saveLink(menuid,menuparent);
			}else if(menu=="category"){
				saveCategory(menuid,menuparent);
			}else if(menu=="gallery"){
				saveGallery(menuid,menuparent);			
			}else{
				return false;
			}
		});
	});
	
	
		
});
function savePage(menuid,menuparent){	
	var pageTitle=$("#page_"+menuid).val();	
	$.ajax({
		type:'post',
		dataType:'json',
		url:'<?=base_url(roleURIUser());?>/style/menus/editpage',
		data:'title='+pageTitle+"&menu="+menuid+"&pos=top&parent="+menuparent,
		success:function(){
			getMenu();
		}
	});
}

function saveCategory(menuid,menuparent){	
	var catTitle=$("#category_"+menuid).val();	
	$.ajax({
		type:'post',
		dataType:'json',
		url:'<?=base_url(roleURIUser());?>/style/menus/editcategory',
		data:'title='+catTitle+"&menu="+menuid+"&pos=top&parent="+menuparent,
		success:function(){
			getMenu();
		}
	});
}

function saveGallery(menuid,menuparent){	
	var catTitle=$("#gallery_"+menuid).val();	
	$.ajax({
		type:'post',
		dataType:'json',
		url:'<?=base_url(roleURIUser());?>/style/menus/editalbum',
		data:'title='+catTitle+"&menu="+menuid+"&pos=top&parent="+menuparent,
		success:function(){
			getMenu();
		}
	});
}

function saveLink(menuid,menuparent){	
	var linkUrl=$("#linkurl_"+menuid).val();	
	var linkTitle=$("#linktitle_"+menuid).val();	
	$.ajax({
		type:'post',
		dataType:'json',
		url:'<?=base_url(roleURIUser());?>/style/menus/editlink',
		data:'title='+linkTitle+"&url="+linkUrl+"&menu="+menuid+"&pos=top&parent="+menuparent,
		success:function(){
			getMenu();
		}
	});
}
</script>
<div class="panel-group" id="accordion">
<ol class="sortable ui-sortable mjs-nestedSortable-branch mjs-nestedSortable-expanded">
<?php
echo menuOutput("top");
?>
</ol>
</div>