<script type="text/javascript">
$(document).ready(function(){
  $("form").submit(function() {
    // submit more than once return false
    $(this).submit(function() {
        return false;
    });
    // submit once return true
    return true;

  });
});

/*function notification(type,notify_message){
  $.notify({
            // options
            message: notify_message 
          },{
            // settings
            type: type, 
            offset: {
                 y: 20, 
                 x: 0
            },
            spacing: 5,
            z_index: 1031,
            delay: 5000,
            timer: 1000,
            placement: {
                from: 'top', 
                align: 'center'
            },
            animate: {
                enter: 'animated fadeInDown',
                exit: 'animated fadeOutUp'
            }
  });
}

<?php /*if($this->session->userdata('insert')){ $this->session->unset_userdata('insert'); ?>
      
    notification('success','Record inserted successfully!.');

<?php }else if($this->session->userdata('calender_error')){ $this->session->unset_userdata('calender_error'); ?>
      
    notification('danger','Please insert valid date range.');

<?php }else if($this->session->userdata('empty')){ $this->session->unset_userdata('empty'); ?>
      
    notification('success','Please insert the require data.');
   
<?php } else if($this->session->userdata('update')){ $this->session->unset_userdata('update'); ?>
   
    notification('success','Record updated successfully!.');

<?php } else if($this->session->userdata('delete')){ $this->session->unset_userdata('delete'); ?>
   
    notification('danger','Record deleted successfully!.');


<?php } else if($this->session->userdata('error_require_data')){ $this->session->unset_userdata('error_require_data'); ?>
   
   notification('danger','Please enter all require data.');

<?php } else if($this->session->userdata('date_error')){ $this->session->unset_userdata('date_error'); ?>
   
   notification('danger','Not able to mark future attendance!');

<?php } else if($this->session->userdata('date_error_1')){ $this->session->unset_userdata('date_error_1'); ?>
   
   notification('danger','Not able to mark previous month attendance!');

<?php } else if($this->session->userdata('error')){ $this->session->unset_userdata('error'); ?>
   
   notification('danger','Something went wrong, Please try again.');
   
<?php } else if($this->session->userdata('status_update')){ $this->session->unset_userdata('status_update'); ?>
   
    notification('success','Status changed successfully!.');
   
<?php }*/ ?>

// To hide flash message in 3 seconds
//var timeout = 3000;
//$('.alert').delay(timeout).fadeOut(300);

// Status Change JS Start
   
