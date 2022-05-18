<script src="<?php echo base_url() ?>public/dist/js/jquery.validate.min.js"></script>
<script src="<?php echo base_url() ?>public/plugins/ckeditor_new/ckeditor.js"></script>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>  Homepage Block</h1>
            </div>
            <div class="col-sm-6">
                <div class="breadcrumb float-sm-right">
                    <a href="<?= base_url('admin/homepage_block'); ?>" class="btn btn-success"><i class="fa fa-list"></i> List of Block</a>
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
                <!-- jquery validation -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            <?php echo isset($id) ? 'Edit' : 'Add'; ?> Homepage Block
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->

                    <div class="card-body">
                        <?php if (!empty($this->session->flashdata('message'))) {
                            echo $this->session->flashdata('message');
                        }
                        if (!isset($id) && empty($id)) {
                            echo form_open_multipart(base_url('admin/homepage_block/add_homepage_block'), 'class="form-horizontal" id="upload_form" method="post"');
                        } else {
                            echo form_open_multipart(base_url('admin/homepage_block/edit_homepage_block/' . $id), 'class="form-horizontal" id="upload_form" method="post"');
                        }
                            $langArr = langArr();
                            foreach ($langArr as $key => $val) {
                                $compulsory = "";                               
                                $compulsory = "<span class='text-danger'>*</span>";
                                ?>
                                <div class="form-group">
                                    <label class="col-sm-12 control-label" for="block_title_<?=$key; ?>">Block Title <?= $compulsory; ?></label>
                                    <div class="col-sm-9">
                                        <?php if (isset($posts) && !empty($posts)) {
                                            $title = $posts['block_title_' . $key];
                                        } else if (isset($_POST['block_title_' . $key]) && !empty($_POST['block_title_' . $key])) {
                                            $title = $_POST['block_title_' . $key];
                                        } else {
                                            $title = "";
                                        } ?>
                                        <input type="text" name="block_title_<?=$key; ?>" id="block_title_<?=$key; ?>" class="form-control" onInput="edValueKeyPress()"  autocomplete="off" placeholder="Block Title" value="<?= $title?>">                            
                                    </div>
                                </div>
                            <?php } 
                            foreach ($langArr as $key => $val) {
                                $compulsory = "";                               
                                    $compulsory = "<span class='text-danger'>*</span>";
                                
                                if (isset($posts) && !empty($posts)) {
                                    $blockDesc = $posts['block_description_' . $key];
                                } else if (isset($_POST['block_description_' . $key]) && !empty($_POST['block_description_' . $key])) {
                                    $blockDesc = $_POST['block_description_' . $key];
                                } else {
                                    $blockDesc = "";
                                } ?> 
                                <div class="form-group" >
                                    <label for="block_description_<?php echo $key; ?>" class="col-sm-12 control-label">Block Description <?php echo $compulsory; ?> <small style="color: blue; font-weight: bold;"></small></label> 
                                    <div class="col-sm-9">
                                        <textarea class="textarea" id="block_description_<?php echo $key; ?>" name="block_description_<?php echo $key; ?>" rows="2" >
                                            <?php echo $blockDesc; ?>
                                        </textarea> 
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="form-group">
                                <label for="file" class="col-sm-2 control-label">File <span class="text-danger">*</span> </label>
                                <div class="col-sm-7">
                                    <input type="file" name="block_img" id="file" class="form-control">
                                    <span id="file-empty-error" style="display: none;" class="error"> Please select file</span>
                                   
                                    <span style="color:blue;" ><i><b>Note:</b> Recommended Image size: <b>400 * 385</b></i></span>
                                </div>                        
                            </div>
                            <?php if (isset($posts) && !empty($posts) && !empty($posts['image'])) { ?>
                                <div class="form-group">
                                    <label for="video" class="col-sm-2 control-label"> </label>
                                    <div class="col-sm-9">
                                        <h3 id="status">
                                            <input type="hidden" name="old_file" value="<?php echo $posts['image']; ?>">                                        
                                            <img src="<?php echo getImagePath() . $posts['image']; ?>" width="540" height="310" alt=""/>

                                        </h3>
                                        <p id="loaded_n_total"></p>
                                    </div>
                                </div>
                            <?php } 
                            if (isset($posts) && !empty($posts) && !empty($posts['image_fr'])) { ?>
                                <div class="form-group">
                                    <label for="video" class="col-sm-2 control-label"> </label>
                                    <div class="col-sm-9">
                                        <h3 id="status">
                                            <input type="hidden" name="old_file_fr" value="<?php echo $posts['image_fr']; ?>">                                        
                                            <img src="<?php echo getImagePath() . $posts['image_fr']; ?>" width="540" height="310" alt=""/>
                                        </h3>
                                        <p id="loaded_n_total"></p>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="form-group">
                                <label for="block_link" class="col-sm-2 control-label">Block Link</label>
                                <div class="col-sm-9">
                                    <?php if (isset($posts) && !empty($posts)) {
                                        $block_link = $posts['block_link'];
                                    } else if (isset($_POST['block_link']) && !empty($_POST['block_link'])) {
                                        $block_link = $_POST['block_link'];
                                    } else {
                                        $block_link = "";
                                    }?>
                                    <input type="text" name="block_link" id="block_link" class="form-control" placeholder="Block Link" value="<?= $block_link; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="block_order" class="col-sm-12 control-label">Block Order <span class="text-danger">*</span> </label>
                                        <div class="col-sm-9">
                                            <?php if (isset($posts) && !empty($posts)) {
                                                $block_order = $posts['block_order'];
                                            } else if (isset($_POST['block_order']) && !empty($_POST['block_order'])) {
                                                $block_order = $_POST['block_order'];
                                            } else {
                                                $block_order = "";
                                            } ?>
                                            <input type="number" name="block_link" id="block_link" class="form-control" placeholder="Block Order" value="<?= $block_link; ?>">
                                            <span style="color:blue;"><i><b>Note:</b> Add block order i.e. 1 or 2 or 3 etc...</i></span>
                                        </div>
                                    </div>                                
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="block_position" class="col-sm-12 control-label"> Block Image Position <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <select name="block_position" id="block_position" class="form-control js-example-basic-single" required="">
                                                <?php $selected = $selected1 = '';
                                                if (isset($posts) && $posts['block_position']) {
                                                    $selected = $posts['block_position'];
                                                } else if (isset($_POST['block_position']) && $_POST['block_position'] ) {
                                                    $selected = $_POST['block_position'];
                                                } else {
                                                    $selected = 'block_position_right';
                                                } ?>
                                                <option value="block_position_right" <?php if($selected=="block_position_right"){ ?>selected <?php } ?>> Right </option>
                                                <option value="block_position_left" <?php if($selected=="block_position_left"){ ?>selected <?php } ?>> Left </option>
                                            </select>
                                        </div>
                                    </div>                               
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="block_status" class="col-sm-12 control-label"> Block Status <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <select name="block_status" id="block_status" class="form-control js-example-basic-single" required="">
                                                <?php $selected = $selected1 = '';
                                                if (isset($posts) && $posts['block_status'] == '1') {
                                                    $selected = 'selected';
                                                } else if (isset($posts) && $posts['block_status'] == '0') {
                                                    $selected1 = 'selected';
                                                } else if (isset($_POST['block_status']) && $_POST['block_status'] == '0') {
                                                    $selected1 = 'selected';
                                                } else {
                                                    $selected = 'selected';
                                                } ?>
                                                <option value="1" <?php echo $selected;?>> Active </option>
                                                <option value="0" <?php echo $selected1;?>> Inactive </option>
                                            </select>
                                        </div>
                                    </div>                             
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-11">
                                    <input type="submit" name="submit" value="Apply" class="btn btn-info pull-right">
                                    <input type="submit" name="saveclose" value="Save and Close" class="btn btn-info pull-right">
                                </div>
                            </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<link rel="stylesheet" href="<?= base_url('public/plugins/select2/select2.css') ?>">
<script type="text/javascript" src="<?= base_url('public/plugins/select2/select2.js'); ?>"></script>
<script type="text/javascript">
    $(document).ready(function () {
        <?php foreach ($langArr as $key => $val) { ?>

            get_editor('email_template_body_<?php echo $key; ?>');

<?php } ?>
        $('.js-example-basic-single').select2();
    });
</script>