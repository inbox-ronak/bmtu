<div class="row">
              <div class="form-group col-md-6">
                <label for="title">Title</label>
                <input type="text" name="title" class="form-control convert-into-slug" id="title" value="<?php echo $data->title;?>" required>
              </div>

              
            
              <div class="form-group col-md-6">
                  <label >Status</label>
                    <select id="status" name="status" class="form-control form-control-sm select2" style="width: 100%;">
                     <option value="1">Active</option>
                     <option value="0">In-Active</option>
                    </select>
              </div>

            
            </div>

           <div class="row">
              <div class="col-md-12">
                <label for="description">Description</label>
                <textarea class="textarea summernote" name="description" style="width: 100%; height: 700px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $data->description;?></textarea>
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