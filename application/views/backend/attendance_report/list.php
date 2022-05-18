<?php $user  = $_SESSION['user_role']; ?>
<?php $add_permission = $this->permission->grant(ATTENDANCEREPORT,'add'); ?>
<?php $edit_permission = $this->permission->grant(ATTENDANCEREPORT,'edit'); ?>
<?php $delete_permission = $this->permission->grant(ATTENDANCEREPORT,'delete'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header"> 
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Attendance Report List</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Attendance Report</li>
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
               <label for="trade_partner_id">Employee</label>
               <select class="form-control select2" id="employee" required name="employee" style="width: 100%;">
                      <option value="">Select</option>
                      <?php
                        $this->db->where('status',1);
                        $employee = $this->db->get('employees')->result_array();
                        if($employee){
                            foreach ($employee as $value){
                        ?>
                        <option <?php echo (($record['employee']==$value['id'])? "selected":"");?> value="<?php echo $value['id'];?>"><?php echo $value['first_name'];?></option>
                      <?php } } ?>
                      </select>
            </div>
            <div class="form-group col-md-2">
              <label for="series_name">From Date</label>
              <input type="date" name="date" class="form-control" id="created_at1" required>
            </div>
            <div class="form-group col-md-2">
              <label for="series_name">To Date</label>
              <input type="date" name="date" class="form-control" id="created_at2" required>
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
            var employee = $('#employee').find('option:selected').val();
            //var user_type = $('#user_type').find('option:selected').val();
            var created_at1 = $('#created_at1').val();
            var created_at2 = $('#created_at2').val();
            $.ajax({
                type  : 'POST',
                url   : '<?php echo base_url('admin/attendance_report/data')?>',
                async : true,
                //dataType : 'json',
                data:{employee:employee,created_at1:created_at1,created_at2:created_at2},
                success : function(data){
                    $('#show_data').html(data);
                    $('#example2').dataTable({"aaSorting":[]});
                }
 
            });
        }

        $('body').on('click','#search',function(){
          show_data();
        });
 
    });
 
</script>