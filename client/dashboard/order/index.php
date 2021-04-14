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
            <span class="text-left">Order List</span>

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
                      <p><i class="icon fa fa-remove"></i>  The order has been cancelled.</p>
                     
                    </div>';
          }
        }
      ?>
      <div class="row">
        <div class="col-md-12">

          <div class="box">
          
            <div class="box-body">
              <table id="table1" class="table table-bordered">
                <thead style="background-color: #222d32;color:white;">
                  <tr>
                    <th>Order Code</th>
                    <th>Status</th>
                    <th>Total Amount</th>
                    <th>Date Processed</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    $sql = "SELECT id,order_code,status,total,timestamp,iscancelled FROM tbl_order WHERE client_id = ?";
                    $qry = $connection->prepare($sql);
                    $qry->bind_param("i",$_SESSION['dbu']);
                    $qry->execute();
                    $qry->bind_result($id,$dboc, $dbstat, $dbtotal,$dbtimestamp,$dbisc);
                    $qry->store_result();
                    while($qry->fetch()){
                      echo"<tr>";
                      echo"<td>";
                      echo $dboc;
                      echo"</td>";
                      echo"<td>";
                      echo $dbstat;
                      echo"</td>";
                      echo"<td class='text-right'>";
                      echo '&#8369;'.number_format($dbtotal,2);
                      echo"</td>";
                      echo"<td class='text-right'>";
                      echo $dbtimestamp;
                      echo"</td>";
                      echo"<td width='15%'>";

                      if($dbstat == 'Pending'){
                        if($dbisc == 'true'){
                         echo '<a class="btn btn-default btn-sm" href="view.php?id='.$id.'"><i class="fa fa-search"></i>&nbsp;View</a>&nbsp;<a class="btn btn-danger btn-sm" disabled ><i class="fa fa-remove"></i> Order Cancelled</a>';
                        }else{
                         echo '<a class="btn btn-default btn-sm" href="view.php?id='.$id.'"><i class="fa fa-search"></i>&nbsp;View</a>&nbsp;<a href="cancel.php?id='.$id.'" ';?>onclick="return confirm('Are you sure you want to cancel this order?')"<?php echo 'class="btn btn-danger btn-sm" ><i class="fa fa-remove"></i> Cancel Order</a>';
                        }
                      }else{
                        if($dbisc == 'true'){
                         echo '<a class="btn btn-default btn-sm" href="view.php?id='.$id.'"><i class="fa fa-search"></i>&nbsp;View</a>&nbsp;<a class="btn btn-danger btn-sm" disabled ><i class="fa fa-remove"></i> Order Cancelled</a>';
                        }else{
                         echo '<a class="btn btn-default btn-sm" href="view.php?id='.$id.'"><i class="fa fa-search"></i>&nbsp;View</a>&nbsp;<a href="#" class="btn btn-danger btn-sm" disabled><i class="fa fa-remove"></i> Cancel Order</a>';
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
