<section class="blog">
<div class="row">
<div class="col-md-8">
	<div class="row">
	<?php	
	$dGallery=mc_gallery($data);
	foreach($dGallery as $rGallery){
		$thumb=$rGallery['image_file_thumb'];
		$ff=$rGallery['image_file'];
		?>
		<div class="col-xs-6 col-md-3">
	    <a href="<?=$ff;?>" class="thumbnail">
	      <img src="<?=$thumb;?>">
	    </a>
	  	</div>
		<?php
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