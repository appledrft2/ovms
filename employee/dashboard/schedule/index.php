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
$pages = 'appointment/schedule';
?>
<?php include('../header.php'); ?>
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
          <h1 class="col-md-6 text-left">
            <span class="text-left">Doctor Schedule</span>

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
                      <p><i class="icon fa fa-check"></i>  Schedule Successfully Added.</p>
                     
                    </div>';
          }if($_GET['status'] == 'deleted'){
            echo '<div class="alert alert-danger alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <p><i class="icon fa fa-remove"></i>  Schedule Successfully Deleted.</p>
                     
                    </div>';
          }if($_GET['status'] == 'updated'){
            echo '<div class="alert alert-info alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <p><i class="icon fa fa-info"></i>  Schedule Successfully Updated.</p>
                     
                    </div>';
          }
        }
      ?>
      <div class="row">
        <div class="col-md-12">

          <div class="box">
            <div class="box-header">
              <a href="add.php" class="btn btn-success"><i class="fa fa-calendar-check-o"></i>&nbsp; Add Schedule</a>
            </div>
            <div class="box-body">
              <table id="table3" class="table table-bordered  table-hover">
                <thead>
                  <tr>
                    <th>Available Date</th>
                    <th>Day</th>
                    <th>Slot Available</th>
                    <th>Veterinarian</th>
                    <th>Date Added</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    if($_SESSION['dbet'] == 'Veterinarian'){
                    $sql = "SELECT s.id,e.firstname,e.lastname,s.schedule_date,s.slot,s.comment,s.timestamp FROM tbl_schedule AS s INNER JOIN tbl_employee AS e ON e.id = s.veterinarian_id WHERE s.veterinarian_id = ? ORDER BY s.schedule_date DESC";
                    $qry = $connection->prepare($sql);
                    $qry->bind_param('i',$_SESSION['dbu']);
                    $qry->execute();
                    }else{
                      $sql = "SELECT s.id,e.firstname,e.lastname,s.schedule_date,s.slot,s.comment,s.timestamp FROM tbl_schedule AS s INNER JOIN tbl_employee AS e ON e.id = s.veterinarian_id ORDER BY s.schedule_date DESC";
                      $qry = $connection->prepare($sql);
                      $qry->execute();
                    }
                    $qry->bind_result($id,$dbefn,$dbeln, $dbs, $dbslot,$dbcomment,$dbtimestamp);
                    $qry->store_result();
                    while($qry->fetch ()) {
                      $dbs = date("M d, Y", strtotime($dbs));
                      echo"<tr>";
                      echo"<td class='text-center'>";
                      echo $dbs;
                      echo"</td>";
                      echo"<td class='text-center'>";
                      echo date_format(new DateTime($dbs),'l');
                      echo"</td>";
                      echo"<td class='text-center'>";
                      echo $dbslot;
                      echo"</td>";
                      echo"<td>";
                      echo 'Dr. '.$dbefn.' '.$dbeln;
                      echo"</td>";
                      echo"<td class='text-right' width='15%'>";
                      echo $dbtimestamp;
                      echo"</td>";
                      echo"<td width='10%' class='text-center'>";
                      echo '
                        <a href="delete.php?id='.$id.'" ';?>onclick="return confirm('Are you sure?')"<?php echo 'class="btn btn-danger btn-sm" ><i class="fa fa-remove"></i></a>';
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
