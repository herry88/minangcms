<div class="form-top">
<div class="form-top-left">
	<h3>User Login</h3>                            		
</div>
<div class="form-top-right">
	<i class="fa fa-lock"></i>
</div>
</div>
<div class="form-bottom">
<?php
$att=array(
'name'=>'loginform',
'id'=>'loginform',
'class'=>'registration-form',
);
echo form_open(base_url(routeGet('loginproccess')));
?>
	<div class="form-group">
	<label class="sr-only">Username</label>
    	<input type="text" name="<?=authForm('user');?>" class="form-control" autocomplete="off" id="<?=authForm('user',FALSE);?>" placeholder="Username Anda">
    </div>
    <div class="form-group">
    	<label class="sr-only">Password</label>
    	<input type="password" name="<?=authForm('pass');?>" class="form-control" autocomplete="off" id="<?=authForm('pass',FALSE);?>" placeholder="Password Anda">
    </div>		
	<p>
		<?php echo runService('login','before');?>
	</p>
	<div class="form-group">
    	<label class="sr-only">&nbsp;</label>
    	<div class="checkbox">
		    <label>		    
		      <input type="checkbox" name="mremember"/>Ini adalah komputer pribadi saya
		    </label>
		</div>
    	
    </div>
	<p class="submit">
		<input type="submit" name="minang-submit" id="minang-submit" class="btn" value="Log In" />
	</p>
<?php
echo form_close();
?>