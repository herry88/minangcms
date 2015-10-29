<?php
require dirname(__FILE__).'/function.php';
register_widget();
configTheme();
$route=$data['route'];
$data=$data['data'];
include dirname(__FILE__).'/header.php';
mc_loader($route,$data);
include dirname(__FILE__).'/footer.php';
?>