<div class="form-group">
  <label for="latitude">Latitude<span style="color: red">*</span></label>
  <input type="number" name="latitude" class="form-control" id="latitude" value="<?php echo $data['latitude'];?>" required >
</div>

<div class="form-group">
  <label for="longitude">Longitude<span style="color: red">*</span></label>
  <input type="number" name="longitude" class="form-control" id="longitude" value="<?php echo $data['longitude'];?>" required >
</div>

<div class="form-group">
  <label for="loacation_name">loacation name<span style="color: red">*</span></label>
  <input type="text" name="location_name" class="form-control" id="loacation_name" value="<?php echo $data['location_name'];?>" required >
</div>

<div class="form-group">
  <label for="loacation_info">Loacation Info<span style="color: red">*</span></label>
  <input type="text" name="location_info" class="form-control" id="loacation_info" value="<?php echo $data['location_info'];?>" required >
</div>



<div class="form-group">
                <label >Status</label>
                  <select id="status" name="status" class="form-control form-control-sm select2" style="width: 100%;">
                   <option value="1" <?php if($data['status'] == '1'){ echo 'selected'; } ?>>Active</option>
                    <option value="0" <?php if($data['status'] == '0'){ echo 'selected'; } ?>>In-Active</option>
                  </select>
            </div>

<input type="hidden" name="id" value="<?php echo $data['id'];?>">