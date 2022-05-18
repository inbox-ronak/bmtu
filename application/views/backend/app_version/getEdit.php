<div class="row">
  <div class="form-group col-md-6">
    <label for="title">App Version</label>
    <input type="text" name="app_version" class="form-control convert-into-slug" data-slug="slug_edit" id="title"  placeholder="Enter faq name" required value="<?php echo $data->app_version;?>">
  </div>
  <div class="form-group col-md-6">
    <label for="slug">Slug</label>
    <input type="text" name="changelog_date" class="form-control" id="slug_edit" value="<?php echo $data->changelog_date;?>" readonly="">
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <textarea class="textarea summernote" name="changelog" placeholder="Place some text here" style="width: 100%; height: 700px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $data->changelog;?></textarea>
  </div>
</div>

<input type="hidden" name="id" value="<?php echo $data->id;?>">

