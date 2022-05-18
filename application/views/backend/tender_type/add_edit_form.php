
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Tender List</h1>
            </div>
            <div class="col-sm-6">
                <div class="breadcrumb float-sm-right">
                    <a href="<?= base_url('admin/registered_users'); ?>" class="btn btn-success"><i class="fa fa-list"></i> Tender List</a>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
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
                            <?php if ($id == '-1') { ?>
                                &nbsp; Add Tender
                            <?php } else { ?>
                                &nbsp; Edit Tender
                            <?php } ?>
                        </h3>
                    </div> 
                    <div class="card-body">
                        <?php if (!empty($this->session->flashdata('message'))) {
                            echo $this->session->flashdata('message');
                        } ?>
                        <?php echo form_open(base_url('admin/tender_type/save/' . $id), 'class="form-horizontal" enctype="multipart/form-data"'); ?>  
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 item">
                                <div class="form-group">
                                    <label for="tender_name" class="control-label">Tender Name: <span class="text-danger">*</span> </label>
                                    <div class="">                              
                                        <input type="text" name="tender_name" class="form-control"value="<?php echo isset($form_details['tender_name']) ? set_value("tender_name", $form_details['tender_name']) : set_value("tender_name"); ?>" id="tender_name" placeholder="Tender Name">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 item">
                                <div class="form-group">
                                    <label for="status" class="control-label"> Status <span class='text-danger'>*</span></label>
                                    <div class="contentradio" id="contant_status">
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" name="status" value="1" <?php echo set_radio('status', 1); ?> id="customCheck1"  <?php if (isset($form_details['status']) && $form_details['status'] == 1) {
                                                echo 'checked="checked"';
                                            } else {
                                                echo 'checked="checked"';
                                            }
                                            ?>  >
                                            <label for="customCheck1">Active</label>
                                        </div>

                                        <div class="icheck-primary d-inline p-3">
                                            <input type="radio" name="status" value="0" <?php echo set_radio('status', 0); ?> id="customCheck2" <?php if (isset($form_details['status']) && $form_details['status'] == 0) {
                                                echo 'checked="checked"';
                                            }
                                            ?>  >
                                            <label for="customCheck2">Inactive</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 item">
                                <div class="form-group">
                                    <div class="text-center">
                                        <input type="submit" name="submit" value="Apply" class="btn btn-info pull-right">
                                        <input type="submit" name="submit" value="Save & Close" class="btn btn-info pull-right">
                                        <a href="<?=base_url().'admin/tender_type';?>"><input type="button" name="submit" value="Cancel" class="btn btn-info pull-right"></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
