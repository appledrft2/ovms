<?php 
session_start();
include('../includes/autoload.php');
if(isset($_SESSION['dbu'])){ 
  if($_SESSION['dbc'] != false){
    header("location:".$baseurl."client/dashboard");
  }else{
    header("location:".$baseurl."employee/dashboard");
  }
}
?>
<?php include('header.php'); ?>
<body class="hold-transition login-page">
  <div id="topstrip"><a href="#">Bath & Bark Grooming and Veterinary Services Management System</a></div>
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>Employee</b>Login</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>

    <form action="login_process.php" method="post">
      <div class="form-group has-feedback">
        <input type="text" name="email-user" class="form-control" placeholder="Email or Username">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="form-group col-md-12">
          <button type="submit" name="btnLogin" class="btn btn-success btn-block btn-flat">Login</button>
        </div>
      </div>
    </form>
    <div class="row">
      
      <div class="col-md-12">
           <div class="col-md-12">
             <a href="<?php echo $baseurl ?>" style="float: left">&lArr; Go back</a>
           </div>
      </div>
    </div>

  </div>
  <!-- /.login-box-body -->
  <?php 
    if(isset($_GET['error'])){

      echo "<br><span class='alert alert-danger col-md-12 '>Login Failed: Credentials do not match our records.</span>";
    }
  ?>
</div>
<!-- /.login-box -->

<?php include('footer.php'); ?>
</body>
</html>
