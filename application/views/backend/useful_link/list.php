<?php $user_role   = $_SESSION['user_role']; ?>
<?php $add_permission = $this->permission->grant(USEFUL_LINK,'add'); ?>
<?php $edit_permission = $this->permission->grant(USEFUL_LINK,'edit'); ?>
<?php $delete_permission = $this->permission->grant(USEFUL_LINK,'delete'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header"> 
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Useful Link</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Useful Link</li>
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
              <h3 class="card-title">Useful Link</h3>
              <?php if($add_permission == true || $user_role == 1){ ?>
              <div class="float-right"><a href="#" data-toggle="modal" data-target="#modal-default" class="btn btn-block btn-primary btn-sm"><i class="fa fa-plus text-xs"></i> Add Useful Link</a></div>
              <?php } ?>
            </div>
            <!-- /.card-header -->
            <div class="card-body" id="show_data">
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
    <div class="modal fade" id="modal-default">
      <div class="modal-dialog">
        <div class="modal-content">
          <form data-toggle="validator" role="form" method='POST' class="form-horizontal" action='<?php echo base_url();?>useful_link/add' id="add-form" name="add-form" enctype='multipart/form-data'>
          <div class="modal-header">
            <h4 class="modal-title">Add Useful Link</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="form-group col-md-12">
                <label for="title">Title<span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control" id="title" placeholder="Enter Title" required>
              </div>
              <div class="form-group col-md-12">
                <label for="link">Link<span class="text-danger">*</span></label>
                <input type="text" name="link" class="form-control" id="link" required placeholder="Enter Link">
              </div>
              <div class="form-group col-md-12">
                  <label >Status</label>
                  <select id="status" name="status" class="form-control form-control-sm select2" style="width: 100%;">
                    <option value="1">Active</option>
                    <option value="0">In-Active</option>
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
    <div class="modal fade" id="modal-edit">
      <div class="modal-dialog">
        <div class="modal-content">
          <form data-toggle="validator" role="form" method='POST' class="form-horizontal2" action='<?php echo base_url();?>useful_link/update' id="edit-form" name="edit-form" enctype='multipart/form-data'>
          <div class="modal-header">
            <h4 class="modal-title">Edit Useful Link</h4>
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
        //call function show all useful_link
        show_data();
        //function show all useful_link
        function show_data(){
          $('#modal-loader').modal('hide');
            $.ajax({
                type  : 'POST',
                url   : '<?php echo base_url('admin/useful_link/data')?>',
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
                  url: "<?php echo base_url('admin/useful_link/add')?>",
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
                url   : '<?php echo base_url('admin/useful_link/getEdit')?>/'+id,
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
                  url: "<?php echo base_url('admin/useful_link/update')?>",
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
            if(conuseful_link('Are you sure want to delete?')){
              $.ajax({
                  type : "POST",
                  url: "<?php echo base_url();?>admin/useful_link/delete/"+id,
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