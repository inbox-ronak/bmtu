<?php $user_role = $_SESSION['user_role']; ?>
<?php $add_permission = $this->permission->grant(DISCIPLINARY,'add'); ?> 
<?php $edit_permission = $this->permission->grant(DISCIPLINARY,'edit'); ?>
<?php $delete_permission = $this->permission->grant(DISCIPLINARY,'delete'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><?php if(isset($record['id'])){ echo 'Update';}else{ echo 'Add'; } ?> Disciplinary</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/Employee">Employee</a></li>
            <li class="breadcrumb-item active"><?php if(isset($record['id'])){ echo 'Update';}else{ echo 'Add'; } ?> Disciplinary</li>
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
              <h3 class="card-title"><?php if(isset($record['id'])){ echo 'Update';}else{ echo 'Add'; } ?> Disciplinary</h3>
            </div>
            <!-- /.card-header -->
            
              <form data-toggle="validator" role="form" method='POST' class="form-horizontal" action='<?php echo base_url();?>admin/Disciplinary/<?php if(isset($record['id'])){ echo 'edit/'.base64_encode($record['id']);}else{ echo 'add'; } ?>' id="add-form" name="add-form" enctype='multipart/form-data'>
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
                     <label>Disciplinary Action</label>
                     <select id="disciplinary" name="disciplinary" class="form-control form-control-sm select2">
                       <option value="1" <?php if(isset($record['disciplinary'])){
                        if($record['disciplinary'] == 1){ echo 'selected'; }
                      }else{
                        if(set_value('disciplinary') == 1){ echo 'selected'; }
                      } ?>>Verbel Warning</option>
                      <option value="2" <?php if(isset($record['disciplinary'])){
                        if($record['disciplinary'] == 2){ echo 'selected'; }
                      }else{
                        if(set_value('disciplinary') == 2){ echo ''; }
                      } ?>>Writing Warning</option>
                      <option value="3" <?php if(isset($record['disciplinary'])){
                        if($record['disciplinary'] == 3){ echo 'selected'; }
                      }else{
                        if(set_value('disciplinary') == 3){ echo ''; }
                      } ?>>Demotion</option>
                      <option value="4" <?php if(isset($record['disciplinary'])){
                        if($record['disciplinary'] == 4){ echo 'selected'; }
                      }else{
                        if(set_value('disciplinary') == 4){ echo ''; }
                      } ?>>Suspension</option>
                    </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="name">Title</label>
                      <input type="text" name="title" class="form-control" id="title" placeholder="Enter Title" value="<?php if(isset($record['title'])){ echo $record['title'];} ?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="name">Details</label>
                      <textarea name="details" class="form-control" id="details" placeholder="Details" required><?php if(isset($record['details'])){echo $record['details'];}?></textarea>
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