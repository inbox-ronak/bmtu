<?php $user_role   = $_SESSION['user_role']; ?>
<?php $add_permission = $this->permission->grant(TEST_CENTER,'add'); ?>
<?php $edit_permission = $this->permission->grant(TEST_CENTER,'edit'); ?>
<?php $delete_permission = $this->permission->grant(TEST_CENTER,'delete'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header"> 
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Test Center</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Test Center</li>
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
              <h3 class="card-title">Test Center</h3>
              <?php if($add_permission == true || $user_role == 1){ ?>
              <div class="float-right"><a href="#" data-toggle="modal" data-target="#modal-default" class="btn btn-block btn-primary btn-sm"><i class="fa fa-plus text-xs"></i> Add Test Center</a></div>
              <?php } ?>
            </div>
            <!-- /.card-header -->
            <div class="card-body" >
              <div class="table-responsive" id="show_data"> </div>
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
    <!-- add modal -->
    <div class="modal fade" id="modal-default" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog">
        <div class="modal-content">
          <form data-toggle="validator" role="form" method='POST' class="form-horizontal" action='<?php echo base_url();?>test_center/add' id="add-form" name="add-form" enctype='multipart/form-data'>
          <div class="modal-header">
            <h4 class="modal-title">Add Test Center</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
            <div class="form-group col-md-6">
              <label for="latitude">Latitude<span style="color: red">*</span></label>
              <input type="number" name="latitude" class="form-control" id="latitude" placeholder="Enter Latitude Name" required>
            </div>

            <div class="form-group col-md-6">
              <label for="longitude">Longitude<span style="color: red">*</span></label>
              <input type="number" name="longitude" class="form-control" id="longitude" placeholder="Enter Longitude Name" required>
            </div>

             <div class="form-group col-md-6">
              <label for="loacation_name">Location Name<span style="color: red">*</span></label>
              <input type="text" name="location_name" class="form-control" id="loacation_name" placeholder="Enter Loacation Name" required>
            </div>

            <div class="form-group col-md-6">
              <label for="loacation_info">Location Info<span style="color: red">*</span></label>
              <input type="text" name="location_info" class="form-control" id="loacation_info" placeholder="Enter Loacation info Name" required>
            </div>

            <div class="form-group col-md-6">
                <label >Status</label>
                  <select id="status" name="status" class="form-control form-control-sm select2" style="width: 100%;">
                   <option value="1" <?php if(isset($record[0]['status'])){
                    if($record[0]['status'] == 1){ echo 'selected'; }
                    }else{
                    if(set_value('status') == 1){ echo 'selected'; }
                    } ?>>Active</option>
                    <option value="0" <?php if(isset($record[0]['status'])){
                    if($record[0]['status'] == 0){ echo 'selected'; }
                    }else{
                    if(set_value('status') == 0){ echo ''; }
                    } ?>>In-Active</option>
                  </select>
            </div>
 
          </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button type="submit" id="btn_save" class="btn btn-primary">Save</button>
          </div>
          </form>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <!-- /.add modal -->
    <!-- edit modal -->
    <div class="modal fade" id="modal-edit" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog">
        <div class="modal-content">
          <form data-toggle="validator" role="form" method='POST' class="form-horizontal2" action='<?php echo base_url();?>test_center/update_test_center' id="edit-form" name="edit-form" enctype='multipart/form-data'>
          <div class="modal-header">
            <h4 class="modal-title">Edit Test</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="editModel" >
            
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button type="submit" id="btn_update" class="btn btn-primary">Save</button>
          </div>
          </form>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <!-- /. edit modal -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script type="text/javascript">
    $(document).ready(function(){
        //call function show all series
        show_data();
        //function show all series
        function show_data(){
          $('#modal-loader').modal('hide');
            $.ajax({
                type  : 'POST',
                url   : '<?php echo base_url('admin/test_center/data')?>',
                async : true,
                //dataType : 'json',
                success : function(data){
                    $('#show_data').html(data);
                    $('#example2').dataTable({"aaSorting":[]});
                }
 
            });
        }
 
        //Save
        $('#btn_save').on('click',function(event){
            event.preventDefault();
            if($("#add-form").valid()){
            var form = $('#add-form')[0];
            var formData = new FormData(form);
              $.ajax({
                  type: "POST",
                  url: "<?php echo base_url('admin/test_center/add')?>",
                  data: formData,
                  //use contentType, processData for sure.
                  contentType: false,
                  processData: false,
                  dataType : "JSON",
                  beforeSend: function() {
                      $('#modal-default').modal('hide');
                      $('#modal-loader').modal('show');
                  },
                  success: function(msg) {
                      setTimeout(function(){ $('#modal-loader').modal('hide'); }, 1000);
                      $('#add-form')[0].reset();
                      success_msg(msg.success,msg.message);
                      show_data();
                  },
                  error: function() {
                      success_msg(0,"Sorry! could not process your request.");
                  }
              });
            }
            return false;
        });
 
        //get data for update record
        $('#show_data').on('click','.item_edit',function(){
            var id = $(this).data('id');
            $('#modal-edit').modal('show');
            $.ajax({
                type  : 'POST',
                url   : '<?php echo base_url('admin/test_center/getEdit')?>/'+id,
                dataType : 'html',
                success : function(data){
                  $('#editModel').html(data);
                  edit();
                }
            });
        }); 
        //update record to database
         $('#btn_update').on('click',function(event){
            event.preventDefault();
            if($("#edit-form").valid()){
            var form = $('#edit-form')[0];
            var formData = new FormData(form);
              $.ajax({
                  type: "POST",
                  url: "<?php echo base_url('admin/test_center/update')?>",
                  data: formData,
                  //use contentType, processData for sure.
                  contentType: false,
                  processData: false,
                  dataType : "JSON",
                  beforeSend: function() {
                      $('#modal-edit').modal('hide');
                      $('#modal-loader').modal('show');
                  },
                  success: function(msg) {
                    setTimeout(function(){ $('#modal-loader').modal('hide'); }, 1000);
                    success_msg(msg.success,msg.message);
                    show_data();
                  },
                  error: function() {
                      success_msg(0,"Sorry! could not process your request.");
                      //alert("Sorry! Couldn't process your request.");
                  }
              });
            }
            return false;
        });
  
        //delete record to database
        $('#show_data').on('click','.item_delete',function(){
            var id = $(this).data('id');
            if(confirm('Are you sure want to delete?')){
              $.ajax({
                  type : "POST",
                  url: "<?php echo base_url();?>admin/test_center/delete/"+id,
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
 
    });
 
</script>