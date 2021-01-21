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
?>
<?php include('header.php'); ?>
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
          <h1 class="col-md-6 text-left">
            <span class="text-left">Add Pet</span>

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
                <input type="text" class="form-control" name="name" required>
                <label>Breed <i style="color:red">*</i></label>
                <input type="text" class="form-control" name="breed" required>
                <label>Gender <i style="color:red">*</i></label>
                <select class="form-control" name="gender" requred>
                  <option value="" selected disabled>Select Gender</option>
                  <option>Male</option>
                  <option>Female</option>
                  <option>Neutered</option>
                  <option>Spayed</option>
                </select>
              </div>
              <div class="col-md-6">
                <label>Specie <i style="color:red">*</i></label>
                <select class="form-control" name="specie">
                  <option value="" selected disabled>Select Specie</option>
                  <option>Canine</option>
                  <option>Feline</option>
                  <option>Other</option>
                </select>
                <label>Date of Birth <i style="color:red">*</i></label>
                <input type="date" class="form-control" name="dob" required>
                <label>Markings </label>
                <textarea class="form-control" name="markings"></textarea>
                <label>Special Considerations </label>&nbsp;(Allergies, Surgeries, etc.)
                <textarea class="form-control" name="considerations"></textarea>
                
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
    $sql = "INSERT INTO tbl_pet(client_id,name,breed,gender,specie,dob,markings,considerations) VALUES(?,?,?,?,?,?,?,?)";
    $qry = $connection->prepare($sql);
    $qry->bind_param("isssssss",$_SESSION['dbu'],$_POST['name'],$_POST['breed'],$_POST['gender'],$_POST['specie'],$_POST['dob'],$_POST['markings'],$_POST['considerations']);

    if($qry->execute()) {
      echo '<meta http-equiv="refresh" content="0; URL=index.php?status=created">';
    }else{
      echo '<meta http-equiv="refresh" content="0; URL=add.php?status=error">';
    }
}
?>