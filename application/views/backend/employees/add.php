<?php $user_role = $_SESSION['user_role']; ?>
<?php $add_permission = $this->permission->grant(EMPLOYEES,'add'); ?> 
<?php $edit_permission = $this->permission->grant(EMPLOYEES,'edit'); ?>
<?php $delete_permission = $this->permission->grant(EMPLOYEES,'delete'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><?php if(isset($record['id'])){ echo 'Update';}else{ echo 'Add'; } ?> Employee</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/Employee">Employee</a></li>
            <li class="breadcrumb-item active"><?php if(isset($record['id'])){ echo 'Update';}else{ echo 'Add'; } ?> Employee</li>
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
              <h3 class="card-title"><?php if(isset($record['id'])){ echo 'Update';}else{ echo 'Add'; } ?> Employee</h3>
            </div>
            <!-- /.card-header -->
            
              <form data-toggle="validator" role="form" method='POST' class="form-horizontal" action='<?php echo base_url();?>admin/Employees/<?php if(isset($record['id'])){ echo 'edit/'.base64_encode($record['id']);}else{ echo 'add'; } ?>' id="add-form" name="add-form" enctype='multipart/form-data'>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="name">First Name</label>
                      <input type="text" name="first_name" class="form-control" id="first_name" placeholder="First Name" value="<?php if(isset($record['first_name'])){ echo $record['first_name'];} ?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="name">Last Name</label>
                      <input type="text" name="last_name" class="form-control" id="last_name" placeholder="Last Name" value="<?php if(isset($record['last_name'])){ echo $record['last_name'];} ?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="name">Employee Code</label>
                      <input type="text" name="employee_code" class="form-control" id="employee_code" placeholder="Employee Code" value="<?php if(isset($record['employee_code'])){ echo $record['employee_code'];} ?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="name">NID</label>
                      <input type="text" name="nid" class="form-control" id="nid" placeholder="NID" value="<?php if(isset($record['nid'])){ echo $record['nid'];} ?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="name">Contact Number</label>
                      <input type="text" name="contact_number" class="form-control" id="contact_number" placeholder="Contact Number" value="<?php if(isset($record['contact_number'])){ echo $record['contact_number'];} ?>">
                    </div>
                  </div>
                  <div class="col-md-4"> 
                    <div class="form-group">
                     <label>Select Gender: </label>
                     <select id="gender" name="gender" class="form-control form-control-sm select2">
                       <option value="1" <?php if(isset($record['gender'])){
                        if($record['gender'] == 1){ echo 'selected'; }
                      }else{
                        if(set_value('gender') == 1){ echo 'selected'; }
                      } ?>>Male</option>
                      <option value="0" <?php if(isset($record['gender'])){
                        if($record['gender'] == 0){ echo 'selected'; }
                      }else{
                        if(set_value('gender') == 0){ echo ''; }
                      } ?>>Female</option>
                    </select>
                    </div>
                  </div>
                  <div class="col-md-4"> 
                    <div class="form-group">
                     <label>Designation: </label>
                     <select id="designation" name="designation" class="form-control form-control-sm select2">
                       <option value="1" <?php if(isset($record['designation'])){
                        if($record['designation'] == 1){ echo 'selected'; }
                      }else{
                        if(set_value('designation') == 1){ echo 'selected'; }
                      } ?>>Vice Chairman</option>
                      <option value="2" <?php if(isset($record['designation'])){
                        if($record['designation'] == 2){ echo 'selected'; }
                      }else{
                        if(set_value('designation') == 2){ echo ''; }
                      } ?>>Chief Executive Officer (CEO)</option>
                      <option value="3" <?php if(isset($record['designation'])){
                        if($record['designation'] == 3){ echo 'selected'; }
                      }else{
                        if(set_value('designation') == 3){ echo ''; }
                      } ?>>Chief Finance & Admin Officer</option>
                      <option value="4" <?php if(isset($record['designation'])){
                        if($record['designation'] == 4){ echo 'selected'; }
                      }else{
                        if(set_value('designation') == 4){ echo ''; }
                      } ?>>Jr. Finance & Admin Officer</option>
                    </select>
                    </div>
                  </div>
                  <div class="col-md-4"> 
                    <div class="form-group">
                     <label>Blood Group: </label>
                     <select id="blood" name="blood" class="form-control form-control-sm select2">
                       <option value="1" <?php if(isset($record['blood'])){
                        if($record['blood'] == 1){ echo 'selected'; }
                      }else{
                        if(set_value('blood') == 1){ echo 'selected'; }
                      } ?>>O+</option>
                      <option value="2" <?php if(isset($record['blood'])){
                        if($record['blood'] == 2){ echo 'selected'; }
                      }else{
                        if(set_value('blood') == 2){ echo ''; }
                      } ?>>O-</option>
                      <option value="3" <?php if(isset($record['blood'])){
                        if($record['blood'] == 3){ echo 'selected'; }
                      }else{
                        if(set_value('blood') == 3){ echo ''; }
                      } ?>>A+</option>
                      <option value="4" <?php if(isset($record['blood'])){
                        if($record['blood'] == 4){ echo 'selected'; }
                      }else{
                        if(set_value('blood') == 4){ echo ''; }
                      } ?>>A-</option>
                      <option value="5" <?php if(isset($record['blood'])){
                        if($record['blood'] == 5){ echo 'selected'; }
                      }else{
                        if(set_value('blood') == 5){ echo ''; }
                      } ?>>B+</option>
                      <option value="6" <?php if(isset($record['blood'])){
                        if($record['blood'] == 6){ echo 'selected'; }
                      }else{
                        if(set_value('blood') == 6){ echo ''; }
                      } ?>>B-</option>
                      <option value="7" <?php if(isset($record['blood'])){
                        if($record['blood'] == 7){ echo 'selected'; }
                      }else{
                        if(set_value('blood') == 7){ echo ''; }
                      } ?>>AB+</option>
                    </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="name">Date Of Birth</label>
                      <input type="date" name="dob" class="form-control" id="dob" placeholder="" value="<?php if(isset($record['dob'])){ echo $record['dob'];} ?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="name">Date Of Joining</label>
                      <input type="date" name="dob_joining" class="form-control" id="dob_joining" placeholder="" value="<?php if(isset($record['dob_joining'])){ echo $record['dob_joining'];} ?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="name">Date Of Leaving</label>
                      <input type="date" name="leaving" class="form-control" id="leaving" placeholder="" value="<?php if(isset($record['leaving'])){ echo $record['leaving'];} ?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="name">Username</label>
                      <input type="text" name="user_name" class="form-control" id="user_name" placeholder="User Name" value="<?php if(isset($record['user_name'])){ echo $record['user_name'];} ?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="name">Email</label>
                      <input type="email" name="email" class="form-control" id="email" placeholder="Email" value="<?php if(isset($record['email'])){ echo $record['email'];} ?>">
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