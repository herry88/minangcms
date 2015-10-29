<footer>
<hr style="border: 1px solid #D3D2D5"/>
<?php
$copy="";
$foot=mc_themeConfigGet("okto1","footer");
if(empty($foot) or $foot=='Copyright &copy; Heru Rahmat'){
	$copy="Copyright &copy; ".date("Y")." ".optionGet('site_title');
}else{
	$copy=$foot;
}
?>
<?=$copy;?>
</footer>
</div>
    <script src="<?=locationTheme();?>frontend/okto1/plugins/jquery/jquery-1.11.3.min.js"></script>
    <script src="<?=locationTheme();?>frontend/okto1/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?=locationTheme();?>frontend/okto1/dist/js/custom.js"></script>
  </body>
</html>