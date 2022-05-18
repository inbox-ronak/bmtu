<!-- <link rel="stylesheet" href="<?= base_url() ?>public/dist/css/croppie.css">

<script src="<?php echo base_url() ?>public/plugins/ckeditor_new/ckeditor.js"></script>
<script src="<?php echo base_url() ?>public/dist/js/jquery.validate.min.js"></script>
<script src="<?php echo base_url() ?>public/dist/js/additional-methods.min.js"></script> -->
<style>
    .red{color:red;}
    .green{color:green;}
</style>
<div class="content-wrapper">
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Pages</h1>
            </div>
            <div class="col-sm-6">
                <div class="breadcrumb float-sm-right">
                    <a href="<?= base_url('admin/pages'); ?>" class="btn btn-success"><i class="fa fa-list"></i> Pages List</a>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <?php echo form_open(base_url('admin/pages/add'), 'class="form-horizontal" enctype="multipart/form-data"'); ?> 
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-9">
                                <h3 class="card-title">Add Page</h3>
                            </div>
                           
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if (isset($msg) || validation_errors() !== ''){ ?>
                            <div class="alert alert-warning alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
                                <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                                <?= validation_errors(); ?>
                                <?= isset($msg) ? $msg : ''; ?>
                            </div>
                        <?php } ?>
                        <div class="form-group">
                                <?php echo form_label('CMS Page ? ', 'cms_page', array('class' => 'col-sm-2 control-label')); ?>
                                <div class="col-sm-9">                                
                                    <div class="icheck-primary d-inline">
                                        <input type="radio" name="cms_page" value="1" id="customCheck1" <?php if (isset($_POST['cms_page']) == '1') echo 'checked="checked"'; ?>   checked>
                                        <label for="customCheck1">YES</label>
                                    </div>
                                    <div class="icheck-primary d-inline p-3">
                                        <input type="radio" name="cms_page" value="0" id="customCheck2" <?php if (isset($_POST['cms_page']) == '0') echo 'checked="checked"'; ?> > 
                                        <label for="customCheck2">No</label>
                                    </div>
                                </div>
                            </div>
                        <?php $langArr = langArr();
                        foreach ($langArr as $key => $val) {
                            $compulsory = "";
                            $compulsory = "<span class='text-danger'>*</span>";
                             ?>
                            <div class="form-group">
                                <label for="page_name_<?= $key; ?>" class="col-sm-2 control-label">Page Name <small style="color: blue; font-weight: bold;"><i>[<?= $val; ?>]</i></small><?= $compulsory;?> </label>
                                <div class="col-sm-9">
                                    <input type="text" name="page_name_<?= $key; ?>" id="page_name_<?= $key; ?>" class="form-control" onInput="edValueKeyPress()" autocomplete="off" placeholder="Page Name " value="<?= isset($_POST['page_name_' . $key]) ? $_POST['page_name_' . $key] : '' ?>">
                                   
                                </div>
                            </div>
                        <?php } ?>
                        <div class="form-group">
                            <label for="identifier" class="col-sm-2 control-label">Page Slug <span class="text-danger">*</span> </label>
                            <div class="col-sm-9">
                                <input type="text" name="identifier" id="identifier" class="form-control" placeholder="Page Slug" value="<?php echo isset($_POST['identifier']) ? $_POST['identifier'] : '' ?>" readonly>
								<span style="color:blue;" ><i><b>Note:</b> It will be automatically generated</i></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="meta_title" class="col-sm-2 control-label">Meta Title </label>
                            <div class="col-sm-9">
                                <input type="text" name="meta_title" id="meta_title" class="form-control" placeholder="Meta Title" autocomplete="off" value="<?= isset($_POST['meta_title']) ? $_POST['meta_title'] : ''?>">
                                <div class="row">
                                    <div class="col-sm-11">
                                        <input type="hidden" name='metval' id='metval' class="metaval" readonly><label> characters Most search engines use a maximum of 60 characters for the title.</label>
                                    </div>
                                    <div class="col-sm-1 text-right">
                                        <span  class="metavalspan">0</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group" >
                            <label for="meta_desc" class="col-sm-2 control-label">Meta Description </label> 
                            <div class="col-sm-9">
                                <textarea id="meta_desc" class="form-control meta_desc" name="meta_desc"  ><?php echo (isset($_POST['meta_desc'])) ? $_POST['meta_desc'] : ''; ?></textarea> 
                                <div class="row">
                                    <div class="col-sm-11">
                                        <input type="hidden" name='metaDescVal' id='metaDescVal'  class="metaDescVal" readonly>
                                        <label> characters Most search engines use a maximum of 230-320 characters for the description.</label>
                                    </div>
                                    <div class="col-sm-1 text-right">
                                        <span class=" metaDescValspan">0</span>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="meta_key" class="col-sm-2 control-label">Meta Keywords </label>
                            <div class="col-sm-9">
                                <input type="text" name="meta_key" id="meta_key" class="form-control" placeholder="Meta Keywords" autocomplete="off" value="<?= isset($_POST['meta_key']) ? $_POST['meta_key'] : ''?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="target" class="col-sm-2 control-label">Page URL </label> 
                            <div class="col-sm-9">
                                <select class="form-control select2 js-example-basic-single" id="type" name="url_type">
                                    <option <?php if(isset($_POST['url_type']) && $_POST['url_type']=='internal'){ echo 'selected'; }; ?>  value="internal">Internal Link</option>
                                    <option <?php if(isset($_POST['url_type']) && $_POST['url_type']=='customized'){ echo 'selected'; }; ?> value="customized">Customized Link</option> 
                                </select>
                            </div>
                        </div>
                        <div class="form-group" id="url" style="display:none;">
                            <label for="url" class="col-sm-2 control-label">URL <span class="text-danger">*</span> </label> 
                            <div class="col-sm-9">
                                <input type="text" name="url" class="form-control"  placeholder="" value="<?php echo isset($_POST['url']) ? $_POST['url'] : ''; ?>">
                            </div>
                        </div>
                        <?php
                        $langArr = langArr();
                        foreach ($langArr as $key => $val) {
                            $compulsory = "";
                            $compulsory = "<span class='text-danger'>*</span>";
                            
                            ?>
                            <div class="form-group" >
                                <label for="page_sort_content_<?php echo $key; ?>" class="col-sm-2 control-label">Content  <small style="color: blue; font-weight: bold;"><i>[<?= $val; ?>]</i></small> <small style="color: blue; font-weight: bold;"></small></label> 
                                <div class="col-sm-9">
                                    <textarea class="summernote" name="page_content_<?php echo $key; ?>" rows="2" >
                                        <?php echo isset($_POST['page_content_' . $key]) ? $_POST['page_content_' . $key] : ''; ?>
                                    </textarea> 
                                </div>
                            </div>
                        <?php } ?>
                                <?php
                                    $langArr = langArr();
                                    $i = 0;
                                    foreach ($langArr as $key => $val) {


                                        $compulsory = "";                                       
                                        $compulsory = "<span class='text-danger'>*</span>";

                                         ?>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php echo form_label('Page Image <small style="color: blue; font-weight: bold;"><i> ['. $val.']</i></small><small style="color: blue; font-weight: bold;"></small>', 'banner_img_' . $key, array('class' => 'col-sm-12 control-label')); ?>
                                                <div class="col-sm-12">
                                                    <input type="file" name="banner_img_<?php echo $key; ?>" id="banner_img_<?php echo $key; ?>">
                                                    <span class="text-danger"><p id="file_message_<?php echo $key; ?>"></p></span>
                                                </div>
                                                <div class="col-md-12 uploaded_img_<?php echo $key; ?>" id="uploaded_img<?php echo $i; ?>" style=" margin-top:10px; ">
                                                    <div class="col-md-3"></div>
                                                    <span style="color:blue;" ><i><b>Note:</b> Recommended Image size: 1903 X 250 </i></span>
                                                    <div class="col-md-6 upload_img_div upload_img_div_<?php echo $key; ?>" id="upload_img_div">                                
                                         
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <?php 
                                        $i++;
                                    }
                                     ?>
                                
                        <div class="form-group" style="display: none">
                            <label for="page_image" class="col-sm-4 control-label">Page Banner <small style="color: blue; font-weight: bold;"></small></label>
                            <div class="col-sm-9">
                                <input type="file" name="page_image" id="event_image" class="form-control" accept="image/*" onchange="readURL(this);">
                            </div>                        
                            <span style="color:blue;" ><i><b>Note:</b> Recommended Image size: <b>1500 X 348</b></i></span>
                        </div>
                        <div class="form-group" style="display: none">
                            <label for="page_pdf" class="col-sm-12 control-label">Associated PDF <small style="color: blue; font-weight: bold;"></small></label>
                            <div class="col-sm-9">
                                <input type="file" accept="application/pdf" name="page_pdf" id="page_pdf" class="form-control">
                            </div>                        
                        </div>
                        <div class="form-group">
                            <div class="col-md-11">
                                <input type="submit" name="submit" value="Apply" class="btn btn-info pull-right">
								<input type="submit" name="saveclose" value="Save and Close" class="btn btn-info pull-right">
                                  <a href="<?=base_url().'admin/pages';?>"><input type="button" name="submit" value="Cancel" class="btn btn-info pull-right"></a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            <div class="col-md-6">
            </div>
        </div>
    </div>
