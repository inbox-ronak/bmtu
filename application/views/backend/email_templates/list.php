<!-- <link rel="stylesheet" href="<?= base_url() ?>public/plugins/datatables-bs4/css/dataTables.bootstrap4.css"> -->
<div class="content-wrapper">
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>List of Email Templates</h1>
            </div>
            <div class="col-sm-6">
                <div class="breadcrumb float-sm-right">
                    <a href="<?= base_url('admin/email_templates/add_template'); ?>" class="btn btn-success"><i class="fa fa-plus"></i> Add Email Template </a>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<section class="content">
    <div class="row">
        <div class="col-12">


            <div class="card">

                <!-- <div class="card-header">
                    <h3 class="card-title">
                        <a title="Delete row selected rows!" class="delete-href btn btn-md btn-danger"> 
                            <i class="fa fa-trash"></i><b> Delete</b>
                        </a>
                    </h3>
                </div> -->
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive">
                    <table id="email_template_tab" class="table table-bordered table-hover dataTable dataTables_wrapper dt-bootstrap4" style="overflow-y:hidden;">
                        <thead>
                            <tr>
                                <th style="width: 1px;">
                                    <div class="icheck-primary d-inline" title="Select All">
                                        <input type="checkbox" class="all_chkbox" id="all_chkbox"><label for="all_chkbox"></label>
                                    </div>
                                </th>
                                <th>Email Template For</th>
                                <th>Email Subject</th>
                                <th>Email Body</th>
                                <th style="width: 130px;" >Created</th>
                                <th style="width: 10%; text-align: center !important;">Action</th>
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

<!-- Modal -->
<div id="confirm-delete" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Delete</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                
            </div>
            <div class="modal-body">
                <p>Are you sure want to delete?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>

    </div>
</div>
</div>

<!-- DataTables -->
<!-- <script src="<?= base_url() ?>public/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>public/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script> -->
<script>
    $(document).on('click', '.all_chkbox', function () {
        if ($(this).prop("checked") == true) {
            $('.chkbox').prop('checked', true);
        } else {
            $('.chkbox').prop('checked', false);
        }
    });

//---------------------------------------------------
    $(document).ready(function(){
    var table = $('#email_template_tab').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "<?php echo base_url('admin/email_templates/datatable_json') ?>",
            "type": "POST",
            data: {'csrf_test_name': $("input[name=csrf_test_name]").val()}
        },
        "order": [[4, 'desc']],
        "columnDefs": [
            {"targets": 0, "name": "email_template_id", 'searchable': false, 'orderable': false},
            {"targets": 1, "name": "email_template_for", 'searchable': true, 'orderable': true},
            {"targets": 2, "name": "email_template_subject", 'searchable': true, 'orderable': true},
            {"targets": 3, "name": "email_template_body", 'searchable': true, 'orderable': false},
            {"targets": 4, "name": "email_template_created_at", 'searchable': false, 'orderable': true},
            {"targets": 5, "name": "action", 'searchable': false, 'orderable': false},
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

        if (records_to_del.length == 0) {            
            alert('Please select any one row!');
        } else {                    
            $('#confirm-delete').modal('show');
        }
    });

    $(document).on('click', '.btn-ok', function (event) {

        var records_to_del = [];
        $("input[name='ids[]']:checked").each(function () {
            records_to_del.push($(this).val());
        });

        if (records_to_del.length > 0) {
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url('admin/email_templates/multidel') ?>",
                data: {records_to_del: records_to_del, 'csrf_test_name': $("input[name=csrf_test_name]").val()},
                success: function (msg) {
                    //console.log(data);
                    window.location.reload();
                }
            });
        }
    });
</script>