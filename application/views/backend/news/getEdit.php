<?php
$cate_name = unserialize($data->news_title_name);
$cate_desc = unserialize($data->news_description);
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
     <?php echo form_label('News Title <small style="color: blue; font-weight: bold;"><i> ['. $val.']</i></small>'.$compulsory . ' <small style="color: blue; font-weight: bold;"></small>', 'title_' . $key, array('class' => 'col-sm-12 control-label')); ?>
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
  <label for="tag">Tag<span style="color: red">*</span></label>
  <input type="text" name="tag" class="form-control" id="tag" value="<?php echo $data->tag;?>" required>
</div>
<div class="form-group col-md-6">
  <label for="slug">Slug</label>
  <input type="text" name="slug" class="form-control" id="slug_edit" value="<?php echo $data->slug;?>" readonly>
</div>
 <div class="form-group col-md-6">
  <label >Status</label>
  <select id="status" name="status" class="form-control form-control-sm select2" style="width: 100%;">
   <option value="1" <?php if($data->status == 1){ echo 'selected'; } ?>>Active</option>
   <option value="0" <?php if($data->status == 0){ echo 'selected'; } ?>>In-Active</option>
 </select>
</div>
<div class="form-group col-md-6">
  <label >Catagory</label>
  <select id="catagory" name="catagory" class="form-control form-control-sm select2" style="width: 100%;" value="<?php echo $data->news_title_name;?>">
   <option value="1">Road Show</option>
   <option value="0">Silk Expo</option>
   <option value="0">Awareness Program</option>
   <option value="0">Exhibition</option>
   <option value="0">WorkShop</option>
 </select>
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