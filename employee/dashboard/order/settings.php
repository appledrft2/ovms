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

  $sql = "SELECT tax,shipping FROM tbl_order_settings WHERE id = 1";
  $qry = $connection->prepare($sql);
  $qry->execute();
  $qry->bind_result($dbtax, $dbshipping);
  $qry->store_result();
  $qry->fetch ();

$pages = 'order/settings';
?>
<?php include('../header.php'); ?>
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
          <h1 class="col-md-6 text-left">
            <span class="text-left">Order Settings</span>

          </h1>
          <h2 class="col-md-6 text-right">
            <span class="text-right"><i class="fa fa-calendar"></i> <?php echo date('D, M. d Y') ?></span>
          </h2>
        </div>
      </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header"></div>
            <div class="box-body">
              <form method="POST" action="#">
              <div class="col-md-6">
                <label>Tax % <i style="color:red">*</i></label>
                <small>(leave empty if none)</small>
                <input type="number" class="form-control" name="tax"  value="<?php echo $dbtax ?>"required>
                <label>Shipping <i style="color:red">*</i></label>
                <small>(leave empty if none)</small>
                <input type="number" class="form-control" name="shipping"  value="<?php echo $dbshipping ?>"required>
              </div>
              <div class="col-md-6">
                
              </div>
              
            </div>
            <div class="box-footer">
              <div class="pull-right">
                <button name="btnSave" class="btn btn-primary" > Save Changes</button>
              </form>
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

<?php 
if(isset($_POST['btnSave'])){

    $tax = ($_POST['tax'] == '') ? 0 : $_POST['tax'];
    $shipping = ($_POST['shipping'] == '') ? 0 : $_POST['shipping'];

    $sql = "UPDATE tbl_order_Settings SET tax=?,shipping=? WHERE id=1";
    $qry = $connection->prepare($sql);
    $qry->bind_param("ss",$tax,$shipping);
    
    if($qry->execute()) {
      echo '<meta http-equiv="refresh" content="0; URL=settings.php?status=updated">';
    }else{
      echo '<meta http-equiv="refresh" content="0; URL=settings.php?status=error">';
    }
}
?>