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
$pages = 'receiving/index';
?>
<?php include('../header.php'); ?>
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
          <h1 class="col-md-6 text-left">
            <span class="text-left">Stock In List</span>

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
              <a href="add.php" class="btn btn-success btn-md"><i class="fa fa-plus-circle"></i> Stock In</a>
            </div>
            <div class="box-body">
              <table id="table1" class="table table-bordered">
                <thead style="background-color: #222d32;color:white;">
                  <tr>
                    <th>Code</th>
                    <th>Supplier</th>
                    <th>Delivery Date</th>
                    <th>Total</th>
                    <th>Processed By</th>
                    <th>Date Added</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    $sql = "SELECT s.id,s.delivery_code,s.delivery_date,s.supplier,s.timestamp,s.total,e.firstname,e.lastname FROM tbl_stockin AS s INNER JOIN tbl_employee AS e ON e.id = s.processed_by ORDER BY s.timestamp ASC";
                    $qry = $connection->prepare($sql);
                    $qry->execute();
                    $qry->bind_result($id,$dbdc, $dbd,$dbs, $dbtimestamp,$dbtotal,$ef,$el);
                    $qry->store_result();
                    while($qry->fetch ()) {
                      $dbtimestamp = date("M d, Y h:ia", strtotime($dbtimestamp));
                      echo"<tr>";
                      echo"<td>";
                      echo $dbdc;
                      echo"</td>";
                      echo"<td>";
                      echo $dbs;
                      echo"</td>";
                      echo"<td>";
                      echo $dbd;
                      echo"</td>";
                      echo"<td class='text-right'>&#8369;";
                      echo number_format($dbtotal,2);
                      echo"</td>";
                      echo"<td class='text-right'>";
                      echo "$ef $el";
                      echo"</td>";
                      echo"</td>";
                      echo"<td class='text-right' width='15%'>";
                      echo $dbtimestamp;
                      echo"</td>";
                      echo"<td width='10%'>";
                      echo '<a class="btn btn-default btn-sm" href="view.php?id='.$id.'"><i class="fa fa-print"></i></a>
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
