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
$pages = 'appointment/book';



$dbstatus = false;

$sql = "SELECT status FROM tbl_appointment WHERE client_id=?";
$qry = $connection->prepare($sql);
$qry->bind_param("i",$_SESSION['dbu']);
$qry->execute();
$qry->bind_result($status);
$qry->store_result();
while($qry->fetch ()){
  if($status == 'pending' || $status == 'approved'){
    $dbstatus = true;
  }
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
            <span class="text-left">Book Appointment</span>

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
          if($_GET['status'] == 'created'){
            echo '<div class="alert alert-success alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <p><i class="icon fa fa-check"></i>  Record Successfully Added.</p>
                     
                    </div>';
          }
        }if($dbstatus == true){
            echo '<div class="alert alert-warning alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <p><i class="icon fa fa-warning"></i>Unable to book: You still have an existing appointment in progress.</p>
                   
                  </div>';
        }
      ?>
      <div class="row">
        <div class="col-md-12">

          <div class="box">
            <div class="box-header">
              
            </div>
            <div class="box-body table-responsive">
              <table id="table3" class="table table-bordered  table-hover table-responsive">
                <thead>
                  <tr>
                    <th>Available Date</th>
                    <th>Day</th>
                    <th>Slot Available</th>
                    <th>Veterinarian</th>
           
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    
                    $sql = "SELECT s.id,e.firstname,e.lastname,s.schedule_date,s.slot,s.comment,s.timestamp FROM tbl_schedule AS s INNER JOIN tbl_employee AS e ON e.id = s.veterinarian_id ORDER BY s.schedule_date ASC";
                    $qry = $connection->prepare($sql);
                    $qry->execute();
                    $qry->bind_result($id,$dbefn,$dbeln, $dbs, $dbslot,$dbcomment,$dbtimestamp);
                    $qry->store_result();
                    while($qry->fetch ()) {

                      $date_now = date("Y-m-d");

                      if ($date_now < $dbs) {
                        $dbs = date("M d, Y", strtotime($dbs));
                        echo"<tr>";
                        echo"<td class='text-center'>";
                        echo $dbs;
                        echo"</td>";
                        echo"<td class='text-center'>";
                        echo date_format(new DateTime($dbs),'l');
                        echo"</td>";
                        echo"<td class='text-center' width='10%'>";
                        echo $dbslot;
                        echo"</td>";
                        echo"<td class='text-center'>";
                        echo 'Dr. '.$dbefn.' '.$dbeln;
                        echo"</td>";
                        
                        echo"<td width='10%' class='text-center'>";
                        if($dbslot == 0 || $dbstatus == true){
                          echo '<a href="#" class="btn btn-primary disabled"><i class="fa fa-hand-o-right"></i>  Book Now</a>';
                        }else{
                          echo '<a href="book.php?id='.$id.'" class="btn btn-primary "><i class="fa fa-hand-o-right"></i>  Book Now</a>';
                        }
                        
                        echo"</td>";
                        echo"</tr>";
                          

                      }
                      

                      
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
