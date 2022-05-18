  <footer class="main-footer text-sm">
    <strong>Copyright &copy; <?php echo date('Y');?> <a href="<?php echo base_url();?>"></a>Collection</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0.0
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<!-- spinner modal -->
<div class="modal fade" id="modal-loader">
  <div class="modal-dialog modal-dialog-centered" style="width:150px;">
    <div class="modal-content">
    <img style="width:150px;" src="<?php echo base_url();?>assets/dist/img/spinner.gif">
    <h5 class="text-primary text-center">Loading...</h5>
    </div>
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- /.spinner modal -->
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url();?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- jquery-validation -->
<script src="<?php echo base_url();?>assets/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/jquery-validation/additional-methods.min.js"></script>
<!-- Select2 -->
<script src="<?php echo base_url();?>assets/plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url();?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Select2 -->
<!-- <script src="<?php //echo base_url();?>assets/plugins/select2/js/select2.full.min.js"></script> -->
<!-- ChartJS -->
<script src="<?php echo base_url();?>assets/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo base_url();?>assets/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="<?php echo base_url();?>assets/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url();?>assets/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo base_url();?>assets/plugins/moment/moment.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="<?php echo base_url();?>assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo base_url();?>assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Bootstrap Switch -->
<script src="<?php echo base_url();?>assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- Summernote -->
<script src="<?php echo base_url();?>assets/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?php echo base_url();?>assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- DataTables -->
<script src="<?php echo base_url();?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- bs-custom-file-input -->
<script src="<?php echo base_url();?>assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url();?>assets/dist/js/adminlte.js"></script>
<?php if(current_url() == base_url('dashboard')){ ?>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo base_url();?>assets/dist/js/pages/dashboard.js"></script>
<?php } ?>
<!-- AdminLTE for demo purposes -->
<!-- <script src="<?php echo base_url();?>assets/dist/js/demo.js"></script> -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
      "aaSorting":[]
    });
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
      "aaSorting":[]
    });
  });
</script>
<script type="text/javascript">
<?php if($this->session->flashdata('success')){ ?>
  $(document).Toasts('create', {
    class: 'bg-success success-msg', 
    title: 'Success',
    autohide: true,
    delay: 3000,
    //subtitle: 'Subtitle',
    body: '<?php echo $this->session->flashdata('success'); ?>'
  });
<?php }else if($this->session->flashdata('error')){  ?>
  $(document).Toasts('create', {
    class: 'bg-danger danger-msg', 
    title: 'Error',
    autohide: true,
    delay: 3000,
    //subtitle: 'Subtitle',
    body: '<?php echo $this->session->flashdata('error'); ?>'
  });
<?php } ?>

