<!-- <script src="<?php echo base_url() ?>public/plugins/ckeditor_new/ckeditor.js"></script>
 -->
<div class="content-wrapper">
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>  Homepage slider data</h1>
            </div>
            <div class="col-sm-6">
                <div class="breadcrumb float-sm-right">
                    <a href="<?= base_url('admin/homepage_slider'); ?>" class="btn btn-success"><i class="fa fa-list"></i> List of Slider</a>
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
                        <h3 class="card-title"><?php echo isset($id) ? 'Edit' : 'Add'; ?> Homepage slider data</h3>
                    </div>
                    <div class="card-body">
                        <?php
                        if (!empty($this->session->flashdata('message'))) {
                            echo $this->session->flashdata('message');
                        }
                        ?>
                        <?php
                        if (!isset($id) && empty($id)) {
                            echo form_open_multipart(base_url('admin/homepage_slider/add_homepage_slider'), 'class="form-horizontal" id="upload_form" method="post"');
                        } else {
                            echo form_open_multipart(base_url('admin/homepage_slider/edit_slider/' . $id), 'class="form-horizontal" id="upload_form" method="post"');
                        }
                        ?>
                        <?php
                        $langArr = langArr();
                        foreach ($langArr as $key => $val) {
                            $compulsory = "";
                            //if ($key == 'en') {
                                $compulsory = "<span class='text-danger'>*</span>";
                           // }
                            ?>
                            <div class="form-group">
                                <?php echo form_label('Title <small style="color: blue; font-weight: bold;"><i> ['. $val.']</i></small>'.$compulsory . ' <small style="color: blue; font-weight: bold;"></small>', 'title_' . $key, array('class' => 'col-sm-12 control-label')); ?>

                                <div class="col-sm-9">
                                    <?php
                                    if (isset($sliderdata) && !empty($sliderdata)) {
                                        $title = $sliderdata[0]['title_' . $key];
                                    } else if (isset($_POST['title_' . $key]) && !empty($_POST['title_' . $key])) {
                                        $title = $_POST['title_' . $key];
                                    } else {
                                        $title = "";
                                    }
                                    $input_attr = array(
                                        'name' => 'title_' . $key,
                                        'id' => 'title_' . $key,
                                        'class' => 'form-control',
                                        'onInput' => 'edValueKeyPress()',
                                        'autocomplete' => 'off',
                                        'placeholder' => 'Title',
                                        'value' => $title,
                                    );
                                    echo form_input($input_attr);
                                    ?>                                    
                                </div>
                            </div>
                        <?php } ?>
                      
                          <?php
                        $langArr = langArr();
                        foreach ($langArr as $key => $val) {
                            $compulsory = "";
                            if ($key == 'en') {
                                $compulsory = "<span class='text-danger'>*</span>";
                            }
                            ?>
                            <div class="form-group">
                                <?php echo form_label('Title Heading <small style="color: blue; font-weight: bold;"><i> ['. $val.']</i></small>'.$compulsory . ' <small style="color: blue; font-weight: bold;"></small>', 'title_heading' . $key, array('class' => 'col-sm-12 control-label')); ?>

                                <div class="col-sm-9">
                                    <?php
                                    if (isset($sliderdata) && !empty($sliderdata)) {
                                        $title_heading = $sliderdata[0]['title_heading_' . $key];
                                    } else if (isset($_POST['title_heading_' . $key]) && !empty($_POST['title_heading_' . $key])) {
                                        $title_heading = $_POST['title_heading_' . $key];
                                    } else {
                                        $title_heading = "";
                                    }
                                    $input_attr = array(
                                        'name' => 'title_heading_' . $key,
                                        'id' => 'title_heading_' . $key,
                                        'class' => 'form-control',
                                        'onInput' => 'edValueKeyPress()',
                                        'autocomplete' => 'off',
                                        'placeholder' => 'Title Heading',
                                        'value' => $title_heading,
                                    );
                                    echo form_input($input_attr);
                                    ?>                                    
                                </div>
                            </div>
                        <?php } ?>
                      
                        
                        
                        <?php
                        foreach ($langArr as $key => $val) {
                            $compulsory = "";
                            if ($key == 'en') {
                                $compulsory = "<span class='text-danger'>*</span>";
                            }
                            $SubTitle = "";
                            if (isset($sliderdata) && !empty($sliderdata)) {
                                $SubTitle = $sliderdata[0]['sub_title_' . $key];
                            } else if (isset($_POST['sub_title_' . $key]) && !empty($_POST['sub_title_' . $key])) {
                                $SubTitle = $_POST['sub_title_' . $key];
                            }
                            ?> 
                            <div class="form-group" >
                                <label for="sub_title_<?php echo $key; ?>" class="col-sm-12 control-label">SubTitle <small style="color: blue; font-weight: bold;"><i>[<?= $val; ?>]</i></small><?php echo $compulsory; ?> <small style="color: blue; font-weight: bold;"></small></label> 
                                <div class="col-sm-9">
                                    <textarea class="textarea" id="sub_title_<?php echo $key; ?>" name="sub_title_<?php echo $key; ?>" rows="2" >
                                        <?php echo $SubTitle; ?>
                                    </textarea> 
                                </div>
                            </div>
                        <?php } ?>

                         
                        <div class="form-group">
                            <label for="file_type" class="col-sm-2 control-label"> File Type</label>
                            <div class="col-sm-9">
                                <select name="file_type" id="file_type" class="form-control js-example-basic-single">                                
                                    <option value=""> Select File type </option>
                                    <option value="1" <?php
                                    if (isset($sliderdata) && !empty($sliderdata)) {
                                        if ($sliderdata[0]['file_type'] == 1) {
                                            echo "selected";
                                        }
                                    } else if (isset($_POST['file_type']) && $_POST['file_type'] == 1) {
                                        echo "selected";
                                    }
                                    ?>> Image </option>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="file" class="col-sm-2 control-label">File <span class="text-danger">*</span> </label>
                            <div class="col-sm-7">
                                <input type="file" name="file" id="file" class="form-control">
                                <span id="file-empty-error" style="display: none;" class="error"> Please select file</span>
                                <span style="color:blue;display:none;" id="imagecls" class="imagecls"><i><b>Note:</b> Recommended Image size: <b>1351 X 574</b></i></span>
                            </div>                        
                        </div>
                        <?php
                        if (isset($sliderdata) && !empty($sliderdata) && !empty($sliderdata[0]['file_name'])) {
                             $file_name_view = basename($sliderdata[0]['file_name']);
                             $image_path = getImagePath() . 'assets/uploads/homepage_slider/thumb/' . $file_name_view;
                                             
                            ?>
                            <div class="form-group">
                                <label for="video" class="col-sm-2 control-label"> </label>
                                <div class="col-sm-9">
                                    <h3 id="status">
                                        <input type="hidden" name="old_file" value="<?php echo $image_path; ?>">
                                        <?php if ($sliderdata[0]['file_type'] == 2) { ?>                                        
                                            <video width="540" height="310" controls autoplay>
                                                <source src="<?php echo getImagePath() . $sliderdata[0]['file_name']; ?>" type="video/mp4">
                                            </video>
                                        <?php } ?>
                                        <?php if ($sliderdata[0]['file_type'] == 1) { ?>

                                            <img src="<?php echo $image_path; ?>"  style="width: 300px;height: 200px;" alt=""/>
                                        <?php } ?>
                                    </h3>
                                    <p id="loaded_n_total"></p>
                                </div>
                            </div>
                        <?php } ?>
						
                        <div class="row">		
                        <div class="form-group">
                            <label for="interval" class="col-sm-6 control-label">Slide interval <span class="text-danger">*</span> </label>

                            <div class="col-sm-12">
                                <?php
                                if (isset($sliderdata) && !empty($sliderdata)) {
                                    $interval = $sliderdata[0]['slide_interval'];
                                } else if (isset($_POST['interval']) && !empty($_POST['interval'])) {
                                    $interval = $_POST['interval'];
                                } else {
                                    $interval = "";
                                }
                                $product_title_en = array(
                                    'type' => 'number',
                                    'name' => 'interval',
                                    'id' => 'interval',
                                    'class' => 'form-control',
                                    'placeholder' => 'Slide interval',
                                    'value' => $interval,
                                );
                                echo form_input($product_title_en);
                                ?>
                                <span style="color:blue;"><i><b>Note:</b> Add slide interval in second i.e. 10</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="slide_order" class="col-sm-6 control-label">Slide Order <span class="text-danger">*</span> </label>

                            <div class="col-sm-12">
                                <?php
                                if (isset($sliderdata) && !empty($sliderdata)) {
                                    $slide_order = $sliderdata[0]['slide_order'];
                                } else if (isset($_POST['slide_order']) && !empty($_POST['slide_order'])) {
                                    $slide_order = $_POST['slide_order'];
                                } else {
                                    $slide_order = "";
                                }
                                $order = array(
                                    'type' => 'number',
                                    'name' => 'slide_order',
                                    'id' => 'slide_order',
                                    'class' => 'form-control',
                                    'placeholder' => 'Slide Order',
                                    'value' => $slide_order,
                                );
                                echo form_input($order);
                                ?>
                                <span style="color:blue;"><i><b>Note:</b> Add slide order i.e. 1 or 2 or 3 etc...</span>
                            </div>
                        </div>
                        </div>
                        <?php
                            foreach ($langArr as $key => $val) { 

                                ?> 
                            <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label for="link" class="col-sm-6 control-label">Button Link &nbsp;<small style="color: blue; font-weight: bold;"><i>[<?= $val; ?>]:</i></small></label>
                                        <div class="col-sm-6">
                                            <?php

                                            if (isset($sliderdata) && !empty($sliderdata)) {
                                                $link = unserialize($sliderdata[0]['link']);
                                                $link = isset($link[$key])?$link[$key]:'';
                                             
                                            } else if (isset($_POST['link_' . $key]) && !empty($_POST['link_' . $key])) {
                                                $link = $_POST['link_' . $key];
                                            } else {
                                                $link = "";
                                            }
     
                                            $order = array(
                                                'type' => 'text',
                                                'name' => 'link_'.$key,
                                                'id' => 'btn_link',
                                                'class' => 'form-control',
                                                'placeholder' => 'Button Link',
                                                'value' => $link,
                                            );
                                            echo form_input($order);
                                            ?>

                                        </div>
                                    </div>	
                                     <div class="form-group col-sm-6"  id="slider_label_div" >
                                        <label for="label" class="col-sm-6 control-label">Button Label &nbsp;<small style="color: blue; font-weight: bold;"><i>[<?= $val; ?>]:</i></small></label>
                                        <div class="col-sm-6">
                                            <?php
                            
                                              if (isset($sliderdata) && !empty($sliderdata)) {
                                            
                                       
                                                $label = @unserialize($sliderdata[0]['label']);
                                                if($label==true){
                                                     $label = isset($label[$key])?$label[$key]:'';
                                                }else{
                                                    $label='';
                                                }    
                                            } else if (isset($_POST['label_' . $key]) && !empty($_POST['label_' . $key])) {
                                                $label = $_POST['label_' . $key];
                                            } else {
                                                $label = "";
                                            }
                                            $order = array(
                                                'type' => 'text',
                                                'name' => 'label_'.$key,
                                                'id' => 'slider_label',
                                                'class' => 'form-control',
                                                'placeholder' => 'Button Label',
                                                'value' => $label,
                                            );
                                            echo form_input($order);
                                            ?>

                                        </div>
                                    </div>
                            </div>
                        <?php
                            }
                        ?>
                        <!-- <div class="form-group">
                            <label for="status" class="col-sm-2 control-label"> Status <span class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                <select name="status" id="status" class="form-control js-example-basic-single" required="">
                                    <?php
                                    $selected = $selected1 = '';
                                    if (isset($sliderdata) && $sliderdata[0]['status'] == '1') {
                                        $selected = 'selected';
                                    } else if (isset($sliderdata) && $sliderdata[0]['status'] == '0') {
                                        $selected1 = 'selected';
                                    } else if (isset($_POST['status']) && $_POST['status'] == '0') {
                                        $selected1 = 'selected';
                                    } else {
                                        $selected = 'selected';
                                    }
                                    ?>
                                    <option value="1" <?php echo $selected; ?>> Active </option>
                                    <option value="0" <?php echo $selected1; ?>> Inactive </option>

                                </select>
                            </div>
                        </div> -->

                        <div class="form-group">
                            <div class="col-md-11">
                                <input type="submit" name="submit" value="Apply" class="btn btn-info pull-right">
								<input type="submit" name="saveclose" value="Save and Close" class="btn btn-info pull-right">
                                <a href="<?php echo base_url('admin/homepage_slider'); ?>" class="btn btn-info pull-right"> Cancel </a>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!--/.col (left) -->           
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
</div>


