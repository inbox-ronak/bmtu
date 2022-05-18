<!-- <link rel="stylesheet" href="<?= base_url() ?>public/dist/css/croppie.css">

<script src="<?php echo base_url() ?>public/plugins/ckeditor_new/ckeditor.js"></script>
<script src="<?php echo base_url() ?>public/dist/js/jquery.validate.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
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
            <div class="col-md-12">
                <?php echo form_open(base_url('admin/pages/edit/' . $page['page_id']), 'class="form-horizontal" enctype="multipart/form-data"') ?>
                <div class="card card-primary">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-9">
                                <h3 class="card-title">Edit Page</h3>
                            </div>
                           
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if (isset($msg) || validation_errors() !== ''){ ?>
                            <div class="alert alert-warning alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                                <?= validation_errors(); ?>
                                <?= isset($msg) ? $msg : ''; ?>
                            </div>
                        <?php } ?>
                        <input type="hidden" id="page_id" name="page_id" value="<?= $page['page_id']; ?>">   
                        <div class="form-group">
                                <?php echo form_label('CMS Page ? ', 'cms_page', array('class' => 'col-sm-2 control-label')); ?>
                                <div class="col-sm-9">                                
                                    <div class="icheck-primary d-inline">
                                        <input type="radio" name="cms_page" value="1" id="customCheck1" <?php if ($page['cms_page'] == '1') echo 'checked="checked"'; ?>   checked>
                                        <label for="customCheck1">YES</label>
                                    </div>
                                    <div class="icheck-primary d-inline p-3">
                                        <input type="radio" name="cms_page" value="0" id="customCheck2" <?php if ($page['cms_page'] == '0') echo 'checked="checked"'; ?> > 
                                        <label for="customCheck2">No</label>
                                    </div>
                                </div>
                            </div>        
                        <?php
                        $langArr = langArr();
                        foreach ($langArr as $key => $val) {
                            $compulsory = "";                          
                            $compulsory = "<span class='text-danger'>*</span>";
                            ?>
                            <div class="form-group">
                                <label for="page_name_<?= $key; ?>" class="col-sm-2 control-label">Page Name <small style="color: blue; font-weight: bold;"><i>[<?= $val; ?>]</i></small> <?= $compulsory;?> </label>
                                <div class="col-sm-9">
                                    <input type="text" name="page_name_<?= $key; ?>" id="page_name_<?= $key; ?>" class="form-control" onInput="edValueKeyPress()" autocomplete="off" placeholder="Page Name" value="<?= $page['page_name_' . $key] ?>">
                                   
                                </div>
                            </div>
                        <?php } ?>
                        <div class="form-group">
                            <label for="Title" class="col-sm-2 control-label">Page Slug <span class="text-danger">*</span> </label>
                            <div class="col-sm-9">
                                <input type="text" name="identifier" id="identifier" class="form-control" placeholder="Page Slug" value="<?= $page['page_slug']?>" readonly>
								<span style="color:blue;" ><i><b>Note:</b> It will be automatically generated</i></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="meta_title" class="col-sm-2 control-label">Meta Title </label>
                            <div class="col-sm-9">
                                <input type="text" name="meta_title" id="meta_title" class="form-control" placeholder="Meta Title" autocomplete="off" value="<?= (isset($page['meta_title'])) ? $page['meta_title'] : ''?>">
                                <div class="row">
                                    <div class="col-sm-11">
                                        <input type="hidden" name='metval' id='metval' class="metaval" readonly value="">
                                        <label> characters Most search engines use a maximum of 60 characters for the title.</label>
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
                                <textarea id="meta_desc" class=" form-control meta_desc" name="meta_desc"   ><?= $page['meta_desc']; ?></textarea> 
                                <div class="row">
                                    <div class="col-sm-11">
                                        <input type="hidden" name='metaDescVal' id='metaDescVal'  class="metaDescVal" readonly value="">
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
                                <input type="text" name="meta_key" id="meta_key" class="form-control" placeholder="Meta Keywords" autocomplete="off" value="<?= (isset($page['meta_key'])) ? $page['meta_key'] : '' ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="url_type" class="col-sm-2 control-label">Page URL </label> 
                            <div class="col-sm-9">
                                <select  class="form-control select2 js-example-basic-single"  id="type" name="url_type">
                                    <option value="internal" <?= ($page['url_type'] == 'internal') ? ' selected="selected"' : '' ?>>Internal Link</option>
                                    <option value="customized" <?= ($page['url_type'] == 'customized') ? ' selected="selected"' : '' ?>>Customized Link</option> 
                                </select>
                            </div>
                        </div> 
                        <div class="form-group" id="url" style="display:none;">
                            <label for="url" class="col-sm-2 control-label">URL <span class="text-danger">*</span> </label> 
                            <div class="col-sm-9">
                                <input type="text" name="url" class="form-control"  placeholder="" value="<?php echo isset($page['page_url']) ? $page['page_url'] : ''; ?>">
                            </div>
                        </div>
                        <?php
                        $langArr = langArr();
                       
                        foreach ($langArr as $key => $val) {

                            $pageContentArr = unserialize($page['page_content']);
                        $pagecontentdesc = '';
                        if (isset($pageContentArr['page_desc'][$key])) {
                          $pagecontentdesc = base64_decode($pageContentArr['page_desc'][$key]);
                           $pagecontentdesc = trim($pagecontentdesc);
                        }

                            $compulsory = "";
                                $compulsory = "<span class='text-danger'>*</span>";
                             ?>
                            <div class="form-group" >
                                <label for="page_content_<?php echo $key; ?>" class="col-sm-2 control-label">Content <small style="color: blue; font-weight: bold;"><i>[<?= $val; ?>]</i></small> <small style="color: blue; font-weight: bold;"></small></label> 
                                <div class="col-sm-9">
                                    <textarea class="summernote" id="page_content_<?php echo $key; ?>" name="page_content_<?php echo $key; ?>" rows="2" ><?= $pagecontentdesc; ?></textarea> 
                                </div>
                            </div>
                        <?php } ?>    
                       
                       
                              
                        
                        <div class="form-group" style="display: none">
                            <label for="page_image" class="col-sm-2 control-label">Page Banner <small style="color: blue; font-weight: bold;"></small></label>

                            <div class="col-sm-9">
                                <input type="file" name="page_image" id="event_image" class="form-control" accept="image/*">
                                <input type="hidden" name="hidden_page_image" class="form-control hidden_page_image_en" value="<?php echo $page['page_image']; ?>">
                                <!-- <span style="color:blue;"><i><b>Note:</b> Recommended Image size: <b>170 x 170</b></i></span> -->                            
                                <div class="col-md-12" id="uploaded_img" style=" margin-top:10px; ">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-6 upload_img_en" id="upload_img_div">
                                        <span class="single-image-wrap">
                                            <?php
                                            if ($page['page_image'] != '') {
                                                echo '<img src="' . getImagePath().'assets/' . $page['page_image'] . '" class="uploaded-images" alt="" style="width: 200px;height: 200px;">'
												. '<span class="delImg" data-id="' . $page['page_id'] . '" data-img="en"  onclick="deleteImage($(this))">X</span>';
                                            }
                                            ?>
                                        </span>
                                    </div>
                                    <div class="col-md-3"></div>
                                </div>
                                <span style="color:blue;" ><i><b>Note:</b> Recommended Image size: <b>1500 X 348</b></i></span>
                            </div>

                        </div>
						
                        <div class="form-group" style="display: none">
                            <label for="page_pdf" class="col-sm-12 control-label">Associated PDF <small style="color: blue; font-weight: bold;"></small></label>

                            <div class="col-sm-9">
                                <input type="file" accept="application/pdf" name="page_pdf" id="page_pdf" class="form-control">
                                <input type="hidden"  name="hidden_page_pdf" class="form-control hidden_page_pdf_en" value="<?php echo $page['page_pdf']; ?>">
                            </div>                        
                            <div class="col-md-12" id="uploaded_img" style=" margin-top:10px; ">
                                <div class="col-md-3"></div>
                                <div class="col-md-6 upload_img_div_en" id="upload_img_div_en">
                                    <span class="single-image-wrap">
                                            <?php
                                            if ($page['page_pdf'] != '') {
                                                echo '<a href="' . base_url() . $page['page_pdf'] . '" class="uploaded-images" style="width: 200px;height: 200px;" target="_blank"><i class="fa fa-file-pdf-o" style="font-size:48px;color:red"></i></a>'
												. '<span class="delImg" data-id="' . $page['page_id'] . '" data-img="en"  onclick="deletePdf($(this))">X</span>';
                                            }
                                            ?>
                                        </span>
                                </div>
                                <div class="col-md-3"></div>
                            </div>
                        </div>
						<?php
                                    $langArr = langArr();
                                    $image = unserialize($page['banner_image']);
                                    $i = 0;
                                    foreach ($langArr as $key => $val) {


                                        $compulsory = "";                                       
                                        $compulsory = "<span class='text-danger'>*</span>";

                                         ?>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php echo form_label('Pages Image <small style="color: blue; font-weight: bold;"><i> ['. $val.']</i></small><small style="color: blue; font-weight: bold;"></small>', 'banner_img_' . $key, array('class' => 'col-sm-12 control-label')); ?>
                                                <div class="col-sm-12">
                                                    <input type="file" name="banner_img_<?php echo $key; ?>" id="banner_img_<?php echo $key; ?>">
                                                    <span class="text-danger"><p id="file_message_<?php echo $key; ?>"></p></span>
                                                </div>
                                                <div class="col-md-12 uploaded_img_<?php echo $key; ?>" id="uploaded_img<?php echo $i; ?>" style=" margin-top:10px; ">
                                                    <div class="col-md-3"></div>
                                                    <span style="color:blue;" ><i><b>Note:</b> Recommended Image size: 1903 X 250 </i></span>
                                                    <div class="col-md-6 upload_img_div upload_img_div_<?php echo $key; ?>" id="upload_img_div">                                
                                                        <span class="single-image-wrap">
                                                            <?php
                                                            if (isset($image[$key]) && $image[$key]['image'] != '') {

                                                                $file_name_view = basename($image[$key]['image']);
                                                                $image_path = getImagePath() . 'assets/uploads/pages/thumb/' . $file_name_view;

                                                                echo '<img src="' . $image_path. '" class="uploaded-images" style="width: 200px;height: 200px;">'
                                                                . '<span class="delImg" data-id="' . $page['page_id'] . '" data-img="' . $key . '"  onclick="deletImage($(this))" style="cursor:pointer">X</span>';
                                                            }


                                                         

                                                             ?>
                                                            <input type="hidden" id="banner_uploaded_img_<?php echo $key; ?>" name="banner_uploaded_img_<?php echo $key; ?>" value="<?php echo isset($image[$key]['image']) ? $image[$key]['image'] : ''; ?>">
                                                        </span>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <?php 
                                        $i++;
                                    }
                                     ?>
                                
                           

                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="submit" name="submit" value="Apply" class="btn btn-info pull-left">
								<input type="submit" name="saveclose" value="Save and Close" class="ml-2 btn btn-info pull-left">
                                <a href="<?=base_url().'admin/pages';?>" style="padding: 7px;">
                                    <input type="button" name="submit" value="Cancel" class="btn btn-info pull-next"></a>
                            </div>
                        </div>
                    </div>

                </div>
                <?php echo form_close(); ?>
                <!-- /.card -->
            </div>
            <!--/.col (left) -->
            <!-- right column -->
            <div class="col-md-6">

            </div>
            <!--/.col (right) -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
