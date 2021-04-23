<?php 
session_start();
include('includes/autoload.php');
if(isset($_SESSION['dbu'])){ 
  if($_SESSION['dbc'] != true){
    header("location:".$baseurl."employee/dashboard");
  }else{
    header("location:".$baseurl."client/dashboard");
  }
}
?>
<?php include('header.php'); ?>
<body class="hold-transition login-page">
  <div id="topstrip"><a href="<?php echo $baseurl; ?>">Bath & Bark Grooming and Veterinary Services Management System</a></div>
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b></b>Sign In</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>

    <form action="login_process.php" method="post">
      <div class="form-group has-feedback">
        <input type="text" name="username" class="form-control" placeholder="Username" required>
        <span class="glyphicon glyphicon-user form-control-feedback" autocomplete="off"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Password" required>
        <span class="glyphicon glyphicon-lock form-control-feedback" autocomplete="off"></span>
      </div>
      <div class="row">
        <div class="form-group col-md-12">
          <button type="submit" name="btnLogin" class="btn btn-block btn-skyblue btn-flat">Login</button>
        </div>
      </div>
    </form>
    <div class="row">
      <div class="form-group col-md-12">
         <div class="col-md-6">
           <a href="<?php echo $baseurl ?>client/register" style="float: left">Create an account</a>
         </div>
         <div class="col-md-6">
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
