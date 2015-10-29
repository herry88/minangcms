<?php
$att=array(
'class'=>'form-horizontal',
'id'=>'',
);
echo form_open(base_url(roleURIUser().'users/addapply'),$att)
?>
    <div class="form-group">
    <label for="userName" class="col-sm-2 control-label"><?=langGet('user','form_name');?></label>
    <div class="col-sm-4">
        <input type="text" class="form-control" id="nama" name="nama" placeholder="<?=langGet('user','form_name');?>" required="">
    </div>
    </div>
    <div class="form-group">
    <label for="username" class="col-sm-2 control-label"><?=langGet('user','form_username');?></label>
    <div class="col-sm-4">
        <input type="text" class="form-control" id="username" name="username" placeholder="<?=langGet('user','form_username');?>" required="">
    </div>
    </div>
    <div class="form-group">
    <label for="password" class="col-sm-2 control-label"><?=langGet('user','form_password');?></label>
    <div class="col-sm-4">
        <input type="text" class="form-control" id="password" name="password" placeholder="<?=langGet('user','form_password');?>" required="">
    </div>
    </div>
<hr/>
    <div class="form-group">
    <label for="email" class="col-sm-2 control-label"><?=langGet('user','form_email');?></label>
    <div class="col-sm-4">
        <input type="email" class="form-control" id="email" name="email" placeholder="<?=langGet('user','form_email');?>" required="">
    </div>
    </div>
    <div class="form-group">
    <label for="hp" class="col-sm-2 control-label"><?=langGet('user','form_handphone');?></label>
    <div class="col-sm-4">
        <input type="text" class="form-control" id="hp" name="hp" placeholder="<?=langGet('user','form_handphone');?>">
    </div>
    </div>
<hr/>
    <div class="form-group">
    <label for="akses" class="col-sm-2 control-label"><?=langGet('user','form_access');?></label>
    <div class="col-sm-4">
        <select name="akses" id="akses" required="" class="form-control">
            <option value="">-<?=langGet('user','form_access_choose');?>-</option>
            <?php
            $sAkses=array(
                'role_id !='=>'1',
                );
            $dAkses=$this->m_database->fetchData('userrole',$sAkses);
            foreach($dAkses as $rAkses)
            {
                ?>
                <option value="<?=$rAkses->role_id;?>"><?=ucwords($rAkses->role_name);?></option>
                <?php
            }
            ?>
        </select>
    </div>
    </div>
 <hr>
    <div class="form-group">
    <label class="col-sm-2 control-label">&nbsp;</label>
    <div class="col-sm-4">
        <button class="btn btn-flat btn-primary" type="submit"><?=langGet('global','button_add');?></button>
        <button class="btn btn-flat btn-default" type="reset" onclick="return confirm('Yakin ingin reset form?');"><?=langGet('global','button_reset');?></button>
    </div>
    </div>

<?php
echo form_close();
?>