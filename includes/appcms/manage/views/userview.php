<a href="<?=base_url(roleURIUser().'users/add');?>" class="btn btn-md btn-flat btn-default"><?=langGet('menu','menu_users_add');?></a>

<?php
echo incCSS(locationPlugin('url').'datatables/dataTables.bootstrap');
echo incCSS(locationPlugin('url').'datatables/extensions/TableTools/css/dataTables.tableTools.min');
echo incCSS(locationPlugin('url').'datatables/extensions/responsive/css/dataTables.responsive');
echo incJS(locationPlugin('url').'datatables/jquery.dataTables');
echo incJS(locationPlugin('url').'datatables/dataTables.bootstrap');
echo incJS(locationPlugin('url').'datatables/extensions/TableTools/js/dataTables.tableTools.min');
echo incJS(locationPlugin('url').'datatables/extensions/responsive/js/dataTables.responsive');
?>

<script type="text/javascript">
    $(document).ready(function () {
        var oTable = $('#tb').dataTable({
            "bProcessing": true,
            "bServerSide": true,
            "responsive": true,
            "sAjaxSource": '<?php echo base_url(roleURIUser()); ?>/users/viewdata',
            "bJQueryUI": false,
            "dom": 'T<"clear">lfrtip<"clear spacer">',
            "tableTools": {
            "sSwfPath": "<?=locationPlugin('url');?>datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf"
            },            
        	"sPaginationType": "full_numbers",        
            "iDisplayStart ": 10,
            "aoColumns": [{
	             "mData": "user"
	         }, {
	             "mData": "nama"
	         }, {
	             "mData": "email"
	         }, {
	             "mData": "akses"
	         }, {
	             "mData": "status"
	         }, {
	             "mData": "login"
	         }, {
	             "mData": "aksi"
	         }],
            "aoColumnDefs": [ {
		      "aTargets": [ 4 ],
		      "mRender": function ( data, type, full ) {
		        var st=data;
                if(st=="active")
                {
                    return '<i class="fa fa-circle text-success"></i> '+data;
                }else{
                    return '<i class="fa fa-circle text-danger"></i> '+data;
                }
		      }
		    } ],
	        "order": [[ 0, "desc" ]],
            "oLanguage": {
                "sProcessing": "<img src='<?= locationUpload('url');?>/ajax-loader.gif'>"
            },
            "fnInitComplete": function () {
                oTable.fnAdjustColumnSizing();
            },
            'fnServerData': function (sSource, aoData, fnCallback) {
                $.ajax
                ({
                    'dataType': 'json',
                    'type': 'GET',
                    'url': sSource,
                    'data': aoData,
                    'success': fnCallback
                });
            }
        });        
    });
</script>

<p>&nbsp;</p>
<table id="tb" class="table table-bordered table-hover table-striped tablesorter dt-responsive nowrap">
<thead>
    <tr>
        <th><?=langGet('user','form_username');?></th>
        <th><?=langGet('user','form_name');?></th>
        <th><?=langGet('user','form_email');?></th>
        <th><?=langGet('user','form_access');?></th>
        <th><?=langGet('user','form_status_user');?></th>
        <th><?=langGet('user','form_lastlogin');?></th>
        <th width="15%"><?=langGet('user','form_action');?></th>
    </tr>  
</thead>
<tbody></tbody>
<tfoot>
	<tr>
		<td colspan="7">
		<span class="btn btn-danger btn-xs"><li class="fa fa-trash"></li> Hapus</span>
		<span class="btn btn-warning btn-xs"><li class="fa fa-lock"></li> Banned</span>
		<span class="btn btn-info btn-xs"><li class="fa fa-refresh"></li> Reset</span>
		<span class="btn btn-primary btn-xs"><li class="fa fa-check"></li> Aktif</span>
		<span>Default Password reset <b>1234</b></span>
		</td>
	</tr>
</tfoot>
</table>
