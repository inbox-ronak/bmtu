<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h1>Ticket</h1>
            </div>
            <div class="col-sm-6">
               <div class="breadcrumb float-sm-right">
                  <a href="<?php echo base_url('admin/tickets'); ?>" class="btn btn-success"><i class="fa fa-list"></i> Tickets List</a>
               </div>
            </div>
         </div>
      </div>
   </section>
   <section class="content">
      <div class="container-fluid">
         <div class="row">
            <div class="col-md-12">
               <div class="card">
                  <div class="card-header">
                     <h3 class="card-title">
                        <?php if ($id == '-1') { ?>
                        Add Ticket
                        <?php } else { ?>
                        Edit Ticket
                        <?php } ?>
                     </h3>
                  </div>
                  <div class="card-body">
                     <?php 
                        if (!empty($this->session->flashdata('message'))) {
                            echo $this->session->flashdata('message');
                        } 
                        if(!empty($form_details)){
                            $id = $form_details->id;
                        }
                        ?>
                        <?php echo form_open(base_url('admin/tickets/save/' . $id), 'class="form-horizontal" enctype="multipart/form-data" data-toggle="validator" '); ?> 
                        <?php
                            $cate_name = unserialize($form_details->title);
                            $cate_desc = unserialize($form_details->desc);
                        ?>
                     <div class="row">
                        <?php
                           $langArr = langArr();
                           foreach ($langArr as $key => $val) {                           
                            
                               $compulsory = "";                               
                               $compulsory = "<span class='text-danger'>*</span>";
                             
                                ?>
                        <div class="col-sm-6">
                           <div class="form-group">
                              <?php echo form_label('Title <small style="color: blue; font-weight: bold;"><i> ['. $val.']</i></small>'.$compulsory . ' <small style="color: blue; font-weight: bold;"></small>', 'title_' . $key, array('class' => 'control-label')); ?>
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

                        <div class="col-md-6">
                            <div class="form-group">
                              <label for="user_type">User Type</label>
                              <select name="user_type" class="form-control select2" id="user_type" style="width: 100%;">
                              <!-- <option value="0">Select</option> -->
                              <?php
                                
                                if($user_type){
                                    foreach ($user_type as $value){
                                ?>
                                <option <?php echo (($form_details->user_type==$value['id'])? "selected":"");?> value="<?php echo $value['id'];?>"><?php echo $value['user_type'];?></option>
                              <?php } } ?>
                              </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                              <label for="user_id" class="user_type_text">Contact</label>
                              <select name="user_id" class="form-control select2" id="user_id" style="width: 100%;">
                              <option value="">Select</option>
                              
                              </select>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="assign_user">Assign To user<span class="text-danger">*</span></label>
                            <select name="assign_user" class="form-control select2" id="assign_user" placeholder="Assign To user" required style="width: 100%;">
                                <option value="">Select</option>
                                <?php
                                  if($users){
                                    foreach ($users as $value){
                                       $selected = '';
                                       if(isset($form_details->assign_user)){
                                          if($value['id'] == $form_details->assign_user)
                                          {
                                             $selected = 'selected';
                                          }
                                       }       
                                      echo '<option '.$selected.' value="'.$value['id'].'">'.trim($value['name']).'</option>';
                                    }
                                  }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                           <label for="stall_no">Stall No</label>
                           <input type="number" name="stall_no" class="form-control" id="stall_no" placeholder="Stall No" value="<?php echo (isset($_POST['stall_no'])) ? $_POST['stall_no'] : $form_details->stall_no;?>">
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="slug">Slug <span class="text-danger">*</span></label>
                            <input type="text" name="slug" id="slug" class="form-control" placeholder="Slug" required readonly="readonly" value="<?php echo (isset($_POST['slug'])) ? $_POST['slug'] : $form_details->slug;?>">
                           &nbsp; <span style="color:blue;" ><i><b>Note:</b> It will be automatically generated (Type-Title)</i></span>
                          </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                              <label for="ticket_status">Status</label>
                              <select name="ticket_status" class="form-control select2" id="ticket_status" style="width: 100%;">
                              <!-- <option value="0">Select</option> -->
                              <?php
                                
                                if($ticket_status){
                                    foreach ($ticket_status as $value){
                                ?>
                                <option <?php echo (($form_details->ticket_status==$value['id'])? "selected":"");?> value="<?php echo $value['id'];?>"><?php echo $value['ticket_status'];?></option>
                              <?php } } ?>
                              </select>
                            </div>
                        </div>
                        <?php
                           /*$link = unserialize($form_details->banner_link);
                           $image = unserialize($form_details->banner_image);
                           
                           $langArr = langArr();
                           $i = 0;?>
                        <?php
                           $langArr = langArr();
                           $i = 0;
                           foreach ($langArr as $key => $val) {
                               $compulsory = "";                                       
                               $compulsory = "<span class='text-danger'>*</span>";
                           
                                ?>
                        <div class="col-md-6">
                           <div class="form-group">
                              <?php echo form_label('Banner Image <small style="color: blue; font-weight: bold;"><i> ['. $val.']</i></small><small style="color: blue; font-weight: bold;"></small>', 'banner_img_' . $key, array('class' => 'col-sm-12 control-label')); ?>
                              <!-- <div class="col-sm-12"> -->
                                 <input type="file" class="form-control" name="banner_img_<?php echo $key; ?>" id="image_file_<?php echo $key; ?>">
                                 <span class='text-danger'>
                                    <p id="file_message_<?php echo $key; ?>"></p>
                                 </span>
                              <!-- </div> -->
                              <div class="col-md-12 uploaded_img_<?php echo $key; ?>" id="uploaded_img<?php echo $i; ?>" style=" margin-top:10px; ">
                                 <div class="col-md-3"></div>
                                 <span style="color:blue;" ><i><b>Note:</b> Recommended Image size: 1500 X 348</i></span>
                                 <div class="col-md-6 upload_img_div upload_img_div_<?php echo $key; ?>" id="upload_img_div">                                
                                    <span class="single-image-wrap">
                                    <?php
                                       if (isset($image[$key]) && $image[$key]['image'] != '') {
                                       
                                       $file_name_view = basename($image[$key]['image']);
                                       $image_path = getImagePath() . 'uploads/ticket/thumb/' . $file_name_view;
                                       
                                           echo '<img src="' . $image_path. '" class="uploaded-images" style="width: 200px;height: 200px;">'
                                           . '<span class="delImg" data-id="' . $form_details->id . '" data-img="' . $key . '"  onclick="deletImage($(this))" style="cursor:pointer">X</span>';
                                       }
                                       
                                       
                                       
                                       
                                        ?>
                                    <input type="hidden" id="banner_uploaded_img_<?php echo $key; ?>" name="banner_uploaded_img_<?php echo $key; ?>" value="<?php echo isset($image[$key]['image']) ? $image[$key]['image'] : ''; ?>">
                                    </span>
                                 </div>
                                 <div class="col-md-3"></div>
                              </div>
                           </div>
                        </div>
                        <?php 
                           $i++;
                           }*/
                           ?>
                     </div>
                     <!-- </div> -->
                     <div class="row">
                        <?php  ?>                       
                        <?php
                           $langArr = langArr();
                           foreach ($langArr as $key => $val) {
                               $compulsory = "";
                              
                               $compulsory = "<span class='text-danger'>*</span>";                                    
                               $cate_desc_base64_decode = base64_decode($cate_desc[$key]);
                               ?>
                        <div class="col-md-6">
                           <div class="form-group" >
                              <?php echo form_label('Description <small style="color: blue; font-weight: bold;"><i> ['. $val.']</i></small> <small style="color: blue; font-weight: bold;"></small>', 'desc_' . $key, array('class' => 'col-sm-4 control-label')); ?>
                              <!-- <div class="col-sm-12"> -->
                                 <?php
                                    $input_attr = array(
                                        'name' => 'desc_' . $key,
                                        'value' => (isset($_POST['desc_' . $key])) ? $_POST['desc_' . $key] : $cate_desc_base64_decode,
                                        'rows' => '5',
                                        'class' => 'form-control textarea'
                                    );
                                    echo form_textarea($input_attr);
                                    ?>
                              <!-- </div> -->
                           </div>
                        </div>
                        <?php } ?>
                        
                        <div class="col-sm-3">
                           <div class="form-group">
                              <label for="Title" class="col-sm-12 control-label">Navigation order<span class="text-danger">*</span> </label>
                              <!-- <div class="col-sm-12"> -->
                                 <?php
                                    $catorder = '';
                                    if (isset($form_details) && !empty($form_details)) {
                                        $catorder = $form_details->cat_order;
                                    }
                                    $Title = array(
                                        'type' => 'text',
                                        'onkeypress' => "return isNumber(event)",
                                        'name' => 'order',
                                        'id' => 'order',
                                        'class' => 'form-control',
                                        'placeholder' => 'Navigation order',
                                        'value' => (isset($_POST['order'])) ? $_POST['order'] : $catorder,
                                    );
                                    echo form_input($Title);
                                    ?>
                              <!-- </div> -->
                           </div>
                        </div>
                        <?php /* ?>
                        <div class="col-sm-3">
                           <div class="form-group">
                              <label for="show_ticket_in_sidebar" class="col-sm-12 control-label"> Show Ticket in Sidebar </label>
                              <!-- <div class="col-sm-12"> -->
                                 <div class="icheck-primary d-inline" title="Select All">
                                    <input type="checkbox" name="show_ticket_in_sidebar"  class="minimal-red" value="1" <?php echo isset($form_details) && !empty($form_details) && ($form_details->show_ticket_in_sidebar == '1') ? 'checked' : ''; ?>
                                       <?php echo isset($_POST) && !empty($_POST['show_ticket_in_sidebar']) && ($_POST['show_ticket_in_sidebar'] == '1') ? 'checked' : ''; ?> id="show_ticket_in_sidebar"><label for="show_ticket_in_sidebar"></label>
                                 </div>
                              <!-- </div> -->
                           </div>
                        </div>
                     
                        <div class="col-md-3">
                           <div class="form-group">
                              <label for="show_ticket_in_navigation" class="col-sm-12 control-label"> Show ticket in Navigation </label>
                              <!-- <div class="col-sm-12"> -->
                                 <div class="icheck-primary d-inline" title="Select All">
                                    <input type="checkbox" name="show_ticket_in_navigation"  class="minimal-red" value="1" <?php echo isset($form_details) && !empty($form_details) && ($form_details->show_ticket_in_navigation == '1') ? 'checked' : ''; ?> id="show_ticket_in_navigation"><label for="show_ticket_in_navigation"></label>
                                 </div>
                              <!-- </div> -->
                           </div>
                        </div>
                        <?php */ ?>
                     </div>
                     <br>
                     <div class="form-group">
                        <div class="col-md-11">
                           <input type="submit" name="submit" value="Apply" class="btn btn-info pull-right">
                           <input type="submit" name="submit" value="Save & Close" class="btn btn-info pull-right">
                           <a href="<?php echo base_url().'admin/tickets';?>"><input type="button" name="submit" value="Cancel" class="btn btn-info pull-right"></a>
                        </div>
                     </div>
                     <?php echo form_close(); ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
</div>
<!-- /.content-wrapper -->
<script language="javascript">
   $(document).ready(function () {          
       $("input[name='title_en']").keyup(function () {
           $("input[name='slug']").val($(this).val().replace(/[^a-z0-9\s]/gi, '').replace(/\s\s+/g, '-').replace(/[_\s]/g, '-').toLowerCase());
       });
   
       $('#slug').keyup(function () {
           this.value = this.value.replace(/[^a-z0-9\s]/gi, '-').replace(/\s\s+/g, '-').replace(/[_\s]/g, '-').toLowerCase();
       });
   $("input[name='cat_type']").on('change',function(){
   
   $("input[name='slug']").val($("input[name='title_en']").val().replace(/[^a-z0-9\s]/gi, '').replace(/\s\s+/g, '-').replace(/[_\s]/g, '-').toLowerCase());
       
   });
   });
</script>
<script type="text/javascript">
   // In your Javascript (external .js resource or <script> tag)
   $(document).ready(function () {
       //$('.learn_more_page').select2();
   
       /*var langArr = <?php echo json_encode(langArr()); ?>;
       if (langArr != null) {
           $.each(langArr, function (key, value) {
               get_editor('desc_' + key);
           });
       }*/
        $('#user_type').on('change',function(){
            var id = $(this).find('option:selected').val();
            //var user_type = '<?php if (isset($form_details->user_type)){echo $form_details->user_type;}?>';
            var user_id = '<?php if (isset($form_details->user_id)){echo $form_details->user_id;}?>';
            if(id == 1){
                $('.user_type_text').text('Contact');
            }else{
                $('.user_type_text').text('Organization'); 
            }
            $.ajax({
               data: {id: id},
               type: 'post',
               url: '<?php echo base_url(); ?>admin/tickets/get_users',
               async: true,
               success: function (output) {
                   //console.log(output);
                   var html = '';
                   var users = JSON.parse(output);
                   for (var i = 0; i < users.length;i++) {
                        var selected = '';
                        if(user_id == users[i].id){
                            selected = 'selected';
                        }
                       html += '<option '+selected+' value="'+users[i].id+'">'+users[i].text+'</option>';
                   }
                   $('#user_id').html(html);
                   $('#user_id').select2();
               }
           });
        });
        $('#user_type').trigger('change');
   });
   function deletImage(obj) {
       img = obj.attr('data-img');
       id = obj.attr('data-id');
       if (confirm("Are you sure you want to delete this Image?")) {
           $.ajax({
               data: {img_lng: img, id: id, 'csrf_test_name': $("input[name=csrf_test_name]").val()},
               type: 'post',
               url: '<?php echo base_url(); ?>admin/tickets/DeleteImage',
               async: true,
               success: function (output) {
                   console.log()
                   $(".upload_img_div_" + img).html('');
                   $(".banner_uploaded_img_" + img).val('');
   
   
                   $('.flash-msg').html('Image deleted Successfully!');
               }
           });
       } else {
           return false;
       }
   }
</script>
<script>
    function isNumber(evt) {
       evt = (evt) ? evt : window.event;
       var charCode = (evt.which) ? evt.which : evt.keyCode;
       if (charCode > 31 && (charCode < 48 || charCode > 57)) {
           return false;
       }
       return true;
    }
    // validate on paste for number type 
    $('#order').on('paste', function (event) {
        if (event.originalEvent.clipboardData.getData('Text').match(/[^\d]/)) {
            event.preventDefault();
        }
    });
   // validate file type
   <?php foreach ($langArr as $key => $val) { ?>
    $("#image_file_<?php echo $key; ?>").change(function () {
        document.getElementById("file_message_<?php echo $key; ?>").innerHTML=''
        var fileUpload = $("#image_file_<?php echo $key; ?>")[0];
        var ext = this.value.match(/\.(.+)$/)[1];
        switch (ext) {
            case 'jpg':
            case 'jpeg':
            case 'png':
            case 'PNG':
            case 'gif':   
            break;
            default:
            document.getElementById("file_message_<?php echo $key; ?>").innerHTML='Please Select Proper Image Type(jpg,jpeg,png,PNG,gif)';
            this.value = '';
        }

    });

    //vlidate dimension of file
    $(function () {
        $("#image_file_<?php echo $key; ?>").change(function () {
            //Get reference of FileUpload.

            var fileUpload = $("#image_file_<?php echo $key; ?>")[0];

            //Check whether the file is valid Image.
            var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.png|.gif|.PNG)$");

            var reader = new FileReader();
            //Read the contents of Image File.
            reader.readAsDataURL(fileUpload.files[0]);
            reader.onload = function (e) {
                //Initiate the JavaScript Image object.
                var image = new Image();
                //Set the Base64 string return from FileReader as source.
                image.src = e.target.result;
                image.onload = function () {
                    //Determine the Height and Width.
                    var height = this.height;
                    var width = this.width;
                    if (height > 1500 || width > 348) {
                        document.getElementById("file_message_<?php echo $key; ?>").innerHTML='Please Select Proper Size'
                        fileUpload.value = '';
                    }
                };
            } 
        });
    });
   <?php } ?>
</script>