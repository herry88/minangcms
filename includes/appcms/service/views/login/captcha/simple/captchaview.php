<style>
.simple-box{			
width: 200px;
}			
.simple-left,
.simple-right{
	 display: inline-block;
    box-sizing: border-box;
    width: 45%;
    height: 100%;
}
.simple-left{				
	margin-right: -34px;	
}
</style>
<div class="simple-box">
<div class="simple-left">
	<img src="<?=$img;?>">
</div>
<div class="simple-right">
	<input type="number" name="simplecaptchainput" autocomplete="off" placeholder="Ketikkan captcha" required=""/>
</div>
</div>