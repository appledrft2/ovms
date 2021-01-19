<?php include('header.php'); ?>
<body class="hold-transition login-page">
  <div id="topstrip"><a href="#">OVMS | Online Veterinary Management System</a></div>
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>Client</b>Login</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>
    <?php 
      if(isset($_GET['status'])){
        if($_GET['status'] == 'created'){
          echo '<div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <p><i class="icon fa fa-check"></i>  Record Successfully Added.</p>
                   
                  </div>';
        }if($_GET['status'] == 'updated'){
          echo '<div class="alert alert-info alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <p><i class="icon fa fa-info"></i>  Record Successfully Updated.</p>
                   
                  </div>';
        }if($_GET['status'] == 'deleted'){
          echo '<div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <p><i class="icon fa fa-remove"></i>  Record Successfully Deleted.</p>
                   
                  </div>';
        }
      }
    ?>
    <form action="index2.html" method="post">
      <div class="form-group has-feedback">
        <input type="email" class="form-control" placeholder="Email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
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
           <a href="" style="float: left">Create an account</a>
         </div>
         <div class="col-md-6">
           <a href="" style="float: right">Forgot Password?</a>
         </div>
      </div>
      <div class="col-md-12">
           <div class="col-md-12">
             <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" style="float: left">&lArr; Go back</a>
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
