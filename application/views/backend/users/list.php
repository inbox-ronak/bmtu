<?php $user_role = $_SESSION['user_role']; ?>
<?php $add_permission = $this->permission->grant(USERS,'add'); ?>
<?php $edit_permission = $this->permission->grant(USERS,'edit'); ?>
<?php $delete_permission = $this->permission->grant(USERS,'delete'); ?>
<style type="text/css">
  .hidecheck {
    display: none;
  }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Users</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Users</li>
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
              <h3 class="card-title">Users</h3>
                <?php if($add_permission == true || $user_role == 1){ ?>
                  <div class="float-right"><a href="#" data-toggle="modal" data-target="#modal-default" class="btn btn-block btn-primary btn-sm"><i class="fa fa-plus text-xs"></i> Add User</a></div>
                <?php } ?>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="table-responsive" id="show_data"></div>
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
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <form data-toggle="validator" role="form" method='POST' class="form-horizontal" action='<?php echo base_url();?>users/addUser' id="add-form" name="add-form" enctype='multipart/form-data'>
          <div class="modal-header">
            <h4 class="modal-title">Add User Details</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="form-group col-md-6 required mt-3">
                <label for="username">User Name</label>
                <input type="text" name="username" class="form-control" id="username" placeholder="Enter User Name" required>
              </div>
              <div class="form-group col-md-6 required mt-3">
                <label for="firstname">First Name</label>
                <input type="text" name="firstname" class="form-control" id="firstname" placeholder="Enter First Name" required>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-md-6 required">
                <label for="lastname">Last Name</label>
                <input type="text" name="lastname" class="form-control" id="lastname" placeholder="Enter Last Name" required>
              </div>
              <div class="form-group col-md-6">
                <label for="address">Address</label>
                <input type="text" name="address" class="form-control" id="address" placeholder="Enter Address">
              </div>
            </div>
            <div class="row">
              <div class="form-group col-md-6 required">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="Enter Email" required autocomplete="username">
              </div>
              <div class="form-group col-md-6 required">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Enter Password" required autocomplete="new-password">
                <div id="meter_wrapper" class="meter_wrapper" style="display: none;">
                  <div id="meter" class="meter"></div>
                  <div id="pass_type" class="pass_type"></div>
                </div>
                <!-- <p>Please Enter Strong Password</p> -->
                <ul style="padding-left: 3%;padding-top: 1%;">
                    <li class="">1 lowercase &amp; 1 uppercase</li>
                    <li class="">1 number (0-9)</li>
                    <li class="">1 Special Character (!@#$%^&*).</li>
                    <li class="">Atleast 6 Character</li>
                </ul>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-md-6 required">
                <label for="cpassword">Confirm password</label>
                <input type="password" name="cpassword" class="form-control" id="cpassword" placeholder="Enter Confirm Password" required autocomplete="new-password">
                <span id="divCheckPasswordMatch"></span>
              </div>
              <div class="form-group col-md-6">
                <label for="phone_no">Mobile Number</label>
                <input type="text" name="phone_no" class="form-control" id="phone_no" placeholder="Enter Mobile Number">
              </div>
            </div>
            <div class="row">
              <!-- <input type="hidden" name="status" value="0">
              <div class="form-check col-md-6 mb-2">
                <input type="checkbox" class="form-check-input" id="status" checked name="status" value="1">
                <label class="form-check-label" for="status">Active</label>
              </div>
               -->
              <div class="form-group col-md-6">
                <label >Status</label>
                <select id="status" name="status" class="form-control form-control-sm select2" style="width: 100%;">
                  <option value="1">Active</option>
                  <option value="0">In-Active</option>
                </select>
              </div>
              <div class="form-group col-md-6 required">
                <label for="role_id">Role</label>
                <select class="form-control select2" id="role_id" required name="role_id" style="width: 100%;">
                  <option value="">Select</option>
                  <?php
                    $this->db->where('status',1);
                    $roles = $this->db->get('role_master')->result_array();
                    if($roles){
                        foreach ($roles as $value){
                    ?>
                              <option value="<?php echo $value['id'];?>"><?php echo $value['role_name'];?></option>
                  <?php } } ?>
                </select>
              </div>
            </div>
            <div class="row">
              <!-- start modules permission -->
              <div class="modules  col-md-12">

              </div>
              <!-- end module permission -->
            </div>
            </div>
          	<div class="modal-footer justify-content-between">
            	<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            	<button type="submit" name="submit" id="btn_save" class="btn btn-primary">Save</button>
          	</div>
          </form>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- edit modal -->
    <div class="modal fade" id="modal-edit">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <form data-toggle="validator" role="form" method='POST' class="form-horizontal2" action='<?php echo base_url();?>users/update_user' id="edit-form" name="edit-form" enctype='multipart/form-data'>
          <div class="modal-header">
            <h4 class="modal-title">Edit User</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="editUserModel">
            
          </div>
          <div class="modal-footer justify-content-between">
            <input type="hidden" name="user_id" id="user_id_edit">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button type="submit" name="submit" id="btn_update" class="btn btn-primary">Save</button>
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
        //call function show all roles
        show_data();
        //function show all roles
        function show_data(){
          $('#modal-loader').modal('hide');
            $.ajax({
                type  : 'POST',
                url   : '<?php echo base_url('admin/users/data')?>',
                async : true,
                //dataType : 'json',
                success : function(data){
                    $('#show_data').html(data);
                    $('#example2').dataTable({"aaSorting":[]});
                }
 
            });
        }
        //Save role
        $('#btn_save').on('click',function(event){
            event.preventDefault();
            if($("#add-form").valid()){
            var form = $('#add-form')[0];
            var formData = new FormData(form);
              $.ajax({
                  type: "POST",
                  url: "<?php echo base_url('admin/users/addUser')?>",
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
                      //console.log(msg);
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
            var userId = $(this).data('user_id');
            $('#modal-edit').modal('show');
            $.ajax({
                type  : 'POST',
                url   : '<?php echo base_url('admin/users/getUserEdit')?>/'+userId,
                dataType : 'html',
                success : function(data){
                    $('#user_id_edit').val(userId);
                    $('#editUserModel').html(data);
                    $('.select2').select2();
                    role_edit();
                    toggle_switch();
                    user_edit();
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
                  url: "<?php echo base_url('admin/users/update_user')?>",
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
            var user_id = $(this).data('user_id');
            if(confirm('Are you sure want to delete?')){
              $.ajax({
                  type : "POST",
                  url: "<?php echo base_url();?>admin/users/delete_user/"+user_id,
                  dataType : "JSON",
                  data : {user_id:user_id},
                  success: function(msg){
                      success_msg(msg.success,msg.message);
                      show_data();
                  }
              });
            }
            return false;
        });
      // start module permission //
      //  modules();
      // end module permission //
    });

$("#role_id").on("change",function(){
  var user_role = $('#role_id').val();
  $.ajax({
        type  : 'POST',
        url   : '<?php echo base_url('admin/users/modules_permission')?>',
        async : true,
        data : {user_role:user_role},
        success : function(data){
            $('.modules').html(data);
            toggle_switch();
        }
    });
});

function toggle_switch(){

  $(".child").on("click",function(){
      var id = $(this).attr('data-id');
      $parent = $(".parent"+id);
      if ($(this).is(":checked")){
        $parent.prop("checked",true);
      }else{
        var len = $parent.parent().find(".child:checked").length;
        if(len > 0){
          $parent.prop("checked",true);
        }else{
          $parent.prop("checked",false);
        }
      }    
  });
  $(".editchild").on("click",function(){
      //alert();
      var id = $(this).attr('data-id');
      $parent = $(".editparent"+id);
      if ($(this).is(":checked")){
        $parent.prop("checked",true);
      }else{
        var len = $parent.parent().find(".editchild:checked").length;
        if(len > 0){
          $parent.prop("checked",true);
        }else{
          $parent.prop("checked",false);
        }
      }    
  });
   // $(".parent").on("click",function() {
   //     $(this).parent().find(".child").prop("checked",this.checked);
   // });
}

function role_edit(){
  $("#role_id_edit").on("change",function(){
    var user_role = $('#role_id_edit').val();
    $.ajax({
          type  : 'POST',
          url   : '<?php echo base_url('admin/users/modules_permission')?>',
          async : true,
          data : {user_role:user_role},
          success : function(data){
              $('.modules_edit').html(data);
              toggle_switch();
          }
      });
  });
}
</script>