<?php $user  = $_SESSION['user_role']; ?>
<?php $add_permission = $this->permission->grant(QR_CODE,'add'); ?>
<?php $edit_permission = $this->permission->grant(QR_CODE,'edit'); ?>
<?php $delete_permission = $this->permission->grant(QR_CODE,'delete'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header"> 
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Generated Qr List</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Generated Qr code</li>
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
            <!-- /.card-header -->
            <div class="card-body" id="show_data1">
                <form id="form-filter">
              <div class="row">
            <div class="form-group col-md-2">
               <label for="trade_partner_id">Label Series</label>
               <select class="form-control select2" id="series_id" required name="series_id" style="width: 100%;">
                      <option value="">Select</option>
                      <?php
                        $this->db->where('status',1);
                        $series = $this->db->get('series_master')->result_array();
                        if($series){
                            foreach ($series as $value){
                        ?>
                        <option <?php echo (($label['series_id']==$value['id'])? "selected":"");?> value="<?php echo $value['id'];?>"><?php echo $value['series_name'];?></option>
                      <?php } } ?>
                      </select>
            </div>
            <div class="form-group col-md-2">
              <label for="series_name">From Date</label>
              <input type="date" name="created_at" class="form-control" id="created_at1" required>
            </div>
            <div class="form-group col-md-2">
              <label for="series_name">To Date</label>
              <input type="date" name="created_at" class="form-control" id="created_at2" required>
            </div>
           
            <div class="form-group col-md-2 pt-4 mt-2">
              <button type="button" id="search" class="btn btn-primary">Search</button>
              <button type="clear" class="btn btn-default">Clear</button>
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
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title"></h3>
              <?php if($add_permission == true || $user_role == 1){ ?>
              <div class="float-right"><a href="<?php echo base_url();?>admin/qr_code/add" class="btn btn-block btn-primary btn-sm"><i class="fa fa-plus text-xs"></i> Generate Label</a></div>
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
                url   : '<?php echo base_url('admin/qr_code/data')?>',
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
                  url: "<?php echo base_url();?>admin/label/delete/"+id,
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