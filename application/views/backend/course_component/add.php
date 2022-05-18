<?php $user_role = $_SESSION['user_role']; ?>
<?php $add_permission = $this->permission->grant(COURSE_COMPONENT,'add'); ?> 
<?php $edit_permission = $this->permission->grant(COURSE_COMPONENT,'edit'); ?>
<?php $delete_permission = $this->permission->grant(COURSE_COMPONENT,'delete'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><?php if(isset($record['id'])){ echo 'Update';}else{ echo 'Add'; } ?> Course Component</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/CourseComponent">Course Component</a></li>
            <li class="breadcrumb-item active"><?php if(isset($record['id'])){ echo 'Update';}else{ echo 'Add'; } ?> Course Component</li>
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
              <h3 class="card-title"><?php if(isset($record['id'])){ echo 'Update';}else{ echo 'Add'; } ?> Course Component</h3>
            </div>
            <!-- /.card-header -->
              <form data-toggle="validator" role="form" method='POST' class="form-horizontal" action='<?php echo base_url();?>admin/CourseComponent/<?php if(isset($record['id'])){ echo 'edit/'.base64_encode($record['id']);}else{ echo 'add'; } ?>' id="add-form" name="add-form" enctype='multipart/form-data'>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="college_name">College Name</label>
                      <!-- <input type="text" name="college_name" class="form-control" id="college_name" placeholder="" value="<?php if(isset($record['college_name'])){ echo $record['college_name'];} ?>"> -->
                      <select name="college_name" id="college_name" class="form-control select2" required>
                        <option value="">Select College Name</option>
                        <?php
                        foreach ($colleges as $key => $value) { ?>
                          <option value="<?= $value['id']; ?>" <?php if(isset($record['college_name'])) if($record['college_name'] == $value['id']){ echo 'selected'; } ?>><?= $value['college_name']; ?></option>
                        <?php }
                        ?>
                      </select>
                    </div>
                  </div>
                  <?php $department = (isset($record['department'])) ? $record['department'] : ''; ?>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="department">Department</label>
                      <!-- <input type="text" name="department" class="form-control" required id="department" placeholder="" value="<?php if(isset($record['department'])){ echo $record['department'];} ?>"> -->
                      <select name="department" id="department" class="form-control select2" required>
                        <option value="">Select Department</option>
                      </select>
                    </div>
                  </div>
                  <?php $program_name = (isset($record['program_name'])) ? $record['program_name'] : ''; ?>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="program_name">Program</label>
                      <!-- <input type="text" name="program_name" class="form-control" required id="program_name" placeholder="" value="<?php if(isset($record['program_name'])){ echo $record['program_name'];} ?>"> -->
                      <select name="program_name" id="program_name" class="form-control select2" required>
                        <option value="">Select Program</option>
                      </select>
                    </div>
                  </div>
                  <?php $course_group_name = (isset($record['course_group_name'])) ? $record['course_group_name'] : ''; //print_r($record); die();?>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="course_group_name">Course Group Name</label>
                      <!-- <input type="text" name="course_group_name" class="form-control" required id="course_group_name" placeholder="" value="<?php if(isset($record['course_group_name'])){ echo $record['course_group_name'];} ?>"> -->
                      <select name="course_group_name" id="course_group_name" class="form-control select2" required>
                        <option value="">Select Course Group</option>
                      </select>
                    </div>
                  </div>
                  <?php $course_name = (isset($record['course_name'])) ? $record['course_name'] : ''; //print_r($record); die();?>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="course_name">Course Name</label>
                      <!-- <input type="text" name="course_name" class="form-control" required id="course_name" placeholder="" value="<?php if(isset($record['course_name'])){ echo $record['course_name'];} ?>"> -->
                      <select name="course_name" id="course_name" class="form-control select2" required>
                        <option value="">Select Course</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="course_component_name">Course Component Name</label>
                      <input type="text" name="course_component_name" class="form-control" required id="course_component_name" placeholder="" value="<?php if(isset($record['course_component_name'])){ echo $record['course_component_name'];} ?>">
                    </div>
                  </div>
                  
                  <div class="col-md-4"> 
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
                  </div>
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
        url: "<?php echo base_url();?>admin/CourseComponent/fetchDepartment",
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
            url: "<?php echo base_url();?>admin/Course/fetchProgram",
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
            url: "<?php echo base_url();?>admin/CourseComponent/fetchCourseGroup",
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
                url: "<?php echo base_url();?>admin/CourseComponent/fetchCourseComponent",
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
              url: "<?php echo base_url();?>admin/CourseComponent/fetchDepartment",
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
              url: "<?php echo base_url();?>admin/CourseComponent/fetchProgram",
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
              url: "<?php echo base_url();?>admin/Course/fetchCourseGroup",
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
              url: "<?php echo base_url();?>admin/CourseComponent/fetchCourseComponent",
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