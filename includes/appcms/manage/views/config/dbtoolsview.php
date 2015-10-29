<?php
$att=array(
'class'=>'form-horizontal',
);
?>
<div class="row">
<div class="col-xs-6">
<div class="panel panel-default">
	<div class="panel-heading">Backup Database</div>
	<div class="panel-body">
		<?php
		echo form_open(base_url(roleURIUser().'config/dbtools/backupdb').'?token='.tokenGenerate(),$att);
		?>
		<div class="form-group">
			<label class="col-sm-2 control-label">Name</label>
			<div class="col-xs-8">
				<input type="text" name="nama" class="form-control" value="<?=$autoname;?>" required=""/>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Output</label>
			<div class="col-xs-6">
				<select name="tipe" class="form-control" required="">
				<option value="txt">Text</option>
				<option value="zip">Zip</option>
				<option value="gzip">Gzip</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Reference</label>
			<div class="col-xs-6">
				<div class="checkbox">
			    <label>
			      <input type="checkbox" name="addinsert"> Add Insert			      
			    </label>			    
			  	</div>
			  	<div class="checkbox">
			    <label>
			      <input type="checkbox" name="adddrop"> Add Drop 
			    </label>
			  	</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">&nbsp;</label>
			<div class="col-xs-8">
				<button type="submit" class="btn btn-flat btn-primary">Backup</button>
			</div>
		</div>
		<?php
		echo form_close();
		?>
	</div>
</div>
</div>
<div class="col-xs-6">

<div class="panel panel-default">
	<div class="panel-heading">Optimize Database</div>
	<div class="panel-body">
		<button type="button" id="optimize" class="btn btn-flat btn-success">Optimize</button>
	</div>
	<div class="panel-footer" id="output1"></div>
</div>
<div class="panel panel-default">
	<div class="panel-heading">Optimize Table</div>
	<div class="panel-body">
		<?php
		$att2=array(
		'class'=>'form-horizontal',
		'id'=>'tableopt',
		);
		echo form_open('#',$att2);		
		?>
		<div class="form-group">
			<label class="col-sm-2 control-label">Table</label>
			<div class="col-xs-8">
				<select id="table" name="table" class="form-control select2" required="">
					<?php					
					foreach($this->db->list_tables() as $table)
					{
						
						?>
						<option value="<?=$table;?>"><?=$table;?></option>
						<?php
					}
					?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">&nbsp;</label>
			<div class="col-xs-6">
				<button type="submit" id="rpt" class="btn btn-flat btn-primary">Repair</button>
			</div>
		</div>
		<?php
		echo form_close();
		?>
	</div>
	<div class="panel-footer" id="output2"></div>
</div>

</div>
</div>

<script>
$(document).ready(function(){

	$("#optimize").click(function(){
		$.ajax({
			type:'get',
			dataType:'json',
			url:'<?=base_url(roleURIUser()."config/dbtools/optimizedb");?>',
			data:'v=1',
			beforeSend:function(){
				$("#output1").html("Sedang proses");
				$("#optimize").attr("disabled","disabled");
			},
			success:function(x){
				$("#output1").html(x);
				$("#optimize").removeAttr("disabled");
			},
		});
	});
	
	$("#tableopt").submit(function(e){
		e.preventDefault();
		$.ajax({
			type:'get',
			dataType:'json',
			url:'<?=base_url(roleURIUser()."config/dbtools/repairtable");?>',
			data:$(this).serialize(),
			beforeSend:function(){
				$("#output2").html("Sedang proses");
				$("#rpt").attr("disabled","disabled");
			},
			success:function(x){
				$("#output2").html(x);
				$("#rpt").removeAttr("disabled");
			},
		});
	});

});
</script>