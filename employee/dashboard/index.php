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
      <div class="row">
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                  <span class="info-box-icon bg-green">&#8369;</span>

                  <div class="info-box-content">
                    <span class="info-box-text">Daily Income</span>
                    <span class="info-box-number">&#8369; 0.00</span>
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
                    <span class="info-box-number">&#8369; 0.00</span>
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
                    <span class="info-box-number">&#8369; 0.00</span>
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
                    <span class="info-box-number">&#8369; 0.00</span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->

      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="box">
            <div class="box-header">
              <label>Upcomming Appointments</label>
            </div>
            <div class="box-body">
              <table id="table1" class="table">
                <thead>
                  <tr>
                    <th>Client</th>
                    <th>Type</th>
                    <th>Date of Appointment</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="box">
            <div class="box-header">
              <label>Appointment Request</label>
            </div>
            <div class="box-body">
              <table id="table11" class="table">
                <thead>
                  <tr>
                    <th width="20%">Client</th>
                    <th>Type</th>
                    <th>Date of Appoinment</th>
                    <th>Veterinarian</th>
                    <th>Status</th>
                    <th>Date Requested</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  
                  $sql = "SELECT ap.id,cl.firstname,cl.lastname,ap.type,ap.appointment_date,ap.status,ap.timestamp,em.firstname,em.lastname FROM tbl_appointment as ap INNER JOIN tbl_client as cl ON ap.client_id = cl.id INNER JOIN tbl_employee as em ON ap.veterinarian_id = em.id";
                  $qry = $connection->prepare($sql);
                  $qry->execute();
                  $qry->bind_result($id,$dbf,$dbl,$dbt,$dba,$dbs,$dbtimestamp,$dbf2,$dbl2);
                  $qry->store_result();
                  while($qry->fetch ()) {
                      echo"<tr>";
                      echo"<td>";
                      echo $dbf." ".$dbl;
                      echo"</td>"; 
                      echo"<td>";
                      echo $dbt;
                      echo"</td>";  
                      echo"<td>";
                      if($dba == ''){
                        echo '-';
                      }else{
                        echo $dba;
                      }
                      echo"</td>";  
                      echo"<td>";
                      echo "Dr. ".$dbf2." ".$dbl2;
                      echo"</td>";
                      echo"<td>";
                      echo $dbs;
                      echo"</td>";
                      echo"<td>";
                      echo $dbtimestamp;
                      echo"</td>";   
                      echo"<td>";
                      echo "<button id=".$id." class='btn btn-default btn-sm btn_details' data-toggle='modal' data-target='#modal-default'><i class='fa fa-list'></i></button>";
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
    <div class="modal fade" id="modal-default">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Default Modal</h4>
          </div>
          <div class="modal-body">
            <p>One fine body&hellip;</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
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
