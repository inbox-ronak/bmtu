<?php $user_role = $_SESSION['user_role']; ?>
<?php $add_permission = $this->permission->grant(ROLE,'add'); ?>
<?php $edit_permission = $this->permission->grant(ROLE,'edit'); ?>
<?php $delete_permission = $this->permission->grant(ROLE,'delete'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header"> 
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Roles</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Roles</li>
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
              <h3 class="card-title">Roles</h3>
              <?php if($add_permission == true || $user_role == 1){ ?>
              <div class="float-right"><a href="#" data-toggle="modal" data-target="#modal-default" class="btn btn-block btn-primary btn-sm"><i class="fa fa-plus text-xs"></i> Add Role</a></div>
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
          <form data-toggle="validator" role="form" method='POST' class="form-horizontal" action='<?php echo base_url();?>role/add_role' id="add-form" name="add-form" enctype='multipart/form-data'>
          <div class="modal-header">
            <h4 class="modal-title">Add Role</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="role">Role Name</label>
              <input type="text" name="role" class="form-control" id="role" placeholder="Enter Role Name" required>
            </div>
            <?php
                  $this->db->where('parent',0);
                  $modules = $this->db->get('modules')->result_array();
                  if($modules){
                      foreach ($modules as $module){

                        if($module['has_child'] == 1){
                  ?>
                  <table>
                    <tr>
                      <td>
                        <div class="form-check">
                          <input type="checkbox" class="parent<?php echo $module['id'];?> form-check-input" id="module<?php echo $module['id'];?>" name="modules[]" value="<?php echo $module['id'];?>">
                          <label class="form-check-label" for="module<?php echo $module['id'];?>"><?php echo $module['module_name'];?></label>
                        </div>
                          <?php 
                          $sub_modules = $this->db->where('parent',$module['id'])->get('modules')->result_array(); 
                            if($sub_modules){ ?>
                          <table class="ml-4">
                          <?php foreach ($sub_modules as $value){ ?>
                          <tr>
                            <td>
                              <div class="form-check">
                                <input type="checkbox" class="childparent<?php echo $module['id'];?> child form-check-input" id="module<?php echo $value['id'];?>" name="modules[]" data-id="<?php echo $module['id'];?>" value="<?php echo $value['id'];?>">
                                <label class="form-check-label" for="module<?php echo $value['id'];?>"><?php echo $value['module_name'];?></label>
                              </div>
                            </td>
                          </tr>
                          <?php } ?>
                          </table>
                          <?php } ?>
                      </td>
                    </tr>
                  </table>
                  <?php }else{ ?>

                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="module<?php echo $module['id'];?>" name="modules[]" value="<?php echo $module['id'];?>">
                    <label class="form-check-label" for="module<?php echo $module['id'];?>"><?php echo $module['module_name'];?></label>
                  </div>
                      
                  <?php 
                        }
                      }
                    } 
                  ?>
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
          <form data-toggle="validator" role="form" method='POST' class="form-horizontal2" action='<?php echo base_url();?>roles/update_role' id="edit-form" name="edit-form" enctype='multipart/form-data'>
          <div class="modal-header">
            <h4 class="modal-title">Edit Role</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="editRoleModel" >
            
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
        //call function show all roles
        show_data();
        //function show all roles
        function show_data(){
          $('#modal-loader').modal('hide');
            $.ajax({
                type  : 'POST',
                url   : '<?php echo base_url('admin/roles/data')?>',
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
                  url: "<?php echo base_url('admin/roles/add_role')?>",
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
            var role_id = $(this).data('role_id');
            var role = $(this).data('role');
            $('#modal-edit').modal('show');
            $.ajax({
                type  : 'POST',
                url   : '<?php echo base_url('admin/roles/getRoleEdit')?>/'+role_id,
                dataType : 'html',
                success : function(data){
                  $('#editRoleModel').html(data);
                  role_edit();
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
                  url: "<?php echo base_url('admin/roles/update_role')?>",
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
            var role_id = $(this).data('role_id');
            if(confirm('Are you sure want to delete?')){
              $.ajax({
                  type : "POST",
                  url: "<?php echo base_url();?>admin/roles/delete_role/"+role_id,
                  dataType : "JSON",
                  data : {role_id:role_id},
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
<script type="text/javascript">
  $(".child").on("click",function(){
      //alert();
      var id = $(this).attr('data-id');
      $parent = $(".parent"+id);
      if ($(this).is(":checked")){
        $parent.prop("checked",true);
      }else{
        var len = $parent.parent().parent().find(".child:checked").length;
        //console.log($parent.parent().parent());
        if(len > 0){
          $parent.prop("checked",true);
        }else{
          $parent.prop("checked",false);
        }
      }    
  });
  $('[class^="parent"]').on("click",function() {
    var id = $(this).val();
    $('.childparent'+id).prop("checked",this.checked);
  });

function role_edit(){
  $(".editchild").on("click",function(){
      //alert();
      var id = $(this).attr('data-id');
      $parent = $(".editparent"+id);
      if ($(this).is(":checked")){
        $parent.prop("checked",true);
      }else{
        var len = $parent.parent().parent().find(".editchild:checked").length;
        //console.log($parent.parent().parent());
        if(len > 0){
          $parent.prop("checked",true);
        }else{
          $parent.prop("checked",false);
        }
      }    
  });
  $('[class^="editparent"]').on("click",function() {
    var id = $(this).val();
    $('.editchildparent'+id).prop("checked",this.checked);
  });
}
</script>