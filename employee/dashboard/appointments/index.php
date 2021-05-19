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
if(isset($_POST['dfrom']) && isset($_POST['dto'])){
  $from = $_POST['dfrom'];
  $to = $_POST['dto'];
}else{
  $from = $to = '';
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
            <span class="text-left">Appointments</span>

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
              <div class="row">
                
                <div class="col-md-6" >
                  <form action="#" method="POST" class="form-inline" style="margin-right:10px;margin-top:5px;">
                    <div class="form-group">
                      <label>From</label>
                      <input type="date" name="dfrom" class="form-control"  required value="<?= $from ?>">
                    </div>
                    <div class="form-group">
                      <label>To</label>
                      <input type="date" name="dto" class="form-control"  required value="<?= $to ?>">
                    </div>
                    <button type="submit" name="btnSearch" class="btn btn-primary"><i class="fa fa-search"></i></button>
                    <a  href="index.php" class="btn btn-default"><i class="fa fa-refresh"></i></a>

                  </form>
                </div>
              </div>
            </div>
            <div class="box-body">
              <table id="table1" class="table table-bordered  table-hover">
                <thead>
                  <tr>
                    <th>Appointment No.</th>
                    <th>Client Name</th>
                    <th>Appointment Date</th>
                    <th>Day</th>
                    <th>Veterinarian</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    if(isset($_POST['btnSearch'])){
                      if($_SESSION['dbet'] == 'Veterinarian'){
                        $sql = "SELECT a.id,s.schedule_date,e.firstname,e.lastname,a.status,a.iscancelled,c.firstname,c.lastname,c.gender,a.total FROM tbl_appointment AS a INNER JOIN tbl_schedule AS s ON s.id = a.schedule_id INNER JOIN tbl_employee AS e ON a.veterinarian_id = e.id INNER JOIN tbl_client AS c ON c.id = a.client_id WHERE a.veterinarian_id = ? AND s.schedule_date BETWEEN ? AND ? ORDER BY s.schedule_date ASC";
                        $qry = $connection->prepare($sql);
                        $qry->bind_param("iss",$_SESSION['dbu'],$_POST['dfrom'],$_POST['dto']);
                        $qry->execute();
                      }else{
                        $sql = "SELECT a.id,s.schedule_date,e.firstname,e.lastname,a.status,a.iscancelled,c.firstname,c.lastname,c.gender,a.total FROM tbl_appointment AS a INNER JOIN tbl_schedule AS s ON s.id = a.schedule_id INNER JOIN tbl_employee AS e ON a.veterinarian_id = e.id INNER JOIN tbl_client AS c ON c.id = a.client_id WHERE s.schedule_date BETWEEN ? AND ? ORDER BY s.schedule_date ASC";
                        $qry = $connection->prepare($sql);
                        $qry->bind_param("ss",$_POST['dfrom'],$_POST['dto']);
                        $qry->execute();
                      }
                    }else{
                      if($_SESSION['dbet'] == 'Veterinarian'){
                        $sql = "SELECT a.id,s.schedule_date,e.firstname,e.lastname,a.status,a.iscancelled,c.firstname,c.lastname,c.gender,a.total FROM tbl_appointment AS a INNER JOIN tbl_schedule AS s ON s.id = a.schedule_id INNER JOIN tbl_employee AS e ON a.veterinarian_id = e.id INNER JOIN tbl_client AS c ON c.id = a.client_id WHERE a.veterinarian_id = ? ORDER BY s.schedule_date ASC";
                        $qry = $connection->prepare($sql);
                        $qry->bind_param("i",$_SESSION['dbu']);
                        $qry->execute();
                      }else{
                        $sql = "SELECT a.id,s.schedule_date,e.firstname,e.lastname,a.status,a.iscancelled,c.firstname,c.lastname,c.gender,a.total FROM tbl_appointment AS a INNER JOIN tbl_schedule AS s ON s.id = a.schedule_id INNER JOIN tbl_employee AS e ON a.veterinarian_id = e.id INNER JOIN tbl_client AS c ON c.id = a.client_id ORDER BY s.schedule_date ASC";
                        $qry = $connection->prepare($sql);
                        $qry->execute();
                      }
                    }
                    

                    $qry->bind_result($id,$ssd,$ef,$el,$dbst,$dbisc,$cfn,$cln,$cg,$dbtotal);
                    $qry->store_result();
                    while($qry->fetch ()) {
                      $cg = ($cg == 'Male') ? 'Mr.' : 'Ms.';
                      $ssd = date("M d, Y", strtotime($ssd));
                      echo"<tr>";
                      echo"<td class='text-center'>";
                      echo $id;
                      echo"</td>";
                      echo"<td class='text-center'>";
                      echo "$cg $cfn $cln";
                      echo"</td>";
                      echo"<td class='text-center'>";
                      echo $ssd;
                      echo"</td>";
                      echo"<td class='text-center'>";
                      echo date_format(new DateTime($ssd),'l');
                      echo"</td>";
                      echo"<td class='text-center'>";
                      echo "Dr.".$ef." ".$el;
                      echo"</td>";                      
                      echo"<td class='text-center'>";
                      $dbst = ucwords($dbst);
                      if($dbst == 'Cancelled'){
                        echo "<span class='label label-danger'>$dbst</span>";
                      }if($dbst == 'Booked'){
                        echo "<span class='label label-warning'>$dbst</span>";
                      }if($dbst == 'In Progress'){
                        echo "<span class='label label-primary'>$dbst</span>";
                      }if($dbst == 'Completed'){
                        echo "<span class='label label-success'>$dbst</span>";
                      }
                      echo"</td>";
                      echo "<td class='text-right'>";
                      echo "&#8369; ".number_format($dbtotal,2);
                      echo "</td>";
                      echo"<td class='text-center'>";
                      if($dbst == 'Booked'){
                        echo "<form method='POST' action='#' style='display:inline'>";
                        echo "<input type='hidden' name='aid' value='$id'>";
                        echo "<button type='submit' name='btnApprove' class='btn btn-success btn-sm' title='Approve Booking' onclick=\"return confirm('Are you sure?')\" ><i class='fa fa-check'></i> Approve</button>&nbsp;";
                        echo "<button type='submit' name='btnCancel' class='btn btn-danger btn-sm' title='Cancel Booking' onclick=\"return confirm('Are you sure?')\"><i class='fa fa-remove'></i> Cancel</button>&nbsp;";
                        echo "</form>";
                          
                      }
                      echo "<a class='btn btn-primary btn-sm' href='view.php?id=".$id."' title='View Details'><i class='fa fa-search'></i></a>";
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
<?php 

  if(isset($_POST['btnApprove']) || isset($_POST['btnCancel'])){

    $stats = (isset($_POST['btnApprove'])) ? 'In Progress' : 'Cancelled';
    $apid = $_POST['aid'];
    
    if($stats == 'In Progress'){
     $activity = "Booking Appointment ID ".$apid." was approved";
    }else{
     $activity = "Booking Appointment ID ".$apid." was cancelled"; 
    }
    

    $sqlx = "INSERT INTO tbl_logs(employee_id,activity) VALUES(?,?)";
    $qryx = $connection->prepare($sqlx);
    $qryx->bind_param("is",$_SESSION['dbu'],$activity);
    $qryx->execute();


    $sql4 = "UPDATE tbl_appointment SET status=? WHERE id=?";
    $qry4 = $connection->prepare($sql4);
    $qry4->bind_param("si",$stats,$_POST['aid']);
    if($qry4->execute()) {
          echo '<meta http-equiv="refresh" content="0; URL=index.php">';
    }
  }

?>