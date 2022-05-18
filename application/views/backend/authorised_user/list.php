<?php $user = $_SESSION['user']; ?>
<?php $add_permission = $this->permission->grant(AUTHORISED_USER,'add'); ?>
<?php $edit_permission = $this->permission->grant(AUTHORISED_USER,'edit'); ?>
<?php $delete_permission = $this->permission->grant(AUTHORISED_USER,'delete'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h1>Authorised Users</h1>
            </div>
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Dashboard</a></li>
                  <li class="breadcrumb-item active">Authorised Users</li>
               </ol>
            </div>
         </div>
      </div>
      <!-- /.container-fluid -->
   </section>
   <!-- Main content -->
   <section class="content">
      <div class="container-fluid">
         <div class="row">
            <div class="col-12">
               <div class="card">
                  <div class="card-header">
                     <h3 class="card-title">Authorised Users</h3>
                     <?php if($add_permission == true || $user == 1){ ?>
                     <div class="float-right"><a href="<?php echo base_url();?>admin/authorised_user/add" class="btn btn-block btn-primary btn-sm"><i class="fa fa-plus text-xs"></i> Add Authorised User</a></div>
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
       //call function show all authorised_user
       show_data();
       //function show all authorised_user
       function show_data(){
         $('#modal-loader').modal('hide');
           $.ajax({
               type  : 'POST',
               url   : '<?php echo base_url('admin/authorised_user/data')?>',
               async : true,
               //dataType : 'json',
               success : function(data){
                   $('#show_data').html(data);
                   $('#example2').dataTable({"aaSorting":[]});
               }
   
           });
       }
   
       //Save role
       $('#btn_save').on('click',function(event){
           event.preventDefault();
           if($("#add-form").valid()){
           var form = $('#add-form')[0];
           var formData = new FormData(form);
             $.ajax({
                 type: "POST",
                 url: "<?php echo base_url('admin/authorised_user/add')?>",
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
               url   : '<?php echo base_url('admin/authorised_user/getEdit')?>/'+id,
               dataType : 'html',
               success : function(data){
                 $('#editModel').html(data);
                 $('#edit-form .select2').select2();
                 edit();
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
                 url: "<?php echo base_url('admin/authorised_user/update')?>",
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
                 url: "<?php echo base_url();?>admin/authorised_user/delete/"+id,
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

       $('#show_data').on('click','.item_aproved',function(){
           var id = $(this).data('id');
           if(confirm('Are you sure want to Approved?')){
             $.ajax({
                 type : "POST",
                 url: "<?php echo base_url();?>admin/authorised_user/approved/"+id,
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

      // Change payment type
      $(document).on('change','#payment_type',function(){
        var value =  $(this).find('option:selected').text();
        $("[for=payment_value]").text(value);
        $("[name=payment_value]").attr("placeholder",value);
      });
      function edit(){
        $(document).on('change','#payment_type_edit',function(){
          var value =  $(this).find('option:selected').text();
          $("[for=payment_value_edit]").text(value);
          $("[id=payment_value_edit]").attr("placeholder",value);
        });
        $('#payment_type_edit').trigger('change');
      }
      // 
   });
   
</script>