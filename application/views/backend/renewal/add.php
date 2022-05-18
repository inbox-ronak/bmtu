<?php $user_role = $_SESSION['user_role']; ?>
<?php $add_permission = $this->permission->grant(RENEWAL,'add'); ?>
<?php $edit_permission = $this->permission->grant(RENEWAL,'edit'); ?>
<?php $delete_permission = $this->permission->grant(RENEWAL,'delete'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h1><?php if(isset($renewal['id'])){ echo 'Update';}else{ echo 'Add'; } ?> Renewal</h1>
            </div>
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Dashboard</a></li>
                  <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/Renewal">Renewal</a></li>
                  <li class="breadcrumb-item active"><?php if(isset($renewal['id'])){ echo 'Update';}else{ echo 'Add'; } ?> Renewal</li>
               </ol>
            </div>
         </div>
      </div>
      <!-- /.container-fluid -->
   </section>
   <?php //echo '<pre>';print_r($label);?>
   <!-- Main content -->
   <section class="content">
      <div class="container-fluid">
         <div class="row">
            <div class="col-12">
               <div class="card">
                  <div class="card-header">
                     <h3 class="card-title"><?php if(isset($renewal['id'])){ echo 'Update';}else{ echo 'Add'; } ?> Renewal</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body" id="show_data">
                     <form data-toggle="validator" role="form" method='POST' class="form-horizontal" action='<?php echo base_url();?>admin/renewal/<?php if(isset($renewal['id'])){ echo 'edit/'.base64_encode($renewal['id']);}else{ echo 'add'; } ?>' id="add-form" name="add-form" enctype='multipart/form-data'>
                        <div class="row">
                           <!-- <div class="row"> -->
                              <div class="card col-md-12 card-header" >
                                 <div >
                                    <label for="renewal_description">APPLICATION FOR RENEWAL OF AUTHORISED USER REGISTRATION.</label>
                                    <div class="form-group">
                                       <textarea class="textarea summernote" name="renewal_description" placeholder="Place some text here" style="width: 100%; height: 700px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php if(isset($renewal['renewal_description'])){echo $renewal['renewal_description'];}else{echo set_value('renewal_description'); } ?></textarea>
                                    </div>
                                 </div>
                              </div>
                           <!-- </div> -->
                           <div class="card col-md-12 card-header" >
                              <h5 style="color: blue">Name and address of the firm :(IN CAPITAL LETTERS)</h5>
                              <div class="form-row">
                                 <div class="col-md-4">
                                    <div class="form-group">
                                       <label for="name">Name</label>
                                       <input type="text" name="name" class="form-control" id="name" value="<?php if(isset($renewal['name'])){ echo $renewal['name'];} ?>">
                                    </div>
                                 </div>
                                 <div class="col-md-4">
                                    <div class="form-group">
                                       <label for="door_no">Door No</label>
                                       <input type="text" name="door_no" class="form-control" id="door_no" value="<?php if(isset($renewal['door_no'])){ echo $renewal['door_no'];} ?>">
                                    </div>
                                 </div>
                                 <div class="col-md-4">
                                    <div class="form-group">
                                       <label for="road">Road</label>
                                       <input type="text" name="road" class="form-control" id="road" value="<?php if(isset($renewal['road'])){ echo $renewal['road'];} ?>">
                                    </div>
                                 </div>
                                 <div class="col-md-4">
                                    <div class="form-group">
                                       <label for="area">Area</label>
                                       <input type="text" name="area" class="form-control" id="area" value="<?php if(isset($renewal['area'])){ echo $renewal['area'];} ?>">
                                    </div>
                                 </div>
                                 <div class="col-md-4">
                                    <div class="form-group">
                                       <label for="city">City</label>
                                       <input type="text" name="city" class="form-control" id="city" value="<?php if(isset($renewal['city'])){ echo $renewal['city'];} ?>">
                                    </div>
                                 </div>
                                 <div class="col-md-4">
                                    <div class="form-group">
                                       <label for="state">State</label>
                                       <input type="text" name="state" class="form-control" id="state" value="<?php if(isset($renewal['state'])){ echo $renewal['state'];} ?>">
                                    </div>
                                 </div>
                                 <div class="col-md-4">
                                    <div class="form-group">
                                       <label for="pin">Pin</label>
                                       <input type="number" name="pin" class="form-control" id="pin" value="<?php if(isset($renewal['pin'])){ echo $renewal['pin'];} ?>">
                                    </div>
                                 </div>
                                 <div class="col-md-4">
                                    <div class="form-group">
                                       <label for="name_phone">Phone</label>
                                       <input type="number" name="name_phone" class="form-control" id="name_phone" value="<?php if(isset($renewal['name_phone'])){ echo $renewal['name_phone'];} ?>">
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="card col-md-12 card-header" >
                              <h5 style="color: blue">Type Of Membership</h5>
                              <div class="form-row">
                                 <div class="col-md-4">
                                    <div class="form-group">
                                       <select name="member_type" class="form-control select2" id="member_type" required style="width: 100%;">
                                  <option value="0">Select</option>
                                  <?php
                                    $this->db->where('id !=',1);
                                    $member_type = $this->db->get('member_type')->result_array();
                                    if($member_type){
                                        foreach ($member_type as $value){
                                    ?>
                                    <option <?php echo (($renewal['member_type']==$value['id'])? "selected":"");?> value="<?php echo $value['id'];?>"><?php echo $value['type'];?></option>
                                  <?php } } ?>
                                  </select>
                                    </div>
                                 </div>
                              </div>
                              <h5 style="color: blue">Telephone  No./Mobile No.</h5>
                              <div class="form-row">
                                 <div class="col-md-4">
                                    <div class="form-group">
                                       <!-- <label for="std_phone">STD-Phone Number</label> -->
                                       <input type="number" name="std_phone" placeholder="STD-Phone Number" class="form-control" id="std_phone" value="<?php if(isset($renewal['std_phone'])){ echo $renewal['std_phone'];} ?>">
                                    </div>
                                 </div>
                                 <div class="col-md-4">
                                    <div class="form-group">
                                       <!-- <label for="std_mobile_number">Mobile Number</label> -->
                                       <input type="std_mobile_number" name="std_mobile_number" placeholder="Mobile Number" class="form-control" id="std_mobile_number" value="<?php if(isset($renewal['std_mobile_number'])){ echo $renewal['std_mobile_number'];} ?>">
                                    </div>
                                 </div>
                              </div>
                              <div class="form-row">
                                 <div class="col-md-4">
                                    <div class="form-group">
                                       <h5 style="color: blue">Email</h5>
                                       <input type="email" name="email" class="form-control" id="email" value="<?php if(isset($renewal['email'])){ echo $renewal['email'];} ?>">
                                    </div>
                                 </div>
                              </div>
                            <!-- <div class="col-md-12"> -->
                               <div class="form-row">
                              <div class="col-md-4">
                              <h5 style="color: blue">Nature of Business</h5>
                              <!-- <div class="form-row"> -->
                                 <!-- <div class="col-md-6"> -->
                                    <div class="form-group">
                                       <!-- <label for="series_id">Manufacturer</label> -->
                                       <select class="form-control select2" id="nature_of_business" required name="nature_of_business" style="width: 100%;">
                                    <option value="">Select</option>
                                    <?php
                                      $this->db->where('status',1);
                                      $roles = $this->db->get('type_of_business')->result_array();
                                      if($roles){
                                          foreach ($roles as $value){
                                      ?>
                                                <option <?php echo (($renewal['nature_of_business']==$value['id'])? "selected":"");?> value="<?php echo $value['id'];?>"><?php echo $value['type_of_business'];?></option>
                                    <?php } } ?>
                                  </select>
                                    </div>
                                 <!-- </div> -->
                              <!-- </div> -->
                           </div>
                             <div class="col-md-4">
                              <h5 style="color: blue">Nature of Organisation</h5>
                              <!-- <div class="form-drow"> -->
                                 <!-- <div class="col-md-6"> -->
                                    <div class="form-group">
                                       <!-- <label for="series_id">Proprietorship</label> -->
                                       <select class="form-control select2" id="nature_of_organistation" required name="nature_of_organistation" style="width: 100%;">
                                    <option value="">Select</option>
                                    <?php
                                      $this->db->where('status',1);
                                      $roles = $this->db->get('type_of_business')->result_array();
                                      if($roles){
                                          foreach ($roles as $value){
                                      ?>
                                                <option <?php echo (($renewal['nature_of_organistation']==$value['id'])? "selected":"");?> value="<?php echo $value['id'];?>"><?php echo $value['type_of_business'];?></option>
                                    <?php } } ?>
                                  </select>
                                    </div>
                                 <!-- </div> -->
                              <!-- </div> -->
                           <!-- </div> -->
                           </div>
                        </div>
                              <div class="form-row">
                                 <div class="col-md-4">
                                    <div class="form-group">
                                       <h5 style="color: blue">AU Registration No</h5>
                                       <!-- <label for="au_registration"></label> -->
                                       <input type="text" name="au_registration" class="form-control" id="au_registration" value="<?php if(isset($renewal['au_registration'])){ echo $renewal['au_registration'];} ?>">
                                    </div>
                                 </div>
                                 <div class="col-md-4">
                                    <div class="form-group">
                                       <h5 style="color: blue">Registration Renewal Due on</h5>
                                       <!-- <label for="registration_date"></label> -->
                                       <input type="date" name="registration_date" class="form-control" id="registration_date" value="<?php if(isset($renewal['registration_date'])){ echo $renewal['registration_date'];} ?>">
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <!-- <div class="row"> -->
                              <div class="card col-md-12 card-header" >
                                 <div >
                                    <label for="footer_description">Footer Details.</label>
                                    <div class="form-group">
                                       <textarea class="textarea summernote" cols="2" rows="10" name="footer_description" placeholder="Place some text here" style="width: 100%; height: 700px; font-size: 14px; line-height: 18px;  border: 1px solid #dddddd; padding: 10px;"><?php if(isset($renewal['footer_description'])){echo $renewal['footer_description'];}else{echo set_value('footer_description'); } ?></textarea>
                                    </div>
                                 </div>
                              </div>
                           <!-- </div> -->
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