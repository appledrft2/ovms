<?php 
session_start();
include('../../../includes/autoload.php');
if(isset($_POST['btnLogout'])){
  session_unset();
  header('location:'.$baseurl.'');
}
if(isset($_SESSION['dbu'])){ 
  if($_SESSION['dbc'] != true){
      header("location:".$baseurl."employees/dashboard");
  }
}else{
  header('location:'.$baseurl.'');
} 
if(isset($_GET['id'])){
  $sql = "SELECT id,name,breed,gender,specie,dob,markings,considerations FROM tbl_pet WHERE id=?";
  $qry = $connection->prepare($sql);
  $qry->bind_param("i",$_GET['id']);
  $qry->execute();
  $qry->bind_result($id,$dbn,$dbb,$dbg,$dbs, $dbdob,$dbm,$dbc);
  $qry->store_result();
  $qry->fetch ();
}
?>
<?php include('header.php'); ?>
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
          <h1 class="col-md-6 text-left">
            <span class="text-left">Edit Employee</span>

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
                <label>Name <i style="color:red">*</i></label>
                <input type="text" class="form-control" name="name"  value="<?php echo $dbn ?>" required>
                <label>Breed <i style="color:red">*</i></label>
                <input type="text" class="form-control" name="breed"  value="<?php echo $dbb ?>" required>
                <label>Gender <i style="color:red">*</i></label>
                <select class="form-control" name="gender" requred>
                  <option value="" selected disabled>Select Gender</option>
                  <option <?php if($dbg == 'Male'){ echo 'selected';} ?>>Male</option>
                  <option <?php if($dbg == 'Female'){ echo 'selected';} ?>>Female</option>
                  <option <?php if($dbg == 'Neutered'){ echo 'selected';} ?>>Neutered</option>
                  <option <?php if($dbg == 'Spayed'){ echo 'selected';} ?>>Spayed</option>
                </select>
              </div>
              <div class="col-md-6">
                <label>Specie <i style="color:red">*</i></label>
                <select class="form-control" name="specie">
                  <option value="" selected disabled>Select Specie</option>
                  <option <?php if($dbs == 'Canine'){ echo 'selected';} ?>>Canine</option>
                  <option <?php if($dbs == 'Feline'){ echo 'selected';} ?>>Feline</option>
                  <option <?php if($dbs == 'Other'){ echo 'selected';} ?>>Other</option>
                </select>
                <label>Date of Birth <i style="color:red">*</i></label>
                <input type="date" class="form-control" name="dob" value="<?php echo $dbdob ?>" required>
                <label>Markings </label>
                <textarea class="form-control" name="markings" ><?php echo $dbm ?></textarea>
                <label>Special Considerations </label>&nbsp;(Allergies, Surgeries, etc.)
                <textarea class="form-control" name="considerations" ><?php echo $dbc ?></textarea>
                
              </div>
              
            </div>
            <div class="box-footer">
              <div class="pull-right">
                <a href="<?php echo $baseurl; ?>client/dashboard/pets" class="btn btn-default" > Go Back</a>
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

    $sql = "UPDATE tbl_pet SET name=?,breed=?,gender=?,specie=?,dob=?,markings=?,considerations=? WHERE id=?";
    $qry = $connection->prepare($sql);
    $qry->bind_param("sssssssi",$_POST['name'],$_POST['breed'],$_POST['gender'],$_POST['specie'],$_POST['dob'],$_POST['markings'],$_POST['considerations'],$_GET['id']);
  
    if($qry->execute()) {
      echo '<meta http-equiv="refresh" content="0; URL=index.php?status=updated">';
    }else{
      echo '<meta http-equiv="refresh" content="0; URL=edit.php?status=error">';
    }
}
?>