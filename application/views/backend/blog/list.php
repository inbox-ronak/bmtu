<?php $user_role   = $_SESSION['user_role']; ?>
<?php $add_permission = $this->permission->grant(BLOG,'add'); ?>
<?php $edit_permission = $this->permission->grant(BLOG,'edit'); ?>
<?php $delete_permission = $this->permission->grant(BLOG,'delete'); ?>

<!-- List Drag and Drop css-- >
  
<style type="text/css">
  .row_position tr{
    cursor: grab;
  }
</style>

<!-- List Drag and Drop css-- >

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header"> 
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Blog</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Blog</li>
          </ol>
        </div> 
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Blog</h3>
              <?php if($add_permission == true || $user_role == 1){ ?>
              <div class="float-right"><a href="#" data-toggle="modal" data-target="#modal-default" class="btn btn-block btn-primary btn-sm"><i class="fa fa-plus text-xs"></i> Add Blog</a></div>
              <?php } ?>
            </div>
            <!-- /.card-header -->
            <div class="card-body" id="show_data">
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
    <!-- add modal -->
    <div class="modal fade" id="modal-default" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <form data-toggle="validator" role="form" method='POST' class="form-horizontal" action='<?php echo base_url();?>blog/add' id="add-form" name="add-form" enctype='multipart/form-data'>
          <div class="modal-header">
            <h4 class="modal-title">Add blogs</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <!-- <div class="form-group col-md-6">
                <label for="blog_title">Blog Title<span style="color: red">*</span></label>
                <input type="text" name="blog_title" class="form-control convert-into-slug" data-slug="slug" id="blog_title" placeholder="Enter Blog Title Name" required>
              </div> -->
              <?php
                         $langArr = langArr();
                         foreach ($langArr as $key => $val) {                           

                           $compulsory = "";                               
                           $compulsory = "<span class='text-danger'>*</span>";

                           ?>
                           <div class="form-group col-md-6">
                             <div class="form-group">
                              <?php echo form_label('Blog Title <small style="color: blue; font-weight: bold;"><i> ['. $val.']</i></small>'.$compulsory . ' <small style="color: blue; font-weight: bold;"></small>', 'title_' . $key, array('class' => 'col-sm-12 control-label')); ?>
                              <!-- <div class="col-sm-12"> -->
                                <?php
                                $input_attr = array(
                                 'name' => 'title_' . $key,
                                 'id' => 'title_' . $key,
                                 'class' => 'form-control',
                                 'autocomplete' => 'off',
                                 'required'=>'required',
                                 'placeholder' => 'Title',
                                 'value' => (isset($_POST['title_' .$key])) ? $_POST['title_' . $key] : $cate_name[$key],
                               );
                                echo form_input($input_attr);
                                ?>
                                <input type="hidden" name="hidden_title_<?php echo $key; ?>" value="<?php echo $cate_name[$key]; ?>">
                                <!-- </div> -->
                              </div>
                            </div>
                          <?php } ?>
              <div class="form-group col-md-6">
                <label for="slug">Slug</label>
                <input type="text" name="slug" class="form-control" id="slug" readonly="">
              </div>

              <div class="form-group col-md-6">
                <label for="blog_image">Blog Image<span style="color: red">*</span></label>
                <input type="file" name="blog_image" class="form-control" id="blog_image" required="">
              </div>

              <div class="form-group col-md-6">
                <label for="blog_published_date">Published Date<span style="color: red">*</span></label>
                <input type="date" name="blog_published_date" class="form-control" id="blog_published_date" required="">
              </div>

              <div class="form-group col-md-6">
                  <label >Status</label>
                    <select id="status" name="status" class="form-control form-control-sm select2" style="width: 100%;">
                     <option value="1">Active</option>
                      <option value="0">De-Active</option>
                    </select>
              </div>

              <div class="form-group col-md-6">
                <label for="intro_content">Intro Content</label>
                 <textarea class="form-control" name="intro_content" id="intro_content" ></textarea>
              </div>

               <div class="form-group col-md-6">
                <label for="ordering">Ordering</label>
                <input type="number" name="ordering" class="form-control"  id="ordering" value="">
              </div>

              
            </div>
            <!-- <div class="row">
              <div class="col-md-12">
                <label for="blog_description">Description</label>
                <textarea class="textarea summernote" name="blog_description" placeholder="Place some text here" style="width: 100%; height: 700px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
              </div>
            </div> -->
            <div class="row">
               <?php
                         $langArr = langArr();
                         foreach ($langArr as $key => $val) {
                           $compulsory = "";

                           $compulsory = "<span class='text-danger'>*</span>";                                    
                           $cate_desc_base64_decode = base64_decode($cate_desc[$key]);
                           ?>
                           <div class="col-md-12">
                             <div class="form-group" >
                              <?php echo form_label('Description <small style="color: blue; font-weight: bold;"><i> ['. $val.']</i></small> <small style="color: blue; font-weight: bold;"></small>'.$compulsory, 'desc_' . $key, array('class' => 'col-sm-4 control-label')); ?>
                              <!-- <div class="col-sm-12"> -->
                                <?php
                                $input_attr = array(
                                 'name' => 'desc_' . $key,
                                 'value' => (isset($_POST['desc_' . $key])) ? $_POST['desc_' . $key] : $cate_desc_base64_decode,
                                 'rows' => '5',
                                 'class' => 'form-control summernote',
                                 'required'=>'required'
                               );
                                echo form_textarea($input_attr);
                                ?>
                                <!-- </div> -->
                              </div>
                            </div>
                          <?php } ?>            
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button type="submit" id="btn_save" class="btn btn-primary">Save</button>
          </div>
          </form>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <!-- /.add modal -->
    <!-- edit modal -->
    <div class="modal fade" id="modal-edit" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <form data-toggle="validator" role="form" method='POST' class="form-horizontal2" action='<?php echo base_url();?>blog/update' id="edit-form" name="edit-form" enctype='multipart/form-data'>
          <div class="modal-header">
            <h4 class="modal-title">Edit BLOG</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="editModel" >
            
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button type="submit" id="btn_update" class="btn btn-primary">Save</button>
          </div>
          </form>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <!-- /. edit modal -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script type="text/javascript">
    $(document).ready(function(){
        //call function show all faq
        show_data();
        //function show all faq
        function show_data(){
          $('#modal-loader').modal('hide');
            $.ajax({
                type  : 'POST',
                url   : '<?php echo base_url('admin/blog/data')?>',
                async : true,
                //dataType : 'json',
                success : function(data){
                    $('#show_data').html(data);
                    $('#example2').dataTable({"aaSorting":[]});
                    row_position();
                }
 
            });
        }
 
        //Save
        $('#btn_save').on('click',function(event){
            event.preventDefault();
            if($("#add-form").valid()){
            var form = $('#add-form')[0];
            var formData = new FormData(form);
              $.ajax({
                  type: "POST",
                  url: "<?php echo base_url('admin/blog/add')?>",
                  data: formData,
                  //use contentType, processData for sure.
                  contentType: false,
                  processData: false,
                  dataType : "JSON",
                  beforeSend: function() {
                      $('#modal-default').modal('hide');
                      $('#modal-loader').modal('show');
                  },
                  success: function(msg) {
                      setTimeout(function(){ $('#modal-loader').modal('hide'); }, 1000);
                      $('#add-form')[0].reset();
                      success_msg(msg.success,msg.message);
                      show_data();
                  },
                  error: function() {
                      success_msg(0,"Sorry! could not process your request.");
                  }
              });
            }
            return false;
        });
 
        //get data for update record
        $('#show_data').on('click','.item_edit',function(){
            var id = $(this).data('id');
            $('#modal-edit').modal('show');
            $.ajax({
                type  : 'POST',
                url   : '<?php echo base_url('admin/blog/getEdit')?>/'+id,
                dataType : 'html',
                success : function(data){
                  $('#editModel').html(data);
                  slug();
                  text_editor();
                }
            });
        }); 
        //update record to database
         $('#btn_update').on('click',function(event){
            event.preventDefault();
            if($("#edit-form").valid()){
            var form = $('#edit-form')[0];
            var formData = new FormData(form);
              $.ajax({
                  type: "POST",
                  url: "<?php echo base_url('admin/blog/update')?>",
                  data: formData,
                  //use contentType, processData for sure.
                  contentType: false,
                  processData: false,
                  dataType : "JSON",
                  beforeSend: function() {
                      $('#modal-edit').modal('hide');
                      $('#modal-loader').modal('show');
                  },
                  success: function(msg) {
                    setTimeout(function(){ $('#modal-loader').modal('hide'); }, 1000);
                    success_msg(msg.success,msg.message);
                    show_data();
                  },
                  error: function() {
                      success_msg(0,"Sorry! could not process your request.");
                      //alert("Sorry! Couldn't process your request.");
                  }
              });
            }
            return false;
        });
  
        //delete record to database
        $('#show_data').on('click','.item_delete',function(){
            var id = $(this).data('id');
            if(confirm('Are you sure want to delete?')){
              $.ajax({
                  type : "POST",
                  url: "<?php echo base_url();?>admin/blog/delete/"+id,
                  dataType : "JSON",
                  data : {id:id},
                  success: function(msg){
                      success_msg(msg.success,msg.message);
                      show_data();
                  }
              });
            }
            return false;
        });

        //

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

        //
        //-- Drag and Drop -->
        function row_position(){
          $(".row_position").sortable({
              delay: 150,
              stop: function() {
                  var selectedData = new Array();
                  $('.row_position>tr').each(function() {
                      selectedData.push($(this).attr("id"));
                  });
                  updateOrder(selectedData);
              }
          });
          function updateOrder(data) {
              $.ajax({
                  url:"<?php echo base_url();?>admin/blog/ordering",
                  type:'post',
                  data:{position:data},
                  success:function(data){
                      success_msg(1,'Your Change Successfully Saved.');
                  }
              })
          }
        }
        //<!--  Drag and Drop -->
    });
 
</script>
<!-- comments-->

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