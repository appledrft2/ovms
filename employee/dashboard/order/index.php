<?php 
session_start();
include('../../../includes/autoload.php');
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
$pages = 'order/index';
?>
<?php include('../header.php'); ?>
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
          <h1 class="col-md-6 text-left">
            <span class="text-left">Client Orders</span>

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
                      <p><i class="icon fa fa-remove"></i>  Record Successfully Deleted.</p>
                     
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
              <table id="table1" class="table table-bordered">
                <thead style="background-color: #222d32;color:white;">
                  <tr>
                    <th>Order Code</th>
                    <th>Client Name</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Date Processed</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    $sql = "SELECT o.id,o.order_code,o.status,o.total,o.timestamp,o.iscancelled,c.firstname,c.middlename,c.lastname FROM tbl_order AS o INNER JOIN tbl_client AS c ON c.id = o.client_id ORDER BY timestamp ASC";
                    $qry = $connection->prepare($sql);
                    $qry->execute();
                    $qry->bind_result($id,$dboc, $dbstat, $dbtotal,$dbtimestamp,$dbisc,$dbfn,$dbmn,$dbln);
                    $qry->store_result();
                    while($qry->fetch()){
                      echo"<tr>";
                      echo"<td>";
                      echo $dboc;
                      echo"</td>";
                      echo"<td>";
                      echo $dbfn.' '.$dbmn.' '.$dbln;
                      echo"</td>";
                      echo"<td class='text-right'>";
                      echo '&#8369;'.number_format($dbtotal,2);
                      echo"</td>";
                      echo"<td width='10%' class='text-center'>";
                      if($dbisc == 'true' ){
                        echo 'Order Cancelled';
                      }else{
                      echo "<form method='POST' action='update_stat.php'  >";
                        if($dbstat == 'Pending'){
                          echo '<input type="hidden" name="id" value="'.$id.'">';
                          echo '<input type="hidden" name="oc" value="'.$dboc.'">';
                          echo "<select name='chngstatus' class='form-control form-control-sm' onchange='this.form.submit()'>
                          <option value='' disabled>Select Status</option>
                          <option selected>Pending</option>
                          <option>Approved</option>
                          <option>Declined</option>
                          <option>Completed</option>

                          </select>";
                        }if($dbstat == 'Approved'){
                          echo '<input type="hidden" name="id" value="'.$id.'">';
                          echo '<input type="hidden" name="oc" value="'.$dboc.'">';
                          echo "<select name='chngstatus' class='form-control form-control-sm' onchange='this.form.submit()'>
                          <option value='' disabled>Select Status</option>
                          <option >Pending</option>
                          <option selected >Approved</option>
                          <option>Declined</option>
                          <option>Completed</option>

                          </select>";
                        }if($dbstat == 'Declined'){
                          echo '<input type="hidden" name="id" value="'.$id.'">';
                          echo '<input type="hidden" name="oc" value="'.$dboc.'">';
                          echo "<select name='chngstatus' class='form-control form-control-sm' onchange='this.form.submit()'>
                          <option value='' disabled>Select Status</option>
                          <option >Pending</option>
                          <option>Approved</option>
                          <option selected>Declined</option>
                          <option>Completed</option>

                          </select>";
                        }if($dbstat == 'Completed'){
                          echo $dbstat;
                        }
                      echo "</form>";
                      }
                      echo"</td>";
                      echo"<td class='text-right'>";
                      echo $dbtimestamp;
                      echo"</td>";
                      echo"<td width='10%'>";
                    
                      echo '<a class="btn btn-default btn-sm " href="view.php?id='.$id.'"><i class="fa fa-search"></i>&nbsp;</a>&nbsp;<a href="delete.php?id='.$id.'" ';?>onclick="return confirm('Are you sure?')"<?php echo 'class="btn btn-danger btn-sm" ><i class="fa fa-remove"></i></a>';
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
