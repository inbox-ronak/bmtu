<div class="row">
              <div class="form-group col-md-6">
                <label for="blog_title">Announcement Title</label>
                <input type="text" name="announcement_title" class="form-control convert-into-slug" data-slug="slug" id="blog_title" value="<?php echo $data->announcement_title;?>" required>
              </div>

              <div class="form-group col-md-6">
                <label for="slug">Slug</label>
                <input type="text" name="slug" class="form-control" id="slug" value="<?php echo $data->slug;?>" readonly="">
              </div>

              <div class="form-group col-md-6">
                <label for="choice_edit">Choice File</label>
                 <select id="choice_edit" name="choice[]" class="form-control select2" multiple style="width: 100%;">
                     <option>Select</option>
                     <option value="url">Url</option>
                     <option value="image">Image</option>
                     <option value="document">Document</option>
                     <option value="video">Video</option>
                 </select>
              </div>

              <!-- hide unhide filed -->

              <div class="form-group col-md-6 choice-hidden url">
                <label for="url"> URL</label>
                <input type="text" name="url" class="form-control" id="url" value="<?php echo $data->url;?>" required="">
              </div>

              <div class="form-group col-md-6 choice-hidden image">
                <label for="image_document"> Image Document</label>
                <input type="file" name="image_document" class="form-control" id="image_document" value="<?php echo $data->image_document;?>" required="">
              </div>

              <div class="form-group col-md-6 choice-hidden document">
                <label for="document"> Document</label>
                <input type="file" name="document" class="form-control" id="document" value="<?php echo $data->document;?>" required="">
                <span>Max File Size 5 MB</span>
              </div>

              <div class="form-group col-md-6 choice-hidden video">
                <label for="document"> Video Document</label>
                <input type="file" name="video_document" class="form-control" id="video_document" value="<?php echo $data->video_document;?>" required="">
                <span>Max Video Size 10 MB</span>

              </div>

              <!-- hide unhide filed -->


              <div class="form-group col-md-6">
                  <label >Status</label>
                    <select id="status" name="status" class="form-control form-control-sm select2" style="width: 100%;">
                     <option value="1">Active</option>
                     <option value="0">In-Active</option>
                    </select>
              </div>

              <div class="form-group col-md-6">
                <label for="announcement_date"> Date</label>
                <input type="date" name="announcement_date" class="form-control" id="announcement_date" value="<?php echo $data->announcement_date;?>" required="">
              </div>

              <div class="form-group col-md-6">
                <label for="announcement_time"> Time</label>
                <input type="time" name="announcement_time" class="form-control" id="announcement_time" value="<?php echo $data->announcement_time;?>" required="">
              </div>

              

              <div class="form-group col-md-6">
                <label for="intro_content">Intro Content</label>
                <textarea class="form-control" name="intro_content" id="intro_content" value="<?php echo $data->intro_content;?>"></textarea>
              </div>

               <div class="form-group col-md-6">
                <label for="ordering">Ordering</label>
                <input type="number" name="ordering" class="form-control"  id="ordering" value="<?php echo $data->ordering;?>">
            </div>

            </div>

           <div class="row">
              <div class="col-md-12">
                <label for="announcement_description">Description</label>
                <textarea class="textarea summernote" name="announcement_description" style="width: 100%; height: 700px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $data->announcement_description;?></textarea>
              </div>
            </div>

<input type="hidden" name="id" value="<?php echo $data->id;?>">

<!-- multiple filed hide show -->
<script>
  $(document).ready(function(){
    $(".choice-hidden").hide();
    $("#choice").change(function(){
      //var name = $(this).find('option:selected').val();
      //var name = $("#choice :selected").map((_, e) => e.value).get();
      //console.log(name);
      $(".choice-hidden").hide();
      $('#choice :selected').each(function(){
        var name = $(this).val();
        $("."+name).show();
      });
      
  })
})
</script>

<!-- multiple filed hide show -->