/* $(function() {
   
  $('.toggle_change_status').click(function() {   
    var id = $(this).attr('id');
    var status = $(this).attr('data-value');
    var table = $('#table').val();
     
    swal({
       title: "Are you sure?",
       text: "Do you really want to change the status?",
       icon: "warning",
       buttons: true,
       dangerMode: true,
     })
    .then((willDelete) => {
       if (willDelete) {
           $.ajax({
               url: SITEURL+"common/changeStatus",
               type: 'POST',
               dataType: 'JSON',
               data: {id:id,status:status,table:table},
               success: function(data) {              
                   if(data.str == "OK"){                   
                       setTimeout(function(){ location.reload(); }, 0);
                   }
               }
           });
       
       } else {
           swal("Status is not change!");
           setTimeout(function(){ location.reload(); }, 2000);
       }
    });
  });

  $("#example-advance-1,.cell-border").on("click", ".toggle_delete_record", function(){
     var id = $(this).attr('id');
     var table = $('#table').val();
     swal({
       title: "Are you sure?",
       text: "Do you really want to delete this record?",
       icon: "warning",
       buttons: true,
       dangerMode: true,
     })
     .then((willDelete) => {
       if (willDelete) {
           $.ajax({
               url: SITEURL+"common/deleteRecord",
               type: 'POST',
               dataType: 'JSON',
               data: {id:id,table:table},
               success: function(data) {  
                   console.log(data);            
                   if(data.str == "OK"){                   
                     window.location.reload();
                 }
             }
         });
      } 
    });
     
  });
     
  $('.toggle_delete_record_multiple').click(function() {
     
     var id = $(this).attr('id');
     var table = $('#table').val();
     
     swal({
       title: "Are you sure?",
       text: "Do you really want to delete this record?",
       icon: "warning",
       buttons: true,
       dangerMode: true,
     })
     .then((willDelete) => {
       if (willDelete) {
     
         $.ajax({
             url: SITEURL+"Common/DeleteRecordMultiple",
             type: 'POST',
             dataType: 'JSON',
             data: {id:id,table:table},
             success: function(data) {              
                 if(data.str == "OK"){                   
                   window.location.reload();
               }
           }
       });
     
     } 
     });
     
  });
   
});
*/ 
// Status Change JS End

  function Numericdotonly(event, id) {
    // alert('lay le');
    var Key = (event.keyCode ? event.keyCode : event.which);
    
    if (Key != 9 && Key != 8 && Key != 46 && (Key < 48
    || Key > 57)) {
        event.preventDefault();
        return false;
    } // prevent if not number/dot           
    var character = document.getElementById(id).value;
    if (Key == 46 && character.indexOf('.') != -1) {
        return false;
    }
    return true;
  }

  function Select(Select, checkboxlist) {
    var Cntrol;
    console.log(document.forms[0]);
    for (var n = 0; n < document.forms[0].length; n++) {
        if (document.forms[0].elements[n].type == 'checkbox') {
            Cntrol = document.forms[0].elements[n].id;
            if (Cntrol.substring(0, 14) != "cb_WeighBridge") {

                if (Cntrol.indexOf(checkboxlist.id) != -1) {
                    document.forms[0].elements[n].checked = Select;
                }
            }
        }
    }
    return false;
  }

  $('input[type=number]').bind('keypress', function(event) {
      var Key = (event.keyCode ? event.keyCode : event.which);
      if (Key == 101) {
        return false;
      }
  });

  $('#from_date').on('change', function(){
    var val = this.value;
    var val2 = $('#to_date').val();
    var from_date = new Date(val);
    var to_date = new Date(val2);
    if(from_date > to_date){
      $('#to_date').val('');
    }
    $("#to_date").removeAttr("min");
    $("#to_date").removeAttr("max");
    $('#to_date').attr('min',val);
  });
  $('#to_date').on('change', function(){
    var val = this.value;
    var val2 = $('#from_date').val();
    var from_date = new Date(val2);
    var to_date = new Date(val);
    console.log(val2 + " " + val);
    if(from_date > to_date){
      $('#from_date').val('');
    }
    //alert(val);
    $("#from_date").removeAttr("min");
    $("#from_date").removeAttr("max");
    $('#from_date').attr('min','');
    $('#from_date').attr('max',val);
  });

  $('input[type=text]').keypress(function (e) {
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

  function onlyAlphabets(e) {
    var code = ('charCode' in e) ? e.charCode : e.keyCode;
    if (!(code == 32) && // space
      !(code > 64 && code < 91) && // upper alpha (A-Z)
      !(code > 96 && code < 123)) { // lower alpha (a-z)
      e.preventDefault();
      return false;
    }
    return true;
  }

  function email_validation(inputText) 
  {
    var mailformat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    if(inputText.match(mailformat))
    {
      alert("Valid email address!");
      document.form1.text1.focus();
      return true;
    }
    else
    {
      alert("You have entered an invalid email address!");
      document.form1.text1.focus();
      return false;
    }
  }

  $('input[type=text],input[type=email]').keydown(function (e) {
    if (this.value.length === 0 && e.which === 32) e.preventDefault();
  });

  setInterval(function(){
    $('#phone_no,#phone_no_edit,#mobile_no').attr("maxlength","10");
    $('#phone_no,#phone_no_edit,#mobile_no').attr("pattern","[6-9]{1}[0-9]{9}");
    $('#phone_no,#phone_no_edit,#mobile_no').keypress(function (e) {
      var regex = new RegExp("^[0-9]+$");
      var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
      if (regex.test(str)) {
          return true;
      }
      e.preventDefault();
      return false;
    });
  },1000);
</script>