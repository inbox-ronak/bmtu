<link rel="stylesheet" href="<?= base_url() ?>public/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Tendor List</h1>
            </div>
            <div class="col-sm-6">
                <div class="breadcrumb float-sm-right">
                    <a href="<?= base_url('admin/tender_type/add_edit_form'); ?>" class="btn btn-success"><i class="fa fa-plus"></i> Add Tendor</a>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <a title="Delete row selected rows!" class="delete-href btn btn-md btn-danger"><i class="fa fa-trash"></i><b> Delete</b></a>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-2 text-right"> 
                                    <label for="status" class="control-label">Status</label>
                                </div>
                                <div class="col-md-6">
                                    <?php
                                    $status_array = array();
                                    $status_array['All'] = 'All';
                                    $status_array['1'] = 'Active';
                                    $status_array['0'] = 'Inactive';

                                    echo form_dropdown('search_form_status', $status_array, '1', array('class' => 'form-control js-example-basic-single search_form_status input-sm'));
                                    ?>
                                </div>
                                <div class="col-md-3"> 
                                    <a class="btn btn-danger btn-md" onclick="reset();"  title="Reset">
                                        <i class="fa fa-refresh"></i>Reset
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table-responsive">
                    <table id="email_template_tab" class="table table-bordered table-hover dataTable dataTables_wrapper dt-bootstrap4" style="overflow-y: scroll;">
                        <thead>
                            <tr>
                                <th style="width: 1px;">
                                    <div class="icheck-primary d-inline" title="Select All">
                                        <input type="checkbox" class="all_chkbox" id="all_chkbox"><label for="all_chkbox"></label>
                                    </div>
                                </th>
                                <th>Tender</th>
                                <th style="width: 130px;" >Created</th>
                                <th>Status</th>
                                <th style="text-align: center !important;">Action</th>
                            </tr>
                        </thead>                        
                    </table>
 </div> 
                </div>
            </div>
        </div>
    </div>
</section>
<div id="confirm-delete" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Archive</h4>
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
<script src="<?= base_url() ?>public/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>public/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>public/plugins/select2/select2.css">
<script src="<?= base_url() ?>public/plugins/select2/select2.js"></script>
<script>
    $(document).on('click', '.all_chkbox', function () {
        if ($(this).prop("checked") == true) {
            $('.chkbox').prop('checked', true);
        } else {
            $('.chkbox').prop('checked', false);
        }
    });
    var table = $('#email_template_tab').DataTable({
        "pageLength": by_default_page_length,
        "lengthMenu": page_length_dropdown,  
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "<?php echo base_url('admin/tender_type/datatable_json') ?>",
            "type": "POST",
            "data": function ( d ) {
                return $.extend( {}, d, {
                   "csrf_test_name": $("input[name=csrf_test_name]").val(),
                   "search_form_status": $(".search_form_status").val().toLowerCase(),
                } );
            }
        },
        "order": [[0, 'desc']],
        "columnDefs": [
            {"targets": 0, "name": "id", 'searchable': false, 'orderable': false},
            {"targets": 1, "name": "tender_name", 'searchable': true, 'orderable': true},
            {"targets": 2, "name": "created_at", 'searchable': false, 'orderable': true},
            {"targets": 3, "name": "status", 'searchable': false, 'orderable': true},
            {"targets": 4, "name": "action", 'searchable': false, 'orderable': false},
        ]
    });
    $(document).ready(function () {
        $('.search_form_status').bind("change", function(){
            table.draw();
        });
        $('.search_form_status').select2({
            placeholder: "Select Status",
            allowClear: true
        });
    });

    $('#confirm-delete').on('show.bs.modal', function (e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    });

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
                url: "<?php echo base_url('admin/tender_type/multidel') ?>",
                data: {records_to_del: records_to_del, 'csrf_test_name': $("input[name=csrf_test_name]").val()},
                success: function (msg) {
                    window.location.reload();
                }
            });
        }
    });

    function ConfirmDelete(id){
        if (confirm("Are you sure want to delete?")){
            location.href='<?=base_url('admin/tender_type/delete/');?>'+id;
        }
    }
</script>