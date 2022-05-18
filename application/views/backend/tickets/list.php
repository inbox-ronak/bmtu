<?php $user_role  = $_SESSION['user_role']; ?>
<?php $add_permission = $this->permission->grant(TICKETS,'add'); ?>
<?php $edit_permission = $this->permission->grant(TICKETS,'edit'); ?>
<?php $delete_permission = $this->permission->grant(TICKETS,'delete'); ?>
<!-- Content Wrapper. Contains page content -->
<style>
    #ticket_table_wrapper{
        overflow-x:auto !important;
    }
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>List of Tickets</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Tickets</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <h3 class="card-title col-md-9">Tickets</h3>
                                <div class="col-md-2 add-btn">
                                    <?php if($add_permission == true || $user_role == 1){ ?>
                                    <a href="<?php echo base_url('admin/tickets/add_edit_form'); ?>" class="btn btn-block btn-primary btn-sm"><i class="fa fa-plus text-xs"></i> Add Ticket</a>
                                    <?php } ?>
                                </div>
                                <!-- <div class="col-md-1 text-right">
                                    <a title="Delete row selected rows!" class="delete-href btn btn-md btn-danger btn-sm"><i class="fa fa-trash text-xs"></i>Delete</a>
                                </div> -->
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="ticket_table" class="table table-bordered table-hover dataTable dataTables_wrapper dt-bootstrap4">
                                <thead>
                                    <tr>
                                        <th style="width: 1px;">
                                            <div class="icheck-primary d-inline" title="Select All">
                                                <input type="checkbox" class="all_chkbox" id="all_chkbox"><label for="all_chkbox"></label>
                                            </div>
                                        </th>
                                        <th style="width: 30%;">Ticket Name</th>
                                        <th>Created</th>
                                        <th>Status</th>
                                        <th>Ticket Status</th>
                                        <th style="width: 10%; text-align: center !important;">Action</th>
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
<!-- /.content-wrapper -->
<script>
$(document).ready(function(){
    $(document).on('click', '.all_chkbox', function () {
        if ($(this).prop("checked") == true) {
            $('.chkbox').prop('checked', true);
        } else {
            $('.chkbox').prop('checked', false);
        }
    });

    var table = $('#ticket_table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "<?php echo base_url('admin/tickets/datatable_json') ?>",
            "type": "POST",
            data: {'csrf_test_name': $("input[name=csrf_test_name]").val()}
        },
        "order": [[0, 'DESC']],
        "columnDefs": [
            {"targets": 0, "name": "id", 'searchable': false, 'orderable': false},
            {"targets": 1, "name": "ticket_name_en", 'searchable': true, 'orderable': true},
            {"targets": 2, "name": "created_at", 'searchable': false, 'orderable': false},
            {"targets": 3, "name": "action", 'searchable': false, 'orderable': false}
        ]
    });

    function reset() {
        $(".search_form_status").val('1').trigger('change');
        getdata();
    }

    function getdata() {
        var _form = $("#user_search").serialize();
        $.ajax({
            data: _form,
            type: 'post',
            url: '<?php echo base_url(); ?>admin/tickets/search',
            async: true,
            success: function (output) {
                table.ajax.reload(null, false);
            }
        });
    }

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
                url: "<?php echo base_url('admin/tickets/multidel') ?>",
                data: {records_to_del: records_to_del, 'csrf_test_name': $("input[name=csrf_test_name]").val()},
                success: function (msg) {
                    window.location.reload();
                }
            });
        }
    });
});

function ticket_status(id){
    var id = $('#ticket-status'+id).attr('data-id');
    var status = $('#ticket-status'+id).val();
    $.ajax({
      url: "<?php echo base_url(); ?>admin/tickets/ticket_status",
      type: "POST",
      data:{
            status:status,
            id:id
      },
      dataType: "json",
      success:function(data){
        success_msg(data.success,data.message);
        //table.ajax.reload(null, false);
      }
    });
}
</script>

