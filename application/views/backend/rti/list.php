<?php $user_role   = $_SESSION['user_role']; ?>
<?php $add_permission = $this->permission->grant(RTI,'add'); ?>
<?php $edit_permission = $this->permission->grant(RTI,'edit'); ?>
<?php $delete_permission = $this->permission->grant(RTI,'delete'); ?>

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
          <h1>RTI</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Dashboard</a></li>
            <li class="breadcrumb-item active">RTI</li>
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
              <h3 class="card-title">RTI</h3>
              <?php if($add_permission == true || $user_role == 1){ ?>
              <div class="float-right"><a href="<?php echo base_url();?>admin/rti/add" class="btn btn-block btn-primary btn-sm"><i class="fa fa-plus text-xs"></i> Add Rti</a></div>
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
                url   : '<?php echo base_url('admin/rti/data')?>',
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
                  url: "<?php echo base_url('admin/rti/add')?>",
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
                url   : '<?php echo base_url('admin/rti/getEdit')?>/'+id,
                dataType : 'html',
                success : function(data){
                  $('#editModel').html(data);
                  slug();
                  text_editor();
                  $('#edit-form .select2').select2();
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
                  url: "<?php echo base_url('admin/rti/update')?>",
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
                  url: "<?php echo base_url();?>admin/rti/delete/"+id,
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
                  url:"<?php echo base_url();?>admin/rti/ordering",
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
<!-- video validation script -->





