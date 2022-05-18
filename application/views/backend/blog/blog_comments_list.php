<?php $user_   = $_SESSION['user_role']; ?>
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
          <h1>Comments</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Comments</li>
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
              <h3 class="card-title"><?php echo $blog['blog_title'];?></h3>
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
                url   : '<?php echo base_url('admin/blog/blog_comments')?>',
                async : true,
                data:{blog_id:'<?php echo $blog['id'];?>'},
                //dataType : 'json',
                success : function(data){
                    $('#show_data').html(data);
                    $('#example2').dataTable({"aaSorting":[]});
                }
 
            });
        }
  });
</script>     