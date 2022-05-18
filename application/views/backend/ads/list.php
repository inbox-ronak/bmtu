<!-- <link rel="stylesheet" href="<?= base_url() ?>public/plugins/datatables-bs4/css/dataTables.bootstrap4.css"> -->
<div class="content-wrapper">
<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1>Ads</h1>           
           
         </div>
         <div class="col-sm-6">
            <div class="breadcrumb float-sm-right">
               <a href="<?= base_url('admin/ads/add_edit_form'); ?>" class="btn btn-success"><i class="fa fa-plus"></i> Add Ads</a>
            </div>
         </div>
      </div>
   </div>
</section>
<section class="content">
   <div class="row">
      <div class="col-12">
          <div class="card">
            <div class="card-body">
             <table id="ads_table" class="table table-bordered table-hover dataTable dataTables_wrapper dt-bootstrap4">
                <thead>
                   <tr>
                     <th style="width: 1px;">
                                    <div class="icheck-primary d-inline" title="Select All">
                                        <input type="checkbox" class="all_chkbox" id="all_chkbox"><label for="all_chkbox"></label>
                                    </div>
                                </th>
                      <th> Page Name </th>
                      <th> Ads Position</th>     
                      <th>Status</th>
                      <th style="width: 8%; text-align: center !important;">Action</th>
                   </tr>
                </thead>
             </table>
            </div>
          </div>
      </div>
   </div>
</section>
</div>
<!-- Modal -->
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
<!-- DataTables -->
<!-- <script src="<?= base_url() ?>public/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>public/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script> -->
<script>
  //========On load Show only Active records=========//
    $( document ).ready(function() {
      getdata();
    });
  
   $(document).on('click', '.all_chkbox', function () {
       if ($(this).prop("checked") == true) {
           $('.chkbox').prop('checked', true);
       } else {
           $('.chkbox').prop('checked', false);
       }
   });
   
   //---------------------------------------------------
    $(document).ready(function(){
    var table = $('#ads_table').DataTable({
       "pageLength": 50,
       "processing": true,
       "serverSide": true,
       "ajax": {
           "url": "<?php echo base_url('admin/ads/datatable_json') ?>",
           "type": "POST",
           data: {'csrf_test_name': $("input[name=csrf_test_name]").val()}
       },
        "aaSorting": [[1, 'desc']],
        "columnDefs": [           
           {"targets": 0, "name": "id", 'searchable': false, 'orderable': false},
           {"targets": 1, "name": "page_slug", 'searchable': true, 'orderable': true},
           {"targets": 2, "name": "page_slug", 'searchable': true, 'orderable': true},
           {"targets": 3, "name": "action", 'searchable': false, 'orderable': false},
           {"targets": 4, "name": "action", 'searchable': false, 'orderable': false},


       ]
    });
    });
    
   function reset() {
       $(".search_form_status").val('').trigger('change');
       getdata();
   }
   $(document).ready(function () {
      var _form = $("#user_search").serialize();
      $.ajax({
          data: _form,
          type: 'post',
          url: '<?php echo base_url(); ?>admin/ads/search',
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
           url: '<?php echo base_url(); ?>admin/ads/search',
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
        }else{                    
            $('#confirm-delete').modal('show');
        }
    });
    $(document).on('click', '.btn-ok', function (event) {
      var records_to_del = [];
      $("input[name='ids[]']:checked").each(function () {
          records_to_del.push($(this).val());
      });

      if (records_to_del.length > 0){
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url('admin/ads/multidel') ?>",
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

<script type="text/javascript">
      function ConfirmDelete(id){
        if (confirm("Are you sure want to delete?"))
          location.href='<?=base_url('admin/ads/delete/');?>'+id;
      }
</script>