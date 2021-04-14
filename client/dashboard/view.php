<?php 
session_start();
include('../../includes/autoload.php');
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
$pages = 'dashboard/index';

$sql = "SELECT app.total,app.status,app.iscancelled,c.firstname,c.lastname,emp.firstname,emp.lastname,app.appointment_date,app.timestamp FROM tbl_appointment AS app INNER JOIN tbl_client AS c ON c.id = app.client_id LEFT JOIN tbl_employee AS emp ON emp.id = app.veterinarian_id WHERE app.id = ?";
$qry = $connection->prepare($sql);
$qry->bind_param('i',$_GET['id']);
$qry->execute();
$qry->bind_result($dbtotal,$dbst,$dbisc,$dbf,$dbl,$dbvf,$dbvl,$dbad,$dbtimestamp);
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
            <span class="text-left">View Appointment</span>

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
                <img src="http://localhost/ovms/logo.jpg" width="100px" style="border:1px solid black"><br>
                <b style="text-transform: uppercase;">Bath & Bark Grooming and Veterinary Services</b>
                <p>
                  Bauan-Batangas Road<br>
                  Poblacion, San Pascual, Philippines<br>
                  Contact No.: 09178827552
                </p>
              </center>
              <div class="col-md-6">
                <label>Date Requested: </label>
                <input type="text" name="" class="form-control" value="<?php echo $dbtimestamp; ?>" >
                <label>Client Name: </label>
                <input type="text" name="" class="form-control" value="<?php echo $dbf.' '.$dbl; ?>" >
                <label>Status: </label>
                <input type="text" name="" class="form-control" value="<?php echo $dbst; ?>" >
               
              </div>
              <div class="col-md-6">
                
                <label>Assigned Veterinarian: </label>
                <input type="text" name="" class="form-control" value="<?php if($dbvf == ''){echo 'No Assigned Veterinarian';}else{echo $dbvf.' '.$dbvl;} ?>" >
                <label>Appointment Date: </label>
                <input type="text" name="" class="form-control" value="<?php if($dbad == ''){echo 'No Assigned Date';}else{echo $dbad;} ?>" >
               
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
          </form>
            <div class="box-footer">
              <div class="pull-right">
                <a href="<?php echo $baseurl; ?>client/dashboard" class="btn btn-default" > Go Back</a>
                  <button type="button" name="btnSave" onClick="printdiv('printme')" class="btn btn-success"> <i class="fa fa-print"></i> Print</button>
  
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