<div class="row">
<div class="col-md-4">
	<label>Pilih Menu</label>
	<select name="menu" class="form-control" onchange="window.location='<?=base_url(roleURIUser().'style/menus?open=');?>'+this.value">
		<?php
		$lastmenu=$this->input->get('open');
		$lastmenu=isset($lastmenu) ? $lastmenu : "top";
		if($lastmenu=="top"){
			?>
			<option value="top">Menu Atas</option>
			<option value="bottom">Menu Bawah</option>
			<?php
		}elseif($lastmenu=="bottom"){
			?>
			<option value="bottom">Menu Bawah</option>
			<option value="top">Menu Atas</option>		
			<?php
		}else{
			?>
			<option value="bottom">Menu Bawah</option>
			<option value="top">Menu Atas</option>
			<?php
		}
		?>		
	</select>
</div>
<input type="hidden" name="menuposition" id="menuposition" value="<?=$lastmenu;?>"/>
<div class="col-md-8">
	Menu Atas dan Menu Bawah disesuaikan dengan template. Jadi, menu atas dan menu bawah belum tentu berada pada posisi atas atau bawah (dapat disesuaikan). <br> <strong class="text-danger">(*) Gunakan custom link jika menu mempunyai item baru</strong>
</div>
</div>
<p>&nbsp;</p>
<div class="row">
<div class="col-md-4">
	<?php $this->load->view('style/menu/sidebartool');?>
</div>
<div class="col-md-8" id="menuloader" style="display: none;overflow: auto;">
	
</div>
</div>
<script>
function getMenu(){
	$.ajax({
		type:'get',
		dataType:'html',
		url:'<?=base_url(roleURIUser()."style/menus/getmenu");?>',
		data:'menu=<?=$lastmenu;?>',
		beforeSend:function(){			
		},
		success:function(x){			
			$("#menuloader").html(x);
			$("#menuloader").show("fade");
		},
	});
}
$(document).ready(function(){
setTimeout(function(){getMenu();},10)
});
</script>