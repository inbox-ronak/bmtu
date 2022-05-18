<div class="row">
	<div class="form-group col-md-12">
	  <label for="title">Title<span class="text-danger">*</span></label>
	  <input type="text" name="title" class="form-control" id="title" value="<?php echo $data['title'];?>" required >
	</div>
	<div class="form-group col-md-12">
	  <label for="link">Link<span class="text-danger">*</span></label>
	  <input type="text" name="link" class="form-control" id="link" value="<?php echo $data['link'];?>" required >
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