<?php include('header.php'); ?>
<body class="hold-transition register-page">
  <div id="topstrip"><a href="#">Bath & Bark Grooming and Veterinary Services Management System</a></div>
<div class="register-box">
  <div class="register-logo">
    <a href="#"><b>Create</b>Account</a>
  </div>
  <div class="register-box-body">
    <p class="login-box-msg">Please fill in your details below</p>
    <?php 
      if(isset($_GET['status'])){
        if($_GET['status'] == 'created'){
          echo '<div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <p><i class="icon fa fa-check"></i>  Record Successfully Added.<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Your ID number: '.$_GET['cid'].'</p>
                   
                  </div>';
        }if($_GET['status'] == 'error'){
          echo '<div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <p><i class="icon fa fa-remove"></i>  There was a problem creating your account.</p>
                   
                  </div>';
        }
      }
    ?>

    <form action="register_process.php" method="post">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" name="firstname" placeholder="First name" required>
        
      </div>
      <div class="form-group has-feedback">
        <input type="text" class="form-control" name="middlename" placeholder="Middle name" required>
        
      </div>
      <div class="form-group has-feedback">
        <input type="text" class="form-control" name="lastname" placeholder="Last name" required>
        
      </div>
      
      <div class="form-group has-feedback">
        <select class="form-control" name="gender" required>
          <option value="" selected disabled="">Select Gender</option>
          <option>Male</option>
          <option>Female</option>
        </select>

      </div>
      <div class="form-group has-feedback">
        <textarea class="form-control" name="address" placeholder="Address (Street, Barangay, City)" required></textarea>
        
      </div>
      <div class="form-group has-feedback">
        <input type="number" class="form-control" name="phone" placeholder="Phone number (09123456789)" required>
    
      </div>

      <hr>
       <label>User Account</label>
       <hr>
      <div class="form-group has-feedback">
        <input type="text" name="username" class="form-control" placeholder="Username" autocomplete="off" required>

      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" name="password" placeholder="Password (at least 8 characters)" autocomplete="off" required>

      </div>
      <div class="row">
        <div class="col-md-12">
          <button type="submit" name="btnRegister" class="btn btn-success btn-block btn-flat">Register</button>
        </div>
      </div>
    </form>
    <br>
    <a href="<?php echo $baseurl ?>client" class="tex-center">&lArr; Go back</a>
  </div>
  <br>
  <!-- /.form-box -->
</div>
<?php include('footer.php'); ?>
</body>
</html>