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
$pages ='service/add';
?>
<?php include('../header.php'); ?>
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
          <h1 class="col-md-6 text-left">
            <span class="text-left">Add Service</span>

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
              <div class="col-md-6">
                <div class="form-group">
                  <label>Upload Image</label><br>
                  <img src="images/placeholder.jpg" id="serviceDisplay" onclick="triggerClick()" style="width: 200px;height: 100px;">
                  <input type="file" name="serviceimage" onchange="displayImage(this)" id="serviceimage" style="display:none" class="form-control" accept="image/x-png,image/gif,image/jpeg">
                </div>
                <label>Name <i style="color:red">*</i></label>
                <input type="text" class="form-control" name="name" required>
                <label>Price <i style="color:red">*</i></label>
                <input type="number" class="form-control" name="price" required>
              </div>
              <div class="col-md-6">
               
               
              </div>
              
            </div>
            <div class="box-footer">
              <div class="pull-right">
                <a href="<?php echo $baseurl; ?>employee/dashboard/services" class="btn btn-default" > Go Back</a>
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
    $("#serviceimage").click();
  }
  function displayImage(e){
    if(e.files[0]){
      var reader = new FileReader();
      reader.onload = function(e){
        $('#serviceDisplay').attr('src',e.target.result);
      }
      reader.readAsDataURL(e.files[0]);
    }
  }
</script>
<?php 
if(isset($_POST['btnSave'])){

    if(!empty($_FILES['serviceimage']['name'])){
      $imagename = time() .'-'.$_FILES['serviceimage']['name'];
      $target = 'images/'.$imagename;
      move_uploaded_file($_FILES['serviceimage']['tmp_name'], $target);
    }else{
      $target = "images/placeholder.jpg";    
    }
    
    $sql = "INSERT INTO tbl_service(name,price,description,image_path) VALUES(?,?,?,?)";
    $qry = $connection->prepare($sql);
    $qry->bind_param("ssss",$_POST['name'],$_POST['price'],$_POST['description'],$target);
    if($qry->execute()) { 

      echo '<meta http-equiv="refresh" content="0; URL=index.php?status=created">';
    }else{
      
      echo '<meta http-equiv="refresh" content="0; URL=add.php?status=error">';

    }
}
?>