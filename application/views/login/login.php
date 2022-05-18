<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo PageTitle;?> | Log in</title>
  <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url() . FaviconURL;?>">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/dist/css/adminlte.min.css">
  <style type="text/css">
    .has-error .checkbox, .has-error .checkbox-inline, .has-error .control-label, .has-error .help-block, .has-error .radio, .has-error .radio-inline, .has-error.checkbox label, .has-error.checkbox-inline label, .has-error.radio label, .has-error.radio-inline label {
          color: #ff5370;
      }
      .help-block {
          display: block;
          margin-top: 5px;
          margin-bottom: 10px;
          color: #737373;
      }
      .has-error .form-control {
          border-color: #ff5370;
          -webkit-box-shadow: inset 0 1px 1px rgb(0 0 0 / 8%);
          box-shadow: inset 0 1px 1px rgb(0 0 0 / 8%);
      }
      .mt-btn{
        margin-top:5px;
      }
      .select2-container--default .select2-selection--single .select2-selection__rendered{
        background-color: unset !important;
        color:#444 !important;
        padding: 3.5px .75rem;
      }
      .select2-container--default .select2-selection--single{
        font-size: 14px;
        border-radius: 2px;
        border: 1px solid #ccc;
      }
      .select2-container--default .select2-selection--single .select2-selection__arrow b {
          border-color: #444 transparent transparent transparent;
      }
      .select2-container--default .select2-selection--single .select2-selection__arrow{
          top: 5px;
          right:5px;
      }

      .growl-animated.alert-success {
          box-shadow: 0 0 5px rgb(76 175 80 / 50%);
          background-color: #2ed8b6;
          color: #ffff;
      }
      .growl-animated.alert-danger {
          box-shadow: 0 0 5px rgb(76 175 80 / 50%);
          background-color: #ff5370;
          color: #ffff;
      }
      button.close{
        margin-top: 3px;
      }
  </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <!-- <img style="width:200px;" src="<?php echo base_url();?>assets/uploads/logo.png" alt="Logo"> -->
    </div>
    <div class="card-body">
      <p class="login-box-msg">Login</p>

      <form class="" action="<?php echo base_url();?>admin/login/Auth" method="post" data-toggle="validator">
        <div class="form-group input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="help-block with-errors"></div>
        <div class="form-group input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="help-block with-errors"></div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" name="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <?php /* ?>
      <div class="social-auth-links text-center mt-2 mb-3">
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
        </a>
      </div>
      <!-- /.social-auth-links -->
      
      <p class="mb-1">
        <a href="forgot-password.html">I forgot my password</a>
      </p>
      <p class="mb-0">
        <a href="register.html" class="text-center">Register a new membership</a>
      </p>
      <?php */ ?>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="<?php echo base_url();?>assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url();?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url(); ?>assets/dist/js/bootstrap-validator.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url();?>assets/dist/js/adminlte.min.js"></script>
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
</script>
</body>
</html>