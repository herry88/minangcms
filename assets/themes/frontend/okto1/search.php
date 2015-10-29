<section class="blog">
<div class="row">
<div class="col-md-8">
<div class="blog-left">
<?php
if(!empty($data)){
$p=array(
'post_content LIKE'=>'%'.$data.'%',
);
$dPost=mc_allpost($p,"post_date DESC","",20);
if($dPost['jumlah'] > 0){
	echo "<h3>Data Pencarian : <i>".$data."</i></h3><hr/>";
	foreach($dPost['data'] as $rPost){
		$postID=$rPost->post_id;
		$postTitle=$rPost->post_title;
		$postContent=$rPost->post_content;
		$link=permalinkPost($postID);
		?>
		<a href="<?=$link;?>"><strong><?=$postTitle;?></strong></a><hr/>
		<?php
	}
}else{
	echo "<h3>Data Pencarian : <i>".$data."</i> Kosong</h3><hr/>";
}
}else{
	echo "Tidak ada kata kunci pencarian";
}
?>
</div>
</div>
<div class="col-md-4">
	<div class="blog-right">
		<?php include(dirname(__FILE__).'/sidebarblog.php'); ?>
	</div>
</div>
</div>
</section>