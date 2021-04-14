<?php 
session_start();
include('../../includes/autoload.php');
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
<?php include('header.php'); ?>
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
          <h1 class="col-md-6 text-left">
            <span class="text-left">Finalize Appointment</span>

          </h1>
          <h2 class="col-md-6 text-right">
            <span class="text-right"><i class="fa fa-calendar"></i> <?php echo date('D, M. d Y') ?></span>
          </h2>
        </div>
      </section>

    <!-- Main content -->
    <section class="content">
      <a href="<?php echo $baseurl; ?>client/dashboard" class="btn btn-default" ><i class='fa fa-angle-left'></i><i class='fa fa-angle-left'></i> Go Back</a><br><br>
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <form method="POST" action="#">
            <div class="box-body">
             
             
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
                      $sql = "SELECT ap.id,p.id,p.name,s.name,s.price FROM tbl_appointment_pet AS ap INNER JOIN tbl_pet AS p ON p.id = ap.pet_id INNER JOIN tbl_service AS s ON s.id = ap.service_id WHERE ap.appointment_id = ?";
                      $qry = $connection->prepare($sql);
                      $qry->bind_param('i',$_GET['id']);
                      $qry->execute();
                      $qry->bind_result($dbap,$dbpid,$dbpn,$dbsn,$dbsp);
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
                               <input type="text" class="form-control" name="temperature[]" value="" placeholder="Pet Temperature" required>

                             <label>Weight (Kg) : <i style="color:red">*</i></label>
                             <input type="text" class="form-control" name="weight[]" value="" placeholder="Pet Weight" required>

                             <label>Diagnosis : <i style="color:red">*</i></label>
                             <textarea class="form-control" name="diagnosis[]" cols="5" rows="5" placeholder="Diagnosis" required></textarea>

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

                  <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#myModal">Reschedule</button>
                  <button type="submit" name="btnFollow"  class="btn btn-primary">Complete, Create Follow-up</button>
                  <button type="submit" name="btnProcess"  class="btn btn-success">Complete Transaction</button>
  
              </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Reschedule </h4>
          </div>
          <div class="modal-body">
            <form method="POST" action="#">
            <label>Reschedule date: <i style="color:red">*</i></label>
            <input type="date" class="form-control" name="reschedule_date" value="<?php echo $dbad ?>" >
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" name="btnReschedule" class="btn btn-success" >Confirm Reschedule</button>
            </form>
          </div>
        </div>

      </div>
    </div>
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

if(isset($_POST['btnFollow']) || isset($_POST['btnProcess'])){
  $message = "";

  if(isset($_POST['btnProcess'])){
    $sql = "UPDATE tbl_appointment SET status='Completed' WHERE id=?";
    $message = '<meta http-equiv="refresh" content="0; URL=index.php?status=completed">';
    $qry = $connection->prepare($sql);
    $qry->bind_param("i",$_GET['id']);
  }


  if(isset($_POST['btnFollow'])){
    $sql = "UPDATE tbl_appointment SET status='Completed' WHERE id=?";
    $message = '<meta http-equiv="refresh" content="0; URL=follow_up.php?id='.$dbcid.'">';

    $qry = $connection->prepare($sql);
    $qry->bind_param("i",$_GET['id']);
  }


  
  if($qry->execute()) {
    $pet_arr = count($_POST['pid']);
    
    for($i = 0;$i < $pet_arr;$i++){

      $sql = "UPDATE tbl_appointment_pet SET temperature=?,weight=?,diagnosis=? WHERE id=?";
      $qry = $connection->prepare($sql);
      $qry->bind_param("sssi",$_POST['temperature'][$i],$_POST['weight'][$i],$_POST['diagnosis'][$i],$_POST['pid'][$i]);
      $qry->execute();

    }

  echo $message;


  }else{
    echo '<meta http-equiv="refresh" content="0; URL=edit.php?status=error">';
  }
}

if(isset($_POST['btnReschedule'])){
  $sql = "UPDATE tbl_appointment SET appointment_date=? WHERE id=?";
  $qry = $connection->prepare($sql);
  $qry->bind_param("si",$_POST['reschedule_date'],$_GET['id']);
  if($qry->execute()) {
    echo '<meta http-equiv="refresh" content="0; URL=index.php?status=rescheduled">';
  }else{
    echo '<meta http-equiv="refresh" content="0; URL=edit.php?status=error">';
  }
}

?>