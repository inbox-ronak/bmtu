<?php $user_role = $_SESSION['user_role']; ?>
<?php $add_permission = $this->permission->grant(STUDENT_REGISTRATION,'add'); ?> 
<?php $edit_permission = $this->permission->grant(STUDENT_REGISTRATION,'edit'); ?>
<?php $delete_permission = $this->permission->grant(STUDENT_REGISTRATION,'delete'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><?php if(isset($record['id'])){ echo 'Update';}else{ echo 'Add'; } ?> Student Registration</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/StudentRegistration">Student Registration</a></li>
            <li class="breadcrumb-item active"><?php if(isset($record['id'])){ echo 'Update';}else{ echo 'Add'; } ?> Student Registration</li>
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
              <h3 class="card-title"><?php if(isset($record['id'])){ echo 'Update';}else{ echo 'Add'; } ?> Student Registration</h3>
            </div>
            <!-- /.card-header -->
            
              <form data-toggle="validator" role="form" method='POST' class="form-horizontal" action='<?php echo base_url();?>admin/StudentRegistration/<?php if(isset($record['id'])){ echo 'edit/'.base64_encode($record['id']);}else{ echo 'add'; } ?>' id="add-form" name="add-form" enctype='multipart/form-data'>
              <input type="hidden" class="form-control" readonly name="student_id" value="<?php if(isset($record['student_id'])){ echo $record['student_id'];} ?>">
                <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                      <label for="hsc_seat_no">HSC Seat Number</label>
                      <input type="text" name="hsc_seat_no" class="form-control" id="hsc_seat_no" placeholder="" required value="<?php if(isset($record['hsc_seat_no'])){ echo $record['hsc_seat_no'];} ?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="mother_name">Mother Name</label>
                      <input type="text" name="mother_name" class="form-control" id="mother_name" placeholder="" required value="<?php if(isset($record['mother_name'])){ echo $record['mother_name'];} ?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="primary_mobile_no">Primary Mobile Number</label>
                      <input type="number" min='0' name="primary_mobile_no" class="form-control" id="primary_mobile_no" placeholder="" required value="<?php if(isset($record['primary_mobile_no'])){ echo $record['primary_mobile_no'];} ?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="secondary_mobile_no">Secondary Mobile Number</label>
                      <input type="number" min='0' name="secondary_mobile_no" class="form-control" id="secondary_mobile_no" placeholder="" required value="<?php if(isset($record['secondary_mobile_no'])){ echo $record['secondary_mobile_no'];} ?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="email">Email Id</label>
                      <input type="email" name="email" class="form-control" id="email" placeholder="" required value="<?php if(isset($record['email'])){ echo $record['email'];} ?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="dob">Date of Birth</label>
                      <input type="date" name="dob" class="form-control" id="dob" placeholder="" required value="<?php if(isset($record['dob'])){ echo $record['dob'];} ?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="category">Category</label>
                      <!-- <input type="date" name="category" class="form-control" id="category" placeholder="" required value="<?php if(isset($record['category'])){ echo $record['category'];} ?>"> -->
                      <select class="form-control" name="category" id="category">
                        <option value="general" <?php if(isset($record['category'])){
                        if($record['category'] == 'general'){ echo 'selected'; } } ?>>General</option>
                        <option value="sebc" <?php if(isset($record['category'])){
                        if($record['category'] == 'sebc'){ echo 'selected'; } } ?>>SEBC</option>
                        <option value="sc" <?php if(isset($record['category'])){
                        if($record['category'] == 'sc'){ echo 'selected'; } } ?>>SC</option>
                        <option value="st" <?php if(isset($record['category'])){
                        if($record['category'] == 'st'){ echo 'selected'; } } ?>>ST</option>
                        <option value="ph" <?php if(isset($record['category'])){
                        if($record['category'] == 'ph'){ echo 'selected'; } } ?>>PH</option>
                        <option value="minority" <?php if(isset($record['category'])){
                        if($record['category'] == 'minority'){ echo 'selected'; } } ?>>Minority</option>
                        <option value="ews" <?php if(isset($record['category'])){
                        if($record['category'] == 'ews'){ echo 'selected'; } } ?>>EWS</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="sub_category">Sub-Category</label>
                      <input type="text" name="sub_category" class="form-control" id="sub_category" placeholder="" value="<?php if(isset($record['sub_category'])){ echo $record['sub_category'];} ?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="gender">Gender</label>
                      <!-- <input type="date" name="gender" class="form-control" id="gender" placeholder="" required value="<?php if(isset($record['gender'])){ echo $record['gender'];} ?>"> -->
                      <select class="form-control" name="gender" id="gender">
                        <option value="male" <?php if(isset($record['gender'])){
                        if($record['gender'] == 'male'){ echo 'selected'; } } ?>>Male</option>
                        <option value="female" <?php if(isset($record['gender'])){
                        if($record['gender'] == 'female'){ echo 'selected'; } } ?>>Female</option>
                      </select>
                    </div>
                  </div>
                  <!-- <div class="col-md-4"> 
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
                  </div> -->
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