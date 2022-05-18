<?php $user  = $_SESSION['user_role']; ?>
<?php $add_permission = $this->permission->grant(COLLEGE,'add'); ?>
<?php $edit_permission = $this->permission->grant(COLLEGE,'edit'); ?>
<?php $delete_permission = $this->permission->grant(COLLEGE,'delete'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header"> 
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>College List</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Dashboard</a></li>
            <li class="breadcrumb-item active">College</li>
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
              <h3 class="card-title"></h3>
              <?php if($add_permission == true || $user_role == 1){ ?>
              <div class="float-right"><a href="<?php echo base_url();?>admin/College/add" class="btn btn-block btn-primary btn-sm"><i class="fa fa-plus text-xs"></i> College</a></div>
              <?php } ?>
            </div>
            <!-- /.card-header -->
            <div class="card-body" >
              <div class="table-responsive" id="show_data">

              </div>
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
        //call function show all series
        show_data();
        //function show all series
        function show_data(){
          $('#modal-loader').modal('hide');
            var series_id = $('#series_id').find('option:selected').val();
            var user_type = $('#user_type').find('option:selected').val();
            var created_at1 = $('#created_at1').val();
            var created_at2 = $('#created_at2').val();
            $.ajax({
                type  : 'POST',
                url   : '<?php echo base_url('admin/College/data')?>',
                async : true,
                //dataType : 'json',
                data:{series_id:series_id,user_type:user_type,created_at1:created_at1,created_at2:created_at2},
                success : function(data){
                    $('#show_data').html(data);
                    $('#example2').dataTable({"aaSorting":[]});
                }
 
            });
        }
        //delete record to database
        $('#show_data').on('click','.item_delete',function(){
            var id = $(this).data('id');
            if(confirm('Are you sure want to delete?')){
              $.ajax({
                  type : "POST",
                  url: "<?php echo base_url();?>admin/College/delete/"+id,
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

        $('body').on('click','#search',function(){
          show_data();
        });
 
    });
 
</script>