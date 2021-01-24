<?php 
session_start();
include('../../../includes/autoload.php');
if(isset($_POST['btnLogout'])){
  session_unset();
  header('location:'.$baseurl.'');
}
if(isset($_SESSION['dbu'])){ 
  if($_SESSION['dbc'] != false){
      header("location:".$baseurl."client/dashboard");
  }
}else{
  header('location:'.$baseurl.'');
}
$pages = 'employee/add';
?>
<?php include('../header.php'); ?>
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
          <h1 class="col-md-6 text-left">
            <span class="text-left">Add Employee</span>

          </h1>
          <h2 class="col-md-6 text-right">
            <span class="text-right"><i class="fa fa-calendar"></i> <?php echo date('D, M. d Y') ?></span>
          </h2>
        </div>
      </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header"></div>
            <div class="box-body">
              <form method="POST" action="#">
              <div class="col-md-6">
                <label>Firstname <i style="color:red">*</i></label>
                <input type="text" class="form-control" name="firstname" required>
                <label>Middlename <i style="color:red">*</i></label>
                <input type="text" class="form-control" name="middlename" required>
                <label>Lastname <i style="color:red">*</i></label>
                <input type="text" class="form-control" name="lastname" required>
                <label>Gender <i style="color:red">*</i></label>
                <select class="form-control" name="gender" requred>
                  <option value="" selected disabled>Select Gender</option>
                  <option>Male</option>
                  <option>Female</option>
                </select>
              </div>
              <div class="col-md-6">
                <label>Employee Type <i style="color:red">*</i></label>
                <select class="form-control" name="employee_type">
                  <option value="" selected disabled>Select type</option>
                  <option>Secretary</option>
                  <option>Veterinarian</option>
                </select>
                <label>Phone <i style="color:red">*</i></label>
                <input type="number" class="form-control" name="phone" required>
                <label>Email <i style="color:red">*</i></label>
                <input type="email" class="form-control" name="email" required>
                <hr>
                <label>Employee Account</label><hr>
                <label>Username <i style="color:red">*</i></label>
                <input type="text" class="form-control" name="username" required>
                <label>Password <i style="color:red">*</i></label>
                <input type="password" class="form-control" name="password" required>
              </div>
              
            </div>
            <div class="box-footer">
              <div class="pull-right">
                <a href="<?php echo $baseurl; ?>employee/dashboard/employees" class="btn btn-default" > Go Back</a>
                <button name="btnSave" class="btn btn-success" > Save Changes</button>
              </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.18
    </div>
    <strong>Copyright &copy; 2020-2021 <a href="#">Bath & Bark Grooming and Veterinary Services Management System</a>.</strong> All rights
    reserved.
  </footer>

</div>
<!-- ./wrapper -->

<?php include('footer.php') ?>

<?php 
if(isset($_POST['btnSave'])){
    $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $sql = "INSERT INTO tbl_employee(firstname,middlename,lastname,gender,employee_type,phone,email,username,password) VALUES(?,?,?,?,?,?,?,?,?)";
    $qry = $connection->prepare($sql);
    $qry->bind_param("sssssssss",$_POST['firstname'],$_POST['middlename'],$_POST['lastname'],$_POST['gender'],$_POST['employee_type'],$_POST['phone'],$_POST['email'],$_POST['username'],$hashed_password);

    if($qry->execute()) {
    
      echo '<meta http-equiv="refresh" content="0; URL=index.php?status=created">';
    }else{
      
      echo '<meta http-equiv="refresh" content="0; URL=add.php?status=error">';

    }
}
?>