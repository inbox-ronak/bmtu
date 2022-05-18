<?php
$cate_name = unserialize($data->blog_title);
$cate_desc = unserialize($data->blog_description);
?>
<div class="row">
  <?php
$langArr = langArr();
foreach ($langArr as $key => $val) {                           
  $compulsory = "";                               
  $compulsory = "<span class='text-danger'>*</span>";

  ?>
  <div class="form-group col-md-6">
    <div class="form-group">
     <?php echo form_label('Blog Title <small style="color: blue; font-weight: bold;"><i> ['. $val.']</i></small>'.$compulsory . ' <small style="color: blue; font-weight: bold;"></small>', 'title_' . $key, array('class' => 'col-sm-12 control-label')); ?>
     <!-- <div class="col-sm-12"> -->
       <?php
       $input_attr = array(
        'name' => 'title_' . $key,
        'id' => 'title_' . $key,
        'class' => 'form-control',
        'autocomplete' => 'off',
        'required'=>'required',
        'placeholder' => 'Title',
        'value' => (isset($_POST['title_' .$key])) ? $_POST['title_' . $key] : $cate_name[$key],
      );
       echo form_input($input_attr);
       ?>
       <input type="hidden" name="hidden_title_<?php echo $key; ?>" value="<?php echo $cate_name[$key]; ?>">
       <!-- </div> -->
     </div>
   </div>
 <?php } ?>
              <div class="form-group col-md-6">
                <label for="slug">Slug</label>
                  <input type="text" name="slug" class="form-control" id="slug_edit" value="<?php echo $data->slug;?>" readonly="">
              </div>

              <div class="form-group col-md-6">
                <label for="blog_image">Blog Image<span style="color: red">*</span></label>
                <input type="file" name="blog_image" class="form-control" id="blog_image" <?php if($data->blog_image == ''){ ?> required <?php } ?> value="<?php echo $data->blog_image;?>">
                <?php if($data->blog_image != ''){ ?>
                  <img style="height: 100px;" src="<?php echo base_url();?>assets/uploads/blog/<?php echo $data->blog_image;?>">
                <?php } ?>
              </div>

              <div class="form-group col-md-6">
                <label for="blog_published_date">Published Date<span style="color: red">*</span></label>
                <input type="date" name="blog_published_date" class="form-control" id="blog_published_date" required value="<?php echo $data->blog_published_date;?>">
              </div>

              <div class="form-group col-md-6">
                  <label >Status</label>
                    <select id="status" name="status" class="form-control form-control-sm select2" style="width: 100%;">
                     <option value="1" <?php if($data->status == 1){ echo 'selected'; } ?>>Active</option>
                      <option value="0" <?php if($data->status == 0){ echo 'selected'; } ?>>De-Active</option>
                    </select>
              </div>

              <div class="form-group col-md-6">
                <label for="intro_content">Intro Content</label>
                 <textarea class="form-control" name="intro_content" id="intro_content"><?php echo $data->intro_content;?></textarea>
              </div>
            </div>

            <div class="row">
              <?php
 $langArr = langArr();
 foreach ($langArr as $key => $val) {
  $compulsory = "";

  $compulsory = "<span class='text-danger'>*</span>";                                    
  $cate_desc_base64_decode = base64_decode($cate_desc[$key]);
  ?>
  <div class="col-md-12">
    <div class="form-group" >
     <?php echo form_label('Description <small style="color: blue; font-weight: bold;"><i> ['. $val.']</i></small> <small style="color: blue; font-weight: bold;"></small>'.$compulsory, 'desc_' . $key, array('class' => 'col-sm-4 control-label')); ?>
     <!-- <div class="col-sm-12"> -->
       <?php
       $input_attr = array(
        'name' => 'desc_' . $key,
        'value' => (isset($_POST['desc_' . $key])) ? $_POST['desc_' . $key] : $cate_desc_base64_decode,
        'rows' => '5',
        'class' => 'form-control summernote',
        'required'=>'required'
      );
       echo form_textarea($input_attr);
       ?>
       <!-- </div> -->
     </div>
   </div>
 <?php } ?>
            </div>

<input type="hidden" name="id" value="<?php echo $data->id;?>">
<script language="javascript">
 $(document).ready(function () {         
   $("input[name='title_en']").keyup(function () {
     $("input[name='slug']").val($(this).val().replace(/[^a-z0-9\s]/gi, '').replace(/\s\s+/g, '-').replace(/[_\s]/g, '-').toLowerCase());
   });
   
   $('#slug').keyup(function () {
     this.value = this.value.replace(/[^a-z0-9\s]/gi, '-').replace(/\s\s+/g, '-').replace(/[_\s]/g, '-').toLowerCase();
   });
 });
</script>