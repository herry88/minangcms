<hr style="border: 1px solid #D3D2D5"/>
<a href="javascript:;" id="btnaddcomment">Tambahkan Komentar</a>
<div id="comment-div" style="display: none;">
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
<input type="text" name="name" class="form-block" required="" value=""/>
</div>
<div class="">
<label>Email</label>
<input type="text" name="email" class="form-block" required="" value=""/>
</div>
<div class="">
<label>Komentar</label>
<textarea class="form-block" rows="3" name="data" required="" maxlength="400"></textarea>
</div><br/>
<button type="submit" class="form-block">Kirim</button>
<?php
echo form_close();
?>
</div>
<hr style="border: 1px solid #D3D2D5"/>
<?php
$s=array(
'post_id'=>$postid,
'comment_status'=>'publish',
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