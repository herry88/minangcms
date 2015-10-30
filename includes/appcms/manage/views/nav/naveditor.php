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