</section>
</div>
<script type="text/javascript">
    <?php if(isset($_POST['url_type']) && $_POST['url_type']=='customized'){ ?>
        $("#url").css('display','block');
    <?php }else if(isset($_POST['url_type']) && $_POST['url_type']=='internal'){ ?>
        $("#url").css('display','none');
    <?php } ?>
    $('#type').change(function () {
        var type = $('#type').val();
        if (type == 'customized') {
            $("#url").show();
        } else {
            $("#url").hide();
        }
    });
    $(document).ready(function () {
        $("input[name='page_name_en']").keyup(function () {
            $("input[name='identifier']").val($(this).val().replace(/[^a-z0-9\s]/gi, '').replace(/\s\s+/g, '-').replace(/[_\s]/g, '-').toLowerCase());
        }).keyup();
        $('#identifier').keyup(function () {
            this.value = this.value.replace(/[^a-z0-9\s]/gi, '-').replace(/\s\s+/g, '-').replace(/[_\s]/g, '-').toLowerCase();
        });
    });
</script>

<!-- <link rel="stylesheet" href="<?= base_url('public/plugins/select2/select2.css') ?>">
<script type="text/javascript" src="<?= base_url('public/plugins/select2/select2.js'); ?>"></script> -->
<script type="text/javascript">
    $(document).ready(function () {
        $('#meta_title').on('keyup', function () {
            title = $(this).val().length;
            $('#metval').val(title);
            $('.metavalspan').text(title);
            
            if (title > '60') {
                $('.metavalspan').removeClass('green');
                $('.metavalspan').addClass('red');
            } else {
                $('.metavalspan').removeClass('red');
                $('.metavalspan').addClass('green');
            }
        });

        $('#meta_desc').on('keyup', function () {
            desc = $(this).val().length;
            $('#metaDescVal').val(desc);
            $('.metaDescValspan').text(desc);
            if (desc > 320) {
                $('.metaDescValspan').removeClass('green');
                $('.metaDescValspan').addClass('red');
            } else {
                $('.metaDescValspan').removeClass('red');
                $('.metaDescValspan').addClass('green');
            }
        });
        //$('.js-example-basic-single').select2();
        var langArr = <?php echo json_encode(langArr()); ?>;
        var websiteType = "<?php echo $websiteType; ?>";
        if (langArr != null) {
            $.each(langArr, function (key, value) {
                //get_editor('page_content_' + key);
                
            });
        }

    });
    
    // validate file type
<?php foreach ($langArr as $key => $val) { ?>
$("#banner_img_<?php echo $key; ?>").change(function () {
    document.getElementById("file_message_<?php echo $key; ?>").innerHTML=''
    var fileUpload = $("#banner_img_<?php echo $key; ?>")[0];
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
                        if (height >= 250 || width >= 1903) {
                            document.getElementById("file_message_<?php echo $key; ?>").innerHTML=''
                        }else{
                            document.getElementById("file_message_<?php echo $key; ?>").innerHTML='Please Select Proper Size'
                            fileUpload.value = '';
                            
                        }
                        
                    };
                }
           
        
    });
});
<?php } ?>
</script>