<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('register_widget')){
	function register_widget(){
		$jsondata=json_encode(array(
		'theme'=>'okto1',
		));
		mc_register_sidebar("okto1","homepageleft",$jsondata);
		mc_register_sidebar("okto1","homepageright",$jsondata);
		mc_register_sidebar("okto1","blogright",$jsondata);
		mc_register_sidebar("okto1","blogleft",$jsondata);
	}
}

if(!function_exists('configTheme')){
	function configTheme(){
		$def=json_encode(array(
		'theme'=>'okto1',
		'footer'=>'Copyright &copy; Heru Rahmat',
		));
		mc_themeConfigSet("okto1",$def);
	}
}

if(!function_exists('menuTop')){
	function menuTop(){
		$menu1=mc_menu("top","0");
		if(!empty($menu1)){
			foreach($menu1 as $rmenu1){
				$idmenu1=$rmenu1->term_id;
				$menu2=mc_menu("top",$idmenu1);
				if(!empty($menu2)){
					?>
					<li class="dropdown">
					<a href="<?=mc_menu_link($idmenu1);?>" class="dropdown-toggle" data-toggle="dropdown"><?=$rmenu1->name;?> <b class="caret"></b></a>
					<ul class="dropdown-menu">
					<?php
					foreach($menu2 as $rmenu2){
						$idmenu2=$rmenu2->term_id;
						$menu3=mc_menu("top",$idmenu2);
						if(!empty($menu3)){
							?>
							<li class="dropdown">
							<a href="<?=mc_menu_link($idmenu2);?>" class="dropdown-toggle" data-toggle="dropdown"><?=$rmenu2->name;?> <b class="caret"></b></a>
							<ul class="dropdown-menu">
							<?php
							foreach($menu3 as $rmenu3){
								$idmenu3=$rmenu3->term_id;
								?>
								<!-- MENU 3 MENU 2 CHILD -->
								<li><a href="<?=mc_menu_link($idmenu3);?>"><?=$rmenu3->name;?></a></li>
								<?php
							}
							?>
							</ul>
							</li>
							<?php
						}else{
							?>
							<!-- MENU 2 MENU 1 CHILD -->
							<li><a href="<?=mc_menu_link($idmenu2);?>"><?=$rmenu2->name;?></a></li>
							<?php
						}
					}
					?>
					</ul>
					</li>
					<?php
				}else{
					?>
					<!-- MENU 1 -->
					<li><a href="<?=mc_menu_link($idmenu1);?>"><?=$rmenu1->name;?></a></li>
					<?php
				}
			}
		}
	}
}

?>