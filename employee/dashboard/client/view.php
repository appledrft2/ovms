<?php 
session_start();
include('../../../includes/autoload.php');

if(isset($_SESSION['dbu'])){ 
  if($_SESSION['dbc'] != false){
      header("location:".$baseurl."client/dashboard");
  }
}else{
  header('location:'.$baseurl.'');
} 
if(isset($_GET['id'])){
  $sql = "SELECT id,firstname,middlename,lastname,gender,phone,address,status,timestamp,client_num FROM tbl_client WHERE id=?";
  $qry = $connection->prepare($sql);
  $qry->bind_param("i",$_GET['id']);
  $qry->execute();
  $qry->bind_result($id,$dbf,$dbm,$dbl,$dbg,$dbp,$dba,$dbs,$dbtimestamp,$dbclient_num);
  $qry->store_result();
  $qry->fetch ();

  $dbtimestamp = date("M d, Y h:ia", strtotime($dbtimestamp));
}
$pages = 'client/index';
?>
<?php include('../header.php'); ?>
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
          <h1 class="col-md-6 text-left">
            <span class="text-left">View Client Information</span>

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
                <label>Client Num: </label>
                <input type="text" class="form-control" name="firstname" value="<?php echo $dbclient_num ?>" required>
                <label>Firstname </label>
                <input type="text" class="form-control" name="firstname" value="<?php echo $dbf ?>" required>
                <label>Middlename </label>
                <input type="text" class="form-control" name="middlename" value="<?php echo $dbm ?>" required>
                <label>Lastname </label>
                <input type="text" class="form-control" name="lastname" value="<?php echo $dbl ?>" required>
                <label>Gender </label>
                <select class="form-control" name="gender" requred>
                  <option value="" selected disabled>Select Gender</option>
                  <option <?php if($dbg == 'Male'){ echo 'selected';} ?>>Male</option>
                  <option <?php if($dbg == 'Female'){ echo 'selected';} ?>>Female</option>
                </select>
              </div>
              <div class="col-md-6">
                
                <label>Date Registered </label>
                <input type="text" class="form-control" name="phone" value="<?php echo $dbtimestamp ?>" required>
                <label>Phone </label>
                <input type="number" class="form-control" name="phone" value="<?php echo $dbp ?>" required>
                <label>Address </label>
                <textarea name="" class="form-control" rows="5"><?= $dba ?></textarea>
                <label>Status </label>
                <input type="text" class="form-control" name="phone" value="<?php echo $dbs ?>" required>
                <hr>
                <label>Client Pets</label><hr>
                <ol style="position:relative;right:20px">
                <?php

                if(isset($_GET['id'])){

                  $sql = "SELECT name FROM tbl_pet WHERE client_id=?";
                  $qry = $connection->prepare($sql);
                  $qry->bind_param("i",$_GET['id']);
                  $qry->execute();
                  $qry->bind_result($dbn);
                  $qry->store_result();
                  while($qry->fetch ()){

                    echo "<li><div class='form-group'><input type='text' class='form-control' value='$dbn'></div></li>";

                  }

                }

                ?>
                </ol>
              </div>
              
            </div>
            <div class="box-footer">
              <div class="pull-right">
                <a href="<?php echo $baseurl; ?>employee/dashboard/client" class="btn btn-default" > Go Back</a>
                <!-- <button name="btnSave" class="btn btn-success" > Save Changes</button> -->
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

    if($_POST['password'] != ''){
      $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
      $sql = "UPDATE tbl_employee SET firstname=?,middlename=?,lastname=?,gender=?,employee_type=?,phone=?,email=?,username=?,password=? WHERE id=?";
      $qry = $connection->prepare($sql);
      $qry->bind_param("sssssssssi",$_POST['firstname'],$_POST['middlename'],$_POST['lastname'],$_POST['gender'],$_POST['employee_type'],$_POST['phone'],$_POST['email'],$_POST['username'],$hashed_password,$_GET['id']);
    }else{
      $sql = "UPDATE tbl_employee SET firstname=?,middlename=?,lastname=?,gender=?,employee_type=?,phone=?,email=?,username=? WHERE id=?";
      $qry = $connection->prepare($sql);
      $qry->bind_param("ssssssssi",$_POST['firstname'],$_POST['middlename'],$_POST['lastname'],$_POST['gender'],$_POST['employee_type'],$_POST['phone'],$_POST['email'],$_POST['username'],$_GET['id']);
    }
  
    if($qry->execute()) {
      echo '<meta http-equiv="refresh" content="0; URL=index.php?status=updated">';
    }else{
      echo '<meta http-equiv="refresh" content="0; URL=edit.php?status=error">';
    }
}
?>