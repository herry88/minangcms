<div id="comment-div">
<strong>Tambahkan Komentar</strong>
<?php
$att=array(
'id'=>'formcomment',
);
echo form_open(base_url("comment"),$att);
$token=tokenGenerate();
?>
<div class="">
<input type="hidden" name="postid" value="<?=$postid;?>"/>
<label>Nama</label>
<input type="text" name="name" class="form-block" required=""/>
</div>
<div class="">
<label>Email</label>
<input type="text" name="email" class="form-block" required=""/>
</div>
<div class="">
<label>Komentar</label>
<textarea class="form-block" rows="5" name="data" required=""></textarea>
</div>
<p>
<?php echo runService('login','before');?>
</p>
<button type="submit" class="form-block">Kirim</button>
<?php
echo form_close();
?>
</div>
<?php
var_dump($this->session->all_userdata());
$s=array(
'post_id'=>$postid,
);

if(dbCount('postcomment',$s) > 0){
	
	$dCom=dbGet('postcomment',$s,'comment_date DESC');
	
	foreach($dCom as $rCom){
		$nama=$rCom->nama;
		$email=$rCom->email;
		$comment=$rCom->comment;
		
		?>
		<div class="comment-item">
		<strong class="comment-author"><?=$nama;?></strong>
		<blockquote class="comment-data"><?=$comment;?></blockquote>
		</div>
		<?php
	}
}
?>