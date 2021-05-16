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
$pages = 'appointment/index';
?>
<?php include('../header.php'); ?>
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
          <h1 class="col-md-6 text-left">
            <span class="text-left">Completed Appointments</span>

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
          if($_GET['status'] == 'deleted'){
            echo '<div class="alert alert-danger alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <p><i class="icon fa fa-remove"></i>  Appointment Successfully Deleted.</p>
                     
                    </div>';
          }if($_GET['status'] == 'updated'){
            echo '<div class="alert alert-info alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <p><i class="icon fa fa-info"></i>  Appointment Successfully Updated.</p>
                     
                    </div>';
          }
        }
      ?>
      <div class="row">
        <div class="col-md-12">

          <div class="box">
            <div class="box-header">
              <form target="_blank" method="POST" action="print.php">
                <div class="form-inline">
                <label>Date From :<i style="color:red"></i></label>
                <input type="date" class="form-control" name="dfrom" required>
                <label>To :<i style="color:red"></i></label>
                <input type="date" class="form-control" name="dto" required>

                <button type="submit" name="print" class="btn btn-success btn-md"><i class="fa fa-print"></i> Print</button> 
              </form>
            </div>
            <div class="box-body">
              <table id="table3" class="table">
                <thead style="background-color: #222d32;color:white;">
                  <tr>
                    <th>Client</th>
                    <th>Type</th>
                    <th>Veterinarian</th>
                    <th>Date of Appointment</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th width="10%">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  
                  $sql = "SELECT ap.id,cl.firstname,cl.middlename,cl.lastname,ap.type,ap.appointment_date,ap.status,ap.timestamp,em.firstname,em.middlename,em.lastname,ap.total FROM tbl_appointment as ap INNER JOIN tbl_client as cl ON ap.client_id = cl.id INNER JOIN tbl_employee as em ON ap.veterinarian_id = em.id WHERE ap.status = 'Completed' ORDER BY ap.appointment_date ASC";
                  $qry = $connection->prepare($sql);
                  $qry->execute();
                  $qry->bind_result($id,$dbf,$dbm,$dbl,$dbt,$dba,$dbs,$dbtimestamp,$dbf2,$dbm2,$dbl2,$dbtotal2);
                  $qry->store_result();
                  while($qry->fetch ()) {
                    $dba = date_create($dba);
                      echo"<tr>";
                      echo"<td>";
                      echo $dbf." ".$dbm." ".$dbl;
                      echo"</td>"; 
                      echo"<td>";
                      echo $dbt;
                      echo"</td>";
                      echo"<td>";
                      echo "Dr. ".$dbf2." ".$dbm2[0].". ".$dbl2;
                      echo"</td>";  
                      echo"<td class='text-center'>";
                      echo date_format($dba,'M d,Y');
                      echo"</td>";  
                      echo"<td>";
                      echo $dbs;
                      echo"</td>";
                      echo"<td class='text-right'>";
                      echo '&#8369; '.number_format($dbtotal2,2);
                      echo"</td>";
                      
                      echo"<td>";
                      echo '<a href="view.php?id='.$id.'" class="btn btn-default btn-sm " ><i class="fa fa-search"></i> View</a>&nbsp;<a href="delete_app.php?id='.$id.'" ';?>onclick="return confirm('Are you sure you want to delete this appointment?')"<?php echo 'class="btn btn-danger btn-sm" ><i class="fa fa-remove"></i></a>';
                      echo"</td>";   
                      echo"</tr>";   
                    }
                  ?>
                </tbody>
              </table>
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
