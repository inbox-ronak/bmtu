<div class="form-group">
  <label for="role">Role Name</label>
  <input type="text" name="role" class="form-control" id="role_edit" value="<?php echo $data['role_name'];?>" required <?php if($data['id'] < 4){ echo 'readonly'; }?>>
</div>
<div class="form-group">
                <label >Status</label>
                  <select id="status" name="status" class="form-control form-control-sm select2" style="width: 100%;">
                   <option value="1" <?php if($data['status'] == '1'){ echo 'selected'; } ?>>Active</option>
                    <option value="0" <?php if($data['status'] == '0'){ echo 'selected'; } ?>>In-Active</option>
                  </select>
            </div>
<?php
$permission = json_decode($data['permission'],true);
//print_r($permission);
$this->db->where('parent',0);
$modules = $this->db->get('modules')->result_array();
if($modules){
  foreach ($modules as $module){
  	$checked = '';
  	if($permission){ if(in_array($module['id'],$permission)){ $checked = 'checked'; } }

    if($module['has_child'] == 1){
?>
<table>
<tr>
  <td>
    <div class="form-check">
      <input type="checkbox" class="editparent<?php echo $module['id'];?> form-check-input" id="module<?php echo $module['id'];?>" name="modules[]" value="<?php echo $module['id'];?>" <?php echo $checked;?>>
      <label class="form-check-label" for="module<?php echo $module['id'];?>"><?php echo $module['module_name'];?></label>
    </div>
      <?php 
      $sub_modules = $this->db->where('parent',$module['id'])->get('modules')->result_array(); 
        if($sub_modules){ ?>
      <table class="ml-4">
    <?php foreach ($sub_modules as $value){ ?>
    <?php 
    	$checked2 = '';
  		if($permission){ if(in_array($value['id'],$permission)){ $checked2 = 'checked'; } } 
  	?>
      <tr>
        <td>
          <div class="form-check">
            <input type="checkbox" class="editchildparent<?php echo $module['id'];?> editchild form-check-input" id="module<?php echo $value['id'];?>" name="modules[]" data-id="<?php echo $module['id'];?>" value="<?php echo $value['id'];?>" <?php echo $checked2;?>>
            <label class="form-check-label" for="module<?php echo $value['id'];?>"><?php echo $value['module_name'];?></label>
          </div>
        </td>
      </tr>
      <?php } ?>
      </table>
      <?php } ?>
  </td>
</tr>
</table>
<?php }else{ ?>

<div class="form-check">
<input type="checkbox" class="form-check-input" id="module<?php echo $module['id'];?>" name="modules[]" value="<?php echo $module['id'];?>" <?php echo $checked;?>>
<label class="form-check-label" for="module<?php echo $module['id'];?>"><?php echo $module['module_name'];?></label>
</div>
  
<?php 
    }
  }
} 
?>
<input type="hidden" name="role_id" value="<?php echo $data['id'];?>">