<div class="row">
<a href="<?=base_url(roleURIUser().'style/templates/installer');?>" class="btn btn-md btn-default">Add New</a>
</div>
<p>&nbsp;</p>
<?php
$d=getTheme('frontend');
$opt=optionGet('theme_front');
foreach($d as $r){
	$themeName=$r['name'];
	$themeImg=$r['thumb'];
	?>	
	<div class="col-sm-3 col-md-4">
    <div class="thumbnail" style="height: auto;">
      <img src="<?=$themeImg;?>">
      <div class="caption">
        <h3><?=$themeName;?></h3>        
        <p>
        <?php
        if($opt!=$themeName){
			?>
			<a href="<?=base_url(roleURIUser().'style/templates/active');?>?v=<?=$themeName;?>" class="btn btn-primary">Active</a>
			<?php
		}
        ?>        
        <a href="<?=base_url(roleURIUser().'style/templates/preview');?>?preview=<?=$themeName;?>" target="_blank" class="btn btn-default">Preview</a>
        <?php
        if(themeHasOption($themeName)){
			?>
			<a href="<?=base_url(roleURIUser().'style/templates/konfigurasi');?>?v=<?=$themeName;?>" class="btn btn-default">Konfigurasi</a>
			<?php
		}
        ?>        
        </p>
        <?php
        if($opt!=$themeName){
        	?>
        	<a onclick="return confirm('Yakin ingin menghapus tema ini?');" href="<?=base_url(roleURIUser().'style/templates/delete');?>?v=<?=$themeName;?>" class="text-danger">Delete</a>
        	<?php
        }
        ?>        
      </div>
      
    </div>    
  	</div>
	<?php
}
?>