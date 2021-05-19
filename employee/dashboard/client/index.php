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
$pages = 'client/index';
?>
<?php include('../header.php'); ?>
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
          <h1 class="col-md-6 text-left">
            <span class="text-left">Client List</span>

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
          }if($_GET['status'] == 'updated'){
            echo '<div class="alert alert-info alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <p><i class="icon fa fa-info"></i>  Record Successfully Updated.</p>
                     
                    </div>';
          }if($_GET['status'] == 'deleted'){
            echo '<div class="alert alert-danger alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <p><i class="icon fa fa-remove"></i>  Record Successfully Deleted.</p>
                     
                    </div>';
          }
        }
      ?>
      <div class="row">
        <div class="col-md-12">

          <div class="box">
            <div class="box-header">
            </div>
            <div class="box-body">
              <table id="table1" class="table table-bordered">
                <thead style="background-color: #222d32;color:white;">
                  <tr>
                    <th>Client Num</th>
                    <th>Firstname</th>
                    <th>Middlename</th>
                    <th>Lastname</th>
                    <th>Gender</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Register Date</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    $sql = "SELECT id,client_num,firstname,middlename,lastname,gender,phone,status,timestamp FROM tbl_client ORDER BY timestamp ASC";
                    $qry = $connection->prepare($sql);
                    $qry->execute();
                    $qry->bind_result($id,$client_num, $dbf,$dbm, $dbl, $dbg,$dbp,$dbst,$dbtimestamp);
                    $qry->store_result();
                    while($qry->fetch ()) {
                      $dbtimestamp = date("M d, Y h:ia", strtotime($dbtimestamp));
                      echo"<tr>";
                      echo"<td>";
                      echo $client_num;
                      echo"</td>";
                      echo"<td>";
                      echo $dbf;
                      echo"</td>";
                      echo"<td>";
                      echo $dbm;
                      echo"</td>";
                      echo"<td>";
                      echo $dbl;
                      echo"</td>";
                      echo"<td>";
                      echo $dbg;
                      echo"</td>";
                      echo"<td>";
                      echo $dbp;
                      echo"</td>";
                       echo"<td class='text-center'>";
                       echo "<form method='POST' action='update_stat.php'  >";
                       if($dbst == 'Activated'){
                         echo '<input type="hidden" name="id" value="'.$id.'">';
                         echo "<select name='chngstatus' class='form-control form-control-sm' onchange='this.form.submit()'>
                         <option value='' disabled>Select Status</option>
                         <option selected>Activated</option>
                         <option>Deactivated</option>
                         </select>";
                       }else{
                         echo '<input type="hidden" name="id" value="'.$id.'">';
                         echo "<select name='chngstatus' class='form-control form-control-sm' onchange='this.form.submit()'>
                         <option value='' disabled>Select Status</option>
                         <option>Activated</option>
                         <option selected>Deactivated</option>
                         </select>";
                       }
                      echo "</form>";

                       echo"</td>";
                      echo"<td class='text-right' width='15%'>";
                      echo $dbtimestamp;
                      echo"</td>";
                      echo"<td width='10%'>";
                      echo '<a class="btn btn-info btn-sm" href="view.php?id='.$id.'"><i class="fa fa-search"></i></a>
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
