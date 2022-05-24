<?php $user  = $_SESSION['user_role']; ?>
<?php $add_permission = $this->permission->grant(GENERATE_MERIT,'add'); ?>
<?php $edit_permission = $this->permission->grant(GENERATE_MERIT,'edit'); ?>
<?php $delete_permission = $this->permission->grant(GENERATE_MERIT,'delete'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header"> 
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Generate Merit List</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Generate Merit</li>
          </ol>
        </div> 
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title"></h3>
              <?php if($add_permission == true || $user_role == 1){ ?>
              <!-- <div class="float-right"><a href="<?php echo base_url();?>admin/GenerateMerit/add" class="btn btn-block btn-primary btn-sm"><i class="fa fa-plus text-xs"></i> Generate Merit</a></div> -->
              <?php } ?>
            </div>
            <!-- /.card-header -->
            <div class="card-body" >
              <div class="table-responsive" id="show_data">

              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>

<!-- Modal -->
<div class="modal fade" id="addRemarkPopup" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="addRemarkPopupLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="addRemarkForm" data-toggle="validator" role="form" method='POST' class="form-horizontal" action='<?php echo base_url();?>admin/GenerateMerit/<?php if(isset($record['id'])){ echo 'edit/'.base64_encode($record['id']);}else{ echo 'addRemark/'; } ?>' method="post">
        <div class="modal-header">
          <h5 class="modal-title" id="addRemarkPopupLabel">Add Remark</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="id">
          <input type="text" required name="remark" id="remark" class="form-control" placeholder="Enter remark here..">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Add</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- /.content-wrapper -->
<script type="text/javascript">
  $(document).on("click", ".addRemarkLink", function () {
      var myBookId = $(this).data('id');
      $(".modal-body #id").val( myBookId );
  });
    $(document).ready(function(){
        //call function show all series
        show_data();
        //function show all series
        function show_data(){
          $('#modal-loader').modal('hide');
            var series_id = $('#series_id').find('option:selected').val();
            var user_type = $('#user_type').find('option:selected').val();
            var created_at1 = $('#created_at1').val();
            var created_at2 = $('#created_at2').val();
            $.ajax({
                type  : 'POST',
                url   : '<?php echo base_url('admin/GenerateMerit/data')?>',
                async : true,
                //dataType : 'json',
                data:{series_id:series_id,user_type:user_type,created_at1:created_at1,created_at2:created_at2},
                success : function(data){
                    $('#show_data').html(data);
                    $('#example2').dataTable({"aaSorting":[]});
                }
 
            });
        }
        //delete record to database
        $('#show_data').on('click','.item_delete',function(){
            var id = $(this).data('id');
            if(confirm('Are you sure want to delete?')){
              $.ajax({
                  type : "POST",
                  url: "<?php echo base_url();?>admin/GenerateMerit/delete/"+id,
                  dataType : "JSON",
                  data : {id:id},
                  success: function(msg){
                      success_msg(msg.success,msg.message);
                      show_data();
                  }
              });
            }
            return false;
        });

        $('body').on('click','#search',function(){
          show_data();
        });
 
    });
    $('#addRemarkPopup').on('hidden.bs.modal', function () {
        $('#addRemarkForm').trigger("reset");
        var validator = $( "#addRemarkForm" ).validate();
        validator.resetForm();
        $('#remark').removeClass('is-invalid');
    });
 
</script>