<?php
if(!isset($_SESSION['username']) || !isset($_SESSION)){
  redirect('admin/login');
}
$module = 'user_master';
$id = $_SESSION['user_id'];
$query = $this->db->get_where($module, array('id' => $id));
$user = $query->result_array();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo PageTitle;?> | <?php echo ucwords(strtolower(str_replace("_", " ",$this->uri->segment(1))));?></title>
  <link rel="shortcut icon" href="<?php echo base_url();?>assets/uploads/favicon.ico"/>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/jqvmap/jqvmap.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/select2/css/select2.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/summernote/summernote-bs4.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- jQuery -->
  <script src="<?php echo base_url();?>assets/plugins/jquery/jquery.min.js"></script>
  <style type="text/css">
    .datepicker .table th,
    .datepicker .table td{
      border: none;
    }
    .text-sm .select2-container--default .select2-selection--single .select2-selection__rendered, select.form-control-sm~.select2-container--default .select2-selection--single .select2-selection__rendered{
      margin-top: -3px !important;
    }
    .text-sm .select2-container--default .select2-selection--single .select2-selection__arrow, select.form-control-sm~.select2-container--default .select2-selection--single .select2-selection__arrow{
      top: 1px !important;
    }
    .text-sm .select2-container--default .select2-selection--single, select.form-control-sm~.select2-container--default .select2-selection--single{
      height: calc(2.25rem + 2px) !important;
    }
    select.is-invalid + .select2-container--default .select2-selection--single{
      border-color: #dc3545;
      padding-right: 2.25rem;
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23dc3545' viewBox='0 0 12 12'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
      background-repeat: no-repeat;
      background-position: right calc(.375em + .1875rem) center;
      background-size: calc(.75em + .375rem) calc(.75em + .375rem);
    }
  </style>
  <style type="text/css">
  form .gmaps,.gmap{
      min-height: 400px;
      max-height: 450px;
      height: auto;
      width: 100% !important;
      position: relative;
      left: 0;
      top: 0px;
      right: 0;
      overflow: hidden;
      z-index: 1;
      margin-bottom: 10PX;
  }
  .fa-clock-o:before{
    content: "\f017";
  }
  .form-group.required label:after,.form-group label.required-label:after {
    content:"*";
    color:red;
  }
</style>
<style type="text/css">
  .zoomin img
  {
   border: 1px solid #dee2e6;
   border-radius: 2px;
  }
  .zoomin:hover img
  {
    transform: scale(1.5);
    transition: .5s ease;
  }
  .custom-file-label::after{
    cursor: pointer;
  }
  .custom-file-input{
    z-index: unset;
  }
</style>
<style type="text/css">
.meter_wrapper{
 border:1px solid #f3f4f7;
 /*margin-left:38%;*/
 margin-top:5px;
 /*width:200px;*/
 height:15px;
 border-radius:10px;
}
.meter{
 width:0px;
 height:13px;
 border-radius:10px;
}
.pass_type{
    font-size: 12px;
    text-align: center;
    color: inherit;
    position: relative;
    bottom: 16px;
    width: 97.2%;
}
input[type="file"] {
    line-height: 1 !important;
}
.add-btn{
  padding: 0px 0px 0px 35px;
}
.form-heading{
  border-bottom: 1px solid #e9ecef !important;
  margin: 0px 8px;
  max-width: 98.5%;
  padding-left: 0px;
  margin-bottom: 5px;
}
.form-heading h3 {
    color: #007bff;
    background-color: #8986862b;
    padding: 5px 10px;
    border-radius: 5px 5px 0px 0px;
}
</style>
<script>  
    var by_default_page_length = '<?php echo get_setting_value_by_name('by_default_listing') ?>';
    var page_length_dropdown =   <?php echo get_page_length_dropdown(); ?>;
</script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/dist/css/style.css">
</head>