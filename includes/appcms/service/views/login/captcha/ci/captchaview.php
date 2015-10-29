<script>
function reloadcicaptcha(){
	document.getElementById("cicaptcha").src="<?=base_url();?>service/login/captcha/refreshcaptcha";
	document.getElementById("captcha-input").value = "";
}
</script>
<div class="cicaptcha">
	<div class="captcha-header">
		<div class="captcha-image"><img src="<?=base_url();?>service/login/captcha/refreshcaptcha" id="cicaptcha"/></div>		
	</div>
	<div class="captcha-body">
		<div class="captcha-div-input">
			<input type="text" name="cicaptcha" class="captcha-input" id="captcha-input" autocomplete="off" placeholder="Enter captcha here" required=""/>
		</div>
		<div class="captcha-div-tool">
			<button type="button" class="btn btn-danger btn-sm captcha-refresh" onclick="javascript:reloadcicaptcha();"><img src="<?=locationUpload('url');?>refresh.png" style="width: 20px"/></button>			
		</div>		
	</div>
</div>
<style>
.cicaptcha{
	padding: 10px;
	width: 210px;
	height: 100px;	
	float:left;	
	text-align:left;		
	border-radius: 10px;
	background-color:#870500;
}
.captcha-image{
	width: 210px;
	height: 60px;	
}
.captcha-header{
	background-color: #fffdfd;
}
.captcha-div-input{
	left: 80%;
	float: left;
	padding-top:5px;	
}

.captcha-refresh{	
	cursor: pointer;	
	padding-left: 4px;
	border-radius: 0px;
	margin-left:3px;	
}
.captcha-body{
	width: 100%;
}
.captcha-input{
	height:30px;
	text-align: center;	
	font-size: 18px;
	width:170px;
	
}

.captcha-div-tool{
	padding-top:6px;	
}
</style>