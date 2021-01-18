<?php include('header.php'); ?>
<body class="hold-transition login-page">
  <div id="topstrip"><a href="#">VetCare - Online Veterinary Management System</a></div>
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>Client</b>Login</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>

    <form action="index2.html" method="post">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Username">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="form-group col-md-12">
          <button type="submit" class="btn btn-success btn-block btn-flat">Login</button>
        </div>
      </div>
    </form>
    <div class="row">
      <div class="form-group col-md-12">
         <div class="col-md-6">
           <a href="<?php echo $baseurl ?>client/register" style="float: left">Create an account</a>
         </div>
         <div class="col-md-6">
           <a href="<?php echo $baseurl ?>client/reset" style="float: right">Forgot Password?</a>
         </div>
      </div>
      <div class="col-md-12">
           <div class="col-md-12">
             <a href="<?php echo $baseurl ?>" style="float: left">&lArr; Go back</a>
           </div>
      </div>
    </div>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<?php include('footer.php'); ?>
</body>
</html>
