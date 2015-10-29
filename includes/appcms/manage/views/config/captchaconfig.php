<?php
echo incCSS(locationPlugin('url').'toggles/dist/css/bootstrap3/bootstrap-switch.min');
echo incJS(locationPlugin('url').'toggles/dist/js/bootstrap-switch.min');
?>
<script>
$(document).ready(function(){
$("[name='service']").bootstrapSwitch();
$('input[name="service"]').on('switchChange.bootstrapSwitch', function(event, state) {
  if(state==true){
  	$("#laststate").val("1");
  	$("#option").show();
  }else{
  	$("#laststate").val("0");
  	$("#option").hide();
  }
});

$("#tipe").change(function(){
	var id=$(this).val();
	$.ajax({
		type:'get',
		dataType:'html',
		url:'<?=base_url(roleURIUser()."/config/captcha/showconfig");?>',
		data:'tipe='+id,
		beforeSend:function(){
			$("#config").hide();
			$("#loader").show();
		},
		success:function(x){
			$("#config").html(x);
			$("#config").show();
			$("#loader").hide();
		},
	});
});

});
</script>
<?php
$csv='';
$service=optionGet('captcha_enable');
$optvis='';
$type=optionGet('captcha_type');
if($service=="0"){
	$csv="";
	$optvis='display:none;';
}else{
	$csv="checked";
	$optvis='';
}
?>
<input type="hidden" name="lasttipe" id="lasttipe" value="<?=$type;?>"/>
<input type="hidden" name="laststate" id="laststate" value="<?=$service;?>"/>
<div class="form-group">
	<label class="col-sm-2 control-label">Captcha Service</label>
	<div class="col-md-4">
		<input type="checkbox" name="service" id="service" <?=$csv;?>/>
	</div>
</div>
<div id="option" style="<?=$optvis;?>">
	<div class="form-group">
		<label class="col-sm-2 control-label">Type</label>
		<div class="col-md-4">
			<select name="tipe" id="tipe" class="form-control">
			<option value="<?=$type;?>"><?=ucfirst($type);?></option>
			<option disabled="">-</option>
			<?php
			$path=scandir(MODPATH.'service/libraries/captcha');
			$dpath=array_diff($path, array('.', '..'));
			$prefix="_captcha.php";
			foreach($dpath as $key=>$val)
	        {
	        	$val=strtolower(str_replace($prefix,"",$val));
		        $label=ucfirst(str_replace($prefix,"",$val));
	        	if(!is_dir(MODPATH.'service/libraries/captcha/'.$val)){					
		            echo '<option value="'.$val.'">'.$label.'</option>';
				}	        	
	        }
			?>
			</select>
		</div>
	</div>
	<?php
	if(!empty($type) && $service=="1"){
		?>
		<div id="config">
			<?php
			$this->load->view('service/login/captcha/'.$type.'/configview');
			?>
		</div>
		<?php
	}else{
		?>
		<div id="config" style="display: none;"></div>
		<?php
	}
	?>
	
</div>
<div class="form-group" id="loader" style="display: none;">
	<label class="col-sm-2 control-label">&nbsp;</label>
	<div class="col-md-4">
		<img src="<?=locationUpload('url');?>ajax-loader.gif"/>
	</div>
</div>