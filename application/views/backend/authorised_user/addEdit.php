<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h1>Authorised Users</h1>
            </div>
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Dashboard</a></li>
                  <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/authorised_user">Authorised Users</a></li>
                  <li class="breadcrumb-item active"><?php if(isset($record['id'])){ echo 'Edit'; }else{ echo 'Add'; } ?> Authorised User</li>
               </ol>
            </div>
         </div>
      </div>
      <!-- /.container-fluid -->
   </section>
   <!-- Main content -->
   <section class="content">
      <div class="container-fluid">
         <div class="row">
            <div class="col-12">
               <div class="card">
                  <div class="card-header">
                     <h3 class="card-title"><?php if(isset($record['id'])){ echo 'Edit'; }else{ echo 'Add'; } ?> Authorised User</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <form data-toggle="validator" role="form" method='POST' class="form-horizontal" action='<?php echo base_url();?>admin/authorised_user/add' id="add-form" name="add-form" enctype='multipart/form-data'>
                      <div class="row">
                        <div class="col-md-12 form-heading">
                          <h3 class="card-title"><strong>User Information</strong></h3>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-md-6">
                          <label for="first_name">First Name<span class="text-danger">*</span></label>
                          <input type="text" name="first_name" class="form-control" id="first_name" placeholder="First Name" required value="<?php if(isset($record['first_name'])){echo $record['first_name'];}?>">
                        </div>
                        <div class="form-group col-md-6">
                          <label for="last_name">Last Name<span class="text-danger">*</span></label>
                          <input type="text" name="last_name" class="form-control" id="last_name" placeholder="Last Name" required value="<?php if(isset($record['last_name'])){echo $record['last_name'];}?>">
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-md-6">
                           <label for="mobile_no">Mobile No.</label>
                           <input type="text" name="mobile_no" class="form-control" id="mobile_no" placeholder="Mobile No." value="<?php if(isset($record['mobile_no'])){echo $record['mobile_no'];}?>">
                        </div>
                        <div class="form-group col-md-6">
                           <label for="telephone1">Phone No.</label>
                           <input type="text" name="telephone1" class="form-control" id="telephone1" placeholder="Phone No." value="<?php if(isset($record['telephone1'])){echo $record['telephone1'];}?>">
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-md-6">
                           <label for="fax">Fax Number</label>
                           <input type="text" name="fax" class="form-control" id="fax" placeholder="Fax Number" value="<?php if(isset($record['fax'])){echo $record['fax'];}?>">
                        </div>
                        <div class="form-group col-md-6">
                           <label for="email">Email</label>
                           <input type="email" name="email" class="form-control" id="email" placeholder="Email" value="<?php if(isset($record['email'])){echo $record['email'];}?>">
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-md-6">
                           <label for="designation_id">Designation Of Applicant<span class="text-danger">*</span></label>
                           <select name="designation_id" class="form-control select2" id="designation_id" placeholder="Designation Of Applicant" required style="width: 100%;">
                              <option value="">Select</option>
                              <?php
                                if($designation){
                                  foreach ($designation as $value){
                                    $selected = '';
                                    if(isset($record['designation_id'])){
                                      if($value['id'] == $record['designation_id'])
                                      {
                                        $selected = 'selected';
                                      }
                                    }       
                                    echo '<option '.$selected.' value="'.$value['id'].'">'.trim($value['designation_en']).'</option>';
                                  }
                                }
                              ?>
                           </select>
                        </div>
                      </div>
                      <div class="form-group col-md-6">
                           <label for="document">Document/KYC</label>
                           <input type="file" name="document_kyc" class="form-control" id="document_kyc"  value="<?php if(isset($record['document_kyc'])){echo $record['document_kyc'];}?>">
                        </div>
                      <div class="row">
                        <div class="col-md-12 form-heading">
                          <h3 class="card-title"><strong>Address Of Applicant</strong></h3>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-md-6">
                           <label for="address">Address<span class="text-danger">*</span></label>
                           <textarea name="address" class="form-control" id="address" placeholder="Address" required><?php if(isset($record['address'])){echo $record['address'];}?></textarea>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="area">Area</label>
                          <input type="text" name="area" class="form-control" id="area" placeholder="Area" value="<?php if(isset($record['area'])){echo $record['area'];}?>">
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-md-6">
                           <label for="country">Country<span class="text-danger">*</span></label>
                           <input type="text" name="country" class="form-control" id="country" required placeholder="country" value="<?php if(isset($record['country'])){echo $record['country'];}?>">
                        </div>
                        <div class="form-group col-md-6">
                           <label for="state">State<span class="text-danger">*</span></label>
                           <input type="text" name="state" class="form-control" id="state" required placeholder="State" value="<?php if(isset($record['state'])){echo $record['state'];}?>">
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-md-6">
                           <label for="city">City<span class="text-danger">*</span></label>
                           <input type="text" name="city" class="form-control" id="city" required placeholder="City" value="<?php if(isset($record['city'])){echo $record['city'];}?>">
                        </div>
                        <div class="form-group col-md-6">
                           <label for="pincode">Pin Code<span class="text-danger">*</span></label>
                           <input type="number" name="pincode" class="form-control" id="pincode" placeholder="Pin Code" required value="<?php if(isset($record['pincode'])){echo $record['pincode'];}?>">
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-md-6">
                          <label for="contact_person">Contact Person<span class="text-danger">*</span></label>
                          <input type="text" name="contact_person" class="form-control" id="contact_person" placeholder="Contact Person" required value="<?php if(isset($record['contact_person'])){echo $record['contact_person'];}?>">
                        </div>
                        <div class="form-group col-md-6">
                           <label for="contact_designation_id">Designation Of Contact Person<span class="text-danger">*</span></label>
                           <select name="contact_designation_id" class="form-control select2" id="contact_designation_id" placeholder="Designation Of Applicant" required style="width: 100%;">
                              <option value="">Select</option>
                              <?php
                                if($designation){
                                  foreach ($designation as $value){
                                    $selected = '';
                                    if(isset($record['contact_designation_id'])){
                                      if($value['id'] == $record['contact_designation_id'])
                                      {
                                        $selected = 'selected';
                                      }
                                    }       
                                    echo '<option '.$selected.' value="'.$value['id'].'">'.trim($value['designation_en']).'</option>';
                                  }
                                }
                              ?>
                           </select>
                        </div>
                      </div>
                      <?php
                      $count = 1;
                      if(isset($record['id'])){
                        $branch_name = json_decode($record['branch_name'],true);
                        $branch_address = json_decode($record['branch_address'],true);
                        $branch_area = json_decode($record['branch_area'],true);
                        $branch_country = json_decode($record['branch_country'],true);
                        $branch_state = json_decode($record['branch_state'],true);
                        $branch_city = json_decode($record['branch_city'],true);
                        $branch_pincode = json_decode($record['branch_pincode'],true);
                        $type_of_business_row = json_decode($record['type_of_business'],true);
                        $silk_product_row = json_decode($record['silk_product'],true);

                        $unit_type_of_business_row = json_decode($record['unit_type_of_business'],true);
                        $unit_silk_product_row = json_decode($record['unit_silk_product'],true);
                        $count = count($branch_name);
                      }
                      ?>
                      <div class="row">
                        <div class="col-md-12 form-heading">
                          <h3 class="card-title"><strong>Address Of Branches</strong></h3>
                        </div>
                      </div>
                      <!--- multiple start -->
                  <div id="multiple-branch">
                      <?php
                        for ($k=0; $k < $count; $k++){ 
                      ?>
                      <div class="row">
                        <div class="form-group col-md-6">
                           <label for="branch_name<?php echo $k;?>">Branch Name<span class="text-danger">*</span></label>
                           <input type="text" name="branch_name[]" class="form-control" id="branch_name<?php echo $k;?>" required placeholder="Branch Name" value="<?php if(isset($branch_name[$k])){echo $branch_name[$k];}?>">
                        </div>
                        <div class="form-group col-md-6">
                           <label for="branch_address<?php echo $k;?>">Branch Address<span class="text-danger">*</span></label>
                           <textarea name="branch_address[]" class="form-control" id="branch_address<?php echo $k;?>" placeholder="Branch Address" required><?php if(isset($branch_address[$k])){echo $branch_address[$k];}?></textarea>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-md-6">
                          <label for="branch_area<?php echo $k;?>">Branch Area</label>
                          <input type="text" name="branch_area[]" class="form-control" id="branch_area<?php echo $k;?>" placeholder="Branch Area" value="<?php if(isset($branch_area[$k])){echo $branch_area[$k];}?>">
                        </div>
                        <div class="form-group col-md-6">
                           <label for="branch_country<?php echo $k;?>">Branch Country<span class="text-danger">*</span></label>
                           <input type="text" name="branch_country[]" class="form-control" id="branch_country<?php echo $k;?>" required placeholder="Branch Country" value="<?php if(isset($branch_country[$k])){echo $branch_country[$k];}?>">
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-md-6">
                           <label for="branch_state<?php echo $k;?>">Branch State<span class="text-danger">*</span></label>
                           <input type="text" name="branch_state[]" class="form-control" id="branch_state<?php echo $k;?>" required placeholder="Branch State" value="<?php if(isset($branch_state[$k])){echo $branch_state[$k];}?>">
                        </div>
                        <div class="form-group col-md-6">
                           <label for="branch_city<?php echo $k;?>">Branch City<span class="text-danger">*</span></label>
                           <input type="text" name="branch_city[]" class="form-control" id="branch_city<?php echo $k;?>" required placeholder="Branch City" value="<?php if(isset($branch_city[$k])){echo $branch_city[$k];}?>">
                        </div>
                      </div>
                      <div class="row" style="border-bottom: 1px solid #007bfc;">
                        <div class="form-group col-md-6">
                           <label for="branch_pincode<?php echo $k;?>">Branch Pin Code<span class="text-danger">*</span></label>
                           <input type="number" name="branch_pincode[]" class="form-control" id="branch_pincode<?php echo $k;?>" placeholder="Branch Pin Code" required value="<?php if(isset($branch_pincode[$k])){echo $branch_pincode[$k];}?>">
                        </div>
                        <div class="form-group col-md-6">
                          <?php if($k == 0){ ?>
                            <button type="button" id="add-more" class="btn btn-sm btn-success" style="margin-top: 35px;">Add More</button>
                          <?php }else{ ?>
                            <button type="button" data-id="<?php echo $k;?>" class="remove-file btn btn-sm btn-danger" style="margin-top: 35px;">Remove</button>
                          <?php } ?>
                        </div>
                      </div>
                      <?php } ?>
                    </div>
                      <!--- /multiple end -->
                      <div class="row">
                        <div class="form-group col-md-6">
                           <label for="type_of_business">Type of Business</label>
                           <select name="type_of_business[]" class="form-control select2" id="type_of_business" multiple required style="width: 100%;" data-placeholder="Select">
                              <option value="">Select</option>
                              <?php
                                if($type_of_business){
                                  foreach ($type_of_business as $value){
                                    $selected = '';
                                    if(in_array($value['id'],$type_of_business_row))
                                    {
                                      $selected = 'selected';
                                    }        
                                    echo '<option '.$selected.' value="'.$value['id'].'">'.$value['type_of_business'].'</option>';
                                  }
                                }
                              ?>
                           </select>
                        </div>
                        <div class="form-group col-md-6">
                           <label for="silk_product">Silk Product dealt In By organisation</label>
                           <select name="silk_product[]" class="form-control select2" id="silk_product" multiple required style="width: 100%;" data-placeholder="Select">
                              <option value="">Select</option>
                              <?php
                                if($silk_product){
                                  
                                  foreach ($silk_product as $value){
                                    $selected = '';
                                    if(in_array($value['id'],$silk_product_row))
                                    {
                                      $selected = 'selected';
                                    }        
                                    echo '<option '.$selected.' value="'.$value['id'].'">'.$value['product_name'].'</option>';
                                  }
                                }
                              ?>
                           </select>
                        </div>
                      </div>
                      <!-- Unit start -->
                      <div class="row">
                        <div class="col-md-12 form-heading">
                          <h3 class="card-title"><strong>Address Of Unit</strong></h3>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-md-6">
                           <label for="unit_branch_name">Branch Name<span class="text-danger">*</span></label>
                           <input type="text" name="unit_branch_name" class="form-control" id="unit_branch_name" required placeholder="Branch Name" value="<?php if(isset($record['unit_branch_name'])){echo $record['unit_branch_name'];}?>">
                        </div>
                        <div class="form-group col-md-6">
                           <label for="unit_address">Unit Address<span class="text-danger">*</span></label>
                           <textarea name="unit_address" class="form-control" id="unit_address" placeholder="Unit Address" required><?php if(isset($record['unit_address'])){echo $record['unit_address'];}?></textarea>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-md-6">
                          <label for="unit_area">Unit Area</label>
                          <input type="text" name="unit_area" class="form-control" id="unit_area" placeholder="Unit Area" value="<?php if(isset($record['unit_area'])){echo $record['unit_area'];}?>">
                        </div>
                        <div class="form-group col-md-6">
                           <label for="unit_country">Unit Country<span class="text-danger">*</span></label>
                           <input type="text" name="unit_country" class="form-control" id="unit_country" required placeholder="Unit Country" value="<?php if(isset($record['unit_country'])){echo $record['unit_country'];}?>">
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-md-6">
                           <label for="unit_state">Unit State<span class="text-danger">*</span></label>
                           <input type="text" name="unit_state" class="form-control" id="unit_state" required placeholder="Unit State" value="<?php if(isset($record['unit_state'])){echo $record['unit_state'];}?>">
                        </div>
                        <div class="form-group col-md-6">
                           <label for="unit_city">Unit City<span class="text-danger">*</span></label>
                           <input type="text" name="unit_city" class="form-control" id="unit_city" required placeholder="Unit City" value="<?php if(isset($record['unit_city'])){echo $record['unit_city'];}?>">
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-md-6">
                           <label for="unit_pincode">Unit Pin Code<span class="text-danger">*</span></label>
                           <input type="number" name="unit_pincode" class="form-control" id="unit_pincode" placeholder="Unit Pin Code" required value="<?php if(isset($record['unit_pincode'])){echo $record['unit_pincode'];}?>">
                        </div>
                        <div class="form-group col-md-6">
                           <label for="unit_mobile_no">Mobile No.</label>
                           <input type="text" name="unit_mobile_no" class="form-control" id="unit_mobile_no" placeholder="Mobile No." value="<?php if(isset($record['unit_mobile_no'])){echo $record['unit_mobile_no'];}?>">
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-md-6">
                           <label for="unit_telephone1">Phone No.</label>
                           <input type="text" name="unit_telephone1" class="form-control" id="unit_telephone1" placeholder="Phone No." value="<?php if(isset($record['unit_telephone1'])){echo $record['unit_telephone1'];}?>">
                        </div>
                        <div class="form-group col-md-6">
                           <label for="unit_type_of_business">Type of Business</label>
                           <select name="unit_type_of_business[]" class="form-control select2" id="unit_type_of_business" multiple required style="width: 100%;" data-placeholder="Select">
                              <option value="">Select</option>
                              <?php
                                if($type_of_business){
                                
                                  foreach ($type_of_business as $value){
                                    $selected = '';
                                    if(in_array($value['id'],$unit_type_of_business_row))
                                    {
                                      $selected = 'selected';
                                    }        
                                    echo '<option '.$selected.' value="'.$value['id'].'">'.$value['type_of_business'].'</option>';
                                  }
                                }
                              ?>
                           </select>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-md-6">
                           <label for="unit_silk_product">Silk Product</label>
                           <select name="unit_silk_product[]" class="form-control select2" id="unit_silk_product" multiple required style="width: 100%;" data-placeholder="Select">
                              <option value="">Select</option>
                              <?php
                                if($silk_product){
                                  foreach ($silk_product as $value){
                                    $selected = '';
                                    if(in_array($value['id'],$unit_silk_product_row))
                                    {
                                      $selected = 'selected';
                                    }        
                                    echo '<option '.$selected.' value="'.$value['id'].'">'.$value['product_name'].'</option>';
                                  }
                                }
                              ?>
                           </select>
                        </div>
                      </div>
                      <!-- /unit end -->
                      <div class="row">
                        <div class="col-md-12 form-heading">
                          <h3 class="card-title"><strong>Other Information</strong></h3>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-md-6">
                           <label for="turn_over_in_production">Turn Over in Production / Sales of Pure silk Goods for the last Financial Year. Please specify<span class="text-danger">*</span></label>
                           <textarea name="turn_over_in_production" class="form-control" id="turn_over_in_production" maxlength="500" placeholder="Details of turnover in last financial Year" required><?php if(isset($record['turn_over_in_production'])){echo $record['turn_over_in_production'];}?></textarea>
                        </div>
                        <div class="form-group col-md-6">
                           <label for="turnover_details">Details of turnover in last financial Year<span class="text-danger">*</span></label>
                           <textarea name="turnover_details" class="form-control" id="turnover_details" maxlength="500" placeholder="Details of turnover in last financial Year" required><?php if(isset($record['turnover_details'])){echo $record['turnover_details'];}?></textarea>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-md-6">
                          <label for="turnover">Turnover<span class="text-danger">*</span></label>
                          <div class="checkbox">
                                <label><input type="radio" value="1" <?php if(isset($record['turnover'])){if($record['turnover'] == '1'){ echo 'checked'; } }else{ echo 'checked'; } ?> name="turnover"> Up to 50 lakh</label>
                          </div>

                          <div class="checkbox">
                                <label><input type="radio" value="2" <?php if(isset($record['turnover'])){if($record['turnover'] == '2'){ echo 'checked'; } } ?> name="turnover"> Beyond 50 Lakhs upto 1 crore</label>
                          </div>

                          <div class="checkbox">
                                <label><input type="radio" value="3" <?php if(isset($record['turnover'])){ if($record['turnover'] == '3'){ echo 'checked'; } } ?> name="turnover"> 1 crore and above</label>
                          </div>
                        </div>
                        <div class="form-group col-md-6">
                           <label for="details_of_sourcing">Details of Sourcing of Raw Materials/Finished Good<span class="text-danger">*</span></label>
                           <textarea name="details_of_sourcing" class="form-control" id="details_of_sourcing" maxlength="500" placeholder="Details of Sourcing of Raw Materials/Finished Good" required><?php if(isset($record['details_of_sourcing'])){echo $record['details_of_sourcing'];}?></textarea>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-md-6">
                           <label for="for_manufactures_facilities">For Manufacturer Facilities in place,No of Looms,Other Machines & Type<span class="text-danger">*</span></label>
                           <textarea name="for_manufactures_facilities" class="form-control" id="for_manufactures_facilities" maxlength="500" placeholder="For Manufacturer Facilities in place,No of Looms,Other Machines & Type" required><?php if(isset($record['for_manufactures_facilities'])){echo $record['for_manufactures_facilities'];}?></textarea>
                        </div>
                        <div class="form-group col-md-6">
                           <label for="quality_control">Quality Control Method<span class="text-danger">*</span></label>
                           <textarea name="quality_control" class="form-control" id="quality_control" maxlength="500" placeholder="Quality Control Method" required><?php if(isset($record['quality_control'])){echo $record['quality_control'];}?></textarea>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-md-6">
                           <label for="specify_the_items_proposed">Specify the items proposed to be traded under silk mark scheme<span class="text-danger">*</span></label>
                           <textarea name="specify_the_items_proposed" class="form-control" id="specify_the_items_proposed" maxlength="500" placeholder="Specify the items proposed to be traded under silk mark scheme" required><?php if(isset($record['specify_the_items_proposed'])){echo $record['specify_the_items_proposed'];}?></textarea>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="do_you_propose">Do you Propose to use 'Silk Mark' on Silk Goods for<span class="text-danger">*</span></label>
                          <div class="checkbox">
                                <label><input type="radio" value="1" <?php if(isset($record['do_you_propose'])){if($record['do_you_propose'] == '1'){ echo 'checked'; } }else{ echo 'checked'; } ?> name="do_you_propose"> Domestic Sale</label>
                          </div>
                          <div class="checkbox">
                                <label><input type="radio" value="2" <?php if(isset($record['do_you_propose'])){if($record['do_you_propose'] == '2'){ echo 'checked'; } } ?> name="do_you_propose"> Export</label>
                          </div>
                          <div class="checkbox">
                                <label><input type="radio" value="3" <?php if(isset($record['do_you_propose'])){ if($record['do_you_propose'] == '3'){ echo 'checked'; } } ?> name="do_you_propose"> Both</label>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-md-6">
                           <label for="turn_over_of_silk_exports">Turn Over of silk exports during last 3 financial years<span class="text-danger">*</span></label>
                           <textarea name="turn_over_of_silk_exports" class="form-control" id="turn_over_of_silk_exports" maxlength="500" placeholder="Turn Over of silk exports during last 3 financial years" required><?php if(isset($record['turn_over_of_silk_exports'])){echo $record['turn_over_of_silk_exports'];}?></textarea>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-md-12">
                          <input type="hidden" value="0" name="rules_and_regulations">
                          <div class="checkbox">
                              <label><input type="checkbox" value="1" <?php if(isset($record['rules_and_regulations'])){if($record['rules_and_regulations'] == '1'){ echo 'checked'; } } ?> name="rules_and_regulations"> I/We here by declare that the information furnished above by me/us are true and correct. I/We agree to abide by the rules and regulations formulated from time to time under the Silk Mark Scheme.</label>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-md-6">
                           <label>Place</label>
                           <input type="text" name="place" class="form-control" id="place" placeholder="Place" value="<?php if(isset($record['place'])){echo $record['place'];}?>">
                        </div>
                        <div class="form-group col-md-6">
                           <label>Signature of the Applicant</label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-md-6">
                           <label>Date</label>
                           <input type="date" name="submit_date" class="form-control" id="submit_date" placeholder="Date" value="<?php if(isset($record['submit_date'])){echo $record['submit_date'];}?>">
                        </div>
                        <div class="form-group col-md-6">
                           <label>Name</label>
                           <input type="text" name="name" class="form-control" id="name"readonly  placeholder="Name" value="<?php if(isset($record['name'])){echo $record['first_name'].' '.$record['last_name'];}?>">
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-md-6">
                           <label></label> 
                        </div>
                        <div class="form-group col-md-6">
                           <label for="contact_designation_id_2">Designation<span class="text-danger">*</span></label>
                           <input type="text" name="contact_designation_id_2" class="form-control" id="contact_designation_id_2" placeholder="Designation" readonly value="<?php if(isset($record['contact_designation_id_2'])){echo $record['contact_designation_id_2'];}?>">
                        </div>
                      </div>
                      <div class="row" style="display: none;">
                        <div class="form-group col-md-6">
                          <label>Status</label>
                          <select id="status" name="status" class="form-control form-control-sm select2" style="width: 100%;">
                            <option <?php if(isset($record['status'])){if($record['status'] == 1){ echo 'selected'; } } ?> value="1">Active</option>
                            <option <?php if(isset($record['status'])){if($record['status'] == 0){ echo 'selected'; } } ?> value="0">In-Active</option>
                          </select>
                        </div>
                      </div>
                      <input type="hidden" id="record_id" name="id" value="<?php if(isset($record['id'])){echo base64_encode($record['id']);}?>">
                      <div class="row">
                        <div class="form-group col-md-12">
                          <button type="submit" name="btn-submit" <?php if(isset($record['id'])){ ?> id="btn_update" <?php }else{ ?> id="btn_save"<?php } ?> class="btn btn-primary">Save</button>
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
    function show_data(){
        $('#modal-loader').modal('hide');
        setTimeout(function() {
          window.location.href = "<?php echo base_url('admin/authorised_user');?>";
        }, 2000);
    }
    //Save
    $('#btn_save').on('click',function(event){
       event.preventDefault();
       if($("#add-form").valid()){
       var form = $('#add-form')[0];
       var formData = new FormData(form);
       formData.append("btn-submit", "btn-submit");
         $.ajax({
             type: "POST",
             url: "<?php echo base_url('admin/authorised_user/add')?>",
             data: formData,
             //use contentType, processData for sure.
             contentType: false,
             processData: false,
             dataType : "JSON",
             beforeSend: function() {
                 //$('#modal-default').modal('hide');
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
    //update record to database
    $('#btn_update').on('click',function(event){
       event.preventDefault();
       if($("#add-form").valid()){
       var id = $('#record_id').val();
       var form = $('#add-form')[0];
       var formData = new FormData(form);
       formData.append("btn-submit", "btn-submit");
         $.ajax({
             type: "POST",
             url: "<?php echo base_url('admin/authorised_user/update')?>/"+id,
             data: formData,
             //use contentType, processData for sure.
             contentType: false,
             processData: false,
             dataType : "JSON",
             beforeSend: function() {
                //$('#modal-edit').modal('hide');
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
    //@dynamic childs
    var next = 0;
    $("#add-more").click(function(e){
        e.preventDefault();
        var addto = "#multiple-branch";
        next = next + 1;
        var newIn = '<div class="row field'+next+'">\
          <div class="form-group col-md-6">\
             <label for="branch_name'+next+'">Branch Name<span class="text-danger">*</span></label>\
             <input type="text" name="branch_name[]" class="form-control" id="branch_name'+next+'" required placeholder="Branch Name" value="<?php if(isset($branch_name[$k])){echo $branch_name[$k];}?>">\
          </div>\
          <div class="form-group col-md-6">\
             <label for="branch_address'+next+'">Branch Address<span class="text-danger">*</span></label>\
             <textarea name="branch_address[]" class="form-control" id="branch_address'+next+'" placeholder="Branch Address" required><?php if(isset($branch_address[$k])){echo $branch_address[$k];}?></textarea>\
          </div>\
        </div>\
        <div class="row field'+next+'">\
          <div class="form-group col-md-6">\
            <label for="branch_area'+next+'">Branch Area</label>\
            <input type="text" name="branch_area[]" class="form-control" id="branch_area'+next+'" placeholder="Branch Area" value="<?php if(isset($branch_area[$k])){echo $branch_area[$k];}?>">\
          </div>\
          <div class="form-group col-md-6">\
             <label for="branch_country'+next+'">Branch Country<span class="text-danger">*</span></label>\
             <input type="text" name="branch_country[]" class="form-control" id="branch_country'+next+'" required placeholder="Branch Country" value="<?php if(isset($branch_country[$k])){echo $branch_country[$k];}?>">\
          </div>\
        </div>\
        <div class="row field'+next+'">\
          <div class="form-group col-md-6">\
             <label for="branch_state'+next+'">Branch State<span class="text-danger">*</span></label>\
             <input type="text" name="branch_state[]" class="form-control" id="branch_state'+next+'" required placeholder="Branch State" value="<?php if(isset($branch_state[$k])){echo $branch_state[$k];}?>">\
          </div>\
          <div class="form-group col-md-6">\
             <label for="branch_city'+next+'">Branch City<span class="text-danger">*</span></label>\
             <input type="text" name="branch_city[]" class="form-control" id="branch_city'+next+'" required placeholder="Branch City" value="<?php if(isset($branch_city[$k])){echo $branch_city[$k];}?>">\
          </div>\
        </div>\
        <div class="row field'+next+'" style="border-bottom: 1px solid #007bfc;">\
          <div class="form-group col-md-6">\
             <label for="branch_pincode'+next+'">Branch Pin Code<span class="text-danger">*</span></label>\
             <input type="number" name="branch_pincode[]" class="form-control" id="branch_pincode'+next+'" placeholder="Branch Pin Code" required value="<?php if(isset($branch_pincode[$k])){echo $branch_pincode[$k];}?>">\
          </div>\
          <div class="form-group col-md-6">\
            <button type="button" data-id="'+next+'" class="btn btn-sm btn-danger remove-file" style="margin-top: 35px;">Remove</button>\
          </div>\
        </div>';
        $(addto).append(newIn);
        $("#add-form").valid();
        $('.remove-file').click(function(e){
            e.preventDefault();
            var fieldNum = $(this).attr('data-id');
            var fieldID = ".field" + fieldNum;
            $(fieldID).remove();
        });
    });
    // File //
    $('#first_name,#last_name').bind('keyup', function() {
        var first_name = $('#first_name').val();
        var last_name = $('#last_name').val();
        $('#name').val(first_name+' '+last_name);
    });
    $('#designation_id').on('change', function() {
        var designation = $('#designation_id').find('option:selected').text();
        $('#contact_designation_id_2').val(designation);
    });
    <?php
      if(isset($record['id'])){
    ?>
        $('#designation_id').trigger('change');
    <?php
      }
    ?>
  });
</script>