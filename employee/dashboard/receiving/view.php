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
$pages ='receiving/index';

 
$sql = "SELECT id,delivery_code,delivery_date,supplier,timestamp,total FROM tbl_stockin WHERE id = ?";
$qry = $connection->prepare($sql);
$qry->bind_param("i",$_GET['id']);
$qry->execute();
$qry->bind_result($stockin_id,$dbdc, $dbd,$dbs, $dbtimestamp,$dbtotal);
$qry->store_result();
$qry->fetch ();
?>
<?php include('../header.php'); ?>
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
          <h1 class="col-md-6 text-left">
            <span class="text-left">Stock In</span>

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
              <div id="printme">
              <div class="box-header">

                <div class="row">
                  <div class="col-md-6">
                    <label>Delivery #: <i style="color:red">*</i></label>
                    <input type="text" class="form-control dcode" value="<?php echo $dbdc ?>" name="dcode" required >
                    
                    <label>Supplier Name: <i style="color:red">*</i></label>
                    <input type="text" class="form-control supplier" name="supplier" value="<?php echo $dbs ?>" required>
                    
                   
                  </div>
                  <div class="col-md-6">
                    <label>Delivery Date: <i style="color:red">*</i></label>
                    <input type="date" class="form-control ddate" name="ddate" value="<?php echo $dbd ?>" required>
                    <label>Date Added: <i style="color:red">*</i></label>
                    <input type="text" class="form-control ddate" name="ddate" value="<?php echo $dbtimestamp; ?>" required>
                   
                  </div>
                 
                </div>
              </div>
              <div class="box-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Product name</th>
                      <th>Update Supplier Price</th>
                      <th>Update Selling Price</th>
                      <th>Qty to Add</th>
                      <th>Subtotal</th>
                    </tr>
                  </thead>
                  <tbody id="tblprod">
                    <?php $sql = "SELECT p.name,sp.original,sp.selling,sp.quantity FROM tbl_stockin_product as sp INNER JOIN tbl_product AS p ON sp.product_id = p.id WHERE sp.stockin_id = ?";
                      $qry = $connection->prepare($sql);
                      $qry->bind_param("i",$_GET['id']);
                      $qry->execute();
                      $qry->bind_result($dbpname,$dbspo, $dbsps,$dbspq);
                      $qry->store_result();
                      $subtotal = 0;
                      while($qry->fetch ()){
                        $subtotal = $dbspo * $dbspq;
                        echo '<tr>
                            <td>
                              '.$dbpname.'
                            </td>
                   
                            
                            <td>'.$dbspo.'</td>
                            <td>'.$dbsps.'</td>
                            <td>'.$dbspq.'</td>
                            <td>&#8369; '.number_format($subtotal,2).'</td>

                          </tr>';

                      }

                    ?>
                    
                  </tbody>
                  <tfoot>
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td ><label>Total:</label> &#8369; <?php echo number_format($dbtotal,2); ?></td>
                    </tr>
                  </tfoot>
                </table>
              </div>
              </div>
              <div class="box-footer">
                <div class="pull-right">
                  <a href="<?php echo $baseurl; ?>employee/dashboard/receiving" class="btn btn-default" > Go Back</a>
                  <button type="button" onclick="printdiv('printme')" name="btnSave" class="btn btn-primary"><i class="fa fa-print"></i> Print</button>
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
<script src="<?php echo $baseurl ?>template/plugins/sweetalert2.all.min.js"></script>

<script type="text/javascript">

  function printdiv(printpage)
  {
  var headstr = "<html><head><title></title></head><body>";
  var footstr = "</body>";
  var newstr = document.all.item(printpage).innerHTML;
  var oldstr = document.body.innerHTML;
  document.body.innerHTML = headstr+newstr+footstr;
  window.print();
  document.body.innerHTML = oldstr;
  return false;
  }

</script>
<?php 
if(isset($_POST['btnSave'])){

    $sql = "INSERT INTO tbl_stockin(delivery_code,delivery_date,supplier) VALUES(?,?,?)";
    $qry = $connection->prepare($sql);
    $qry->bind_param("sss",$_POST['dcode'],$_POST['ddate'],$_POST['supplier']);

    if($qry->execute()) {

      $last_id = mysqli_insert_id($connection);
      $total = $subtotal = $original = $quantity =  0;
      $prod_arr = count($_POST['prodid']);

      for($i = 0;$i < $prod_arr;$i++){

        $sql = "INSERT INTO tbl_stockin_product(stockin_id,product_id,original,selling,quantity) VALUES(?,?,?,?,?)";
        $qry = $connection->prepare($sql);
        $qry->bind_param('iissi',$last_id,$_POST['prodid'][$i],$_POST['original'][$i],$_POST['selling'][$i],$_POST['quantity'][$i]);

        $subtotal = $_POST['original'][$i] * $_POST['quantity'][$i];

        $total = $total + $subtotal;

        if($qry->execute()){

            $sql = "SELECT quantity FROM tbl_product WHERE id = ?";
            $qry = $connection->prepare($sql);
            $qry->bind_param('i',$_POST['prodid'][$i]);
            $qry->execute();
            $qry->bind_result($dbpquantity);
            $qry->store_result();
            $qry->fetch();

            $dbpquantity = $dbpquantity + $_POST['quantity'][$i];

            $sql = "UPDATE tbl_product SET original=?,selling=?,quantity=? WHERE id=?";
            $qry = $connection->prepare($sql);
            $qry->bind_param("sssi",$_POST['original'][$i],$_POST['selling'][$i],$dbpquantity,$_POST['prodid'][$i]);

            if($qry->execute()) {
              $sql = "UPDATE tbl_stockin SET total=? WHERE id=?";
              $qry = $connection->prepare($sql);
              $qry->bind_param("si",$total,$last_id);

              if($qry->execute()){
                echo '<meta http-equiv="refresh" content="0; URL=index.php?status=created">';
              }

            }
  
        }else{
          echo '<meta http-equiv="refresh" content="0; URL=index.php?status=error">';
        }
      }
      
    }else{
      
      echo '<meta http-equiv="refresh" content="0; URL=index.php?status=error">';

    }
}
?>