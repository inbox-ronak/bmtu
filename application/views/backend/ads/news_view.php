<link rel="stylesheet" href="<?= base_url() ?>public/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>News Details</h1>
            </div>
            <div class="col-sm-6">
                <div class="breadcrumb float-sm-right">
                    <?php $selected_brochure_id = $this->uri->segment('4'); ?>
                    <a href="<?= base_url('admin/news'); ?>" class="btn btn-success"><i class="fa fa-plus"></i> BackTo List </a>
                </div>
            </div>
        </div>
    </div>
</section>
<?php 
    $langArr = langArr();
    $title = unserialize($news_details['title']); 
    $description = base64_decode($news_details['descriptions']);
    $description = unserialize($description);
    $status = 'Inactive';
    if($news_details['status'] == 1){
        $status = 'Active';
    }else if($news_details['status'] == 2){
        $status = 'Archive';
    }
    $banner_image = unserialize($news_details['banner_image']); 
?>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            View News    
                        </h3>
                    </div> 
                    <div class="card-body">
                        <?php
                            foreach ($title as $title_key => $title_value) { 
                            $language_title = 'News Title';
                            if($title_key == 'en'){
                                $language_title = 'News Title: [English]';
                            }else if($title_key == 'ar'){
                                $language_title = 'News Title: [Arabic]';
                            }else if($title_key == 'ku'){
                                $language_title = 'News Title: [Kurdish]';
                            }
                        ?>
                            <div class="row">
                                <div class="col-sm-3">
                                    <label  class="control-label"><?php echo $language_title ?></label>
                                </div>
                                <div class="col-sm-9">
                                    <p><?php echo isset($title_value)?$title_value:''; ?></p>
                                </div>
                            </div>
                        <?php
                            }
                        ?>
                        <?php
                            foreach ($description as $description_key => $description_value) { 
                            $language_desc = 'Description';
                            if($description_key == 'en'){
                                $language_desc = 'Description: [English]';
                            }else if($description_key == 'ar'){
                                $language_desc = 'Description: [Arabic]';
                            }else if($description_key == 'ku'){
                                $language_desc = 'Description: [Kurdish]';
                            }
                        ?>
                            <div class="row">
                                <div class="col-sm-3">
                                    <label  class="control-label"><?php echo $language_desc ?></label>
                                </div>
                                <div class="col-sm-9">
                                    <p><?php echo isset($description_value)?$description_value:''; ?></p>
                                </div>
                            </div>
                        <?php
                            }
                        ?>
                        <div class="row">
                            <div class="col-sm-3">
                                <label  class="control-label">Status</label>
                            </div>
                            <div class="col-sm-9">
                                <p><?php echo $status ?></p>
                            </div>
                        </div>
                        <?php
                            foreach ($banner_image as $banner_image_key => $banner_image_value) { 
                            $language_banner_image_key = 'Image';
                            $image_path = '';
                            $class ='';
                            if($banner_image_key == 'en' && $banner_image_value['image'] != ''){
                                $language_banner_image_key = 'Image: [English]';
                                $image_path = base_url().$banner_image_value['image'];
                            }else if($banner_image_key == 'ar' && $banner_image_value['image'] != ''){
                                $language_banner_image_key = 'Image: [Arabic]';
                                $image_path = base_url().$banner_image_value['image'];
                            }else if($banner_image_key == 'ku' && $banner_image_value['image'] != ''){
                                $language_banner_image_key = 'Image: [Kurdish]';
                                $image_path = base_url().$banner_image_value['image'];
                            }else{
                                $class = 'd-none';
                            }
                        ?>
                            <div class="row mt-1 <?php echo $class; ?>">
                                <div class="col-sm-3">
                                    <label  class="control-label"><?php echo $language_banner_image_key ?></label>
                                </div>
                                <div class="col-sm-9"> 
                                    <img src="<?php echo $image_path ?>" class="uploaded-images" style="width: 150px;height: 100px;">
                                </div>
                            </div>
                        <?php
                            }
                        ?> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
                           
