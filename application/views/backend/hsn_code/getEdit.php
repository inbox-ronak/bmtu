 <div class="row">
<div class="form-group col-md-12">
  <label for="hsn_code">HSN Code</label>
  <input type="text" name="hsn_code" class="form-control" id="hsn_code" value="<?php echo $data['hsn_code'];?>" required >
</div>

<div class="form-group col-md-12">
                <label >Status</label>
                  <select id="status" name="status" class="form-control form-control-sm select2" style="width: 100%;">
                   <option value="1" <?php if($data['status'] == '1'){ echo 'selected'; } ?>>Active</option>
                    <option value="0" <?php if($data['status'] == '0'){ echo 'selected'; } ?>>In-Active</option>
                  </select>
            </div>

<input type="hidden" name="id" value="<?php echo $data['id'];?>">
</div>