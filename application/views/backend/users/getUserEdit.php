<input type="hidden" name="user_id" id="user_id" value="<?php echo $data->id; ?>">
<div class="row">
  <div class="form-group col-md-6 required mt-3">
    <label for="username_edit">User Name</label>
    <input type="text" name="username" class="form-control" id="username_edit" placeholder="Enter User Name" required value="<?php echo $data->username;?>">
  </div>
  <div class="form-group col-md-6 required mt-3">
    <label for="firstname_edit">First Name</label>
    <input type="text" name="firstname" class="form-control" id="firstname_edit" placeholder="Enter First Name" required value="<?php echo $data->first_name;?>">
  </div>
</div>
<div class="row">
  <div class="form-group col-md-6 required">
    <label for="lastname_edit">Last Name</label>
    <input type="text" name="lastname" class="form-control" id="lastname_edit" placeholder="Enter Last Name" required value="<?php echo $data->last_name;?>">
  </div>
  <div class="form-group col-md-6">
    <label for="address_edit">Address</label>
    <input type="text" name="address" class="form-control" id="address_edit" placeholder="Enter Address"  value="<?php echo $data->address;?>">
  </div>
</div>
<div class="row">
  <div class="form-group col-md-6 required">
    <label for="email_edit">Email</label>
    <input type="email" name="email" class="form-control" id="email_edit" placeholder="Enter Email" required autocomplete="username" value="<?php echo $data->email;?>">
  </div>
  <div class="form-group col-md-6">
    <label for="password_edit">Password</label>
    <input type="password" name="password" class="form-control" id="password_edit" placeholder="Enter Password"  autocomplete="new-password">
    <div id="meter_wrapper_edit" class="meter_wrapper" style="display: none;">
      <div id="meter_edit" class="meter"></div>
      <div id="pass_type_edit" class="pass_type"></div>
    </div>
    <!-- <p>Please Enter Strong Password</p> -->
    <ul style="padding-left: 3%;padding-top: 1%;">
        <li class="">1 lowercase &amp; 1 uppercase</li>
        <li class="">1 number (0-9)</li>
        <li class="">1 Special Character (!@#$%^&*).</li>
        <li class="">Atleast 6 Character</li>
    </ul>
  </div>
</div>
<div class="row">
  <div class="form-group col-md-6">
    <label for="cpassword_edit">Confirm password</label>
    <input type="password" name="cpassword" class="form-control" id="cpassword_edit" placeholder="Enter Confirm Password" autocomplete="new-password">
    <span id="divCheckPasswordMatch_edit"></span>
  </div>
  <div class="form-group col-md-6">
    <label for="phone_no_edit">Mobile Number</label>
    <input type="text" name="phone_no" class="form-control" id="phone_no_edit" placeholder="Enter Mobile Number" value="<?php echo $data->mobile_no;?>">
  </div>
</div>
<?php /* ?>
<input type="hidden" name="status" value="0">
<div class="form-check mb-2">
  <input type="checkbox" class="form-check-input" id="status_edit" <?php echo (($data->status==1)? "checked":"");?> name="status" value="1">
  <label class="form-check-label" for="status_edit">Active</label>
</div>
<?php */ ?>
<div class="row">
  <div class="form-group col-md-6">
    <label >Status</label>
    <select id="status" name="status" class="form-control form-control-sm select2" style="width: 100%;">
      <option <?php if($data->status == 1){ echo 'selected'; } ?> value="1">Active</option>
      <option <?php if($data->status == 0){ echo 'selected'; } ?> value="0">In-Active</option>
    </select>
  </div>
  <div class="form-group col-md-6 required">
    <label for="role_id">Role</label>
    <select class="form-control select2" id="role_id_edit" required name="role_id" style="width: 100%;">
      <option value="">Select</option>
      <?php
        $this->db->where('status',1);
        $roles = $this->db->get('role_master')->result_array();
        if($roles){
            foreach ($roles as $value){
        ?>
                  <option <?php echo (($data->member_type==$value['id'])? "selected":"");?> value="<?php echo $value['id'];?>"><?php echo $value['role_name'];?></option>
      <?php } } ?>
    </select>
  </div>
</div>
<div class="row">
  <!-- start modules permission -->
  <div class="modules_edit col-md-12">
    <?php
    $user_role=$data->role_id;
    $roles = $this->db->where('id',$user_role)->get('role_master')->row_array();
    $role_module = array(0);
    $per_array = json_decode($roles['permission'],true);
    if($per_array){
      $role_module = array_merge($role_module,$per_array);
    }
    //echo '<pre>';print_r($role_module);
    if($user_role != 1){
  ?>
    <table class="mt-3 table">
      <tr>
        <td colspan="5"><label>Module Permission</label></td>
      </tr>
      <?php 
        $modules = $this->db->where('parent',0)->get('modules')->result_array();
        foreach ($modules as $module){
          $module_per = array();
          $blank_modules = json_decode($data->module_permission,true);

          if($blank_modules){
            foreach ($blank_modules as $key2 => $value2) {
              foreach ($value2 as $key3 => $value3) {
                $module_per[$key3] = $value3;
              }
            }

          }
          //echo '<pre>';print_r($module_per);
          $view = $edit = $add = $delete = '';
          if($module_per){
              if(array_key_exists($module['module_slug'],$module_per)){
                  $actions = explode(',',$module_per[$module['module_slug']]);
                  //print_r($actions);
                  if(in_array('add',$actions)){
                    $add = 'checked';
                  }
                  if(in_array('edit',$actions)){
                    $edit = 'checked';
                  }
                  if(in_array('delete',$actions)){
                    $delete = 'checked';
                  }
                  if(in_array('view',$actions)){
                    $view = 'checked';
                  }
              }
          }

          if(in_array($module['id'],$role_module)){

            if($module['has_child'] == 1){
      ?>
        <tr>
        <td valign="top"><span><?php echo $module['module_name'];?></span></td>
        <td colspan="4" class="pt-0 pl-0" style="border: none;">
            <input type="checkbox" <?php echo $view;?> class="hidecheck editparent<?php echo $module['id'];?>" name="modules[<?php echo $module['module_slug'];?>][]" value="view">
            <input type="checkbox" <?php echo $add;?> class="hidecheck editparent<?php echo $module['id'];?>" name="modules[<?php echo $module['module_slug'];?>][]" value="add">
            <input type="checkbox" <?php echo $edit;?> class="hidecheck editparent<?php echo $module['id'];?>" name="modules[<?php echo $module['module_slug'];?>][]" value="edit">
            <input type="checkbox" <?php echo $delete;?> class="hidecheck editparent<?php echo $module['id'];?>" name="modules[<?php echo $module['module_slug'];?>][]" value="delete">
            <table class="table">
            <?php 
            $sub_modules = $this->db->where('parent',$module['id'])->get('modules')->result_array(); 
              if($sub_modules){
              foreach ($sub_modules as $value) {
                if(in_array($value['id'],$role_module)){
            ?>
            <tr>
              <td valign="top" style="width:10.25rem;"><span><?php echo $value['module_name'];?></span></td>
              <td>
                <div class="form-group">
                  <div class="custom-control custom-switch custom-switch-on-success">
                    <input type="checkbox" class="editchild custom-control-input" name="modules[<?php echo $value['module_slug'];?>][]" value="view" <?php echo $view;?> data-id="<?php echo $module['id'];?>" id="view<?php echo $value['id'];?>">
                    <label class="custom-control-label" for="view<?php echo $value['id'];?>">View</label>
                  </div>
                </div>
              </td>
              <td>
                <div class="form-group">
                  <div class="custom-control custom-switch custom-switch-on-success">
                    <input type="checkbox" class="editchild custom-control-input" name="modules[<?php echo $value['module_slug'];?>][]" value="add" <?php echo $add;?> data-id="<?php echo $module['id'];?>" id="add<?php echo $value['id'];?>">
                    <label class="custom-control-label" for="add<?php echo $value['id'];?>">Add</label>
                  </div>
                </div>
              </td>
              <td>
                <div class="form-group">
                  <div class="custom-control custom-switch custom-switch-on-success">
                    <input type="checkbox" class="editchild custom-control-input" name="modules[<?php echo $value['module_slug'];?>][]" value="edit" <?php echo $edit;?> data-id="<?php echo $module['id'];?>" id="edit<?php echo $value['id'];?>">
                    <label class="custom-control-label" for="edit<?php echo $value['id'];?>">Edit</label>
                  </div>
                </div>
              </td>
              <td><div class="form-group">
                  <div class="custom-control custom-switch custom-switch-on-success">
                    <input type="checkbox" class="editchild custom-control-input" name="modules[<?php echo $value['module_slug'];?>][]" value="delete" <?php echo $delete;?> data-id="<?php echo $module['id'];?>" id="delete<?php echo $value['id'];?>">
                    <label class="custom-control-label" for="delete<?php echo $value['id'];?>">Delete</label>
                  </div>
                </div>
              </td>
            </tr>
            <?php } } } ?>
          </table>
        </td>
      </tr>
    <?php }else{ ?>
      <tr>
        <td valign="top"><span><?php echo $module['module_name'];?></span></td>
        <td>
          <div class="form-group">
            <div class="custom-control custom-switch custom-switch-on-success">
              <input type="checkbox" class="custom-control-input" name="modules[<?php echo $module['module_slug'];?>][]" value="view" <?php echo $view;?> id="view<?php echo $module['id'];?>">
              <label class="custom-control-label" for="view<?php echo $module['id'];?>">View</label>
            </div>
          </div>
        </td>
        <td>
          <div class="form-group">
            <div class="custom-control custom-switch custom-switch-on-success">
              <input type="checkbox" class="custom-control-input" name="modules[<?php echo $module['module_slug'];?>][]" value="add" <?php echo $add;?> id="add<?php echo $module['id'];?>">
              <label class="custom-control-label" for="add<?php echo $module['id'];?>">Add</label>
            </div>
          </div>
        </td>
        <td>
          <div class="form-group">
            <div class="custom-control custom-switch custom-switch-on-success">
              <input type="checkbox" class="custom-control-input" name="modules[<?php echo $module['module_slug'];?>][]" value="edit" <?php echo $edit;?> id="edit<?php echo $module['id'];?>">
              <label class="custom-control-label" for="edit<?php echo $module['id'];?>">Edit</label>
            </div>
          </div>
        </td>
        <td><div class="form-group">
            <div class="custom-control custom-switch custom-switch-on-success">
              <input type="checkbox" class="custom-control-input" name="modules[<?php echo $module['module_slug'];?>][]" value="delete" <?php echo $delete;?> id="delete<?php echo $module['id'];?>">
              <label class="custom-control-label" for="delete<?php echo $module['id'];?>">Delete</label>
            </div>
          </div>
        </td>
      </tr>
      <?php } } } ?>
    </table>
    <?php } ?>
  </div>
  <!-- end module permission -->
</div>