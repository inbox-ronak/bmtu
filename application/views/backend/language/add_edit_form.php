<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Language Variable</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/language'); ?>">Language Variables</a></li>
                        <li class="breadcrumb-item active">Add Language Variable</li>
                    </ol>
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
    							Add Language Variable
    							<?php } else { ?>
    							Edit Language Variable
    							<?php } ?>
                            </h3>
                            <div class="float-sm-right">
                                <a href="<?php echo base_url('admin/language'); ?>" class="btn btn-success btn-sm"><i class="fa fa-list"></i> Language List</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($this->session->flashdata('message'))) {
                                echo $this->session->flashdata('message');
                            } ?>
                            <?php echo form_open(base_url('admin/language/save/' . $id), 'class="form-horizontal" enctype="multipart/form-data" method="post"'); ?> 
                            <div class="row">
                                <div class="col-sm-12"> 
                                    <div class="form-group"> 
                                        <?php if ($id == '-1') { ?>
                                            <label for="lang_name" class="control-label">Lang Name<span class='text-danger'>*</span></label> 
                                            <input  placeholder="Lang Name" class="lang-name form-control" type="text" name="lang_name" value="<?php if(isset($_POST['lang_name'])){ echo  $_POST['lang_name']; }else if(isset($form_details['lang_name'])){echo $form_details['lang_name']; }  ?>">
                                        <?php }else{ ?>
                                            <label for="content" class="control-label">Lang Name : <?php if(isset($form_details['lang_name'])){echo $form_details['lang_name'];}?></label>
                                        <?php } ?>
                                    </div> 
                                </div>
                            </div>
    						<div class="row">
                                <div class="col-sm-12"> 
                                    <div class="form-group"> 
                                        <label for="lang_en" class="control-label">Lang <small style="color: blue; font-weight: bold;"><i>[English]</i></small><span class='text-danger'>*</span></label> 
                                        <input placeholder="Lang [English]" class="form-control" type="text" name="lang_en" value="<?php if(isset($_POST['lang_en'])){ echo  $_POST['lang_en']; }else if(isset($form_details['lang_en'])){echo $form_details['lang_en']; }  ?>">
                                    </div> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12"> 
                                    <div class="form-group"> 
                                        <label for="lang_hi" class="control-label">Lang <small style="color: blue; font-weight: bold;"><i>[Hindi]</i></small><span class='text-danger'>*</span></label> 
                                        <input placeholder="Lang [Hindi]" class="form-control" type="text" name="lang_hi" value="<?php if(isset($_POST['lang_hi'])){ echo  $_POST['lang_hi']; }else if(isset($form_details['lang_hi'])){echo $form_details['lang_hi']; }  ?>">
                                    </div> 
                                </div>
                            </div>
                            <?php /* ?>
                            <div class="row">
                                <div class="col-sm-12"> 
                                    <div class="form-group"> 
                                        <label for="lang_ar" class="control-label">Lang <small style="color: blue; font-weight: bold;"><i>[Arabic]</i></small><span class='text-danger'>*</span></label> 
                                        <input placeholder="Lang [Arabic]" class="form-control" type="text" name="lang_ar" value="<?php if(isset($_POST['lang_ar'])){ echo  $_POST['lang_ar']; }elseif(isset($form_details['lang_ar'])){echo $form_details['lang_ar']; }  ?>">
                                    </div> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12"> 
                                    <div class="form-group"> 
                                        <label for="lang_ku" class="control-label">Lang <small style="color: blue; font-weight: bold;"><i>[Kurdish]</i></small><span class='text-danger'>*</span></label> 
                                        <input placeholder="Lang [Kurdish]" class="form-control" type="text" name="lang_ku" value="<?php if(isset($_POST['lang_ku'])){ echo  $_POST['lang_ku']; }elseif(isset($form_details['lang_ku'])){echo $form_details['lang_ku']; }  ?>">
                                    </div> 
                                </div>
                            </div>
                            <?php */ ?>
                            <div class="form-group">
                                <div class="col-md-11">
                                    <input type="submit" name="submit" value="Apply" class="btn btn-info pull-right">
                                    <input type="submit" name="submit" value="Save & Close" class="btn btn-info pull-right">
                                      <a href="<?=base_url().'admin/language';?>"><input type="button" name="submit" value="Cancel" class="btn btn-info pull-right"></a>
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
<script>
$(".lang-name").keyup(function () {
    $(this).val($(this).val().split(' ').join('_'));
});
</script>
