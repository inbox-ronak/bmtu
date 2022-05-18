<?php $user_role = $_SESSION['user_role']; ?>
<?php $add_permission = $this->permission->grant(ANNOUNCEMENT,'add'); ?>
<?php $edit_permission = $this->permission->grant(ANNOUNCEMENT,'edit'); ?>
<?php $delete_permission = $this->permission->grant(ANNOUNCEMENT,'delete'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h1><?php if(isset($announcement['id'])){ echo 'Update';}else{ echo 'Add'; } ?> Announcement</h1>
            </div>
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Dashboard</a></li>
                  <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/announcement">Announcement</a></li>
                  <li class="breadcrumb-item active"><?php if(isset($announcement['id'])){ echo 'Update';}else{ echo 'Add'; } ?> Announcement</li>
               </ol>
            </div>
         </div>
      </div>
      <!-- /.container-fluid -->
   </section>
   <?php //echo '<pre>';print_r($label);?>
   <!-- Main content -->
   <section class="content">
      <div class="container-fluid">
         <div class="row">
            <div class="col-12">
               <div class="card">
                  <div class="card-header">
                     <h3 class="card-title"><?php if(isset($announcement['id'])){ echo 'Update';}else{ echo 'Add'; } ?> Announcement</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body" id="show_data">
                     <form data-toggle="validator" role="form" method='POST' class="form-horizontal" action='<?php echo base_url();?>admin/announcement/<?php if(isset($announcement['id'])){ echo 'edit/'.base64_encode($announcement['id']);}else{ echo 'add'; } ?>' id="add-form" name="add-form" enctype='multipart/form-data'>
                        <?php 
                           if (!empty($this->session->flashdata('message'))) {
                               echo $this->session->flashdata('message');
                           } 
                           if(!empty($form_details)){
                               $id = $form_details->id;
                           }
                           ?>
                        <?php echo form_open(base_url('admin/events/save/' . $id), 'class="form-horizontal" enctype="multipart/form-data" data-toggle="validator" '); ?> 
                        <?php
                           $cate_name = unserialize($announcement['announcement_title']);
                           $cate_desc = unserialize($announcement['announcement_description']);
                           ?>
                        <div class="row">
                           <!-- <div class="form-group col-md-6">
                              <label for="blog_title">Announcement Title<span style="color: red">*</span></label>
                              <input type="text" name="announcement_title" class="form-control convert-into-slug" data-slug="slug" id="announcement_title" value="<?php if(isset($announcement['announcement_title'])){ echo $announcement['announcement_title'];} ?>"  placeholder="Enter Announcement Title Name" required>
                              </div> -->
                           <?php
                              $langArr = langArr();
                              foreach ($langArr as $key => $val) {                           
                               
                                  $compulsory = "";                               
                                  $compulsory = "<span class='text-danger'>*</span>";
                                
                                   ?>
                           <div class="form-group col-md-6">
                              <div class="form-group">
                                 <?php echo form_label('Announcement Title <small style="color: blue; font-weight: bold;"><i> ['. $val.']</i></small>'.$compulsory . ' <small style="color: blue; font-weight: bold;"></small>', 'title_' . $key, array('class' => 'col-sm-12 control-label')); ?>
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
                              <input type="text" name="slug" class="form-control" id="slug" readonly="" value="<?php if(isset($announcement['slug'])){ echo $announcement['slug'];} ?>">
                           </div>
                           <div class="form-group col-md-6">
                              <label for="choice">Choice File</label>
                              <select id="choice" name="choice[]" class="form-control select2" multiple style="width: 100%;">
                                 <?php
                                    $choice = array();
                                    if(isset($announcement['choice'])){
                                      $choice = json_decode($announcement['choice'],true);
                                    }
                                    ?>
                                 <option>Select</option>
                                 <option value="url" <?php if($choice){ if(in_array('url', $choice)){ echo 'selected'; }} ?>>Url</option>
                                 <option value="image" <?php if($choice){ if(in_array('image', $choice)){ echo 'selected'; }} ?>>Image</option>
                                 <option value="document" <?php if($choice){ if(in_array('document', $choice)){ echo 'selected'; }} ?>>Document</option>
                                 <option value="video" <?php if($choice){ if(in_array('videovideo', $choice)){ echo 'selected'; }} ?>>Video</option>
                              </select>
                           </div>
                           <!-- hide unhide filed -->
                           <div class="form-group col-md-6 choice-hidden url">
                              <label for="url"> URL</label>
                              <input type="text" name="url" class="form-control" id="url" value="<?php if(isset($announcement['url'])){ echo $announcement['url'];} ?>">
                           </div>
                           <div class="form-group col-md-6 choice-hidden image">
                              <label for="image_document"> Image Document</label>
                              <input type="file" name="image_document" class="form-control" id="image_document">
                           </div>
                           <?php if(isset($announcement['image_document'])){ ?>
                           <div class="form-group col-md-6">
                              <label for="image_document">Uploaded Image Document</label><br>
                              <img style="width:150px;" src="<?php echo base_url().'assets/uploads/announcement/'.$announcement['image_document'];?>">
                           </div>
                           <?php } ?>
                           <div class="form-group col-md-6 choice-hidden document">
                              <label for="document">Document</label><br>
                              <input type="file" name="document" class="form-control" id="document">
                              <span>Max File Size 5 MB</span>
                           </div>
                           <?php if(isset($announcement['document'])){ ?>
                           <div class="form-group col-md-6">
                              <label>Uploaded Document</label><br>
                              <iframe style="width:150px;" src="<?php echo base_url().'assets/uploads/announcement/'.$announcement['document'];?>"></iframe>
                           </div>
                           <?php } ?>
                           <div class="form-group col-md-6 choice-hidden video">
                              <label for="document"> Video Document</label>
                              <input type="file" name="video_document" class="form-control" id="video_document">
                              <span>Max Video Size 10 MB</span>
                           </div>
                           <?php if(isset($announcement['video_document'])){ ?>
                           <div class="form-group col-md-6">
                              <label>Uploaded Video</label>
                              <video style="width:150px;" src="<?php echo base_url().'assets/uploads/announcement/'.$announcement['video_document'];?>">
                           </div>
                           <?php } ?>
                           <!-- hide unhide filed -->
                           <div class="form-group col-md-6">
                              <label >Status</label>
                              <select id="status" name="status" class="form-control form-control-sm select2" style="width: 100%;">
                                 <option value="1">Active</option>
                                 <option value="0">In-Active</option>
                              </select>
                           </div>
                           <div class="form-group col-md-6">
                              <label for="announcement_date">Date<span style="color: red">*</span></label>
                              <input type="date" name="announcement_date" class="form-control" id="announcement_date" required="" value="<?php if(isset($announcement['announcement_date'])){ echo $announcement['announcement_date'];} ?>">
                           </div>
                           <div class="form-group col-md-6">
                              <label for="announcement_time">Time<span style="color: red">*</span></label>
                              <input type="time" name="announcement_time" class="form-control" id="announcement_time" required="" value="<?php if(isset($announcement['announcement_time'])){ echo $announcement['announcement_time'];} ?>">
                           </div>
                           <div class="form-group col-md-6">
                              <label for="intro_content">Intro Content</label>
                              <textarea class="form-control" name="intro_content" id="intro_content" ><?php echo $announcement['intro_content'];?></textarea>
                           </div>
                           <div class="form-group col-md-6">
                              <label for="ordering">Ordering</label>
                              <input type="number" name="ordering" class="form-control"  id="ordering" value="<?php if(isset($announcement['ordering'])){ echo $announcement['ordering'];} ?>">
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
                        <div class="row">
                           <div class="col-md-4">
                              <div class="form-group">
                                 <button type="submit" name="submit" class="btn btn-primary">Save</button>
                              </div>
                           </div>
                        </div>
                     </form>
                  </div>
                  <!-- /.card-body -->
               </div>
               <!-- /.card -->
            </div>
            <!-- /.col -->
         </div>
         <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
   </section>
   <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
   $(document).ready(function(){
     function text_editor(){
       $('.summernote').summernote({
         toolbar: [
               ["style", ["style"]],
               ["font", ["bold", "underline", "clear"]],
               //["fontname", ["fontname"]],
               ["color", ["color"]],
               ["para", ["ul", "ol", "paragraph"]],
               ["table", ["table"]],
               ["insert", ["link", "picture", "video"]],
               ["view", ["fullscreen", "codeview", "help"]]
             ],
       });
     }
     text_editor();
     function user_type(){
       var value = $('#user_type').find('option:selected').val();
       //console.log()
       if (value == '2')
       {
         $(".user_list_chapter").show();
         $(".user_list_au").hide();
         
       }
       else if (value == '3')
       {
         $(".user_list_chapter").hide();
         $(".user_list_au").show();
       }
       else
       {
         $(".user_list_chapter").hide();
         $(".user_list_au").hide();
         
       }
     }
     user_type();
     $('#user_type').on('change',function(){
       user_type();
     });
   });
   
</script>
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
       
   });
   
     $('#choice :selected').each(function(){
         var name = $(this).val();
         console.log(name);
         $("."+name).show();
       });
   })
</script>
<!-- multiple filed hide show -->
<!-- video validation script -->
<script>
   $('#video_document').on('change', function() {
   var numb = $(this)[0].files[0].size / 1024 / 1024;
   numb = numb.toFixed(2);
   if (numb > 10) {
     alert('to big, maximum is 10MiB. You file size is: ' + numb + ' MiB');
     $('#video_document').val('');
   } else {
     alert('it okey, your file has ' + numb + 'MiB')
   }
   });
</script>
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
<!-- video validation script -->