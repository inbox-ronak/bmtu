<?php $user_role = $_SESSION['user_role']; ?>
<?php $add_permission = $this->permission->grant(SUBSCRIPTION_NEWS_LATTER,'add'); ?>
<?php $edit_permission = $this->permission->grant(SUBSCRIPTION_NEWS_LATTER,'edit'); ?>
<?php $delete_permission = $this->permission->grant(SUBSCRIPTION_NEWS_LATTER,'delete'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h1><?php if(isset($renewal['id'])){ echo 'Update';}else{ echo 'Add'; } ?> subscription News Latter</h1>
            </div>
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Dashboard</a></li>
                  <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/subscription_news_latter">Subscription News Latter</a></li>
                  <li class="breadcrumb-item active"><?php if(isset($renewal['id'])){ echo 'Update';}else{ echo 'Add'; } ?> Subscription News Latter</li>
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
                     <h3 class="card-title"><?php if(isset($renewal['id'])){ echo 'Update';}else{ echo 'Add'; } ?> subscription News Latter</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body" id="show_data">
                     <form data-toggle="validator" role="form" method='POST' class="form-horizontal" action='<?php echo base_url();?>admin/subscription_news_latter/<?php if(isset($renewal['id'])){ echo 'edit/'.base64_encode($renewal['id']);}else{ echo 'add'; } ?>' id="add-form" name="add-form" enctype='multipart/form-data'>
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
                              <h5 style="color: blue">Encl: Demand Draft/Cheque/Online payment details</h5>
                              <label>For official use</label>
                              
                              
                              <div class="form-row">
                                 <div class="col-md-4">
                                    <h5 style="color: blue">Space for Booking Chapter</h5>
                                    
                                    <div class="form-group">
                                       <lable>Booked by</lable>
                                       <input type="text" name="booked_by" class="form-control" id="booked_by" value="<?php if(isset($renewal['booked_by'])){ echo $renewal['booked_by'];} ?>">
                                    </div>
                                    <div class="form-group">
                                       <lable>Chapter</lable>
                                       <input type="text" name="chapter" class="form-control" id="chapter" value="<?php if(isset($renewal['chapter'])){ echo $renewal['chapter'];} ?>">
                                    </div>
                                    <div class="form-group">
                                       <lable>Booking No</lable>
                                       <input type="text" name="booking_no" class="form-control" id="booking_no" value="<?php if(isset($renewal['booking_no'])){ echo $renewal['booking_no'];} ?>">
                                    </div>
                                    <div class="form-group">
                                       <lable>Remark If Any</lable>
                                       <input type="text" name="remark_if_any" class="form-control" id="remark_if_any" value="<?php if(isset($renewal['remark_if_any'])){ echo $renewal['remark_if_any'];} ?>">
                                    </div>
                                    <!-- </div> -->
                                    <!-- </div> -->
                                 </div>
                                 <div class="col-md-4">
                                    <h5 style="color: blue">Space for Magazine Office</h5>
                                    <div class="form-group">
                                       <lable>Subscription No.</lable>
                                       <input type="text" name="subscription_no" class="form-control" id="subscription_no" value="<?php if(isset($renewal['subscription_no'])){ echo $renewal['subscription_no'];} ?>">
                                    </div>
                                    <div class="form-group">
                                       <lable>Money Receipt No.</lable>
                                       <input type="text" name="money_receipt" class="form-control" id="money_receipt" value="<?php if(isset($renewal['money_receipt'])){ echo $renewal['money_receipt'];} ?>">
                                    </div>
                                    <div class="form-group">
                                       <lable>Renewal Due on</lable>
                                       <input type="text" name="renewal_duo" class="form-control" id="renewal_duo" value="<?php if(isset($renewal['renewal_duo'])){ echo $renewal['renewal_duo'];} ?>">
                                    </div>
                                    <div class="form-group">
                                       <lable>Remarks</lable>
                                       <input type="text" name="remark" class="form-control" id="remark" value="<?php if(isset($renewal['remark'])){ echo $renewal['remark'];} ?>">
                                    </div>
                                 </div>
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