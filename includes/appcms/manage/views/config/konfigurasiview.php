<style>
.tab-pane{
	padding-top: 20px;
	padding-bottom: 20px;
}
</style>
<div class="nav-tabs-custom">
<ul class="nav nav-tabs">
  <li class="active"><a href="#tab_1" data-toggle="tab">General</a></li>
  <li><a href="#tab_2" data-toggle="tab">Publikasi</a></li>
  <li><a href="#tab_3" data-toggle="tab">Keamanan</a></li>  
</ul>
<?php
$att=array(
'class'=>'form-horizontal',
);
echo form_open(base_url(roleURIUser().'config/konfigurasi/updateconfig'),$att);
?>
<div class="tab-content">

<div class="tab-pane active" id="tab_1">

<div class="form-group">
	<label class="col-sm-2 control-label">Judul Website</label>
	<div class="col-md-7">
		<input type="text" name="sitetitle" class="form-control" value="<?=optionGet('site_title');?>"/>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label">Deskripsi Website</label>
	<div class="col-md-7">
		<input type="text" name="sitedescription" class="form-control" value="<?=optionGet('site_description');?>"/>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label">Komentar</label>
	<div class="col-md-7">
		<?php echo inputCheckbox("komen","",optionGet('site_comment'),'Aktifkan sistem Komentar');?>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label">Moderasi Komentar</label>
	<div class="col-md-7">
		<?php echo inputCheckbox("komenmoderator","",optionGet('site_comment_moderator'),'Aktifkan sistem Moderasi Komentar');?>
	</div>
</div>

</div>
<div class="tab-pane" id="tab_2">

<div class="form-group">
	<label class="col-sm-2 control-label">Tayangan Utama</label>
	<div class="col-md-7">
		<?php
		$optFrontPage=optionGet('site_frontpage');
		$fpPost="";
		$fpPage="";
		$pageDisplay="";
		if($optFrontPage=="post"){
			$fpPost='checked=""';
			$fpPage='';
			$pageDisplay='style="display:none;"';
		}elseif($optFrontPage=="page"){
			$fpPost='';
			$fpPage='checked=""';
			$pageDisplay='';
		}		
		?>
		<div class="radio">
		  <label>
		    <input type="radio" name="frontpagepost" id="hiddenpages" <?=$fpPost;?>>
		    Berita Terbaru
		  </label>
		</div>
		<div class="radio">
		  <label>
		    <input type="radio" name="frontpagepage" id="showpages" <?=$fpPage;?>>
		    Halaman
		  </label>
		</div>
		<div id="pagescombo" <?=$pageDisplay;?>>
			<select name="pagefont" class="form-control">
				<?php
				$sPost=array('post_type'=>'page','post_status'=>'publish');
				$post=getPosts($sPost,'post_title ASC');
				if($post['jumlah'] > 0){
					foreach($post['data'] as $rPost){
						?>
						<option value="<?=$rPost->post_id;?>"><?=$rPost->post_title;?></option>
						<?php
					}
				}
				?>
			</select>
		</div>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label">Jelajah Internet</label>
	<div class="col-md-7">
		<?php echo inputCheckbox("searchengine","",optionGet('site_searchengine'),'Izinkan Search Engine menjelajah website anda');?>
	</div>
</div>


</div>
<div class="tab-pane" id="tab_3">

<div class="form-group">
	<label class="col-sm-2 control-label">Bruce Force Protection</label>
	<div class="col-md-7">
		<?php echo inputCheckbox("bruceforce","",optionGet('service_login_bruceforce'),'Proteksi Login website. Antisipasi hacker akan menyusupi website anda');?>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label">Batas Login</label>
	<div class="col-md-1">
		<input type="number" name="bruceforcelimit" class="form-control" value="<?=optionGet('service_login_bruceforce_limit');?>"/>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label">Arahkan Gagal Login</label>
	<div class="col-md-7">
		<input type="url" name="bruceforcedirect" class="form-control" value="<?=optionGet('service_login_bruceforce_direct');?>"/>
	</div>
</div>
<hr/>
<h3 class="heading-a">Captcha</h3>
<?php $this->load->view('config/captchaconfig');?>

</div>

</div>
<button type="submit" class="btn btn-primary btn-flat btn-md pull-right">Simpan Konfigurasi</button>
<?php echo form_close();?>
</div>
<script>
$(document).ready(function(){
$("#showpages").change(function(){
	if(this.checked){
		$("#pagescombo").show();
	}else{
		$("#pagescombo").hide();
	}
});
$("#hiddenpages").change(function(){
	if(this.checked){
		$("#pagescombo").hide();		
	}
});
});
</script>