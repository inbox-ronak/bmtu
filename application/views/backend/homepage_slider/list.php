<link rel="stylesheet" href="<?= base_url() ?>public/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<!-- Content Header (Page header) -->
<div class="content-wrapper">
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>List of Homepage Slider</h1>
            </div>
            <div class="col-sm-6">
                <div class="breadcrumb float-sm-right">
                    <a href="<?= base_url('admin/homepage_slider/add_homepage_slider'); ?>" class="btn btn-success"><i class="fa fa-plus"></i> Add HomePage Slider </a>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-2">
                            <h3 class="card-title">
                                <a title="Delete row selected rows!" class="delete-href btn btn-md btn-danger"> 
                                    <i class="fa fa-trash"></i><b> Delete</b>
                                </a>
                            </h3>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-2" style="text-align:right;"> 
                                    <label for="status" class="control-label">Status</label>
                                </div>
                                <div class="col-md-6">
                                    <?php
                                    echo form_open("/", 'id="user_search"');
                                    $status_array = array();

                                    $status_array[''] = 'All';
                                    $status_array['1'] = 'Active';
                                    $status_array['0'] = 'Inactive';

                                    echo form_dropdown('search_form_status', $status_array, '1', array('class' => 'form-control js-example-basic-single search_form_status input-sm', 'onchange' => 'getdata();'));
                                    echo form_close(); 
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
                    <div class="responsive-table" id="silder_tab">
                    <table id="silder_tab" class="table table-bordered table-striped" width="100%">
                        <thead>
                            <tr>
                                <th style="width: 1px;">
                                    <div class="icheck-primary d-inline" title="Select All">
                                        <input type="checkbox" class="all_chkbox" id="all_chkbox"><label for="all_chkbox"></label>
                                    </div>
                                </th>  
                                <th>Title</th>
                                <th>File</th>
                                <th>Order</th>
                                <th style="width: 50px;">Status </th>                 
                                <th style="text-align: center !important;">Action</th>
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
                <h4 class="modal-title"></h4>
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


<!-- DataTables -->
<script src="<?= base_url() ?>public/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>public/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script>
  var table = '';
  $(document).on('click', '.all_chkbox', function () {
      if ($(this).prop("checked") == true) {
          $('.chkbox').prop('checked', true);
      } else {
          $('.chkbox').prop('checked', false);
      }
  });
  $(document).ready(function(){
  table = $('#silder_tab').DataTable({
      "processing": true,
      "serverSide": true,
      "ajax": {
          "url": "<?php echo base_url('admin/homepage_slider/datatable_json') ?>",
          "type": "POST",
          data: {'csrf_test_name': $("input[name=csrf_test_name]").val()}
      },
      "order": [[0, 'desc']],
      "columnDefs": [
          {"targets": 0, "name": "id", 'searchable': false, 'orderable': false},
          {"targets": 1, "name": "title", 'searchable': true, 'orderable': true},
          {"targets": 2, "name": "file_type", 'searchable': true, 'orderable': false},
          {"targets": 3, "name": "slide_order", 'searchable': true, 'orderable': true},
          {"targets": 4, "name": "status", 'searchable': false, 'orderable': false},
          {"targets": 5, "name": "action", 'searchable': false, 'orderable': false},
      ]
  });
  });
  function reset() {
      $(".search_form_status").val('1').trigger('change');
      getdata();
  }
  $(document).ready(function () {
      var _form = $("#user_search").serialize();
      $.ajax({
          data: _form,
          type: 'post',
          url: '<?php echo base_url(); ?>admin/homepage_slider/search',
          async: true,
          success: function (output) {
              table.ajax.reload(null, false);
          }
      });
  });
  function getdata() {
      var _form = $("#user_search").serialize();
      $.ajax({
          data: _form,
          type: 'post',
          url: '<?php echo base_url(); ?>admin/homepage_slider/search',
          async: true,
          success: function (output) {
              table.ajax.reload(null, false);
          }
      });
  }
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
                url: "<?php echo base_url('admin/homepage_slider/multidel') ?>",
                data: {records_to_del: records_to_del, 'csrf_test_name': $("input[name=csrf_test_name]").val()},
                success: function (msg) {
                    //console.log(data);
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