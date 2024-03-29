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
  $sql = "SELECT id,name,category,unit,original,selling,quantity,image_path FROM tbl_product WHERE id=?";
  $qry = $connection->prepare($sql);
  $qry->bind_param("i",$_GET['id']);
  $qry->execute();
  $qry->bind_result($id,$dbn, $dbc, $dbu,$dbo,$dbs,$dbq,$dbpip);
  $qry->store_result();
  $qry->fetch ();
}
$pages = 'product/index';
?>
<?php include('../header.php'); ?>
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
          <h1 class="col-md-6 text-left">
            <span class="text-left">Edit Products</span>

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
              <form method="POST" action="#" enctype="multipart/form-data">
              <div class="col-md-12">
                <label>Upload Image</label><br>
                <img src="<?php echo $dbpip ?>" id="productDisplay" onclick="triggerClick()" style="width: 200px;height: 100px;">
                <input type="file" name="productimage" onchange="displayImage(this)" id="productimage" style="display:none" class="form-control" accept="image/x-png,image/gif,image/jpeg">
              </div>


              <div class="col-md-6">
                <label>Name <i style="color:red">*</i></label>
                <input type="text" class="form-control" name="name" value="<?php echo $dbn; ?>" required>

                <label>Category <i style="color:red">*</i></label>
                <select class="form-control" name="category" requred>
                  <option value="" selected disabled>Select Category</option>
                  <?php 
                  $sql = "SELECT id,name FROM tbl_pcategory ORDER BY name ASC";
                  $qry = $connection->prepare($sql);
                  $qry->execute();
                  $qry->bind_result($id,$dbcn);
                  $qry->store_result();
                  while($qry->fetch ()) {
                      if($dbc == $dbcn){ echo '<option selected>';}else{echo'<option>';}
                      echo $dbcn;
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
                  $qry->bind_result($id,$dbun);
                  $qry->store_result();
                  while($qry->fetch ()) {
                      if($dbu == $dbun){ echo '<option selected>';}else{echo'<option>';}
                      echo $dbun;
                      echo"</option>";
                    }
                  ?>
                  <option>Other</option>
                </select>
              </div>
              <div class="col-md-6">
                <label style="display:none">Supplier Price <i style="color:red">*</i></label>
                <input style="display:none" type="text" class="form-control" name="original" value="<?php echo $dbo; ?>" required>
                <label>Price <i style="color:red">*</i></label>
                <input type="text" class="form-control" name="selling" value="<?php echo $dbs; ?>" required>
                <label>Quantity <i style="color:red">*</i></label>
                <input type="number" class="form-control" name="quantity" value="<?php echo $dbq; ?>" required>
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

  if(!empty($_FILES['productimage'])){

    if($_FILES['productimage']['name'] == ''){
      $target = 'images/placeholder.jpg';
    }else{
      $imagename = time() .'-'.$_FILES['productimage']['name'];
      $target = 'images/'.$imagename;
      move_uploaded_file($_FILES['productimage']['tmp_name'], $target);
    }


    $sql = "UPDATE tbl_product SET name=?,category=?,unit=?,original=?,selling=?,image_path=?,quantity=?,user_id=? WHERE id=?";
    $qry = $connection->prepare($sql);
    $qry->bind_param("ssssssiii",$_POST['name'],$_POST['category'],$_POST['unit'],$_POST['original'],$_POST['selling'],$target,$_POST['quantity'],$_SESSION['dbu'],$_GET['id']);
  }else{
    $sql = "UPDATE tbl_product SET name=?,category=?,unit=?,original=?,selling=?,quantity=?,user_id=? WHERE id=?";
    $qry = $connection->prepare($sql);
    $qry->bind_param("sssssiii",$_POST['name'],$_POST['category'],$_POST['unit'],$_POST['original'],$_POST['selling'],$_POST['quantity'],$_SESSION['dbu'],$_GET['id']);
  }

    
    if($qry->execute()) {
      $activity = "Updated Product: ".$dbn;
      $sqlx = "INSERT INTO tbl_logs(employee_id,activity) VALUES(?,?)";
      $qryx = $connection->prepare($sqlx);
      $qryx->bind_param("is",$_SESSION['dbu'],$activity);
      $qryx->execute();
      echo '<meta http-equiv="refresh" content="0; URL=index.php?status=updated">';
    }else{
      echo '<meta http-equiv="refresh" content="0; URL=edit.php?status=error">';
    }
}
?>