<script src="<?php echo base_url() ?>public/plugins/ckeditor_new/ckeditor.js"></script>
<script src="<?php echo base_url() ?>public/dist/js/jquery.validate.min.js"></script>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-12">
            <div class="col-sm-6">
                <h1>Ads</h1>
            </div>
            <div class="col-sm-6">
                <div class="breadcrumb float-sm-right">
                    <a href="<?= base_url('admin/ads'); ?>" class="btn btn-success"><i class="fa fa-list"></i> Ads's List</a>
                    <?php if (!empty($form_details && $form_details->id > 0)) { ?>
                        <a style="margin-left:5px;color:#fff" title="Delete" 
                           class="delete btn btn-danger"  
                           data-href="<?php echo base_url('admin/ads/delete/' . $form_details->id); ?>" data-toggle="modal" 
                           data-target="#confirm-delete"> <i class="fa fas fa-trash-alt"></i> Delete</a>
                       <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            <?php
                                
                            if ($id == '-1') { ?>
                                &nbsp; Add Ads
                            <?php } else { ?>
                                &nbsp; Edit Ads
                            <?php } 
                              
                            ?>
                             

                        </h3>
                    </div>
                    <div class="card-body">
                        <?php
                        if (!empty($this->session->flashdata('message'))) {
                            echo $this->session->flashdata('message');
                        }
                        ?>
                        <?php echo form_open(base_url('admin/ads/save/' . $form_details->id), 'class="form-horizontal" enctype="multipart/form-data"  '); 
                        ?> 

                        <div class="row">
                               <div class="col-lg-6 col-md-6 col-sm-6 item">
                                <div class="form-group">
                                    <label for="page_name" class="control-label">Page Name :<span class="text-danger">*</span> </label>
                                    <select class="form-control" name="page_slug" id="page_slug"  >
                                        <option  value="">Select Page Name</option>
                                        <?php  
                                             if(!empty($page_data)){
                                                $selected = '';
                                                foreach($page_data as $page_list){               
                                                 ?>

                                           <option data-slug="<?php echo $page_list['page_slug'];?>" value="<?= $page_list['page_slug'] ?>" <?= ($form_details->page_slug == $page_list['page_slug']) ? "selected" : ''; ?> <?= $selected; ?>> <?=$page_list['page_name_en'];?> </option>
                                                <?php }
                                             }
                                        ?>
                                        
                                    </select> 
                             </div>
                        </div>
                        </div>
                         <!--Page Top Image  -->
                         <?php 
                           $langArr = langArr();
                           $top_ads_array  = array();
                           $i = 0;
                           if(!empty($form_details->top_ads)){
                            $top_ads_array = unserialize($form_details->top_ads);
                            }
                            
                            foreach ($langArr as $key => $val) {?>
                                  <div class="col-md-6">
                                            <div class="form-group">
                                                <?php echo form_label('Top Position Image <small style="color: blue; font-weight: bold;"><i> ['. $val.']</i></small><small style="color: blue; font-weight: bold;"></small>', 'top_ads_' . $key, array('class' => 'col-sm-12 control-label')); ?>
                                                <div class="col-sm-12">
                                                    <input type="file" name="top_ads_<?php echo $key; ?>" id="top_ads_<?php echo $key; ?>">
                                                    <span class="text-danger"><p id="top_ads_file_message_<?php echo $key; ?>"></p></span>
                                                </div>
                                                <div class="col-md-12 top_ads_uploaded_img_<?php echo $key; ?>" id="top_ads_uploaded_img<?php echo $i; ?>" style=" margin-top:10px; ">
                                                    <div class="col-md-3"></div>
                                                    <span style="color:blue;" ><i><b>Note:</b> Recommended Image size: 1470 X 199 </i></span>
                                                    <div class="col-md-6 upload_img_div upload_img_div_<?php echo $key; ?>" id="upload_img_div">                                
                                                        <span class="single-image-wrap">
                                                            <?php
                                                        if (isset($top_ads_array[$key]) && $top_ads_array[$key]['image'] != '') {

                                                            $file_name_view = basename($top_ads_array[$key]['image']);
                                                            $image_path = getImagePath() . 'uploads/ads/thumb/' . $file_name_view;

                                                                echo '<img src="' . $image_path. '" class="uploaded-images" style="width: 200px;height: 200px;">'
                                                                . '<span class="delImg" data-id="' . $form_details->id . '" data-img="' . $key . '"  onclick="deletImage($(this))" style="cursor:pointer">X</span>';
                                                            }
                                                             ?>
                                                            <input type="hidden" id="hidden_top_ads_<?php echo $key; ?>" name="hidden_top_ads_<?php echo $key; ?>" value="<?php echo isset($top_ads_array[$key]['image']) ? $top_ads_array[$key]['image'] : ''; ?>">
                                                        </span>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                            <?php } ?>
                         <!-- End Page Top Image  -->

                          <!--Page left Image  -->
                         <?php 
                           $langArr = langArr();
                           $left_ads_array  = array();
                            if(!empty($form_details->left_ads)){
                            $left_ads_array = unserialize($form_details->left_ads);
                            }
                            
                           $i = 0;
                            foreach ($langArr as $key => $val) {?>
                                  <div class="col-md-6">
                                            <div class="form-group">
                                                <?php echo form_label('Left Position Image <small style="color: blue; font-weight: bold;"><i> ['. $val.']</i></small><small style="color: blue; font-weight: bold;"></small>', 'left_ads_' . $key, array('class' => 'col-sm-12 control-label')); ?>
                                                <div class="col-sm-12">
                                                    <input type="file" name="left_ads_<?php echo $key; ?>" id="left_ads_<?php echo $key; ?>">
                                                    <span class="text-danger"><p id="left_ads_file_message_<?php echo $key; ?>"></p></span>
                                                </div>
                                                <div class="col-md-12 left_ads_uploaded_img_<?php echo $key; ?>" id="left_ads_uploaded_img<?php echo $i; ?>" style=" margin-top:10px; ">
                                                    <div class="col-md-3"></div>
                                                    <span style="color:blue;" ><i><b>Note:</b> Recommended Image size: 348 X 320 </i></span>
                                                    <div class="col-md-6 upload_img_div upload_img_div_<?php echo $key; ?>" id="upload_img_div">                                
                                                        <span class="single-image-wrap">
                                                            <?php
                                                        if (isset($left_ads_array[$key]) && $left_ads_array[$key]['image'] != '') {

                                                            $file_name_view = basename($left_ads_array[$key]['image']);
                                                            $image_path = getImagePath() . 'uploads/ads/thumb/' . $file_name_view;

                                                                echo '<img src="' . $image_path. '" class="uploaded-images" style="width: 200px;height: 200px;">'
                                                                . '<span class="delImg" data-id="' . $form_details->id . '" data-img="' . $key . '"  onclick="deletImage($(this))" style="cursor:pointer">X</span>';
                                                            }
                                                             ?>
                                                            <input type="hidden" id="hidden_left_ads_<?php echo $key; ?>" name="hidden_left_ads_<?php echo $key; ?>" value="<?php echo isset($left_ads_array[$key]['image']) ? $left_ads_array[$key]['image'] : ''; ?>">
                                                        </span>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                            <?php } ?>
                         <!-- End Page Top Image  -->

                          <!--Page Top Image  -->
                         <?php 
                           $langArr = langArr();
                           $right_ads_array = array();
                          if(!empty($form_details->right_ads)){
                            $right_ads_array = unserialize($form_details->right_ads);
                            }

                           
                           $i = 0;
                            foreach ($langArr as $key => $val) {?>
                                  <div class="col-md-6">
                                            <div class="form-group">
                                                <?php echo form_label('Right Position Image <small style="color: blue; font-weight: bold;"><i> ['. $val.']</i></small><small style="color: blue; font-weight: bold;"></small>', 'right_ads_' . $key, array('class' => 'col-sm-12 control-label')); ?>
                                                <div class="col-sm-12">
                                                    <input type="file" name="right_ads_<?php echo $key; ?>" id="right_ads_<?php echo $key; ?>">
                                                    <span class="text-danger"><p id="right_ads_file_message_<?php echo $key; ?>"></p></span>
                                                </div>
                                                <div class="col-md-12 right_ads_uploaded_img_<?php echo $key; ?>" id="top_ads_uploaded_img<?php echo $i; ?>" style=" margin-top:10px; ">
                                                    <div class="col-md-3"></div>
                                                    <span style="color:blue;" ><i><b>Note:</b> Recommended Image size: 348 X 320 </i></span>
                                                    <div class="col-md-6 upload_img_div upload_img_div_<?php echo $key; ?>" id="upload_img_div">                                
                                                        <span class="single-image-wrap">
                                                            <?php
                                                        if (isset($right_ads_array[$key]) && $right_ads_array[$key]['image'] != '') {

                                                            $file_name_view = basename($right_ads_array[$key]['image']);
                                                            $image_path = getImagePath() . 'uploads/ads/thumb/' . $file_name_view;

                                                                echo '<img src="' . $image_path. '" class="uploaded-images" style="width: 200px;height: 200px;">'
                                                                . '<span class="delImg" data-id="' . $form_details->id . '" data-img="' . $key . '"  onclick="deletImage($(this))" style="cursor:pointer">X</span>';
                                                            }
                                                             ?>
                                                            <input type="hidden" id="hidden_right_ads_<?php echo $key; ?>" name="hidden_right_ads_<?php echo $key; ?>" value="<?php echo isset($right_ads_array[$key]['image']) ? $right_ads_array[$key]['image'] : ''; ?>">
                                                        </span>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                            <?php } ?>
                         <!-- End Page Top Image  -->
                          <!--Page Top Image  -->
                         <?php 
                           $langArr = langArr();
                           $bottom_ads_array  = array();
                            if(!empty($form_details->bottom_ads)){
                            $bottom_ads_array = unserialize($form_details->bottom_ads);
                            }
                           $i = 0;
                            foreach ($langArr as $key => $val) {?>
                                  <div class="col-md-6">
                                            <div class="form-group">
                                                <?php echo form_label('Bottom Position Image <small style="color: blue; font-weight: bold;"><i> ['. $val.']</i></small><small style="color: blue; font-weight: bold;"></small>', 'top_ads_' . $key, array('class' => 'col-sm-12 control-label')); ?>
                                                <div class="col-sm-12">
                                                    <input type="file" name="bottom_ads_<?php echo $key; ?>" id="bottom_ads_<?php echo $key; ?>">
                                                    <span class="text-danger"><p id="bottom_ads_file_message_<?php echo $key; ?>"></p></span>
                                                </div>
                                                <div class="col-md-12 bottom_ads_uploaded_img_<?php echo $key; ?>" id="top_ads_uploaded_img<?php echo $i; ?>" style=" margin-top:10px; ">
                                                    <div class="col-md-3"></div>
                                                    <span style="color:blue;" ><i><b>Note:</b> Recommended Image size: 1470 X 199 </i></span>
                                                    <div class="col-md-6 upload_img_div upload_img_div_<?php echo $key; ?>" id="upload_img_div">                                
                                                        <span class="single-image-wrap">
                                                            <?php
                                                        if (isset($bottom_ads_array[$key]) && $bottom_ads_array[$key]['image'] != '') {

                                                            $file_name_view = basename($bottom_ads_array[$key]['image']);
                                                            $image_path = getImagePath() . 'uploads/ads/thumb/' . $file_name_view;

                                                                echo '<img src="' . $image_path. '" class="uploaded-images" style="width: 200px;height: 200px;">'
                                                                . '<span class="delImg" data-id="' . $form_details->id . '" data-img="' . $key . '"  onclick="deletImage($(this))" style="cursor:pointer">X</span>';
                                                            }
                                                             ?>
                                                            <input type="hidden" id="hidden_bottom_ads_<?php echo $key; ?>" name="hidden_bottom_ads_<?php echo $key; ?>" value="<?php echo isset($bottom_ads_array[$key]['image']) ? $bottom_ads_array[$key]['image'] : ''; ?>">
                                                        </span>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                            <?php } ?>
                         <!-- End Page Top Image  -->

                           <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="status" class="col-sm-12 control-label"> Status <span class='text-danger'>*</span></label>
                                    <div class="col-sm-12 contentradio" id="contant_status_en">
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" name="status" value="1" <?php echo set_radio('status', 1); ?> id="customCheck1"
                                            <?php
                                            if ($form_details->status == '1')
                                                echo 'checked="checked"';
                                            if (isset($form_details->status) && $form_details->status == 1) {
                                                echo 'checked="checked"';
                                            } else {
                                                echo 'checked="checked"';
                                            }
                                            ?>
                                                   >
                                            <label for="customCheck1">Active</label>
                                        </div>
                                        <div class="icheck-primary d-inline p-3">
                                            <input type="radio" name="status" value="0" <?php echo set_radio('status', 0); ?> id="customCheck2" 
                                                   <?php if ($form_details->status == '0') echo 'checked="checked"'; ?> >
                                            <label for="customCheck2">Inactive</label>
                                        </div>
                                    </div>
                                </div>
                            </div>                           
                        </div>




                        <div class="form-group">
                            <div class="col-md-12 text-left">
                                <input type="submit" name="submit" value="Apply" class="btn btn-info pull-right">
                                <input type="submit" name="close" value="Save & Close" class="btn btn-info pull-right"> 
                                <a href="<?php echo base_url('admin/ads'); ?>" class="btn btn-info pull-right"> Cancel </a>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!--/.col (left) -->           
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Modal -->
<div id="confirm-delete" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Delete</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Are you sure want to delete?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="<?= base_url() ?>public/plugins/select2/select2.css">
<script src="<?= base_url() ?>public/plugins/select2/select2.js"></script>
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
<script language="javascript">
   $(document).ready(function () {
            $("#page_slug").select2({
                placeholder : 'Select Page Name',
                allowClear : true,
            });
            });

     function deletImage(obj) {
        img = obj.attr('data-img');
        id = obj.attr('data-id');
        if (confirm("Are you sure you want to delete this Image?")) {
            $.ajax({
                data: {img_lng: img, id: id, 'csrf_test_name': $("input[name=csrf_test_name]").val()},
                type: 'post',
                url: '<?php echo base_url(); ?>admin/ads/DeleteImage',
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

    $('#confirm-delete').on('show.bs.modal', function (e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    });

    $(document).on('click', '.delete-href', function (event) {
        var records_to_del = [];
        $("input[name='ids[]']:checked").each(function () {
            records_to_del.push($(this).val());
        });

        if (records_to_del.length == 0) {
            alert('Please select any one row!');
        } else {
            $('#confirm-delete').modal('show');
        }
    });

</script>

<script>
 // validate file type
<?php foreach ($langArr as $key => $val) { ?>
$("#banner_img_<?php echo $key; ?>").change(function () {
    document.getElementById("file_message_<?php echo $key; ?>").innerHTML=''
    var fileUpload = $("#banner_img_<?php echo $key; ?>")[0];
    // alert(JSON.stringify(fileUpload));
    var ext = this.value.match(/\.(.+)$/)[1];
    switch (ext) {

        case 'jpg':
        case 'jpeg':
        case 'png':
        case 'PNG':
        case 'gif':   
        break;
        default:
        document.getElementById("file_message_<?php echo $key; ?>").innerHTML='Please Select Proper Image Type(jpg,jpeg,png,PNG,gif)'
        this.value = '';
    }

});

//vlidate dimension of file
$(function () {
   $("#banner_img_<?php echo $key; ?>").change(function () {
        //Get reference of FileUpload.

        var fileUpload = $("#banner_img_<?php echo $key; ?>")[0];

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
                        if (height > 348 || width > 320) {
                             document.getElementById("file_message_<?php echo $key; ?>").innerHTML='Please Select Proper Size'
                            fileUpload.value = '';
                            
                        }
                        
                    };
                }
           
        
    });
});
<?php } ?>
</script>