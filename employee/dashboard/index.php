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

include('sales_income.php');
include('order_income.php');
include('appointment_income.php');




$pages ='dashboard/index';
?>
<?php include('header.php'); ?>
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
          <h1 class="col-md-6 text-left">
            <span class="text-left">Overview</span>

          </h1>
          <h2 class="col-md-6 text-right">
            <span class="text-right"><i class="fa fa-calendar"></i> <?php echo date('D, M. d Y') ?></span>
          </h2>
        </div>
      </section>

    <!-- Main content -->
    <section class="content">
      <div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <p><i class="icon fa fa-dollar"></i>OVERALL TOTAL INCOME OF SALES, COMPLETED APPOINTMENTS, AND ORDERS IS DISPLAYED BELOW.</p>
       
      </div>
      <div class="row">
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                  <span class="info-box-icon bg-green">&#8369;</span>

                  <div class="info-box-content">
                    <span class="info-box-text">Daily Income</span>
                    <span class="info-box-number">&#8369; <?php echo number_format($today + $o_today + $a_today,2);  ?></span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                  <span class="info-box-icon bg-red">&#8369;</span>

                  <div class="info-box-content">
                    <span class="info-box-text">Weekly Income</span>
                    <span class="info-box-number">&#8369; <?php echo number_format($week + $o_week + $a_week,2);  ?></span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->
               <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                  <span class="info-box-icon bg-default">&#8369;</span>

                  <div class="info-box-content">
                    <span class="info-box-text">Monthly Income</span>
                    <span class="info-box-number">&#8369; <?php echo number_format($month + $o_month + $a_month,2);  ?></span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                  <span class="info-box-icon bg-blue">&#8369;</span>

                  <div class="info-box-content">
                    <span class="info-box-text">Annual Income</span>
                    <span class="info-box-number">&#8369; <?php echo number_format($year + $o_year + $a_year,2);  ?></span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->

      </div>
      <?php 
        if(isset($_GET['status'])){
          if($_GET['status'] == 'approved'){
            echo '<div class="alert alert-success alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <p><i class="icon fa fa-check"></i>  Appointment Successfully Approved.</p>
                     
                    </div>';
          }if($_GET['status'] == 'completed'){
            echo '<div class="alert alert-success alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <p><i class="icon fa fa-check"></i>  Appointment Successfully Completed.</p>
                     
                    </div>';
          }if($_GET['status'] == 'followup'){
            echo '<div class="alert alert-success alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <p><i class="icon fa fa-check"></i>  Appointment Successfully Followed Up.</p>
                     
                    </div>';
          }if($_GET['status'] == 'rescheduled'){
            echo '<div class="alert alert-info alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <p><i class="icon fa fa-info"></i>  Appointment Has Been Rescheduled.</p>
                     
                    </div>';
          }if($_GET['status'] == 'declined'){
            echo '<div class="alert alert-warning alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <p><i class="icon fa fa-info"></i>  Appointment Has Been Declined.</p>
                     
                    </div>';
          }if($_GET['status'] == 'deleted'){
            echo '<div class="alert alert-danger alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <p><i class="icon fa fa-remove"></i>  Appointment Successfully Deleted.</p>
                     
                    </div>';
          }
        }
      ?>
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header">
              <label>Upcomming Appointments</label><br>
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
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  
                  $sql = "SELECT ap.id,cl.firstname,cl.middlename,cl.lastname,ap.type,ap.appointment_date,ap.status,ap.timestamp,em.firstname,em.middlename,em.lastname,ap.total FROM tbl_appointment as ap INNER JOIN tbl_client as cl ON ap.client_id = cl.id INNER JOIN tbl_employee as em ON ap.veterinarian_id = em.id WHERE ap.status = 'Approved' ORDER BY ap.appointment_date ASC";
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
                      echo "<a href='finalize.php?id=".$id."' class='btn btn-default btn-sm ' ><i class='fa fa-edit'></i> Finalize</a>";
                      echo"</td>";   
                      echo"</tr>";   
                    }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="box">
            <div class="box-header">
              <label>Appointment Request</label>
            </div>
            <div class="box-body">
              <table id="table12" class="table">
                <thead style="background-color: #222d32;color:white;">
                  <tr>
                    <th width="20%">Client</th>
                    <th>Type</th>
                    <th>Veterinarian</th>
                    <th>Date of Appoinment</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Date Requested</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  
                  $sql = "SELECT ap.id,cl.firstname,cl.middlename,cl.lastname,ap.type,ap.appointment_date,ap.status,ap.timestamp,em.firstname,em.middlename,em.lastname,ap.total,ap.iscancelled FROM tbl_appointment as ap INNER JOIN tbl_client as cl ON ap.client_id = cl.id LEFT JOIN tbl_employee as em ON ap.veterinarian_id = em.id WHERE status = 'Pending'";
                  $qry = $connection->prepare($sql);
                  $qry->execute();
                  $qry->bind_result($id,$dbf,$dbm,$dbl,$dbt,$dba,$dbs,$dbtimestamp,$dbf2,$dbm2,$dbl2,$dbtotal,$dbisc);
                  $qry->store_result();
                  while($qry->fetch ()) {
                      echo"<tr>";
                      echo"<td >";
                      echo $dbf." ".$dbm.' '.$dbl;
                      echo"</td>"; 
                      echo"<td>";
                      echo $dbt;
                      echo"</td>";
                      echo"<td class='text-center'>";
                      if($dbf2 != '' && $dbl2 != ''){
                        echo "Dr. ".$dbf2." ".$dbm2[0].". ".$dbl2;
                      }else{
                        echo '-';
                      }
                      echo"</td>";  
                      echo"<td class='text-center'>";
                      if($dba == ''){
                        echo '-';
                      }else{
                        echo $dba;
                      }
                      echo"</td>";  
                      echo"<td >";
                      if($dbisc == 'true'){
                        echo 'Client Cancelled';
                      }else{
                        echo $dbs;
                      }
                      echo"</td>";
                      echo"<td class='text-right'>";
                      echo '&#8369; '.number_format($dbtotal,2);
                      echo"</td>";
                      echo"<td class='text-right'>";
                      echo $dbtimestamp;
                      echo"</td>";   
                      echo"<td>";

                      if($dbisc == 'true'){
                        echo '<button type="button" class="btn btn-default btn-sm" href="#" disabled><i class="fa fa-search"></i> View</button>
                                      &nbsp;<a href="delete_app.php?id='.$id.'" ';?>onclick="return confirm('Are you sure you want to delete this appointment?')"<?php echo 'class="btn btn-danger btn-sm" ><i class="fa fa-remove"></i></a>';
                      }else{
                        echo '<a class="btn btn-default btn-sm" href="view.php?id='.$id.'"><i class="fa fa-search"></i> View</a>
                                      &nbsp;<a href="delete_app.php?id='.$id.'" ';?>onclick="return confirm('Are you sure you want to delete this appointment?')"<?php echo 'class="btn btn-danger btn-sm" ><i class="fa fa-remove"></i></a>';
                      }

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

