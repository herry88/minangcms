<?php
echo incCSS(locationPlugin().'tags/jquery-tag-this');
echo incCSS(locationPlugin().'jqueryui/jquery-ui.min');
echo incCSS(locationPlugin().'tags/jquery-ui-1.9.2.custom.min');

echo incJS(locationPlugin().'jqueryui/jquery-ui.min');
echo incJS(locationPlugin().'tags/jquery-ui-1.9.2.custom.min');
echo incJS(locationPlugin().'tags/jquery.tagthis');

echo incCSS(locationPlugin().'timepicker/bootstrap-timepicker.min');
echo incJS(locationPlugin().'timepicker/bootstrap-timepicker.min');
?>

<script>
$(document).ready(function(){

$(".timepicker").timepicker({  
  secondStep: false,
  showMeridian:false,
  showInputs: false
});

$("#triggertimer").click(function(){
	$(".timepicker").trigger("focus");
});

$(".tanggal").datepicker({
	dateFormat: "yy-mm-dd",
	showAnim:"slide",
	changeMonth: true,
	changeYear: true,
	yearRange:'c-2:c+1',
});

$("#tritgl").click(function(){
	$("#tanggal").focus();
});

$("#tritgl2").click(function(){
	$("#tanggal2").focus();
});

$('#tags').tagThis({
    noDuplicates: true,
    defaultText : 'tulis tags',
    autocompleteSource :'<?=base_url(roleURIUser()."content/posts/tagscomplete");?>',
    callbacks: {
	    onChange : getTags
	}
});

$("#formentri").submit(function(){
	var tagField = $('#tags').data('tag');
	var tagd=JSON.stringify(tagField);
	$("#tagsdata").text(tagd);
	return true;
});

function getTags(){
	var tagField = $('#tags').data('tags');
	var tagd=JSON.stringify(tagField);
	$("#tagsdata").text(tagd);
}

$("#remFeature").click(function(){
	$("#featureimage").val("");
	$("#imgfeature").attr('src','');
	$("#imgfeature").hide();
	$("#addFeature").show();
	$(this).hide();
});

});
</script>
<style type="text/css">
#kcfinder_div {
    display: none;
    position: absolute;
    width: 670px;
    height: 400px;
    background: #e0dfde;
    border: 2px solid #3687e2;
    border-radius: 6px;
    -moz-border-radius: 6px;
    -webkit-border-radius: 6px;
    padding: 1px;
    z-index: 1;
}
</style>
<script type="text/javascript">
function openKCFinder(field) {
    var div = document.getElementById('kcfinder_div');
    if (div.style.display == "block") {
        div.style.display = 'none';
        div.innerHTML = '';
        return;
    }
    window.KCFinder = {
        callBack: function(url) {
            window.KCFinder = null;
            //field.value = url;
            $("#"+field).val(url);
            $("#imgfeature").attr('src','<?=urlApp();?>'+url);
            $("#imgfeature").show();
            $("#remFeature").show();
            div.style.display = 'none';
            div.innerHTML = '';
            if(url!=''){
				$("#addFeature").hide();
			}
        }
    };
    div.innerHTML = '<iframe name="kcfinder_iframe" src="<?=locationPlugin("url")."kcfinder";?>/browse.php?type=images&dir=assets/uploads/" ' +
        'frameborder="0" width="100%" height="100%" marginwidth="0" marginheight="0" scrolling="no" />';
    div.style.display = 'block';
}
</script>
<div class="box box-primary collapsed-box">
<div class="box-header with-border">
  <h5 class="box-title">Publikasi</h5>
  <div class="box-tools pull-right">
    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
  </div>
</div>
<div class="box-body">
  <div class="col-xs-8">
  <label for="tanggal">Tanggal Publikasi</label>
  <div class="input-group">
  <?php
  $lastTanggal='';
  $valTanggal=set_value('tanggal');
  if(!empty($valTanggal)){
  	$lastTanggal=set_value('tanggal');
  }else{
  	$lastTanggal=dateNow();
  }
  ?>
  <input type="text" name="tanggal" class="form-control tanggal" id="tanggal" readonly="" required="" value="<?=$lastTanggal;?>"/>
  <span class="input-group-btn">
        <button class="btn btn-default" type="button" id="tritgl"><i class="fa fa-calendar"></i></button>
  </span>
  </div>
  </div>  
  <hr/>
  <div class="col-md-12">
		<label>Status</label>
		<div class="radio">
			<label class="radio-inline">
			<input type="radio" name="statpublish" value="publish" checked=""/> Publikasi sekarang
			</label>
			<label class="radio-inline">
			<input type="radio" name="statpublish" value="draft"/> Draft
			</label>			
		</div>
	</div>
