<?php $user_role = $_SESSION['user_role']; ?>
<?php $add_permission = $this->permission->grant(RTI,'add'); ?>
<?php $edit_permission = $this->permission->grant(RTI,'edit'); ?>
<?php $delete_permission = $this->permission->grant(RTI,'delete'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h1><?php if(isset($_POST['id'])){ echo 'Update';}else{ echo 'Add'; } ?> RTI</h1>
            </div>
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Dashboard</a></li>
                  <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/rti">RTI</a></li>
                  <li class="breadcrumb-item active"><?php if(isset($rti['id'])){ echo 'Update';}else{ echo 'Add'; } ?> RTI</li>
               </ol>
            </div>
         </div>
      </div>
      <!-- /.container-fluid -->
   </section>
   <?php //echo '<pre>';print_r($label);
   // print_r($_REQUEST);?>
   <!-- Main content -->
   <section class="content">
      <div class="container-fluid">
         <div class="row">
            <div class="col-12">
               <div class="card">
                  <div class="card-header">
                     <h3 class="card-title"><?php if(isset($_POST['id'])){ echo 'Update';}else{ echo 'Add'; } ?> RTI</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body" id="show_data">
                     <form data-toggle="validator" role="form" method='POST' class="form-horizontal" action='<?php echo base_url();?>admin/rti/<?php if(isset($_POST['id'])){ echo 'edit/'.$_POST['id'];}else{ echo 'add'; } ?>' id="add-form" name="add-form" enctype='multipart/form-data'>
                      

                      <div class="col-md-6">
                            <div class="form-group">
                              <label for="name">Title</label>
                              <input type="text" name="title" class="form-control" id="title" placeholder="Enter Title" required value="<?php echo $label['title'];?>">
                            </div>
                       </div>

                       <div class="row">
                          <div class="col-md-12">
                            <label for="description">Description</label>
                            <textarea class="textarea summernote" name="description" style="width: 100%; height: 700px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $label['description'];?></textarea>
                          </div>
                       </div>

                       <div class="form-group col-md-6">
                          <label >Status</label>
                            <select id="status" name="status" class="form-control form-control-sm select2" style="width: 100%;">
                              <option value="1">Active</option>
                              <option value="0">In-Active</option>
                            </select>
                        </div>
                        
              
                        <div class="row">
                           <div class="col-md-4">
                              <div class="form-group">
                                 <button type="submit" name="submit" class="btn btn-primary">Save</button>
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
<script>
   $(document).ready(function(){
     function text_editor(){
       $('.summernote').summernote({
         toolbar: [
               ["style", ["style"]],
               ["font", ["bold", "underline", "clear"]],
               //["fontname", ["fontname"]],
               ["color", ["color"]],
               ["para", ["ul", "ol", "paragraph"]],
               ["table", ["table"]],
               ["insert", ["link", "picture", "video"]],
               ["view", ["fullscreen", "codeview", "help"]]
             ],
       });
     }
     text_editor();
     function user_type(){
       var value = $('#user_type').find('option:selected').val();
       //console.log()
       if (value == '2')
       {
         $(".user_list_chapter").show();
         $(".user_list_au").hide();
         
       }
       else if (value == '3')
       {
         $(".user_list_chapter").hide();
         $(".user_list_au").show();
       }
       else
       {
         $(".user_list_chapter").hide();
         $(".user_list_au").hide();
         
       }
     }
     user_type();
     $('#user_type').on('change',function(){
       user_type();
     });
   });
   
</script>
<!-- multiple filed hide show -->
<script>
   $(document).ready(function(){
     $(".choice-hidden").hide();
     $("#choice").change(function(){
       //var name = $(this).find('option:selected').val();
       //var name = $("#choice :selected").map((_, e) => e.value).get();
       //console.log(name);
       $(".choice-hidden").hide();
       $('#choice :selected').each(function(){
         var name = $(this).val();
         $("."+name).show();
       });
       
   });
   
     $('#choice :selected').each(function(){
         var name = $(this).val();
         console.log(name);
         $("."+name).show();
       });
   })
</script>
<!-- multiple filed hide show -->
<!-- video validation script -->
<script>
   $('#video_document').on('change', function() {
   var numb = $(this)[0].files[0].size / 1024 / 1024;
   numb = numb.toFixed(2);
   if (numb > 10) {
     alert('to big, maximum is 10MiB. You file size is: ' + numb + ' MiB');
     $('#video_document').val('');
   } else {
     alert('it okey, your file has ' + numb + 'MiB')
   }
   });
</script>
<script language="javascript">
   $(document).ready(function () {          
       $("input[name='title_en']").keyup(function () {
           $("input[name='slug']").val($(this).val().replace(/[^a-z0-9\s]/gi, '').replace(/\s\s+/g, '-').replace(/[_\s]/g, '-').toLowerCase());
       });
   
       $('#slug').keyup(function () {
           this.value = this.value.replace(/[^a-z0-9\s]/gi, '-').replace(/\s\s+/g, '-').replace(/[_\s]/g, '-').toLowerCase();
       });
   });
</script>
<!-- video validation script -->

<input type="hidden" name="id" value="<?php echo $data->id;?>">

<!-- multiple filed hide show -->
<script>
  $(document).ready(function(){
    $(".choice-hidden").hide();
    $("#choice").change(function(){
      //var name = $(this).find('option:selected').val();
      //var name = $("#choice :selected").map((_, e) => e.value).get();
      //console.log(name);
      $(".choice-hidden").hide();
      $('#choice :selected').each(function(){
        var name = $(this).val();
        $("."+name).show();
      });
      
  })
})
</script>

