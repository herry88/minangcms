<li><a href="<?=base_url();?>" target="_blank"><i class="fa fa-globe"></i><span>Kunjungi Web</span></a></li>
<li class="treeview <?=menuActive("content","posts");?>">
    <a href="#"><i class="fa fa-newspaper-o"></i> <span>Berita</span> <i class="fa fa-angle-left pull-right"></i></a>
    <ul class="treeview-menu">
        <li><a href="<?=base_url(roleURIUser().'content/posts');?>"><i class="fa fa-circle-o"></i> <?=langGet("menu","menu_news_all");?></a></li>
        <li><a href="<?=base_url(roleURIUser().'content/posts/add');?>"><i class="fa fa-circle-o"></i> <?=langGet("menu","menu_news_add");?></a></li>
        <li><a href="<?=base_url(roleURIUser().'content/category');?>"><i class="fa fa-circle-o"></i> <?=langGet("menu","menu_news_category");?></a></li>
        <li><a href="<?=base_url(roleURIUser().'content/tags');?>"><i class="fa fa-circle-o"></i> <?=langGet("menu","menu_news_tags");?></a></li>
    </ul>
</li>


<?php
if(roleUser()=="mimin"){
	include dirname(__FILE__).'/'.'navadmin.php';
}elseif(roleUser()=="editor"){
	include dirname(__FILE__).'/'.'naveditor.php';
}elseif(roleUser()=="op"){
	include dirname(__FILE__).'/'.'navop.php';
}
?>