<link rel="stylesheet" href="<?= base_url('public/plugins/select2/select2.css') ?>">
<script type="text/javascript" src="<?= base_url('public/plugins/select2/select2.js'); ?>"></script> -->
<script type="text/javascript">
    // In your Javascript (external .js resource or <script> tag)
    $(document).ready(function () {
        $('.js-example-basic-single').select2();
        <?php foreach ($langArr as $key => $val) { ?>

            get_editor('sub_title_<?php echo $key; ?>');

<?php } ?>
    });
    $(document).ready(function () {
		if ($("#file_type").val() == 1) {
			$('.imagecls').show();
		}
        $("#file_type").on('change', function () {
            $('#imagecls').hide();
            if ($(this).val() == 1) {
                $('.imagecls').show();
            }

        });
    });

    // var btn_link = $('#btn_link').val();
    // if (btn_link == '') {
    //     $("#slider_label_div").hide();
    // } else {
    //     $("#slider_label_div").show();
    // }

    // $("#btn_link").keypress(function(){
    //   $("#slider_label_div").show();
    // });


    <?php if(isset($_POST['link']) && $_POST['link']!=''){ ?>
        $("#slider_label_div").css('display','block');
    <?php } else if(isset($_POST['link']) && $_POST['link']=='') {?>
        $("#slider_label_div").css('display','none');
    <?php } ?>



</script>
   