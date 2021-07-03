<?php
session_start();
include('../../includes/autoload.php');
$fname = $mname = $lname = $email = $gender = $address = $phone = '';
$message = '';

if (isset($_POST['btnRegister'])) {
  $fname = $_POST['firstname'];
  $mname = $_POST['middlename'];
  $lname = $_POST['lastname'];
  $email = $_POST['email'];
  $gender = $_POST['gender'];
  $address = $_POST['address'];
  $phone = $_POST['phone'];
  $username = $_POST['username'];
  $sql = "SELECT u.username FROM tbl_user AS u INNER JOIN tbl_client AS c ON c.id = u.user_id WHERE u.username=? OR c.email=?";
  $qry = $connection->prepare($sql);
  $qry->bind_param('ss', $username, $email);
  $qry->execute();
  $qry->bind_result($dbusername);
  $qry->store_result();
  $qry->fetch();

  if ($qry->num_rows() > 0) {

    $message = '<div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <p><i class="icon fa fa-remove"></i>  The username or email is already taken.</p>
                 
                </div>';
  } else {

    $client_num = "CID" . rand(19999, 29999);
    $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $sql = "INSERT INTO tbl_client(firstname,middlename,lastname,username,gender,address,phone,password,client_num) VALUES(?,?,?,?,?,?,?,?,?)";
    $qry = $connection->prepare($sql);
    $qry->bind_param("sssssssss", $_POST['firstname'], $_POST['middlename'], $_POST['lastname'], $username, $_POST['gender'], $_POST['address'], $_POST['phone'], $hashed_password, $client_num);

    if ($qry->execute()) {

      $last_id = mysqli_insert_id($connection);
      $role = "client";
      $sql2 = "INSERT INTO tbl_user(username,password,role,user_id) VALUES(?,?,?,?)";
      $qry2 = $connection->prepare($sql2);
      $qry2->bind_param("sssi", $_POST['username'], $hashed_password, $role, $last_id);
      $qry2->execute();

      header('location:index.php?status=created');
    } else {
      echo '<meta http-equiv="refresh" content="0; URL=index.php?status=error">';
    }
  }
}
include('header.php');
?>

<body class="hold-transition register-page">
  <div id="topstrip"><a href="#">Bath & Bark Grooming and Veterinary Services Management System</a></div>
  <div class="register-box">
    <div class="register-logo">
      <a href="#"><b>Create</b>Account</a>
    </div>
    <div class="register-box-body">
      <p class="login-box-msg">Please fill in your details below</p>
      <?php
      if (isset($_GET['status'])) {
        if ($_GET['status'] == 'created') {
          echo '<div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <p><i class="icon fa fa-check"></i>  Record Successfully Added.</p>
                   
                  </div>';
        }
        if ($_GET['status'] == 'error') {
          echo '<div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <p><i class="icon fa fa-remove"></i>  There was a problem creating your account.</p>
                   
                  </div>';
        }
      }

      echo $message;
      ?>

      <form action="#" method="post">
        <div class="form-group has-feedback">
          <input type="text" class="form-control" name="firstname" minlength="3" placeholder="First name" value="<?php echo $fname ?>" required>

        </div>
        <div class="form-group has-feedback">
          <input type="text" class="form-control" name="middlename" minlength="3" placeholder="Middle name" value="<?php echo $mname ?>" required>

        </div>
        <div class="form-group has-feedback">
          <input type="text" class="form-control" name="lastname" minlength="3" placeholder="Last name" value="<?php echo $lname ?>" required>
        </div>
        <div class="form-group has-feedback">
          <input type="email" class="form-control" name="email" placeholder="Email Address" value="<?php echo $email ?>" required>
        </div>

        <div class="form-group has-feedback">
          <select class="form-control" name="gender" required>
            <option value="" selected disabled="">Select Gender</option>
            <option <?php if ($gender == 'Male') {
                      echo 'selected';
                    } ?>>Male</option>
            <option <?php if ($gender == 'Female') {
                      echo 'selected';
                    } ?>>Female</option>
          </select>

        </div>
        <div class="form-group has-feedback">
          <textarea class="form-control" name="address" placeholder="Address (Street, Barangay, City)" required><?php echo $address; ?></textarea>

        </div>
        <div class="form-group has-feedback">
          <input type="number" class="form-control" name="phone" value="<?php echo $phone ?>" placeholder="Phone number (09123456789)" required>

        </div>

        <hr>
        <label>User Account</label>
        <hr>
        <div class="form-group has-feedback">
          <input type="text" name="username" class="form-control" placeholder="Username" autocomplete="off" required>

        </div>
        <div class="form-group has-feedback">
          <input type="password" class="form-control" name="password" minlength="8" placeholder="Password (at least 8 characters)" autocomplete="off" required>

        </div>
        <div class="row">
          <div class="col-md-12">
            <button type="submit" name="btnRegister" class="btn btn-skyblue btn-block btn-flat">Register</button>
          </div>
        </div>
      </form>
      <br>
      <a href="<?php echo $baseurl ?>login.php" class="tex-center">&lArr; Go back</a>
    </div>
    <br>
    <!-- /.form-box -->
  </div>
  <?php include('footer.php'); ?>
</body>

</html>