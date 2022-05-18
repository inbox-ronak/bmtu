<?php $user_role = $_SESSION['user_role']; ?>
<?php $add_permission = $this->permission->grant(QR_CODE,'add'); ?>
<?php $edit_permission = $this->permission->grant(QR_CODE,'edit'); ?>
<?php $delete_permission = $this->permission->grant(QR_CODE,'delete'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><?php if(isset($label['id'])){ echo 'Update';}else{ echo 'Add'; } ?> Generate Qr Code</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/qr_code">Label</a></li>
            <li class="breadcrumb-item active"><?php if(isset($label['id'])){ echo 'Update';}else{ echo 'Add'; } ?> Qr</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <?php //echo '<pre>';print_r($label);?>
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title"><?php if(isset($label['id'])){ echo 'Update';}else{ echo 'Add'; } ?> Generate Qr Code</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body" id="show_data">
              <form data-toggle="validator" role="form" method='POST' class="form-horizontal" action='<?php echo base_url();?>admin/qr_code/<?php if(isset($label['id'])){ echo 'edit/'.base64_encode($label['id']);}else{ echo 'getDataWithQR'; } ?>' id="add-form" name="add-form" enctype='multipart/form-data'>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="series_id">Enter Label</label>
                      <select class="form-control select2" id="series_id" required name="series_id" style="width: 100%;">
                      <option value="">Select</option>
                      <?php
                        $this->db->where('status',1);
                        $series = $this->db->get('series_master')->result_array();
                        if($series){
                            foreach ($series as $value){
                        ?>
                        <option <?php echo (($label['series_id']==$value['id'])? "selected":"");?> value="<?php echo $value['series_name'];?>"><?php echo $value['series_name'];?></option>
                      <?php } } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="name">&nbsp;</label>
                      <input type="number" name="user_list" class="form-control" id="user_list" required value="<?php if(isset($label['user_list'])){ echo $label['user_list'];} ?>">
                    </div>
                  </div>                    
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <button type="submit" name="submit" class="btn btn-primary">Save</button>
                    </div>
                  </div>
                </div>
              </form>
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
<!-- /.content-wrapper -->
<script>
  $(document).ready(function(){
    function user_type(){
      var value = $('#user_type').find('option:selected').val();
      //console.log()
      if (value == '2')
      {
        $(".user_list_chapter").show();
        $(".user_list_au").hide();
        
      }
      else if (value == '3')
      {
        $(".user_list_chapter").hide();
        $(".user_list_au").show();
      }
      else
      {
        $(".user_list_chapter").hide();
        $(".user_list_au").hide();
        
      }
    }
    user_type();
    $('#user_type').on('change',function(){
      user_type();
    });


});
</script>