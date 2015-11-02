<div class="row">
<div class="box box-info">
<div class="box-body">
	<h3>Selamat Datang di MinangCMS <br/><small>Kami akan membantu anda untuk memulai menggunakannya</small></h3>
	<div class="row">
		<div class="col-md-4">
			<h3>Dimulai</h3><br/>
			<a href="<?=base_url(roleURIUser().'style/templates');?>" class="btn btn-md btn-primary btn-flat">Pilih Tema</a><br/><br/>
			<a href="#" class="btn btn-default btn-md btn-flat">Tata Cara Penggunaan Online</a>
		</div>
		<div class="col-md-4">
			<h3>Langkah Lanjut</h3>
			<ul class="dashboard-step">
				<li><a href="<?=base_url(roleURIUser().'content/posts/add');?>"><i class="fa fa-edit"></i> Tambah Berita</a></li>
				<li><a href="<?=base_url(roleURIUser().'content/pages/add');?>"><i class="fa fa-file-o"></i> Tambah Halaman</a></li>
				<li><a href="<?=base_url();?>" target="_blank"><i class="fa fa-globe"></i> Lihat Website</a></li>				
			</ul>
		</div>
		<div class="col-md-4">
			<h3>Utiliti</h3>
			<ul class="dashboard-step">
				<li><a href="<?=base_url(roleURIUser().'style/widgets');?>"><i class="fa fa-cubes"></i> Lihat Widget</a></li>
				<li><a href="<?=base_url(roleURIUser().'style/menus');?>"><i class="fa fa-reorder"></i> Lihat Menu</a></li>
				<li><a href="<?=base_url(roleURIUser().'config/konfigurasi');?>"><i class="fa fa-wrench"></i> Konfigurasi</a></li>
			</ul>
		</div>
	</div>
</div>
</div>
</div>

<div class="row">
<div class="col-md-6">
	<div class="box box-default">
    <div class="box-header with-border">
      <h3 class="box-title">Statistik</h3>
      <div class="box-tools pull-right">
        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
    </div>
    <div class="box-body">
      <ul class="dashboard-step">
      	<?php      	
      	$postCount=dbCount('posts',array('post_type'=>'post'));
      	$pageCount=dbCount('posts',array('post_type'=>'page'));
      	$eventCount=dbCount('posts',array('post_type'=>'event'));
      	?>
      	<li><i class="fa fa-newspaper-o"></i> <?=$postCount;?> <a href="<?=base_url(roleURIUser().'content/posts');?>"> Berita </a></li>
      	<li><i class="fa fa-file-o"></i> <?=$pageCount;?> <a href="<?=base_url(roleURIUser().'content/pages');?>"> Halaman </a></li>
      	<li><i class="fa fa-calendar-o"></i> <?=$eventCount;?> <a href="<?=base_url(roleURIUser().'content/event');?>"> Event </a></li>
      </ul>
    </div>
  	</div>
</div>
<div class="col-md-6">
<?php echo form_open(base_url(roleURIUser()).'/content/posts/adddraft');?>
	<div class="box box-default">
    <div class="box-header with-border">
      <h3 class="box-title">Quick Draft</h3>
      <div class="box-tools pull-right">
        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
    </div>
    <div class="box-body">      
      <input type="text" name="title" class="form-control" placeholder="Judul"/><br/>
      <textarea name="konten" class="form-control" rows="3" placeholder="Ketik Apapun disini"></textarea>      
    </div>
    <div class="box-footer">
    	<button type="submit" class="btn btn-primary btn-flat">Simpan Draft</button>
    </div>
  	</div>
<?php echo form_close();?>
</div>
</div>
<div class="row">
<div class="col-md-6">
<div class="box box-default">
<div class="box-header with-border">
  <h3 class="box-title">Developer Info</h3>
  <div class="box-tools pull-right">
    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
  </div>
</div>
<div class="box-body">      
  <ul class="dashboard-step">
  	<li><a href="https://github.com/urangawak/minangcms" target="_blank" class="btn btn-default btn-lg btn-flat"><i class="fa fa-github-alt"></i> Github Repository</a></li>
  	<li><a href="#" class="btn btn-default btn-lg btn-flat"><i class="fa fa-book"></i> Developer Reference</a></li>
  </ul>
</div>
</div>
</div>
<div class="col-md-6">
<div class="box box-default">
<div class="box-header with-border">
  <h3 class="box-title">Minang CMS News</h3>
  <div class="box-tools pull-right">
    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
  </div>
</div>
<div class="box-body">      
  <div id="rssfeed" style="overflow: auto;height:300px;"></div>
</div>
<div class="overlay" style="display: none;"><li class="fa fa-spinner fa-spin fa-5x"></li></div>
</div>
</div>
</div>
<script>
$(document).ready(function(){

setTimeout(function(){getFeed();},10)

});

function getFeed(){
	$.ajax({
		type:'get',
		dataType:'html',
		url:"<?=base_url(roleURIUser().'dashboard/getfeed');?>",
		data:'v=1',
		beforeSend:function(){
			$(".overlay").show();
		},
		success:function(x){
			$("#rssfeed").html(x);
			$(".overlay").hide();
		},
	});
}
</script>
