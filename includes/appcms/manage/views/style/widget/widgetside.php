<?php
$themeFront=optionGet('theme_front');
$sidebar=getTerms('sidebar');
?>
<label>Pilih Widget</label>
<select name="widget" id="widget" class="form-control">
<option value="">-Posisi Widget-</option>
<?php
foreach($sidebar as $rside){
if(stristr($rside->name,$themeFront."_sidebar")==TRUE){		
	$ex=explode("_",$rside->name);
	$termid=$rside->term_id;
	?>
	<option value="<?=$ex[2].":".$termid;?>"><?=ucfirst($ex[2]);?></option>
	<?php
}
}
?>
</select>
<p>&nbsp;</p>
<div id="widgetloader"></div>
<script>
$(document).ready(function(){
$("#widget").change(function(){
	getWidget();
});

});

function getWidget(){
	var i=$("#widget").val();
	if(i!=''){
		$.ajax({
			type:'get',
			dataType:'html',
			url:'<?=base_url(roleURIUser());?>/style/widgets/loaderitem',
			data:'pos='+i,
			success:function(x){
				$("#widgetloader").html(x);
			},
		});
	}
}
</script>