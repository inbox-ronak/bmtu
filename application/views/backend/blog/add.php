<?php $user_role = $_SESSION['user_role']; ?>
<?php $add_permission = $this->permission->grant(BLOG,'add'); ?>
<?php $edit_permission = $this->permission->grant(BLOG,'edit'); ?>
<?php $delete_permission = $this->permission->grant(BLOG,'delete'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><?php if(isset($record[0]['id'])){ echo 'Update';}else{ echo 'Add'; } ?> Gallery</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/gallery">Gallery</a></li>
            <li class="breadcrumb-item active"><?php if(isset($record[0]['id'])){ echo 'Update';}else{ echo 'Add'; } ?> Gallery</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <?php //echo '<pre>';print_r($record);?>
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title"><?php if(isset($record[0]['id'])){ echo 'Update';}else{ echo 'Add'; } ?> Gallery</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body" id="show_data">
              <form data-toggle="validator" role="form" method='POST' class="form-horizontal" action='<?php echo base_url();?>admin/gallery/<?php if(isset($record[0]['id'])){ echo 'edit/'.base64_encode($record[0]['id']);}else{ echo 'add'; } ?>' id="add-form" name="add-form" enctype='multipart/form-data'>
                  <div class="col-md-6">
                  <table style="width: 100%;" id="field">
                    <tr id="field0">
                      <td style="width: 90.3%;">
                        <div class="form-group">
                          <label class="required-label" for="gallery_images0">Product Images</label>
                          <div class="custom-file">
                            <input type="file" <?php if(empty($record)){ ?> required <?php }?> name="gallery_images[]" accept="image/*" class="galleryImage-input custom-file-input" id="gallery_images0">
                            <label class="custom-file-label" for="gallery_images0">Product Images</label>
                            <button type="button" id="add-more" style="padding:7px;" class="btn btn-success">Add-More</button>
                          </div>
                        </div>
                      </td>
                    </tr>
                  </table>
                </div>
                <div class="col-md-12"></div>

<?php 
if($record){
  $attached_files = json_decode($record[0]['galleryImage'],true);
  $fieldFileCount = count($attached_files);
}else
{
$attached_files='';
}
?>
<div class="row remove-row-galleryImage">
  <div class="col-md-12">
    <!-- <h6><strong>Uploaded Gallery Images</strong></h6> -->
    <table style="min-width:50%;max-width: 100%;">
      <?php
      if($attached_files){
      foreach ($attached_files as $key => $value) { ?>
          <tr style="border-bottom: 0px solid #ced4da;">
            <td class="pt-1 pb-1">
                <?php if(isset($record[0]['galleryImage'])){ ?>
                <embed src="<?php echo base_url().'assets/uploads/gallery/'.$value;?>" width="105px" height="100px" />

            </td>
            <td class="pl-2 pr-2"><a target="_blank" href="<?php echo base_url().'assets/uploads/gallery/'.$value;?>"><?php echo $value;?></a></td>
            <?php } ?>
            <td>
              <input type="hidden" name="uploaded_files[]" value="<?php echo $key;?>">
              <a href="javascript:;" class="removeFile text-danger">Remove</a>
            </td>
          </tr>
      <?php } } ?>
    </table>
  </div>
</div>
<input type="hidden" name="uploaded_mainImage" id="uploaded_mainImage" value="1">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <button type="submit" name="btn-submit" class="btn btn-primary m-b-0"><?php if(!empty($record)) { echo 'Update'; }else{ echo 'Save'; } ?></button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script type="text/javascript">
  $(document).ready(function() {
        var next = 0;
        $("#add-more").click(function(e){
            e.preventDefault();
            var addto = "#field";
            next = next + 1;
            var newIn = '<tr id="field'+next+'">\
              <td>\
                <div class="form-group">\
                  <label class="required-label" for="gallery_images'+next+'"></label>\
                  <div class="custom-file">\
                    <input type="file" required name="gallery_images[]" accept="image/*" class="custom-file-input" id="gallery_images'+next+'">\
                    <label class="custom-file-label" for="gallery_images'+next+'">Product Images</label>\
                    <button type="button" style="padding:7px;" data-id="'+next+'" class="remove-file btn btn-danger">Remove</button>\
                  </div>\
                </div>\
              </td>\
            </tr>';
            $(addto).append(newIn);
            $('.remove-file').click(function(e){
                e.preventDefault();
                var fieldNum = $(this).attr('data-id');
                var fieldID = "#field" + fieldNum;
                $(fieldID).remove();
            });
            // $('.removeFile').click(function(){
            // var whichtr = $(this).closest("tr");
            // whichtr.remove(); 
            // requiredLabel();
            // });
            customFile();
        });
        // File //
        $('.removeFile').click(function(){
            var whichtr = $(this).closest("tr");
            whichtr.remove(); 
            requiredLabel();
        });
    });
</script>