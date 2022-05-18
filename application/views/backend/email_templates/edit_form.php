<!-- <script src="<?php echo base_url() ?>public/dist/js/jquery.validate.min.js"></script><script src="<?php echo base_url() ?>public/plugins/ckeditor_new/ckeditor.js"></script><script src="<?php echo base_url() ?>public/dist/js/additional-methods.min.js"></script> --><div class="content-wrapper">    <section class="content-header">        <div class="container-fluid">            <div class="row mb-2">                <div class="col-sm-6">                    <h1>Edit Email Templates</h1>                </div>                <div class="col-sm-6">                    <div class="breadcrumb float-sm-right">                        <a href="<?= base_url('admin/email_templates'); ?>" class="btn btn-success"><i class="fa fa-list"></i> List of Email Templates</a>                    </div>                </div>            </div>        </div><!-- /.container-fluid -->    </section>                   <section class="content">        <div class="container-fluid">            <div class="row">                <div class="col-md-12">                    <div class="card">                        <div class="card-header">                            <h3 class="card-title">Edit Email Templates</h3>                        </div>                        <div class="card-body">                        <?php                        if (!empty($this->session->flashdata('message'))) {                            echo $this->session->flashdata('message');                        } ?>                        <?php echo form_open(base_url('admin/email_templates/edit_template'), 'class="form-horizontal" id="user_form" enctype="multipart/form-data" method="post"') ?>                         <input type="hidden" name="email_template_id" value="<?php echo $posts['email_template_id']; ?>">                        <div class="form-group">                            <label for="email_template_for" class="col-sm-2 control-label">Email For <span class="text-danger">*</span> </label>                            <div class="col-sm-9">                                <?php                                $email_template_for = array(                                    'type' => 'text',                                    'name' => 'email_template_for',                                    'id' => 'email_template_for',                                    'class' => 'form-control',                                    'placeholder' => 'Email Title',                                    'value' => (isset($posts['email_template_for'])) ? $posts['email_template_for'] : '',                                );                                echo form_input($email_template_for);                                ?>                            </div>                        </div>                        <?php                        $langArr = langArr();                        foreach ($langArr as $key => $val) {                            $compulsory = "";                            $compulsory = "<span class='text-danger'>*</span>";                             ?>                             <div class="form-group">                                <label for="email_template_subject_en" class="col-sm-2 control-label">Email Subject <small style="color: blue; font-weight: bold;"><i>[<?= $val; ?>]</i></small>  <?php echo $compulsory; ?> <small style="color: blue; font-weight: bold;"></small></label>                                <div class="col-sm-9">                                    <?php                                    $email_template_subject_en = array(                                        'type' => 'text',                                        'name' => 'email_template_subject_' . $key,                                        'id' => 'email_template_subject_' . $key,                                        'class' => 'form-control',                                         'placeholder' => 'Email Subject ['. $val.']',                                        'value' => (isset($posts['email_template_subject_' . $key])) ? $posts['email_template_subject_' . $key] : ''                                    );                                    echo form_input($email_template_subject_en); ?>                                </div>                            </div>                        <?php } ?>                        <?php                        $langArr = langArr();                        foreach ($langArr as $key => $val) {                            $compulsory = "";                                                   $compulsory = "<span class='text-danger'>*</span>";                             ?>                             <div class="form-group" >                                <label for="email_template_body_<?php echo $key; ?>" class="col-sm-2 control-label">Email Body <small style="color: blue; font-weight: bold;"><i>[<?= $val; ?>]</i></small> <?php echo $compulsory; ?> <small style="color: blue; font-weight: bold;"></small></label>                                 <div class="col-sm-9">                                    <textarea id="email_template_body_<?php echo $key; ?>" name="email_template_body_<?php echo $key; ?>" rows="2" >                                        <?php echo (isset($posts['email_template_body_' . $key])) ? base64_decode($posts['email_template_body_' . $key]) : ''; ?>                                    </textarea>                                 </div>                            </div>                        <?php } ?>                                                <div class="form-group">                            <div class="col-md-11">                                <input type="submit" name="submit" value="Apply" class="btn btn-info pull-right">                                <input type="submit" name="submit" value="Save & Close" class="btn btn-info pull-right">                                 <a href="<?=base_url().'admin/email_templates';?>"><input type="button" name="submit" value="Cancel" class="btn btn-info pull-right"></a>                            </div>                        </div>                        <?php echo form_close(); ?>                    </div>                    </div>                    <!-- /.card -->                </div>                <!--/.col (left) -->                <!--/.col (right) -->            </div>            <!-- /.row -->        </div><!-- /.container-fluid -->    </section></div><script type="text/javascript">    //$('.datepicker').datepicker({dateformat: 'dd-mm-yyyy', autoclose: true});    $(document).ready(function () {        <?php foreach ($langArr as $key => $val) { ?>            get_editor('email_template_body_<?php echo $key; ?>');         <?php } ?>        var $image_crop;        $image_crop = $('.upload-demo').croppie({            enableExif: true,            viewport: {                width: 1920,                height: 630,                type: 'square' //circle            },            boundary: {                width: 1050,                height: 500            },            showZoomer: true,            enableResize: true,            enableOrientation: true,        });        $(document).on('change', '.news_event_image', function (event) {            var reader = new FileReader();            reader.onload = function (event) {                $image_crop.croppie('bind', {                    url: event.target.result                }).then(function () {                    console.log('jQuery bind complete');                });            }            reader.readAsDataURL(this.files[0]);            $('.uploadimageModal').modal('show');        });        $(document).on('click', '.crop_images', function (event) {            var ext = $('#news_event_image').val().split('.').pop().toLowerCase();            if (ext == 'jpg' || ext == 'jpeg' || ext == 'png') {                $('.crop_popup_image').show();                $('#news_event_image').val('');                var cct = $("input[name=csrf_test_name]").val();                // console.log(cct);return false;                $image_crop.croppie('result', {                    type: 'canvas',                    size: {                        width: 1920,                        height: 630,                        type: 'square', //circle                        quality: 1                    }                }).then(function (response) {                    $.ajax({                        url: "<?= base_url('admin/news/add_crop_image'); ?>",                        type: "post",                        data: {"image": response, 'csrf_test_name': cct},                        // datatype:"json",                        success: function (data) {                            $('.crop_popup_image').hide();                            var result = JSON.parse(data);                            $('.uploadimageModal').modal('hide');                            $('#news_event_image_hidden').val(result.img_name);                            var image_url = '<img src="' + response + '"  style="margin:1%;width: 30%;"/>';                            $('#cover-uploaded-images').html(image_url);                        }                    });                });            } else {                alert('Only image type jpg / jpeg / png is allowed.');                $('.uploadimageModal').modal('hide');            }        });    });</script><!-- <link href="<?= base_url() ?>public/plugins/select2/select2.min.css" rel="stylesheet" /><script src="<?= base_url() ?>public/plugins/select2/select2.min.js"></script> --><script type="text/javascript">    // In your Javascript (external .js resource or <script> tag)    $(document).ready(function () {        $('.js-example-basic-single').select2();    });</script><div id="uploadimageModal" class="modal uploadimageModal " role="dialog" >    <div class="modal-dialog" style="width: 100%;">        <div class="modal-content ">            <div class="modal-header">                <button type="button" class="close" data-dismiss="modal">&times;</button>                <h4 class="modal-title">Upload & Crop Image</h4>            </div>            <div class="modal-body">                <div class="row">                    <div class="col-md-12 text-center">                        <div id="upload-demo" class="upload-demo"></div>                    </div>                </div>            </div>            <div class="modal-footer">                <button class="btn btn-success crop_images">Crop & Upload Image &nbsp;<i class="fa fa-spinner fa-spin fa-3x fa-fw crop_popup_image" style="font-size:18px; display: none;"></i></button>                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>            </div>        </div>    </div></div>