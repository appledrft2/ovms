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
$pages = 'product/index';
?>
<?php include('../header.php'); ?>
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
          <h1 class="col-md-6 text-left">
            <span class="text-left">Products List</span>

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
              <a href="add.php" class="btn btn-success btn-md"><i class="fa fa-plus-circle"></i> Add Product</a>
            </div>
            <div class="box-body">
              <table id="table1" class="table table-bordered">
                <thead style="background-color: #222d32;color:white;">
                  <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Unit</th>
                    <th>Supplier Price</th>
                    <th>Selling Price</th>
                    <th>Quantity</th>
                    <th>Status</th>
                    <th>Date Added</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody id="tbod">
                  <?php 
                    $sql = "SELECT id,name,category,unit,original,selling,quantity,status,timestamp FROM tbl_product ORDER BY timestamp ASC";
                    $qry = $connection->prepare($sql);
                    $qry->execute();
                    $qry->bind_result($id,$dbn, $dbc, $dbu,$dbo,$dbs,$dbq,$dbst,$dbtimestamp);
                    $qry->store_result();
                    while($qry->fetch ()) {
                      echo"<tr>";
                      echo"<td>";
                      echo $dbn;
                      echo"</td>";
                      echo"<td>";
                      echo $dbc;
                      echo"</td>";
                      echo"<td>";
                      echo $dbu;
                      echo"</td>";
                      echo"<td class='text-right'>&#8369;";
                      echo number_format($dbo,2);
                      echo"</td>";
                      echo"<td class='text-right'>&#8369;";
                      echo number_format($dbs,2);
                      echo"</td>";
                      echo"<td class='text-center'>";
                      echo $dbq;
                      echo"</td>";
                      echo"<td class='text-center'>";
                      echo "<form method='POST' action='update_stat.php'  >";
                      if($dbst == 'Available'){
                        echo '<input type="hidden" name="id" value="'.$id.'">';
                        echo "<select name='chngstatus' class='form-control form-control-sm' onchange='this.form.submit()'>
                        <option value='' disabled>Select Status</option>
                        <option selected>Available</option>
                        <option>Not Available</option>
                        </select>";
                      }else{
                        echo '<input type="hidden" name="id" value="'.$id.'">';
                        echo "<select name='chngstatus' class='form-control form-control-sm' onchange='this.form.submit()'>
                        <option value='' disabled>Select Status</option>
                        <option>Available</option>
                        <option selected>Not Available</option>
                        </select>";
                      }
                     echo "</form>";

                      echo"</td>";
                      echo"<td class='text-center'>";
                      echo $dbtimestamp;
                      echo"</td>";
                      echo"<td>";
                      echo '<a class="btn btn-info btn-sm" href="edit.php?id='.$id.'"><i class="fa fa-edit"></i></a>
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

