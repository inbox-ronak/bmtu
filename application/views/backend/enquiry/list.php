<?php $user  = $_SESSION['user_role']; ?>
<?php $add_permission = $this->permission->grant(ENQUIRY,'add'); ?>
<?php $edit_permission = $this->permission->grant(ENQUIRY,'edit'); ?>
<?php $delete_permission = $this->permission->grant(ENQUIRY,'delete'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header"> 
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Enquiry List</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Enquiry</li>
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
  <!-- <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="print_bill1">
<div class="modal-dialog modal-sm iframeholder1">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title">Message</h5>
<button type="button" class="close" data-dismiss="modal"><span>&times;</span>
</button>
</div>
<div class="modal-body" id="iframeholder1">
</div>
<div class="modal-footer">
</div>
</div>
</div>
</div> -->
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
                url   : '<?php echo base_url('admin/Enquiry/data')?>',
                async : true,
                //dataType : 'json',
                data:{series_id:series_id,user_type:user_type,created_at1:created_at1,created_at2:created_at2},
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
<!-- <script type="text/javascript">
$('.print_bill1').on('click',function(){
    alert('TT');
      $('#iframeholder1').html('');
      var href = $(this).attr('data-href'); 
      ifrm = document.createElement("iframe");
      ifrm.setAttribute("src", "<?php //echo base_url('admin/Enquiry/data/');?>"+href);
      ifrm.style.width = 100+"%";
      ifrm.style.height = 200+"px";
      document.getElementById("iframeholder1").appendChild(ifrm);
   });
</script> -->