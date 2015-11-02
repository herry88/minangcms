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
				url:'<?=site_url(roleURIUser());?>/style/menus/reorder?menu=<?=$ismenu;?>',
				data:serialized,
				success:function(x){
					getMenu();					
				}
			});
		}
	});		
	
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
	
	///DUMP
	$('#serialize').click(function(){
			serialized = $('ol.sortable').nestedSortable('serialize');
			$('#serializeOutput').text(serialized+'\n\n');
		})

		$('#toHierarchy').click(function(e){
			hiered = $('ol.sortable').nestedSortable('toHierarchy', {startDepthCount: 0});
			hiered = dump(hiered);
			(typeof($('#toHierarchyOutput')[0].textContent) != 'undefined') ?
			$('#toHierarchyOutput')[0].textContent = hiered : $('#toHierarchyOutput')[0].innerText = hiered;
		})

		$('#toArray').click(function(e){
			arraied = $('ol.sortable').nestedSortable('toArray', {startDepthCount: 0});
			arraied = dump(arraied);
			(typeof($('#toArrayOutput')[0].textContent) != 'undefined') ?
			$('#toArrayOutput')[0].textContent = arraied : $('#toArrayOutput')[0].innerText = arraied;
		})
		
});

function dump(arr,level) {
	var dumped_text = "";
	if(!level) level = 0;

	//The padding given at the beginning of the line.
	var level_padding = "";
	for(var j=0;j<level+1;j++) level_padding += "    ";

	if(typeof(arr) == 'object') { //Array/Hashes/Objects
		for(var item in arr) {
			var value = arr[item];

			if(typeof(value) == 'object') { //If it is an array,
				dumped_text += level_padding + "'" + item + "' ...\n";
				dumped_text += dump(value,level+1);
			} else {
				dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
			}
		}
	} else { //Strings/Chars/Numbers etc.
		dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
	}
	return dumped_text;
}
	
function savePage(menuid,menuparent){	
	var pageTitle=$("#page_"+menuid).val();	
	$.ajax({
		type:'post',
		dataType:'json',
		url:'<?=base_url(roleURIUser());?>/style/menus/editpage',
		data:'title='+pageTitle+"&menu="+menuid+"&pos=<?=$ismenu;?>&parent="+menuparent,
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
		data:'title='+catTitle+"&menu="+menuid+"&pos=<?=$ismenu;?>&parent="+menuparent,
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
		data:'title='+catTitle+"&menu="+menuid+"&pos=<?=$ismenu;?>&parent="+menuparent,
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
		data:'title='+linkTitle+"&url="+linkUrl+"&menu="+menuid+"&pos=<?=$ismenu;?>&parent="+menuparent,
		success:function(){
			getMenu();
		}
	});
}
</script>
<div class="panel-group" id="accordion">
<ol class="sortable ui-sortable mjs-nestedSortable-branch mjs-nestedSortable-expanded">
<?php
echo menuOutput($ismenu);
?>
</ol>
</div>
<div id="dumpjs" style="display: none;">
<p><br />
	<input type="submit" name="serialize" id="serialize" value="Serialize" />
<pre id="serializeOutput"></pre>
</p>
<p>
	<input type="submit" name="toArray" id="toArray" value="To array" />
<pre id="toArrayOutput"></pre>
</p>
<p>
	<input type="submit" name="toHierarchy" id="toHierarchy" value="To hierarchy" />
<pre id="toHierarchyOutput"></pre>
</p>
</div>