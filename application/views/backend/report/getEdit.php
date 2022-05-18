<div class="row">

              <div class="form-group col-md-6">
                <label for="title">Title</label>
                <input type="text" name="title" class="form-control convert-into-slug" data-slug="slug" id="title" value="<?php echo $data->title;?>" placeholder="Enter Title Name" required>
              </div>

              <div class="form-group col-md-6">
                <label for="sub_title">Sub Title</label>
                <input type="text" name="sub_title" class="form-control convert-into-slug" data-slug="slug" id="sub_title" value="<?php echo $data->sub_title;?>" placeholder="Enter Sub Title Name" required>
              </div>

              <div class="form-group col-md-6">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control convert-into-slug" data-slug="slug" id="email" value="<?php echo $data->email;?>" placeholder="Enter Email" required>
              </div>

             <div class="form-group col-md-6">
                  <label >Status</label>
                    <select id="status" name="status" class="form-control form-control-sm select2" style="width: 100%;">
                     <option value="1" <?php if($data->status == 1){ echo 'selected'; } ?>>Active</option>
                      <option value="0" <?php if($data->status == 0){ echo 'selected'; } ?>>In-Active</option>
                    </select>
              </div>
              
            </div>

            <div class="row">
              <div class="col-md-12">
                <label >Description</label>
                <textarea class="textarea summernote" name="description" id="description" placeholder="Place some text here" style="width: 100%; height: 700px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $data->description;?></textarea>
              </div>
            </div>

<input type="hidden" name="id" value="<?php echo $data->id;?>">

