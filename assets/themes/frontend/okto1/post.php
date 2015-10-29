<section class="blog">
<div class="row">
<div class="col-md-8">
	<div class="blog-left">
	<?php
	$param=$data;
	$dPost=mc_allpost($param,'post_date DESC','',1);
	if($dPost['jumlah'] > 0){
		foreach($dPost['data'] as $rPost){			
		}
		$postID=$rPost->post_id;
		$postTitle=$rPost->post_title;
		$postContent=$rPost->post_content;
	}	
	?>
	<h3><?=$postTitle;?></h3><hr/>
	<p><?=$postContent;?></p>
	<?=mc_commentPost($postID);?>
	</div>
</div>
<div class="col-md-4">
	<div class="blog-right">
		<?php include(dirname(__FILE__).'/sidebarblog.php'); ?>
	</div>
</div>
</div>
</section>