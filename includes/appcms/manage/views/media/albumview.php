<a href="<?=base_url(roleURIUser().'media/album/add');?>" class="btn btn-md btn-flat btn-default">Tambah Album</a>

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
            "sAjaxSource": '<?php echo base_url(roleURIUser()); ?>/media/album/viewdata',
            "bJQueryUI": false,
            "dom": 'T<"clear">lfrtip<"clear spacer">',
            "tableTools": {
            "sSwfPath": "<?=locationPlugin('url');?>datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf"
            },            
        	"sPaginationType": "full_numbers",        
            "iDisplayStart ": 10,
            "aoColumns": [{
	             "mData": "cover"
	         }, {
	             "mData": "judul"
	         }, {
	             "mData": "tanggal"
	         }, {
	             "mData": "keterangan"
	         }, {
	             "mData": "aksi"
	         }],
	        "order": [[ 2, "desc" ]],
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
    	<th>#</th>
        <th>Judul</th>
        <th>Tanggal</th>
        <th>Keterangan</th>  
        <th width="15%">Aksi</th>
    </tr>  
</thead>
<tbody></tbody>
</table>
