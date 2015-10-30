<li class="treeview <?=menuActive("media");?>">
    <a href="#"><i class="fa fa-picture-o"></i> <span>Galeri Album</span> <i class="fa fa-angle-left pull-right"></i></a>
    <ul class="treeview-menu">
        <li><a href="<?=base_url(roleURIUser().'media/album');?>"><i class="fa fa-circle-o"></i> Semua Album</a></li>
        <li><a href="<?=base_url(roleURIUser().'media/album/add');?>"><i class="fa fa-circle-o"></i> Tambah Album</a></li>
        <li><a href="<?=base_url(roleURIUser().'media/gallery');?>"><i class="fa fa-circle-o"></i> Semua Galeri</a></li>
        <li><a href="<?=base_url(roleURIUser().'media/gallery/add');?>"><i class="fa fa-circle-o"></i> Tambah Galeri</a></li>
    </ul>
</li>
<li class="treeview <?=menuActive("content","events");?>">
    <a href="#"><i class="fa fa-calendar"></i> <span>Events</span> <i class="fa fa-angle-left pull-right"></i></a>
    <ul class="treeview-menu">
        <li><a href="<?=base_url(roleURIUser().'content/events');?>"><i class="fa fa-circle-o"></i> Semua Event</a></li>
        <li><a href="<?=base_url(roleURIUser().'content/events/add');?>"><i class="fa fa-circle-o"></i> Tambah Event</a></li>
    </ul>
</li>
<li class="treeview <?=menuActive("content","pages");?>">
    <a href="#"><i class="fa fa-files-o"></i> <span>Halaman</span> <i class="fa fa-angle-left pull-right"></i></a>
    <ul class="treeview-menu">
        <li><a href="<?=base_url(roleURIUser().'content/pages');?>"><i class="fa fa-circle-o"></i> <?=langGet("menu","menu_pages_all");?></a></li>
        <li><a href="<?=base_url(roleURIUser().'content/pages/add');?>"><i class="fa fa-circle-o"></i> <?=langGet("menu","menu_pages_add");?></a></li>
    </ul>
</li>
<li class="treeview <?=menuActive("style");?>">
    <a href="#"><i class="fa fa-paint-brush"></i> <span><?=langGet("menu","menu_appearance");?></span> <i class="fa fa-angle-left pull-right"></i></a>
    <ul class="treeview-menu">
        <li><a href="<?=base_url(roleURIUser().'style/logo');?>"><i class="fa fa-circle-o"></i> <?=langGet("menu","menu_appearance_logo");?></a></li>
        <li><a href="<?=base_url(roleURIUser().'style/templates');?>"><i class="fa fa-circle-o"></i> <?=langGet("menu","menu_appearance_template");?></a></li>
        <?php
        $themeActive=optionGet('theme_front');
        
        if(themeHasOption($themeActive)){
			?>
			<li><a href="<?=base_url(roleURIUser().'style/templates/konfigurasi');?>"><i class="fa fa-circle-o"></i> Konfigurasi Tema</a></li>
			<?php
		}
        ?>
        <li><a href="<?=base_url(roleURIUser().'style/widgets');?>"><i class="fa fa-circle-o"></i> <?=langGet("menu","menu_appearance_widget");?></a></li>
        <li><a href="<?=base_url(roleURIUser().'style/menus');?>"><i class="fa fa-circle-o"></i> <?=langGet("menu","menu_appearance_menu");?></a></li>
    </ul>
</li>
<li class="treeview <?=menuActive("users");?>">
    <a href="#"><i class="fa fa-users"></i> <span><?=langGet("menu","menu_users");?></span> <i class="fa fa-angle-left pull-right"></i></a>
    <ul class="treeview-menu">
        <li><a href="<?=base_url(roleURIUser().'users');?>"><i class="fa fa-circle-o"></i> <?=langGet("menu","menu_users_all");?></a></li>
        <li><a href="<?=base_url(roleURIUser().'users/add');?>"><i class="fa fa-circle-o"></i> <?=langGet("menu","menu_users_add");?></a></li>
    </ul>
</li>
<li class="treeview <?=menuActive("config");?>">
    <a href="#"><i class="fa fa-gear"></i> <span><?=langGet("menu","menu_configuration");?></span> <i class="fa fa-angle-left pull-right"></i></a>
    <ul class="treeview-menu">
        <li><a href="<?=base_url(roleURIUser().'config/konfigurasi');?>"><i class="fa fa-circle-o"></i> <?=langGet("menu","menu_configuration_general");?></a></li>
        <li><a href="<?=base_url(roleURIUser().'config/dbtools');?>"><i class="fa fa-circle-o"></i> <?=langGet("menu","menu_configuration_database");?></a></li>
        <li><a href="<?=base_url(roleURIUser().'config/permalink');?>"><i class="fa fa-circle-o"></i> <?=langGet("menu","menu_configuration_permalink");?></a></li>
        <li><a href="<?=base_url(roleURIUser().'config/searchengine');?>"><i class="fa fa-circle-o"></i> Search Engine</a></li>
    </ul>
</li>