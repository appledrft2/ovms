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
      <?php 
        if(isset($_GET['status'])){
         if($_GET['status'] == 'error'){
            echo '<div class="alert alert-danger alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <p><i class="icon fa fa-remove"></i>  There was an error adding your product.</p>
                     
                    </div>';
          }
        }
      ?>
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header"></div>
            <div class="box-body">
              <form method="POST" action="#" enctype="multipart/form-data">

              <div class="col-md-12">
                <label>Upload Image</label><br>
                <img src="images/placeholder.jpg" id="productDisplay" onclick="triggerClick()" style="width: 200px;height: 100px;">
                <input type="file" name="productimage" onchange="displayImage(this)" id="productimage" style="display:none" class="form-control" accept="image/x-png,image/gif,image/jpeg">
              </div>

              <div class="col-md-6">

                <label>Name <i style="color:red">*</i></label>
                <input type="text" class="form-control" name="name" required>

                <label>Category <i style="color:red">*</i></label>
                <select class="form-control" name="category" requred>
                  <option value="" selected disabled>Select Category</option>
                  <?php 
                  $sql = "SELECT id,name FROM tbl_pcategory ORDER BY name ASC";
                  $qry = $connection->prepare($sql);
                  $qry->execute();
                  $qry->bind_result($id,$dbn);
                  $qry->store_result();
                  while($qry->fetch ()) {
                      echo"<option>";
                      echo $dbn;
                      echo"</option>";
                    }
                  ?>
                  <option>Other</option>
                </select>
                <label>Unit <i style="color:red">*</i></label>
                <select class="form-control" name="unit" requred>
                  <option value="" selected disabled>Select Unit</option>
                  <?php 
                  $sql = "SELECT id,name FROM tbl_punit ORDER BY name ASC";
                  $qry = $connection->prepare($sql);
                  $qry->execute();
                  $qry->bind_result($id,$dbn);
                  $qry->store_result();
                  while($qry->fetch ()) {
                      echo"<option>";
                      echo $dbn;
                      echo"</option>";
                    }
                  ?>
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
<script type="text/javascript">
  function triggerClick(){
    $("#productimage").click();
  }
  function displayImage(e){
    if(e.files[0]){
      var reader = new FileReader();
      reader.onload = function(e){
        $('#productDisplay').attr('src',e.target.result);
      }
      reader.readAsDataURL(e.files[0]);
    }
  }
</script>
<?php 
if(isset($_POST['btnSave'])){

    $st = 'Available';
    if(!empty($_FILES['productimage']['name'])){
      $imagename = time() .'-'.$_FILES['productimage']['name'];
      $target = 'images/'.$imagename;
      move_uploaded_file($_FILES['productimage']['tmp_name'], $target);
  
    }else{
      $target = "images/placeholder.jpg";
    }

    $sql = "INSERT INTO tbl_product(name,category,unit,original,selling,quantity,status,image_path) VALUES(?,?,?,?,?,?,?,?)";
    $qry = $connection->prepare($sql);
    $qry->bind_param("sssssiss",$_POST['name'],$_POST['category'],$_POST['unit'],$_POST['original'],$_POST['selling'],$_POST['quantity'],$st,$target);


    if($qry->execute()) {
    
      echo '<meta http-equiv="refresh" content="0; URL=index.php?status=created">';
    }else{
      
      echo '<meta http-equiv="refresh" content="0; URL=add.php?status=error">';

    }
}
?>