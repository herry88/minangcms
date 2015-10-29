<style>
.math-box{			
width: 200px;
}			
.math-left,
.math-right{
	 display: inline-block;
    box-sizing: border-box;
    width: 45%;
    height: 100%;
}
.math-left{				
	margin-right: -34px;	
}
</style>
<div class="math-box">
<div class="math-left">
	<img src="<?=$img;?>">	
</div>
<div class="math-right">
	<input type="number" name="mathcaptchainput" autocomplete="off" placeholder="Masukkan jawaban" required=""/>
</div>
</div>