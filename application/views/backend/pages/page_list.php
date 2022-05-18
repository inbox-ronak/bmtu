
<link rel="stylesheet" href="<?= base_url()?>public/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<div class="content-wrapper">
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>List of Pages</h1>
            </div>
            <div class="col-sm-6">
                <div class="breadcrumb float-sm-right">
                    <a href="<?= base_url('admin/pages/add'); ?>" class="btn btn-success"><i class="fa fa-plus"></i> Add New Page</a>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="row">

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    
                    
                    <!-- <a title="Delete row selected rows!" href="javascript:void(0)" class="delete-href btn btn-md btn-danger"> 
                        <i class="fa fa-trash"></i><b> Delete</b>
                    </a>    -->                                        
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive">
                    <table id="page_table" class="table table-bordered table-hover dataTable dataTables_wrapper dt-bootstrap4" style="overflow-y: scroll;" >
                        <thead>
                            <tr>
								<th style="width: 1px;">
                                    <div class="icheck-primary d-inline" title="Select All">
                                        <input type="checkbox" class="all_chkbox" id="all_chkbox"><label for="all_chkbox"></label>
                                    </div>
                                </th>
                                <th>Page Name</th>
                                <th>Page Content</th>
                                <th>URL Type</th>
                                <th style="width: 150px;" class="text-right">Action</th>
                            </tr>
                        </thead>                        
                    </table>
</div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
</div>
<!-- Modal -->
<div id="confirm-delete" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                
            </div>
            <div class="modal-body">
                <p>As you sure you want to delete.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>

    </div>
</div>


<!-- DataTables -->
<script src="<?= base_url() ?>public/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>public/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script>
$(document).on('click', '.all_chkbox', function () {
    if ($(this).prop("checked") == true) 
    {
        $('.chkbox').prop('checked', true);
    }
    else 
    {
        $('.chkbox').prop('checked', false);
    }
});
//---------------------------------------------------
$(document).ready(function(){
var table = $('#page_table').DataTable({
        "processing": true,
		"serverSide": true,
		"ajax": {
            "url": "<?= base_url('admin/pages/datatable_json') ?>",
            "type": "POST",
            data: {'csrf_test_name': $("input[name=csrf_test_name]").val()}
        },
        "order": [[0, 'DESC']],
        "columnDefs": [
			{"targets": 0, "name": "id", 'searchable': false, 'orderable': false},
            {"targets": 1, "name": "page_name_en", 'searchable': true, 'orderable': true},
            {"targets": 2, "name": "page_content", 'searchable': true, 'orderable': false},
            {"targets": 3, "name": "url_type", 'searchable': true, 'orderable': false, 'width': '100px'},
            {"targets": 4, "name": "Action", 'searchable': false, 'orderable': false, 'width': '100px'}
        ]
    });
});
</script>

<script type="text/javascript">
    $('#confirm-delete').on('show.bs.modal', function (e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    });
</script>


<script type="text/javascript">

$(document).on('click', '.delete-href', function (event) {        
    var records_to_del = [];
    $("input[name='ids[]']:checked").each(function () {
        records_to_del.push($(this).val());
    });

    if (records_to_del.length == 0)
    {            
        alert('Please select any one row!');
    } 
    else 
    {                    
        $('#confirm-delete').modal('show');
    }
});
$(document).on('click', '.btn-ok', function (event) {

    var records_to_del = [];
    $("input[name='ids[]']:checked").each(function () {
        records_to_del.push($(this).val());
    });

    if (records_to_del.length > 0) 
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url('admin/pages/multidel') ?>",
            data: {records_to_del: records_to_del, 'csrf_test_name': $("input[name=csrf_test_name]").val()},
            success: function (msg) {
                window.location.reload();
            }
        });
    }
});
</script>

<link rel="stylesheet" href="<?= base_url() ?>public/plugins/select2/select2.css">
<script src="<?= base_url() ?>public/plugins/select2/select2.js"></script>
<script type="text/javascript">
    // In your Javascript (external .js resource or <script> tag)
    $(document).ready(function () {
        $('.js-example-basic-single').select2();
    });
</script>
