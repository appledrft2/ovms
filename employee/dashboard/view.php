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

$sql = "SELECT app.total,app.status,app.iscancelled,c.firstname,c.middlename,c.lastname,emp.firstname,emp.lastname,app.appointment_date,app.timestamp FROM tbl_appointment AS app INNER JOIN tbl_client AS c ON c.id = app.client_id LEFT JOIN tbl_employee AS emp ON emp.id = app.veterinarian_id WHERE app.id = ?";
$qry = $connection->prepare($sql);
$qry->bind_param('i',$_GET['id']);
$qry->execute();
$qry->bind_result($dbtotal,$dbst,$dbisc,$dbf,$dbm,$dbl,$dbvf,$dbvl,$dbad,$dbtimestamp);
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
            <span class="text-left">View Request</span>

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
                
                <label>Set Veterinarian: </label>
                <select type="text" class="form-control " name="veterinarian_id" required>
                  <option selected disabled value="">Select Veterinarian</option>
                   <?php 
                    $sql = "SELECT id,firstname,middlename,lastname FROM tbl_employee WHERE employee_type = 'Veterinarian' ORDER BY timestamp ASC";
                    $qry = $connection->prepare($sql);
                    $qry->execute();
                    $qry->bind_result($id,$dbvf,$dbvm,$dbvl);
                    $qry->store_result();
                    while($qry->fetch ()) {
                      echo '
                        <option value="'.$id.'">Doc. '.$dbvf.' '.$dbvm[0].'. '.$dbvl.'</option>
                       ';
                    }
                  ?>
                </select>
                <label>Set Appointment Date: </label>
                <input type="date" name="appointment_date" class="form-control" value="" required>
               
              </div>
              <div class="col-md-6">
                <label>Date Requested: </label>
                <input type="text" name="" class="form-control" readonly value="<?php echo $dbtimestamp; ?>" >
                <label>Client Name: </label>
                <input type="text" name="" class="form-control" readonly value="<?php echo $dbf.' '.$dbm.' '.$dbl; ?>" >
                <label>Status: </label>
                <input type="text" name="" class="form-control" readonly value="<?php echo $dbst; ?>" >
               
              </div>
              <div class="col-md-12">
                <br>
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th width="25%">Pet Name</th>
                      <th width="25%">Service</th>
                      <th width="20%">Price</th>

                    </tr>
                  </thead>
                  <tbody id="tblservice">
                     <?php 
                      $sql = "SELECT p.name,s.name,s.price FROM tbl_appointment_pet AS ap INNER JOIN tbl_pet AS p ON p.id = ap.pet_id INNER JOIN tbl_service AS s ON s.id = ap.service_id WHERE ap.appointment_id = ?";
                      $qry = $connection->prepare($sql);
                      $qry->bind_param('i',$_GET['id']);
                      $qry->execute();
                      $qry->bind_result($dbpn,$dbsn,$dbsp);
                      $qry->store_result();
                      while($qry->fetch ()) {
                        echo '
                          <tr>
                            <td>
                             '.$dbpn.'

                            </td>
                            <td>
                             '.$dbsn.'
                            </td>
                            <td>
                              &#8369;'.number_format($dbsp,2).'
                            </td>
                            
                          </tr>
                         ';
                      }
                    ?>
                    
                  </tbody>

                  <tfoot>
                    <tr>
                      <td></td>
                      <td class="text-right"><b>Total:</b></td>
                      <td>
                        &#8369;<?php echo number_format($dbtotal,2);  ?>
                      </td>
                   
                    </tr>
                   
                  </tfoot>
                </table>
              </div>

            </div>

            <div class="box-footer">
              <div class="pull-right">

                  <button type="submit" name="btnDecline"  class="btn btn-danger" formnovalidate>Decline Request</button>
                  <button type="submit" name="btnApprove"  class="btn btn-success">Approve Request</button>
  
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

if(isset($_POST['btnApprove']) || isset($_POST['btnDecline'])){
  $message = "";
  if(isset($_POST['btnApprove'])){
    $sql = "UPDATE tbl_appointment SET veterinarian_id=?,appointment_date=?,status='Approved' WHERE id=?";
    $message = '<meta http-equiv="refresh" content="0; URL=index.php?status=approved">';
    $qry = $connection->prepare($sql);
    $qry->bind_param("iss",$_POST['veterinarian_id'],$_POST['appointment_date'],$_GET['id']);
  }if(isset($_POST['btnDecline'])){
    $sql = "UPDATE tbl_appointment SET status='Declined' WHERE id=?";
    $message = '<meta http-equiv="refresh" content="0; URL=index.php?status=declined">';
    $qry = $connection->prepare($sql);
    $qry->bind_param("i",$_GET['id']);
  }


  
  if($qry->execute()) {
    echo $message;
  }else{
    echo '<meta http-equiv="refresh" content="0; URL=edit.php?status=error">';
  }
}

?>