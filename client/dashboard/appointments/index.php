<?php 
session_start();
include('../../../includes/autoload.php');
if(isset($_POST['btnLogout'])){
  session_unset();
  header('location:'.$baseurl.'');
}
if(isset($_SESSION['dbu'])){ 
  if($_SESSION['dbc'] != true){
      header("location:".$baseurl."employee/dashboard");
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
            <span class="text-left">My Appointments</span>

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
          if($_GET['status'] == 'cancelled'){
            echo '<div class="alert alert-danger alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <p><i class="icon fa fa-remove"></i>  Appointment has been cancelled.</p>
                     
                    </div>';
          }if($_GET['status'] == 'created'){
            echo '<div class="alert alert-success alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <p><i class="icon fa fa-check"></i>  Appointment Successfully Booked.</p>
                     
                    </div>';
          }
        }
      ?>
      <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <p><i class="icon fa fa-print"></i>Please print your booking reservation before you arrive at the clinic. thank you!</p>
         
        </div>
      <div class="row">
        <div class="col-md-12">

          <div class="box">
            <div class="box-header">
              
            </div>
            <div class="box-body">
              <table id="table1" class="table table-bordered  table-hover table-responsive">
                <thead>
                  <tr>
                    <th>Appointment No.</th>
                    <th>Appointment Date</th>
                    <th>Day</th>
                    <th>Veterinarian</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    
                    $sql = "SELECT a.id,s.schedule_date,e.firstname,e.lastname,a.status,a.iscancelled FROM tbl_appointment AS a INNER JOIN tbl_schedule AS s ON s.id = a.schedule_id INNER JOIN tbl_employee AS e ON a.veterinarian_id = e.id WHERE a.client_id = ? ORDER BY s.schedule_date ASC";
                    $qry = $connection->prepare($sql);
                    $qry->bind_param("i",$_SESSION['dbu']);
                    $qry->execute();
                    $qry->bind_result($id,$ssd,$ef,$el,$dbst,$dbisc);
                    $qry->store_result();
                    while($qry->fetch ()) {
                      $ssd = date("M d, Y", strtotime($ssd));
                      echo"<tr>";
                      echo"<td class='text-center'>";
                      echo $id;
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
                      echo"<td class='text-center'>";

                        if($dbst == 'Booked'){
                          if($dbisc == 'true'){
                           echo '<button class="btn btn-primary  btn-sm" disabled onclick="printExternal('.$id.')"  ><i class="fa fa-print"></i>&nbsp;Print</button>&nbsp;<a class="btn btn-danger btn-sm" disabled ><i class="fa fa-remove"></i> Cancelled</a>';
                          }else{
                           echo '<a class="btn btn-primary btn-sm" href="#" onclick="printExternal('.$id.')"  ><i class="fa fa-print"></i>&nbsp;Print</a>&nbsp;<a href="cancel.php?id='.$id.'" ';?>onclick="return confirm('Are you sure you want to cancel this Appointment?')"<?php echo 'class="btn btn-danger btn-sm" ><i class="fa fa-remove"></i> Cancel </a>';
                          }
                        }else{
                          if($dbisc == 'true'){
                           echo '<button class="btn btn-primary btn-sm" disabled onclick="printExternal('.$id.')"  ><i class="fa fa-print"></i>&nbsp;Print</button>&nbsp;<a class="btn btn-danger btn-sm" disabled ><i class="fa fa-remove"></i> Cancelled</a>';
                          }else{
                           echo '<a class="btn btn-primary btn-sm"  onclick="printExternal('.$id.')"  ><i class="fa fa-print"></i>&nbsp;Print</a>&nbsp;<a  class="btn btn-danger btn-sm" disabled><i class="fa fa-remove"></i> Cancel </a>';
                          }
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
<script>
  function printExternal(url) {
    var url2 = 'print.php?id='+url; 
    var printWindow = window.open( url2, 'Print', 'left=200, top=200, width=950, height=500, toolbar=0, resizable=0');

    printWindow.addEventListener('load', function() {
        if (Boolean(printWindow.chrome)) {
            printWindow.print();
            setTimeout(function(){
                printWindow.close();
            }, 500);
        } else {
            printWindow.print();
            printWindow.close();
        }
    }, true);
}
</script>
