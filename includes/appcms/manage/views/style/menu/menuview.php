<?php
$themeActive=optionGet('theme_front');
?>
<div class="row">
<div class="col-md-4">
	<label>Pilih Menu</label>
	<select name="menu" class="form-control" id="menu">
		<?php
		$lastmenu=$this->input->get('open');
		if(!empty($lastmenu)){
			?>
			<option value="<?=$lastmenu;?>"><?=ucfirst($lastmenu);?></option>
			<?php
		}
		?>
		<option value="">-Pilih Menu-</option>
		<?php
		$lastmenu=$this->input->get('open');
		$s=array(
		'name LIKE '=>$themeActive."_theme_menu%",
		);
		$d=$this->m_database->fetchData('terms',$s);
		foreach($d as $r){
			$prefix=$themeActive."_theme_menu_";
			$sanit=str_replace($prefix,"",$r->name);
			$val=strtolower($sanit);
			$label=ucfirst($sanit);
			?>
			<option value="<?=$val;?>"><?=$label;?></option>
			<?php
		}
		?>		
	</select>
</div>
<input type="hidden" name="menuposition" id="menuposition" value="<?=$lastmenu;?>"/>
<div class="col-md-8">
	Posisi menu sama dengan posisi yang dikonfigurasikan pada tema aktif <b><?=ucfirst($themeActive);?></b>
</div>
</div>
<p>&nbsp;</p>
<div class="row">
<div class="col-md-4">
	<?php $this->load->view('style/menu/sidebartool');?>
</div>
<div class="col-md-8" id="menuloader" style="display: none;">
	
</div>
</div>
<script>
function getMenu(){
	var m=$("#menu").val();
	if(m!=''){
		$.ajax({
			type:'get',
			dataType:'html',
			url:'<?=base_url(roleURIUser()."style/menus/getmenu");?>',
			data:'menu='+m,
			beforeSend:function(){			
			},
			success:function(x){			
				$("#menuloader").html(x);
				$("#menuloader").show("fade");
				$(".globalpos").val(m);
			},
		});
	}else{
		$(".globalpos").val("");
		return false;
	}
}
$(document).ready(function(){

$("#menu").change(function(){
	getMenu();
});

setTimeout(function(){$("#menu").trigger("change");},10);

});
</script>