<?php $user_role = $_SESSION['user_role']; ?>
<?php $add_permission = $this->permission->grant(ATTENDANCE,'add'); ?> 
<?php $edit_permission = $this->permission->grant(ATTENDANCE,'edit'); ?>
<?php $delete_permission = $this->permission->grant(ATTENDANCE,'delete'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><?php if(isset($record['id'])){ echo 'Update';}else{ echo 'Add'; } ?> Attendance</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/Attendance">Attendance</a></li>
            <li class="breadcrumb-item active"><?php if(isset($record['id'])){ echo 'Update';}else{ echo 'Add'; } ?> Attendance</li>
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
              <h3 class="card-title"><?php if(isset($record['id'])){ echo 'Update';}else{ echo 'Add'; } ?> Attendance</h3>
            </div>
            <!-- /.card-header -->
            
              <form data-toggle="validator" role="form" method='POST' class="form-horizontal" action='<?php echo base_url();?>admin/Attendance/<?php if(isset($record['id'])){ echo 'edit/'.base64_encode($record['id']);}else{ echo 'add'; } ?>' id="add-form" name="add-form" enctype='multipart/form-data'>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="employee">Employee Name<span class="text-danger">*</span></label>
                      <select class="form-control select2" id="employee" name="employee" style="width: 100%;">
                      <option value="">Select</option>
                      <?php
                        $this->db->where('status',1);
                        $employee = $this->db->get('employees')->result_array();
                        if($employee){
                            foreach ($employee as $value){
                        ?>
                        <option <?php echo (($record['employee']==$value['id'])? "selected":"");?> value="<?php echo $value['id'];?>"><?php echo $value['first_name'];?></option>
                      <?php } } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="name">Select Date</label>
                      <input type="date" name="date" class="form-control" id="date" placeholder="" value="<?php if(isset($record['date'])){ echo $record['date'];} ?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="name">Sign In Time</label>
                      <input type="time" name="sign_in" class="form-control" id="sign_in" placeholder="" value="<?php if(isset($record['sign_in'])){ echo $record['sign_in'];} ?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="name">Sign Out Time</label>
                      <input type="time" name="sign_out" class="form-control" id="sign_out" placeholder="" value="<?php if(isset($record['sign_out'])){ echo $record['sign_out'];} ?>">
                    </div>
                  </div>
                  <div class="col-md-4"> 
                    <div class="form-group">
                     <label>Place</label>
                     <select id="place" name="place" class="form-control form-control-sm select2">
                       <option value="1" <?php if(isset($record['place'])){
                        if($record['place'] == 1){ echo 'selected'; }
                      }else{
                        if(set_value('place') == 1){ echo 'selected'; }
                      } ?>>Office</option>
                      <option value="2" <?php if(isset($record['place'])){
                        if($record['place'] == 2){ echo 'selected'; }
                      }else{
                        if(set_value('place') == 2){ echo ''; }
                      } ?>>Field</option>
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