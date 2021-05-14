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
$pages = 'dashboard/index';

$sql = "SELECT app.total,app.status,app.iscancelled,c.id,c.firstname,c.middlename,c.lastname,emp.firstname,emp.middlename,emp.lastname,app.appointment_date,app.timestamp FROM tbl_appointment AS app INNER JOIN tbl_client AS c ON c.id = app.client_id LEFT JOIN tbl_employee AS emp ON emp.id = app.veterinarian_id WHERE app.id = ?";
$qry = $connection->prepare($sql);
$qry->bind_param('i',$_GET['id']);
$qry->execute();
$qry->bind_result($dbtotal,$dbst,$dbisc,$dbcid,$dbf,$dbm,$dbl,$dbvf,$dbvm,$dbvl,$dbad,$dbtimestamp);
$qry->store_result();
$qry->fetch ();
if($dbisc == 'true'){
  $dbst = 'Cancelled';
}

?>
<?php include('../header.php'); ?>
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
          <h1 class="col-md-6 text-left">
            <span class="text-left">View Appointment </span>

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
            <form method="POST" id="printme" action="#">
              
            <div class="box-body">
             <center>
               <img src="<?php echo $baseurl ?>logo.jpg" width="100px" style="border:1px solid black"><br>
               <b style="text-transform: uppercase;">Bath & Bark Grooming and Veterinary Services</b>
               <p>
                 Bauan-Batangas Road<br>
                 Poblacion, San Pascual, Philippines<br>
                 Contact No.: 09178827552
               </p>
             </center>
             
              <div class="col-md-6">

                <label>Client Name: </label>
                <input type="hidden" name="" class="form-control" name="cid"  value="<?php echo $dbcid; ?>" >
                <input type="text" name="" class="form-control" readonly value="<?php echo $dbf.' '.$dbm.' '.$dbl; ?>" >
                <label>Status: </label>
                <input type="text" name="" class="form-control" readonly value="<?php echo $dbst; ?>" >

               
              </div>
              <div class="col-md-6">
                <label>Date Requested: </label>
                <input type="text" name="" class="form-control" readonly value="<?php echo $dbtimestamp; ?>" >
               <label>Veterinarian: </label>
               <input type="text" name="veterinarian_id" class="form-control" value="Doc. <?php echo $dbvf.' '.$dbvm.' '.$dbvl; ?>" readonly>
               <label>Appointment Date: </label>
               <input type="date" name="appointment_date" class="form-control" value="<?php echo $dbad; ?>" readonly>

              </div>
              <div class="col-md-12">
                <br>
                <div class="row">
                     <?php 
                      $sql = "SELECT ap.id,p.id,p.name,s.name,s.price,ap.temperature,ap.weight,ap.diagnosis FROM tbl_appointment_pet AS ap INNER JOIN tbl_pet AS p ON p.id = ap.pet_id INNER JOIN tbl_service AS s ON s.id = ap.service_id WHERE ap.appointment_id = ?";
                      $qry = $connection->prepare($sql);
                      $qry->bind_param('i',$_GET['id']);
                      $qry->execute();
                      $qry->bind_result($dbap,$dbpid,$dbpn,$dbsn,$dbsp,$dbtemp,$dbw,$dbdiag);
                      $qry->store_result();
                      while($qry->fetch ()) {
                        $dbsp = number_format($dbsp,2);
                        echo '
                          <div class="col-md-6">
                           <div class="box">
                             <div class="box-body">
                             <label>Pet Name: </label>
                               <input type="hidden" class="form-control" name="pid[]" value="'.$dbap.'">
                               <input type="text" class="form-control" name="petname[]" value="'.$dbpn.'" readonly>                             
                             <label>Service: </label>
                             <input type="text" class="form-control" name="servicename[]" value="'.$dbsn.' (&#8369;'.$dbsp.')" readonly>

                             <label>Temperature (&#8451;) : <i style="color:red">*</i></label>
                               <input type="text" class="form-control" name="temperature[]" value="'.$dbtemp.'" placeholder="Pet Temperature" required>

                             <label>Weight (Kg) : <i style="color:red">*</i></label>
                             <input type="text" class="form-control" name="weight[]" value="'.$dbw.'" placeholder="Pet Weight" required>

                             <label>Diagnosis : <i style="color:red">*</i></label>
                             <textarea class="form-control" name="diagnosis[]" cols="5" rows="5" placeholder="Diagnosis" required>'.$dbdiag.'</textarea>

                             </div>


                           </div>
                         </div>';
                      }
                    ?>

                   
                     
                  </div>
                    
                 
              </div>

            </div>

            <div class="box-footer">
              <div class="pull-right">
                  <a id="printPageButton" href="<?php echo $baseurl; ?>employee/dashboard/appointment" class="btn btn-default" > Go Back</a>
                  <button id="printPageButton" type="submit" name="btnUpdate" class="btn btn-primary" ><i class="fa fa-edit"></i> Update</button>
                  <button id="printPageButton" type="button" name="btnSave" onClick="printdiv('printme')" class="btn btn-success"> <i class="fa fa-print"></i> Print</button>

  
              </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
    <!-- Modal -->
    
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

  function printdiv(printpage)
  {
  var headstr = "<html><head><title></title></head><body>";
  var footstr = "</body>";
  var newstr = document.all.item(printpage).innerHTML;
  var oldstr = document.body.innerHTML;
  document.body.innerHTML = headstr+newstr+footstr;
  window.print();
  document.body.innerHTML = oldstr;
  return false;
  }


</script>

<?php 

if(isset($_POST['btnUpdate'])){

 
    $pet_arr = count($_POST['pid']);
    
    for($i = 0;$i < $pet_arr;$i++){

      $sql = "UPDATE tbl_appointment_pet SET temperature=?,weight=?,diagnosis=? WHERE id=?";
      $qry = $connection->prepare($sql);
      $qry->bind_param("sssi",$_POST['temperature'][$i],$_POST['weight'][$i],$_POST['diagnosis'][$i],$_POST['pid'][$i]);
      $qry->execute();

    }

    echo '<meta http-equiv="refresh" content="0; URL=index.php?status=updated">';
  
}


?>