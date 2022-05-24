<?php $user_role = $_SESSION['user_role']; ?>
<?php $add_permission = $this->permission->grant(GENERATE_MERIT,'add'); ?> 
<?php $edit_permission = $this->permission->grant(GENERATE_MERIT,'edit'); ?>
<?php $delete_permission = $this->permission->grant(GENERATE_MERIT,'delete'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><?php if(isset($record['id'])){ echo 'Update';}else{ echo 'Add'; } ?> Generate Merit</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/GenerateMerit">Generate Merit</a></li>
            <li class="breadcrumb-item active"><?php if(isset($record['id'])){ echo 'Update';}else{ echo 'Add'; } ?> Generate Merit</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <?php //echo '<pre>';print_r($label);?>
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
            <div class="card-body" id="show_data">
            
            <div class="table-responsive" id="show_data">
          </div>
              <h3 class="card-title"><?php if(isset($record['id'])){ echo 'Update';}else{ echo 'Add'; } ?> Generate Merit</h3>
            </div>
            <!-- /.card-header -->
              <form data-toggle="validator" role="form" method='POST' class="form-horizontal" action='<?php echo base_url();?>admin/GenerateMerit/<?php if(isset($record['id'])){ echo 'edit/'.base64_encode($record['id']);}else{ echo 'add'; } ?>' id="add-form" name="add-form" enctype='multipart/form-data'>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="student_id">Student Id</label>
                      <select class="form-control" name="student_id" id="student_id">
                        <option value="">Select Student Id</option>
                        <?php
                        foreach ($student_ids as $key => $value) { ?>
                          <option value="<?= $value['student_id']; ?>" <?php if(isset($record['student_id'])) if($record['student_id'] == $value['student_id']){ echo 'selected'; } ?>><?= $value['student_id']; ?></option>
                        <?php }
                        ?>
                      </select>
                      <!-- <input type="number" min="0" name="student_id" class="form-control" required id="student_id" placeholder="" value="<?php if(isset($record['student_id'])){ echo $record['student_id'];} ?>"> -->
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="pwp_certificate">PWP Certificate</label>
                      <input type="number" min="0" name="pwp_certificate" class="form-control" required id="pwp_certificate" placeholder="" value="<?php if(isset($record['pwp_certificate'])){ echo $record['pwp_certificate'];} ?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="physically_hendicap">Physically Hendicap</label>
                      <input type="number" min="0" name="physically_hendicap" class="form-control" required id="physically_hendicap" placeholder="" value="<?php if(isset($record['physically_hendicap'])){ echo $record['physically_hendicap'];} ?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="dob_ssc">Date of Birth(DOB) as per SSC</label>
                      <input type="number" min="0" name="dob_ssc" class="form-control" required id="dob_ssc" placeholder="" value="<?php if(isset($record['dob_ssc'])){ echo $record['dob_ssc'];} ?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="dob_ssc_aadhar">DOB as per SSC and Aadhar are same?</label>
                      <select class="form-control" name="dob_ssc_aadhar" id="dob_ssc_aadhar">
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                      </select>
                      <!-- <input type="number" min="0" name="dob_ssc_aadhar" class="form-control" required id="dob_ssc_aadhar" placeholder="" value="<?php if(isset($record['dob_ssc_aadhar'])){ echo $record['dob_ssc_aadhar'];} ?>"> -->
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="st_sc_ewc_obc_certificate">ST/SC/EWC/OBC Certificate No.</label>
                      <input type="number" min="0" name="st_sc_ewc_obc_certificate" class="form-control" required id="st_sc_ewc_obc_certificate" placeholder="" value="<?php if(isset($record['st_sc_ewc_obc_certificate'])){ echo $record['st_sc_ewc_obc_certificate'];} ?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="certificate_validity_date">Certificate Validity Date</label>
                      <input type="date" name="certificate_validity_date" class="form-control" required id="certificate_validity_date" placeholder="" value="<?php if(isset($record['certificate_validity_date'])){ echo $record['certificate_validity_date'];} ?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                      <div class="form-group">
                         <label class="col-form-label">HSC Marksheet </label>
                         <input type="file"  name="hsc_marksheet" class="form-control" id="hsc_marksheet" value="<?php if(isset($product['hsc_marksheet'])){echo $product['hsc_marksheet'];}else{echo set_value('hsc_marksheet'); } ?>">
                         <div class="help-block with-errors"></div>
                      </div>
                   </div>
                   <?php if(isset($product['hsc_marksheet'])){ ?>
                    <div class="col-md-4">
                      <div class="form-group">
                          <label class="col-form-label">Product Image </label>
                          <img style="height: 150px;" class="form-control" src="<?php echo base_url().'assets/uploads/product/'.$product['hsc_marksheet'];?>">
                        </div>
                    </div>
                    <?php } ?>
                  <!-- <div class="col-md-4">
                    <div class="form-group">
                      <label for="hsc_marksheet">HSC Marksheet</label>
                      <input type="file" name="hsc_marksheet" class="form-control" required id="hsc_marksheet" placeholder="">
                    </div>
                  </div> -->
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="leaving_certificate">Leaving Certificate</label>
                      <input type="file" name="leaving_certificate" class="form-control" required id="leaving_certificate" placeholder="">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="cast_certificate">Cast Certificate</label>
                      <input type="file" name="cast_certificate" class="form-control" required id="cast_certificate" placeholder="">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="non_creamy_certificate">Non-Creamy Layer Certificate</label>
                      <input type="file" name="non_creamy_certificate" class="form-control" required id="non_creamy_certificate" placeholder="">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="non_creamy_date">Non-Creamy Layer Date</label>
                      <input type="date" name="non_creamy_date" class="form-control" required id="non_creamy_date" placeholder="">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="aadhar_card">Aadhar Card</label>
                      <input type="file" name="aadhar_card" class="form-control" required id="aadhar_card" placeholder="">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="sc_bc_obc_certificate">ST/SC/EWC/OBC Certificate</label>
                      <input type="file" name="sc_bc_obc_certificate" class="form-control" required id="sc_bc_obc_certificate" placeholder="">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="sc_st_certificate">ST/SC Certificate</label>
                      <input type="file" name="sc_st_certificate" class="form-control" required id="sc_st_certificate" placeholder="">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="ews_certificate">EWS Certificate No.</label>
                      <input type="file" name="ews_certificate" class="form-control" required id="ews_certificate" placeholder="">
                    </div>
                  </div>
                  <!-- <div class="col-md-4"> 
                    <div class="form-group">
                     <label>Status: </label>
                     <select id="status" name="status" class="form-control form-control-sm select2">
                       <option value="1" <?php if(isset($record['status'])){
                        if($record['status'] == 1){ echo 'selected'; }
                      }else{
                        if(set_value('status') == 1){ echo 'selected'; }
                      } ?>>Active</option>
                      <option value="0" <?php if(isset($record['status'])){
                        if($record['status'] == 0){ echo 'selected'; }
                      }else{
                        if(set_value('status') == 0){ echo ''; }
                      } ?>>In-Active</option>
                    </select>
                    </div>
                  </div> -->
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
<script type="text/javascript">
    function resetDepartment() {
      $('#department').empty();
      $('#department').append(`<option value="">Select Department</option>`);
    }
    function resetProgram() {
      $('#program_name').empty();
      $('#program_name').append(`<option value="">Select Program</option>`);
    }
    function resetCourseGroup() {
      $('#course_group_name').empty();
      $('#course_group_name').append(`<option value="">Select Course Group</option>`);
    }
    function resetCourse() {
      $('#course_name').empty();
      $('#course_name').append(`<option value="">Select Course</option>`);
    }

    $(document).ready(function(){
      let old_department = '<?php echo $department; ?>';
      let old_program_name = '<?php echo $program_name; ?>';
      let course_group_name = '<?php echo $course_group_name; ?>';
      let course_name = '<?php echo $course_name; ?>';
      // alert(department);
      var college_name = $('#college_name').val();
      $.ajax({
        type : "POST",
        url: "<?php echo base_url();?>admin/GenerateMerit/fetchDepartment",
        dataType : "JSON",
        data : {college_name:college_name},
        success: function(msg){
          resetDepartment();
          // console.log(JSON.parse(JSON.stringify(msg)));
          JSON.parse(JSON.stringify(msg)).forEach(element => {
            $('#department').append('<option value='+element.department+'>'+element.department+'</option>');
          });
        }
      }).done(function (data) {
        $('#department').val(old_department);
        let department = $('#department').val();
        var college_name = $('#college_name').val();
        $.ajax({
            type : "POST",
            url: "<?php echo base_url();?>admin/GenerateMerit/fetchProgram",
            dataType : "JSON",
            data : {college_name,department},
            success: function(msg){
              resetProgram();
              JSON.parse(JSON.stringify(msg)).forEach(element => {
                $('#program_name').append(`<option value="${element.program_name}">${element.program_name}</option>`);
              });
            }
        }).done(function (data) {
          $('#program_name').val(old_program_name);
          let department = $('#department').val();
          var college_name = $('#college_name').val();
          var program_name = $('#program_name').val();
          // alert(department);
          $.ajax({
            type : "POST",
            url: "<?php echo base_url();?>admin/GenerateMerit/fetchCourseGroup",
            dataType : "JSON",
            data : {college_name,department, program_name},
            success: function(msg){
                  resetCourseGroup();
              // console.log(JSON.parse(JSON.stringify(msg)));
              JSON.parse(JSON.stringify(msg)).forEach(element => {
                $('#course_group_name').append(`<option value="${element.course_group_name}">${element.course_group_name}</option>`);
              });
            }
          }).done(function (data) {
            $('#course_group_name').val(course_group_name);
            // let course_group_name = $('#course_group_name').val();
            // alert(department);
            var department = $('#department').val();
            var college_name = $('#college_name').val();
            var program_name = $('#program_name').val();
            $.ajax({
                type : "POST",
                url: "<?php echo base_url();?>admin/GenerateMerit/fetchCourseComponent",
                dataType : "JSON",
                data : {college_name, department, program_name, course_group_name},
                success: function(msg){
                  resetCourse();
                  JSON.parse(JSON.stringify(msg)).forEach(element => {
                    $('#course_name').append(`<option value="${element.course_name}">${element.course_name}</option>`);
                  });
                }
            }).done(function (data) {
              $('#course_name').val(course_name);
            });
          });
        });
      });
      
      $('#college_name').change(function(){
          var college_name = $(this).val();
          $.ajax({
              type : "POST",
              url: "<?php echo base_url();?>admin/GenerateMerit/fetchDepartment",
              dataType : "JSON",
              data : {college_name:college_name},
              success: function(msg){
                resetDepartment();
                JSON.parse(JSON.stringify(msg)).forEach(element => {
                  $('#department').append(`<option value="${element.department}">${element.department}</option>`);
                });
              }
          });
      });
      
      $('#department').change(function(){
          var department = $(this).val();
          var college_name = $('#college_name').val();
          $.ajax({
              type : "POST",
              url: "<?php echo base_url();?>admin/GenerateMerit/fetchProgram",
              dataType : "JSON",
              data : {college_name,department},
              success: function(msg){
                // resetDepartment();
                resetProgram();
                JSON.parse(JSON.stringify(msg)).forEach(element => {
                  $('#program_name').append(`<option value="${element.program_name}">${element.program_name}</option>`);
                });
              }
          });
      });

      $('#program_name').change(function(){
          var department = $('#department').val();
          var college_name = $('#college_name').val();
          var program_name = $(this).val();
          $.ajax({
              type : "POST",
              url: "<?php echo base_url();?>admin/GenerateMerit/fetchCourseGroup",
              dataType : "JSON",
              data : {college_name, department, program_name},
              success: function(msg){
                // resetDepartment();
                // resetProgram();
                resetCourseGroup();
                JSON.parse(JSON.stringify(msg)).forEach(element => {
                  $('#course_group_name').append(`<option value="${element.course_group_name}">${element.course_group_name}</option>`);
                });
              }
          });
      });

      $('#course_group_name').change(function(){
          var course_group_name = $(this).val();
          var department = $('#department').val();
          var college_name = $('#college_name').val();
          var program_name = $('#program_name').val();
          $.ajax({
              type : "POST",
              url: "<?php echo base_url();?>admin/GenerateMerit/fetchCourseComponent",
              dataType : "JSON",
              data : {college_name,department, program_name, course_group_name},
              success: function(msg){
                // resetDepartment();
                // resetProgram();
                // resetCourseGroup();
                resetCourse();
                JSON.parse(JSON.stringify(msg)).forEach(element => {
                  $('#course_name').append(`<option value="${element.course_name}">${element.course_name}</option>`);
                });
              }
          });
      });
    });
</script>