</div>


<script type="text/javascript">
    var getType = $('#type').val();
    if (getType == 'customized') {
        $("#url").show();
    } else {
        $("#url").hide();
    }

    $('#type').change(function () {
        var type = $('#type').val();
        if (type == 'customized') {
            $("#url").show();
        } else {
            $("#url").hide();
        }
    });
	function deletePdf(obj) {
        img = obj.attr('data-img');
        id = obj.attr('data-id');
        if (confirm("Are you sure you want to delete this Pdf?")) {
//            id = $('#id').val();
            $.ajax({
                data: {img_lng: img, id: id, 'csrf_test_name': $("input[name=csrf_test_name]").val()},
                type: 'post',
                url: '<?php echo base_url(); ?>admin/pages/DeletePdf',
                async: true,
                success: function (output) {
                    $(".upload_img_div_" + img).html('');
                    $(".hidden_page_pdf_" + img).val('');
                    $('.flash-msg').html('Pdf deleted Successfully!');
                }
            });
        } else {
            return false;
        }
    }
    // In edit mode unlink image and delete image here
    function deletImage(obj) {
        img = obj.attr('data-img');
        id = obj.attr('data-id');
        if (confirm("Are you sure you want to delete this Image?")) {
            $.ajax({
                data: {img_lng: img, id: id, 'csrf_test_name': $("input[name=csrf_test_name]").val()},
                type: 'post',
                url: '<?php echo base_url(); ?>admin/pages/DeleteImage',
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

<script language="javascript">
    $(document).ready(function () {
        $(document).keypress(function (event) {
            $("input[name='page_name_en']").keyup(function () {
                $("input[name='identifier']").val($(this).val().replace(/[^a-z0-9\s]/gi, '').replace(/\s\s+/g, '-').replace(/[_\s]/g, '-').toLowerCase());
            }).keyup();

            $('#identifier').keyup(function () {
                this.value = this.value.replace(/[^a-z0-9\s]/gi, '-').replace(/\s\s+/g, '-').replace(/[_\s]/g, '-').toLowerCase();
            });
        });
    });
</script>
<link rel="stylesheet" href="<?= base_url('public/plugins/select2/select2.css') ?>">
<script type="text/javascript" src="<?= base_url('public/plugins/select2/select2.js'); ?>"></script>
<script type="text/javascript">
    // In your Javascript (external .js resource or <script> tag)
    $(document).ready(function () {
        //$('.js-example-basic-single').select2();
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
 

                        if (height >= 250 && width >= 1903) {
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