<?php
if($tipe=="post"){	
$p='';
$dParent=getCategory();		
if(!empty($dParent)){
foreach($dParent as $rParent){
	$p.='<div class="checkbox">';
	$p.='<label>';
	$p.='<input type="checkbox" name="kat[]" value="'.$rParent->term_id.'"/>'.$rParent->name;
	$p.='</label>';
	$p.='</div>';		
	$dChild=getCategory($rParent->term_id);
	if(!empty($dChild)){
	foreach($dChild as $rChild){
		$p.='<div class="checkbox">';
		$p.='<label>';
		$p.='<span style="padding-left:10px;"><input type="checkbox" name="kat[]" value="'.$rChild->term_id.'"/>'.$rChild->name.'</style>';
		$p.='</label>';
		$p.='</div>';
	}
	}
}
}
echo $p;
}
?>