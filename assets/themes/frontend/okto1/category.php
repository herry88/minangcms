<section class="blog">
<div class="row">
<div class="col-md-8">
	<?php	
	$dPost=mc_postCategory($data,"post_date DESC",10);
	if(count($dPost) > 0){
		foreach($dPost as $rPost){
			$postID=$rPost->post_id;
			$postTitle=$rPost->post_title;
			$postContent=$rPost->post_content;			
			?>
			<h3><?=$postTitle;?></h3><hr/>
			<p><?=$postContent;?></p>	
			<?php
		}
	}
	?>	
</div>
<div class="col-md-4">
	<div class="blog-right">
		<?php include(dirname(__FILE__).'/sidebarblog.php'); ?>
	</div>
</div>
</div>
</section>