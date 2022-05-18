<?php $user_role = $_SESSION['user_role']; ?>
<?php $add_permission = $this->permission->grant(PROGRAM,'add'); ?> 
<?php $edit_permission = $this->permission->grant(PROGRAM,'edit'); ?>
<?php $delete_permission = $this->permission->grant(PROGRAM,'delete'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><?php if(isset($record['id'])){ echo 'Update';}else{ echo 'Add'; } ?> Program</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/Program">Program</a></li>
            <li class="breadcrumb-item active"><?php if(isset($record['id'])){ echo 'Update';}else{ echo 'Add'; } ?> Program</li>
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
            <div class="card-body" id="show_data">
            
            <div class="table-responsive" id="show_data">
          </div>
              <h3 class="card-title"><?php if(isset($record['id'])){ echo 'Update';}else{ echo 'Add'; } ?> Program</h3>
            </div>
            <!-- /.card-header -->
              <form data-toggle="validator" role="form" method='POST' class="form-horizontal" action='<?php echo base_url();?>admin/Program/<?php if(isset($record['id'])){ echo 'edit/'.base64_encode($record['id']);}else{ echo 'add'; } ?>' id="add-form" name="add-form" enctype='multipart/form-data'>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="college_name">College Name</label>
                      <!-- <input type="text" name="college_name" class="form-control" id="college_name" placeholder="" value="<?php if(isset($record['college_name'])){ echo $record['college_name'];} ?>"> -->
                      <select name="college_name" id="college_name" class="form-control select2" required>
                        <option value="">Select College Name</option>
                        <?php
                        foreach ($colleges as $key => $value) { ?>
                          <option value="<?= $value['id']; ?>" <?php if(isset($record['college_name'])) if($record['college_name'] == $value['id']){ echo 'selected'; } ?>><?= $value['college_name']; ?></option>
                        <?php }
                        ?>
                      </select>
                    </div>
                  </div>
                  <?php $department = (isset($record['department'])) ? $record['department'] : ''; ?>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="department">Department</label>
                      <!-- <input type="text" name="department" class="form-control" required id="department" placeholder="" value="<?php if(isset($record['department'])){ echo $record['department'];} ?>"> -->
                      <select name="department" id="department" class="form-control select2" required>
                        <option value="">Select Department</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="program_name">Program Name</label>
                      <input type="text" name="program_name" class="form-control" required id="program_name" placeholder="" value="<?php if(isset($record['program_name'])){ echo $record['program_name'];} ?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="program_duration">Program Duration(Year)</label>
                      <input type="number" name="program_duration" class="form-control" required id="program_duration" placeholder="" min="0" step="0.1" value="<?php if(isset($record['program_duration'])){ echo $record['program_duration'];} ?>">
                    </div>
                  </div>
                  
                  <div class="col-md-4"> 
                    <div class="form-group">
                     <label>Status: </label>
                     <select id="status" name="status" class="form-control form-control-sm select2">
                       <option value="1" <?php if(isset($record['status'])){
                        if($record['status'] == 1){ echo 'selected'; }
                      }else{
                        if(set_value('status') == 1){ echo 'selected'; }
                      } ?>>Active</option>
                      <option value="0" <?php if(isset($record['status'])){
                        if($record['status'] == 0){ echo 'selected'; }
                      }else{
                        if(set_value('status') == 0){ echo ''; }
                      } ?>>In-Active</option>
                    </select>
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
<script type="text/javascript">
    $(document).ready(function(){
      let old_department = '<?php echo $department; ?>';
      // alert(department);
      var college_name = $('#college_name').val();
      $.ajax({
        type : "POST",
        url: "<?php echo base_url();?>admin/Program/fetchDepartment",
        dataType : "JSON",
        data : {college_name:college_name},
        success: function(msg){
          $('#department').empty();
          $('#department').append(`<option value="">Select Department</option>`);
          // console.log(JSON.parse(JSON.stringify(msg)));
          JSON.parse(JSON.stringify(msg)).forEach(element => {
            $('#department').append('<option value='+element.department+'>'+element.department+'</option>');
          });
        }
      }).done(function (data) {
        $('#department').val(old_department);
      });
      
      $('#college_name').change(function(){
          var college_name = $(this).val();
          $.ajax({
              type : "POST",
              url: "<?php echo base_url();?>admin/Program/fetchDepartment",
              dataType : "JSON",
              data : {college_name:college_name},
              success: function(msg){
                $('#department').empty();
                $('#department').append(`<option value="">Select Department</option>`);
                JSON.parse(JSON.stringify(msg)).forEach(element => {
                  $('#department').append(`<option value="${element.department}">${element.department}</option>`);
                });
              }
          });
      });
    });
</script>