<?php 
session_start();
include('../../includes/autoload.php');
if(isset($_POST['btnLogout'])){
  session_unset();
  header('location:'.$baseurl.'');
}
if(!isset($_SESSION['dbu'])){ 

  header('location:'.$baseurl.'');
} 
if(isset($_SESSION['dbu'])){
  $sql = "SELECT id,firstname,middlename,lastname,gender,phone,email,address,username FROM tbl_client WHERE id=?";
  $qry = $connection->prepare($sql);
  $qry->bind_param("i",$_SESSION['dbu']);
  $qry->execute();
  $qry->bind_result($id,$dbf,$dbm,$dbl,$dbg,$dbp,$dbe,$dbadd,$dbus);
  $qry->store_result();
  $qry->fetch ();
}
$pages = 'dashboard/index';
?>
<?php include('header.php'); ?>
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        User Settings
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> User Settings</a></li>
        <li class="active">Index</li>
      </ol>
    </section>


    <!-- Main content -->
    <section class="content">
       <?php 
      if(isset($_GET['status'])){
        if($_GET['status'] == 'created'){
          echo '<div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <p><i class="icon fa fa-check"></i>  Settings Successfully Added.</p>
                   
                  </div>';
        }if($_GET['status'] == 'updated'){
          echo '<div class="alert alert-info alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <p><i class="icon fa fa-info"></i>  Settings Successfully Updated.</p>
                   
                  </div>';
        }if($_GET['status'] == 'deleted'){
          echo '<div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <p><i class="icon fa fa-remove"></i>  Settings Successfully Deleted.</p>
                   
                  </div>';
        }
      }
    ?>
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header"></div>
            <div class="box-body">
              <form method="POST" action="#">
              <div class="col-md-6">
                <label>Firstname <i style="color:red">*</i></label>
                <input type="text" class="form-control" name="firstname" value="<?php echo $dbf; ?>" required>
                <label>Middlename <i style="color:red">*</i></label>
                <input type="text" class="form-control" name="middlename" value="<?php echo $dbm; ?>" required>
                <label>Lastname <i style="color:red">*</i></label>
                <input type="text" class="form-control" name="lastname" value="<?php echo $dbl; ?>" required>
                <label>Gender <i style="color:red">*</i></label>
                <select class="form-control" name="gender">
                  <option selected disabled value="">Select Gender</option>
                  <option <?php if($dbg == 'Male'){echo 'Selected';} ?>>Male</option>
                  <option <?php if($dbg == 'Female'){echo 'Selected';} ?>>Female</option>
                </select>
              </div>
              <div class="col-md-6">
                
                <label>Phone <i style="color:red">*</i></label>
                <input type="text" class="form-control" name="phone" value="<?php echo $dbp; ?>"  required>
                <label>Address <i style="color:red"></i></label>
                <textarea class="form-control" name="address"><?php echo $dbadd; ?></textarea>
                <hr>
                <label>User Account</label>
                <hr>
                <label>Username <i style="color:red">*</i></label>
                <input type="text" class="form-control" name="username" value="<?php echo $dbus; ?>"  required>
                <label>Password </label> (Leave empty if you dont want to change)
                <input type="password" class="form-control" name="password" >
              </div>
              
            </div>
            <div class="box-footer">
              <div class="pull-right">
              
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

    if($_POST['password'] != ''){
      $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
      $sql = "UPDATE tbl_client SET firstname=?,middlename=?,lastname=?,gender=?,phone=?,username=?,password=?,address=? WHERE id=?";
      $qry = $connection->prepare($sql);
      $qry->bind_param("ssssssssi",$_POST['firstname'],$_POST['middlename'],$_POST['lastname'],$_POST['gender'],$_POST['phone'],$_POST['username'],$hashed_password,$_POST['address'],$_SESSION['dbu']);
    }else{
      $sql = "UPDATE tbl_client SET firstname=?,middlename=?,lastname=?,gender=?,phone=?,username=?,address=? WHERE id=?";
      $qry = $connection->prepare($sql);
      $qry->bind_param("sssssssi",$_POST['firstname'],$_POST['middlename'],$_POST['lastname'],$_POST['gender'],$_POST['phone'],$_POST['username'],$_POST['address'],$_SESSION['dbu']);
    }
  
    if($qry->execute()) {
      echo '<meta http-equiv="refresh" content="0; URL=settings.php?status=updated">';
    }else{
      echo '<meta http-equiv="refresh" content="0; URL=settings.php?status=error">';
    }
}
?>