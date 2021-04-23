<?php 
header('location:products/index.php');
session_start();
include('../../includes/autoload.php');
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
$pages = 'dashboard/index';
?>
<?php include('header.php'); ?>
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
          if($_GET['status'] == 'requested'){
            echo '<div class="alert alert-success alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <p><i class="icon fa fa-check"></i>  Appointment Successfully Requested.</p>
                     
                    </div>';
          }if($_GET['status'] == 'cancelled'){
            echo '<div class="alert alert-danger alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <p><i class="icon fa fa-remove"></i>  Appointment Successfully Cancelled.</p>
                     
                    </div>';
          }
        }
      ?>
      <div class="box">

        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
                <div class="row" id="tblappointments">
                    <div class="col-md-12">
                      <a href="request.php" class="btn btn-success">Request Schedule</a>
                          <br><br>
                         <table id="table1" class="table table-bordered table-hover">
                           <thead>
                           <tr>
                            <th>Type</th>
                            <th>Veterinarian</th>
                            <th>Date of Appointment</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Date Requested</th>
                            <th>Action</th>
                           
                           </tr>
                           </thead>
                           <tbody>
                            <?php 
                            
                            $i = 0;
                            $sql = "SELECT ap.id,ap.type,emp.firstname,emp.lastname,ap.appointment_date,ap.status,ap.timestamp,ap.total,ap.iscancelled FROM tbl_appointment AS ap LEFT JOIN tbl_employee AS emp ON emp.id = ap.veterinarian_id WHERE ap.client_id = ?";
                            $qry = $connection->prepare($sql);
                            $qry->bind_param("i",$_SESSION['dbu']);
                            $qry->execute();
                            $qry->bind_result($id,$dbt,$dbfn,$dbln,$dba,$dbs,$dbtimestamp,$dbtotal,$dbisc);
                            $qry->store_result();
                            while($qry->fetch ()) {
                                $dbad = date_create($dba);
                                echo"<tr>";
                                echo"<td class='text-center'>";
                                echo $dbt;
                                echo"</td>"; 
                                echo"<td class='text-center'>";
                               if($dbfn != '' && $dbln != ''){
                                echo 'Doc. '.$dbfn.' '.$dbln;
                               }else{
                                echo '-';
                               }
                                echo"</td>";  
                                echo"<td class='text-center'>";
                                if($dba == ''){
                                  echo '-';
                                }else{
                                  echo date_format($dbad,'M d,Y');
                                }
                                echo"</td>";  
                                echo"<td class='text-center'>";
                                if($dbisc == 'true'){
                                  echo 'Cancelled';
                                }else{
                                  echo $dbs;
                                }
                                echo"</td>";
                                echo"</td>";  
                                echo"<td class='text-right'>";
                                echo '&#8369;'.number_format($dbtotal,2);
                                echo"</td>";
                                echo"<td class='text-right'>";
                                echo $dbtimestamp;
                                echo"</td>";    
                                echo"<td width='15%'>";
                                if($dbs != 'Pending'){
                                   echo '<a class="btn btn-default btn-sm" href="view.php?id='.$id.'"><i class="fa fa-search"></i> View</a>
                                     &nbsp;<a href="#" class="btn btn-danger btn-sm" disabled><i class="fa fa-remove"></i>Cancel</a>';
                                }
                                else{
                                  if($dbisc == 'true'){
                                    echo '<a class="btn btn-default btn-sm" href="view.php?id='.$id.'"><i class="fa fa-search"></i> View</a>
                                      &nbsp;<a href="#" class="btn btn-danger btn-sm" disabled><i class="fa fa-remove"></i>Cancel</a>';

                                  }else{
                                    echo '<a class="btn btn-default btn-sm" href="view.php?id='.$id.'"><i class="fa fa-search"></i> View</a>
                                      &nbsp;<a href="cancel_appointment.php?id='.$id.'" ';?>onclick="return confirm('Are you sure you want to cancel this appointment?')"<?php echo 'class="btn btn-danger btn-sm" ><i class="fa fa-remove"></i> Cancel</a>';
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