function success_msg(status,msg){
setTimeout(function(){
    if(status == 0){
      $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Error',
        //subtitle: 'Subtitle',
        autohide: true,
        delay: 3000,
        body: msg
      });
    }else{
      $(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Success',
        //subtitle: 'Subtitle',
        autohide: true,
        delay: 3000,
        body: msg
      });
    }
  },1000);
}
function close_loader(event){
  event.preventDefault();
  $('#modal-loader').modal('hide');
}
</script>
<script type="text/javascript">
function form_validation(formclass){
$(formclass).validate({
    errorElement: 'span',
    /*errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      if (element.closest('.form-group > div').length > 0) {
          // Do your code here
          console.log(element.closest('.form-group > div').length);
          element.closest('.form-group > div').append(error);
      }else{
        element.closest('.form-group').append(error);
      }
    },*/
    errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        if(element.hasClass('select2') && element.next('.select2-container').length) {
          error.insertAfter(element.next('.select2-container'));
        } else if (element.parent('.input-group').length) {
            error.insertAfter(element.parent());
        }
        else if (element.prop('type') === 'radio' && element.parent('.radio-inline').length) {
            error.insertAfter(element.parent().parent());
        }
        else if (element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
            error.appendTo(element.parent().parent());
        }
        else {
            error.insertAfter(element);
        }
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });
}
form_validation('.form-horizontal');
form_validation('.form-horizontal2');
</script>
<script type="text/javascript"> 
function isNumber(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode != 43 && charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
</script>
<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
  //Initialize Select2 Elements
  $('.select2').select2();
 
});
</script>
<?php /* ?>
<script src="<?php echo base_url();?>assets/dist/js/lineloader/lineloader.js"></script>
<?php */ ?>
<script type="text/javascript">
  $('.date-picker').datetimepicker({
        //format: 'L',
        format: 'DD-MM-YYYY'
  });
  $('.time-picker').datetimepicker({
        //format: 'LT',
        format: 'HH:mm'
  });
  $('.datetime-picker').datetimepicker({
        //format: 'LT',
        format: 'DD-MM-YYYY HH:mm'
  });
  $('.datetimepicker-input').on('click',function(){
      //console.log('hello');
      $(this).next('.input-group-append').trigger('click');
  });
  $('.select2').select2();

  //Colorpicker
  $('.my-colorpicker1').colorpicker()
    //color picker with addon
  $('.my-colorpicker2').colorpicker()

  $('.my-colorpicker2').on('colorpickerChange', function(event) {
    $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
  });

  $("input[data-bootstrap-switch]").each(function(){
    $(this).bootstrapSwitch('state', $(this).prop('checked'));
  });

  /*$('input[type=text]').keypress(function (e) {
      var code = ('charCode' in e) ? e.charCode : e.keyCode;
      if (!(code == 32) && // space
        !(code == 45) && // -
        !(code > 47 && code < 58) && // numeric (0-9)
        !(code > 64 && code < 91) && // upper alpha (A-Z)
        !(code > 96 && code < 123)) { // lower alpha (a-z)
        e.preventDefault();
        return false;
      }
      return true;
  });

  $('input[type=email]').keypress(function (e) {
    
  });*/

  setInterval(function(){
    $('input[type=email],#email').attr("pattern","[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$");
    $('#phone_no,#phone_no_edit,#mobile_no').attr("maxlength","13");
    $('#phone_no,#phone_no_edit,#mobile_no').attr("minlength","10");
    //$('#phone_no,#phone_no_edit,#mobile_no').attr("pattern","[1-9]{1}[0-9]{9}");
    //$('#phone_no,#phone_no_edit,#mobile_no').attr("pattern",'[0-9]');
    $('input[type=password]').attr("pattern",".{6,16}");
    $('input[type=password]').attr("title","Minimum Password Length is 6");
    $('#phone_no,#phone_no_edit,#mobile_no').keypress(function (e) {
      var regex = new RegExp("^[0-9]+$");
      var regex2 = new RegExp("^[1-9]+$");
      var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
      var phone_val = $(this).val();
      console.log(phone_val.length);
      if(phone_val == '' && !regex2.test(str)) {
          return false;
      }
      if (regex.test(str)) {
          return true;
      }
      e.preventDefault();
      return false;
    });

    $('#firstname_edit,#lastname_edit,#firstname,#lastname,#role,#role_edit,#userlevel,#userlevel_edit').keypress(function (e) {
      var code = ('charCode' in e) ? e.charCode : e.keyCode;
      if (!(code == 32) && // space
        !(code == 45) && // -
        //!(code > 47 && code < 58) && // numeric (0-9)
        !(code > 64 && code < 91) && // upper alpha (A-Z)
        !(code > 96 && code < 123)) { // lower alpha (a-z)
        e.preventDefault();
        return false;
      }
      return true;
  });


  $("#range,#range_edit").keypress(function (e){
      var str = $(this).val();
      var arr = str.split("-");
      if(arr.length > 2){
        return false;
      }
      //if the letter is not digit then display error and don't type anything
      if (e.which != 8 && e.which != 0 && String.fromCharCode(e.which) != '-' 
        && (e.which < 48 || e.which > 57)) {
          //display error message
          return false;
      }
  });

  //$("#password, #cpassword").keyup(checkPasswordMatch($("#password").val(),$("#cpassword").val(),"#divCheckPasswordMatch","#btn_save"));
    
  //$("#password_edit, #cpassword_edit").keyup(checkPasswordMatch($("#password_edit").val(),$("#cpassword_edit").val(),"#divCheckPasswordMatch_edit","#btn_update"));

  $("input").on("keypress", function(e) {
    //alert($(this).attr('type'));
    //if($(this).attr('type') != 'password'){
      if (e.which === 32 && !this.value.length){
        e.preventDefault();
      }
    //}
  });

  $('.modal').on('hidden.bs.modal', function(){
    $('#add-form')[0].reset();
    $('#add-form').find(".select2").trigger('change');
    $('#meter_wrapper').css('display','none');
    $('#divCheckPasswordMatch').css('display','none');
  });

 

  },1000);

  $("#password, #cpassword").on("keyup", function(e){
    checkPasswordMatch($("#password").val(),$("#cpassword").val(),"#divCheckPasswordMatch","#btn_save");
    check_pass($("#password").val(),$("#cpassword").val(),"#btn_save",'');
  });

  function user_edit(){
    $("#password_edit, #cpassword_edit").on("keyup", function(e){
      checkPasswordMatch($("#password_edit").val(),$("#cpassword_edit").val(),"#divCheckPasswordMatch_edit","#btn_update");
      check_pass($("#password_edit").val(),$("#cpassword_edit").val(),"#btn_update",'_edit');
    });
  }

  function slug(){
  
    $(".convert-into-slug").on("keyup", function(e){
      var str = $(this).val();
      var id = $(this).attr('data-slug');
        //replace all special characters | symbols with a space
        str = str.replace(/[`~!@#$%^&*()_\-+=\[\]{};:'"\\|\/,.<>?\s]/g, ' ').toLowerCase();
        // trim spaces at start and end of string
        str = str.replace(/^\s+|\s+$/gm,'');
        // replace space with dash/hyphen
        str = str.replace(/\s+/g, '-');
        document.getElementById(id).value= str;
        //return str;
    });
  }
  slug();
</script>
<script type="text/javascript">
function checkPasswordMatch(password,confirmPassword,hashID,btn) {
    //var password = $("#password").val();
    //var confirmPassword = $("#cpassword").val();
    $(hashID).html("");
    $(btn).prop('disabled',false);
    if(password != '' && confirmPassword != ''){
      if(password != confirmPassword){
          $(hashID).html("<span class='text-danger'>Passwords do not match!</span>");
          $(btn).prop('disabled',true);
      }else{
          $(hashID).html("<span class='text-success'>Passwords match.</span>");
          $(btn).prop('disabled',false);
      }
    }
}
</script>
<script type="text/javascript">
//var meter_wrapper = document.getElementById("meter_wrapper");
//var meter_wrapper2 = document.getElementById("meter_wrapper_edit");
//meter_wrapper.style.display = meter_wrapper2.style.display = 'none';
function check_pass(password,cpassword,btn,id)
{
  //alert(password);
 var val = password;//document.getElementById(id).value;
 var meter = document.getElementById("meter"+id);
 var meter_wrapper = document.getElementById("meter_wrapper"+id);
 if(val == null){
    val = "";
 }
 var no=0;
 if(val!="")
 {
  //console.log('Hello : '+val);
  meter_wrapper.style.display = 'block';
  // If the password length is less than or equal to 6
  if(val.length<5){
    no=1;
  }
  // If the password length is greater than 6 and contain any lowercase alphabet or any number or any special character
  if(val.length>=6 && (val.match(/[a-z]/) || val.match(/\d+/) || val.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/))){
    no=2;
  }
  // If the password length is greater than 6 and contain alphabet,number,special character respectively
  if(val.length>=6 && ((val.match(/[a-z]/) && val.match(/\d+/)) || (val.match(/\d+/) && val.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/)) || (val.match(/[a-z]/) && val.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/)))){
    no=3;
  }

  // If the password length is greater than 6 and must contain alphabets,numbers and special characters
  if(val.length>=6 && val.match(/[a-z]/) && val.match(/[A-Z]/) && val.match(/\d+/) && val.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/)){
    no=4;
  }

  if(no==1)
  {
   $("#meter"+id).animate({width:'25%'},100);
   meter.style.backgroundColor="red";
   document.getElementById("pass_type"+id).innerHTML="Very Weak";
  }

  if(no==2)
  {
   $("#meter"+id).animate({width:'50%'},100);
   meter.style.backgroundColor="#F5BCA9";
   document.getElementById("pass_type"+id).innerHTML="Weak";
  }

  if(no==3)
  {
   $("#meter"+id).animate({width:'75%'},100);
   meter.style.backgroundColor="#FF8000";
   document.getElementById("pass_type"+id).innerHTML="Good";
  }

  if(no==4)
  {
   $("#meter"+id).animate({width:'100%'},100);
   meter.style.backgroundColor="#00FF40";
   document.getElementById("pass_type"+id).innerHTML="Strong";
  }
 }

 else
 {
  meter_wrapper.style.display = 'none';
  meter.style.backgroundColor="white";
  document.getElementById("pass_type"+id).innerHTML="";
 }
 //console.log('no'+no);
 if(no == 4){
  //alert('Please enter strong password.');
  $(btn).prop('disabled',false); 
  //return false;
  if(password != cpassword){
    $(btn).prop('disabled',true); 
  }
 }else{
  $(btn).prop('disabled',true); 
  //return true;
 }
}

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
</script>

</body>
</html>