</div>
</div>


<?php
if($tipe=="event"){
?>
<div class="box box-primary">
<div class="box-header with-border">
  <h5 class="box-title">Info Event</h5>
  <div class="box-tools pull-right">
    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
  </div>
</div>
<div class="box-body" >
<div class="col-xs-8">
  <label>Tanggal Event</label>
  <div class="input-group">
  <?php
  $lastTanggal2='';
  $valTanggal2=set_value('tanggalevent');
  if(!empty($valTanggal2)){
  	$lastTanggal2=set_value('tanggalevent');
  }else{
  	$lastTanggal2=dateNow();
  }
  
  $lastTanggal3='';
  $valTanggal3=set_value('jamevent');
  if(!empty($valTanggal3)){
  	$lastTanggal3=set_value('jamevent');
  }else{
  	$lastTanggal3=date("H:i");
  }
  ?>
  <input type="text" name="tanggalevent" class="form-control tanggal" id="tanggal2" readonly="" required="" value="<?=$lastTanggal2;?>"/>  
  <span class="input-group-btn">
        <button class="btn btn-default" type="button" id="tritgl2"><i class="fa fa-calendar"></i></button>
  </span>
  </div>
    
  </div>
  
  <div class="col-md-6">
  <label>Jam Event</label>
<div class="bootstrap-timepicker">
<div class="input-group">
<input type="text" name="jamevent" class="form-control timepicker" required="" value="<?=$lastTanggal3;?>" placeholder="10:00"/>
<div class="input-group-btn">
  <button type="button" class="btn btn-default" id="triggertimer"><i class="fa fa-clock-o"></i></button>
</div>
</div>
</div>
</div>
  
  
</div>
</div>
<?php } ?>

<?php
if($tipe=="post"){
?>
<div class="box box-primary">
<div class="box-header with-border">
  <h5 class="box-title">Kategori</h5>
  <div class="box-tools pull-right">
    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
  </div>
</div>
<div class="box-body" style="overflow: auto;height:200px;">
  <?php
  $p='';
  $dParent=getCategory();		
	if(!empty($dParent)){
	foreach($dParent as $rParent){
		$p.='<div class="checkbox">';
		$p.='<label>';
		$p.='<input type="checkbox" name="kat[]" value="'.$rParent->term_id.'"/>'.$rParent->name;
		$p.='</label>';
		$p.='</div>';		
		$dChild=getCategory($rParent->term_id);
		if(!empty($dChild)){									
		foreach($dChild as $rChild){
			$p.='<div class="checkbox">';
			$p.='<label>';
			$p.='<span style="padding-left:10px;"><input type="checkbox" name="kat[]" value="'.$rChild->term_id.'"/>'.$rChild->name.'</style>';
			$p.='</label>';
			$p.='</div>';
		}
		}
	}
	}
	echo $p;
  ?>
</div>
</div>
<?php } ?>


<div class="box box-primary">
<div class="box-header with-border">
  <h5 class="box-title">Tags</h5>
  <div class="box-tools pull-right">
    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
  </div>
</div>
<div class="box-body">
  <input type="text" name="tags" id="tags"/>
  <textarea name="tagsdata" id="tagsdata" style="display: none;"></textarea>
</div>
</div>

<?php
if($tipe=="post"){
?>
<div class="box box-primary">
<div class="box-header with-border">
  <h5 class="box-title">Feature Image</h5>  
  <div class="box-tools pull-right">
    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
  </div>
</div>
<div class="box-body">
  <img src="" id="imgfeature" class="thumbnail img-responsive" style="height: 300px;display: none;"/>
  <a href="javascript:;" onclick="openKCFinder('featureimage')" id="addFeature">Set Feature Image</a>
  <a href="javascript:;" id="remFeature" style="display: none;">Remove Feature Image</a>
  <input type="hidden" name="featureimage" id="featureimage"/>  
</div>
<div class="box-footer">
	<small class="text-warning">Jika menampilkan gambar custom pada daftar berita. Beberap template nantinya membutuhkan feature image, kalau kosong maka akan ditampilkan gambar pertama dari berita atau "no image"</small>
</div>
</div>
<?php } ?>