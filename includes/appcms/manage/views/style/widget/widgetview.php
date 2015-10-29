<div class="col-md-6">
<?php $this->load->view('style/widget/widgettool');?>
</div>
<div class="col-md-6">
<?php $this->load->view('style/widget/widgetside');?>
</div>
<script>
$(document).ready(function(){

});

function addwidget(widget){
	var g=$("#widgetpos").val();
	var gid=$("#widgetid").val();	
	$.ajax({
		type:'post',
		dataType:'json',
		url:'<?=base_url(roleURIUser());?>/style/widgets/addwidget',
		data:'pos='+g+"&id="+gid+"&widget="+widget,
		success:function(){
			getWidget();
		},
	});
}
</script>