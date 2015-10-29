<section class="homepage">
<div class="row">
<div class="col-md-8">
	<div class="homepage-left">
		<div class="slide">
		<div id="carousel-slide" class="carousel slide" data-ride="carousel">
		<div class="carousel-inner">
		<?php
		$param=array(
		'post_type'=>'post',
		);
		$dPost=mc_allpost($param,"post_date DESC","",5);
		$iSlide=0;
		if($dPost['jumlah'] > 0){
			foreach($dPost['data'] as $rPost){
				$iSlide+=1;
				$postId=$rPost->post_id;
				$postTitle=$rPost->post_title;
				$postImage=mc_imagepost($postId);
				$postLink=permalinkPost($postId);
				if($iSlide==1){
					?>
					<div class="item active">
				      <img src="<?=$postImage;?>" alt="<?=$postTitle;?>">
				      <div class="carousel-caption">
				        <a href="<?=$postLink;?>"><?=$postTitle;?></a>
				      </div>
				    </div>
					<?php
				}else{
					?>
					<div class="item">
				      <img src="<?=$postImage;?>" alt="<?=$postTitle;?>">
				      <div class="carousel-caption">
				        <a href="<?=$postLink;?>"><?=$postTitle;?></a>
				      </div>
				    </div>
					<?php
				}
			}
		}
		?>
		<a class="left carousel-control" href="#carousel-slide" data-slide="prev">
	    	<span class="glyphicon glyphicon-chevron-left"></span>
	  	</a>
	  	<a class="right carousel-control" href="#carousel-slide" data-slide="next">
	    	<span class="glyphicon glyphicon-chevron-right"></span>
	  	</a>
		</div>
		</div>
		</div>
		
		<!-- WIDGET HOMEPAGE LEFT -->
		<div class="row">		
		<div class="widget">
		<?php
		$divider='col-md-6';
		echo mc_get_sidebar_item("okto1","homepageleft",$divider);
		?>		
		</div>
		</div>
		<!-- END WIDGET HOMEPAGE LEFT -->
	</div>
</div>
<div class="col-md-4">
	<div class="homepage-right">
		<?php include(dirname(__FILE__).'/sidebarhomepage.php'); ?>
	</div>
</div>
</div>
</section>