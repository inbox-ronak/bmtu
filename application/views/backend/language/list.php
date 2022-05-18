<?php $user_role   = $_SESSION['user_role']; ?>
<?php $add_permission = $this->permission->grant(LANGUAGE,'add'); ?>
<?php $edit_permission = $this->permission->grant(LANGUAGE,'edit'); ?>
<?php $delete_permission = $this->permission->grant(LANGUAGE,'delete'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Language Variables</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url();?>chapter/apitest">Dashboard</a></li>
                        <li class="breadcrumb-item active">Language Variables</li>
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
                            <h3 class="card-title">Language Variables</h3>
                            <?php if($add_permission == true || $user_role == 1){ ?>
                                <div class="float-right"><a href="<?php echo base_url('admin/language/add_edit_form'); ?>" class="btn btn-block btn-primary btn-sm"><i class="fa fa-plus text-xs"></i> Add Language</a></div>
                            <?php } ?>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                            <table id="user_type_table" class="table table-bordered table-hover dataTable dataTables_wrapper dt-bootstrap4" style="overflow-y:hidden;">
                                <thead>
                                    <tr>
                                        <th>Lang Name</th>
                                        <th>Lang <small style="color: blue; font-weight: bold;"><i>[English]</i></small></th>
                                        <th>Lang  <small style="color: blue; font-weight: bold;"><i>[Hindi]</i></small></th>
                                        <!-- <th>Lang  <small style="color: blue; font-weight: bold;"><i>[Arabic]</i></small></th>
                                        <th>Lang <small style="color: blue; font-weight: bold;"><i>[Kurdish]</i></small></th> -->
                                        <th style="width: 1%; text-align: center !important;">Action</th>
                                    </tr>
                                </thead>                        
                            </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- /.content-wrapper -->
<script type="text/javascript">
$(document).ready(function(){
    var table = $('#user_type_table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "<?php echo base_url('admin/language/datatable_json') ?>",
            "type": "POST",
            data: {'csrf_test_name': $("input[name=csrf_test_name]").val()}
        },
        "order": [[0, 'DESC']],
        "columnDefs": [
			{"targets": 0, "name": "lang_name", 'searchable': true, 'orderable': true},
            {"targets": 1, "name": "lang_en", 'searchable': true, 'orderable': true},
            // {"targets": 2, "name": "lang_ar", 'searchable': true, 'orderable': true},
            // {"targets": 3, "name": "lang_ku", 'searchable': true, 'orderable': true},
            {"targets": 2, "name": "lang_hi", 'searchable': true, 'orderable': true},
            {"targets": 3, "name": "action", 'searchable': false, 'orderable': false},
        ]
    });
});
</script>



