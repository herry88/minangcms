<?php
$path=scandir(MODPATH.'service/controllers/widget');
$dpath=array_diff($path, array('.', '..'));
$prefix=".php";
foreach($dpath as $key=>$val)
{
$val=strtolower(str_replace($prefix,"",$val));
    $label=strtoupper(str_replace($prefix,"",$val));
if(!is_dir(MODPATH.'service/controllers/widget/'.$val)){

$json=json_encode(array(
'service'=>$val,
'description'=>'Menampilkan '.$val,
));
insertTerms($val."_widget",$val."-widget",$val."-widget",'Menampilkan '.$val,"0",$json);

        ?>        
        <div class="col-md-4 col-sm-6">
        <div class="panel panel-default">
        	<div class="panel-heading"><?=$label;?></div>
        	<div class="panel-body">
        	<?php        	
        	$d=getTerms($val."_widget");
        	foreach($d as $r){				
			}
			$termid=$r->term_id;
			$data=menuInfoJSON($termid,"description");
			echo $data;
        	?>
        	</div>
        	<div class="panel-footer">
        		<a href="javascript:;" onclick="addwidget('<?=$val;?>')">Add Widget</a>
        	</div>
        </div>
        </div>
        
        <?php
	}	        	
}
?>