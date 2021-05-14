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
$pages = 'pet/index';
?>
<?php include('../header.php'); ?>
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
              <form method="POST" action="#" enctype="multipart/form-data">
              <div class="col-md-6">
                <label>Name <i style="color:red">*</i></label>
                <input type="text" class="form-control" name="name" required>
                <label>Species <i style="color:red">*</i></label>
                <select class="form-control" name="specie" id="species" onchange="getSpecies(this);">
                  <option value="" selected disabled>Select Species</option>
                  <option>Canine</option>
                  <option>Feline</option>
                </select>
                <label>Breed <i style="color:red">*</i></label>
                <select name="breed" disabled id="breed" class="form-control">
                  <option selected value="">Select Breed</option>
                  <?php 
                      $sql = "SELECT id,name,type FROM tbl_pet_breed ORDER BY name ASC";
                      $qry = $connection->prepare($sql);
                      $qry->execute();
                      $qry->bind_result($id,$dbn,$dbt);
                      $qry->store_result();
                      while($qry->fetch()){
                        echo '<option>
                          '.$dbn.'
                          ('.$dbt.')';               
                        echo '</option>';
                      }

                    ?>
                </select>
             
                <a href="breed.php" onclick="window.open('breed.php','popup','width=600,height=600'); return false;" style="margin-top:1px;" class="btn btn-primary btn-sm"><i class="fa fa-paw"></i> Breed Not In list?</a>
                <br>
                <br>

                <div class="form-group">
                  <label>Upload Birth Certificate (Optional) (jpg/png)<i style="color:red"></i></label><br>
                  <img src="uploads/placeholder.jpg" id="petDisplay" onclick="triggerClick()" style="width: 200px;height: 100px;">
                  <input type="file" name="birth_certificate" onchange="displayImage(this)" id="petimage" style="display:none" class="form-control" accept="image/x-png,image/gif,image/jpeg">
                </div>
              </div>
              <div class="col-md-6">
                <label>Gender <i style="color:red">*</i></label>
                <select class="form-control" name="gender" requred>
                  <option value="" selected disabled>Select Gender</option>
                  <option>Male</option>
                  <option>Female</option>
                  <option>Neutered</option>
                  <option>Spayed</option>
                </select>
                <label>Date of Birth <i style="color:red">*</i></label>
                <input type="date" class="form-control" name="dob" id="dob" required>
                <label>Markings </label>
                <textarea class="form-control" name="markings"></textarea>
                <label>Special Considerations </label>&nbsp;(Allergies, Surgeries, etc.)
                <textarea class="form-control" name="considerations"></textarea>
                
              </div>
              
            </div>
            <div class="box-footer">
              <div class="pull-right">
                <a href="<?php echo $baseurl; ?>client/dashboard/pets" class="btn btn-default" > Go Back</a>
                <button name="btnSave" class="btn btn-primary" > Save Changes</button>
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
    $("#petimage").click();
  }
  function displayImage(e){
    if(e.files[0]){
      var reader = new FileReader();
      reader.onload = function(e){
        $('#petDisplay').attr('src',e.target.result);
      }
      reader.readAsDataURL(e.files[0]);
    }
  }


  function getSpecies(species){
    filterFunction(species.value);
    document.getElementById("breed").disabled = false;
  
  }

  function filterFunction(specie) { 
    var input, filter, ul, li, a, i;
    input = document.getElementById(specie);
    filter = specie.toUpperCase();
    div = document.getElementById("breed");
    a = div.getElementsByTagName("option");
    for (i = 0; i < a.length; i++) {
      txtValue = a[i].textContent || a[i].innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        a[i].style.display = "";
      } else {
        a[i].style.display = "none";
      }
    }
  }


  var date = new Date().toISOString().slice(0,10);
  //To restrict future date
  var restrict = document.getElementById("dob");
  restrict.setAttribute('max', date);
</script>

<?php 
if(isset($_POST['btnSave'])){

    if(!empty($_FILES['birth_certificate']['name'])){
      $imagename = time() .'-'.$_FILES['birth_certificate']['name'];
      $target = 'uploads/'.$imagename;
      move_uploaded_file($_FILES['birth_certificate']['tmp_name'], $target);
    }else{
      $target = "uploads/placeholder.jpg";    
    }

    $sql = "INSERT INTO tbl_pet(client_id,name,breed,gender,specie,dob,markings,considerations,birth_certificate) VALUES(?,?,?,?,?,?,?,?,?)";
    $qry = $connection->prepare($sql);
    $qry->bind_param("issssssss",$_SESSION['dbu'],$_POST['name'],$_POST['breed'],$_POST['gender'],$_POST['specie'],$_POST['dob'],$_POST['markings'],$_POST['considerations'],$target);

    if($qry->execute()) {




      echo '<meta http-equiv="refresh" content="0; URL=index.php?status=created">';
    }else{
      echo '<meta http-equiv="refresh" content="0; URL=add.php?status=error">';
    }
}
?>