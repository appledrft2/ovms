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
$pages ='product/add';
?>
<?php include('../header.php'); ?>
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
          <h1 class="col-md-6 text-left">
            <span class="text-left">Add Product</span>

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

                <label>Category <i style="color:red">*</i></label>
                <select class="form-control" name="category" requred>
                  <option value="" selected disabled>Select Category</option>
                  <option>Medicine</option>
                  <option>Vaccine</option>
                  <option>Dog Food</option>
                  <option>Cat Food</option>
                  <option>Soap</option>
                  <option>Shampoo</option>
                  <option>Suppliments</option>
                  <option>Others</option>
                </select>
                <label>Unit <i style="color:red">*</i></label>
                <select class="form-control" name="unit" requred>
                  <option value="" selected disabled>Select Unit</option>
                  <option>Pc</option>
                  <option>Ml</option>
                  <option>Kg</option>
                  <option>Can</option>
                  <option>Ampule</option>
                  <option>Vial</option>
                  <option>Pipette</option>
                  <option>Capsule</option>
                  <option>Tablet</option>
                  <option>Sack</option>
                  <option>Other</option>
                </select>
              </div>
              <div class="col-md-6">
                <label>Supplier Price <i style="color:red">*</i></label>
                <input type="text" class="form-control" name="original" required>
                <label>Selling Price <i style="color:red">*</i></label>
                <input type="text" class="form-control" name="selling" required>
                <label>Quantity <i style="color:red">*</i></label>
                <input type="number" class="form-control" name="quantity" required>
              </div>
              
            </div>
            <div class="box-footer">
              <div class="pull-right">
                <a href="<?php echo $baseurl; ?>employee/dashboard/products" class="btn btn-default" > Go Back</a>
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
    $sql = "INSERT INTO tbl_product(name,category,unit,original,selling,quantity) VALUES(?,?,?,?,?,?)";
    $qry = $connection->prepare($sql);
    $qry->bind_param("sssssi",$_POST['name'],$_POST['category'],$_POST['unit'],$_POST['original'],$_POST['selling'],$_POST['quantity']);

    if($qry->execute()) {
    
      echo '<meta http-equiv="refresh" content="0; URL=index.php?status=created">';
    }else{
      
      echo '<meta http-equiv="refresh" content="0; URL=add.php?status=error">';

    }
}
?>