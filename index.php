<?php include('includes/autoload.php'); ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Welcome to VetCare</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo $baseurl ?>template/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo $baseurl ?>template/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo $baseurl ?>template/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $baseurl ?>template/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo $baseurl ?>template/plugins/iCheck/square/blue.css">

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <style type="text/css">
    #topstrip{
        background: #008d4c;
        padding: 10px;
        font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif;
        font-size: 15px;
        color: #ffffff;
        text-transform: uppercase;
    }
    #topstrip a{
        text-decoration: none;
        color: #ffffff;
    }
  </style>
</head>
<body class="hold-transition login-page">
  <div id="topstrip"><a href="#">VetCare - Online Veterinary Management System</a></div>
<div class="login-box">
  
  <!-- /.login-logo -->
  <div class="login-box-body">
    <div class="login-logo">
      <img width="50%" src="logo.png" alt="Logo Image" />
    </div>

    <form action="index2.html" method="post">
        
      <div class="row">
        <div class="form-group col-md-12">
          <a href="http://localhost/ovms/client" class="btn btn-success btn-block btn-lg">CLIENT LOGIN</a>
        </div>
        <div class="form-group col-md-12">
          <a href="http://localhost/ovms/employee" class="btn btn-success btn-block btn-lg">EMPLOYEE LOGIN</a>
        </div>
      </div>
    </form>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="<?php echo $baseurl ?>template/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo $baseurl ?>template/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?php echo $baseurl ?>template/plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
</body>
</html>
