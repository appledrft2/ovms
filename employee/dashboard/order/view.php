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

$sqlo = "SELECT order_code,proof_of_payment FROM tbl_order WHERE id = ?";
$qryo = $connection->prepare($sqlo);
$qryo->bind_param("i",$_GET['id']);
$qryo->execute();
$qryo->bind_result($oc,$pop);
$qryo->store_result();
$qryo->fetch();


$sql = "SELECT id,fullname,phone,province,city,barangay,postal,street,message FROM tbl_delivery_address WHERE order_code = ?";
$qry = $connection->prepare($sql);
$qry->bind_param("s",$oc);
$qry->execute();
$qry->bind_result($id,$dbfn,$dbp,$dbpr,$dbc,$dbb,$dbpt,$dbs,$dbm);
$qry->store_result();
$qry->fetch();

if($dbfn == ''){
  $dbfn = $_SESSION['dbf']." ".$_SESSION['dbl'];
}if($dbp == ''){
  $dbp = $_SESSION['dbphone'];
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
            <span class="text-left">CART</span>

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
          if($_GET['status'] == 'success'){
            echo '<div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <p><i class="icon fa fa-check"></i>  Transaction Successfully Processed.</p>
                   
                  </div>';
          }
        }
      ?>
      <a href="<?php echo $baseurl; ?>employee/dashboard/order" class="btn btn-default" > Go Back</a><br><br>
      <div class="row" >
        <div class="col-md-12">
          <div class="box">
            <div class="box-header"></div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-12" id="deladd">
                  <form method="POST" action="#" enctype="multipart/form-data">
                    <p class="form-inline"><input type="text" class="form-control"  readonly name="order_code" value="<?php echo $oc; ?>"></p>
                    <hr>
                  <h4 class=""><i class="fa fa-truck"></i> Delivery Address</h4>
                  <div class="row">
                    <div class="col-md-6">
                      
                        <label>Fullname: <i class="text-red">*</i></label>
                        <input type="text" class="form-control" name="fullname" value="<?php echo $dbfn; ?>">
                        <label>Phone Number: <i class="text-red">*</i></label>
                        <input type="text" class="form-control" name="phone" value="<?php echo $dbp; ?>">
                       
                        <label>Special Notes: <i class="text-red"></i></label>
                        <textarea class="form-control" rows="3" name="message" placeholder="(Optional)"><?php echo $dbm; ?></textarea>
                      
                    </div>
                    <div class="col-md-6">
        
                        
                        <label>Province: <i class="text-red">*</i></label>
                        <input type="text" class="form-control" name="province" value="<?php echo $dbpr; ?>">
                        <label>City: <i class="text-red">*</i></label>
                        <input type="text" class="form-control" name="city" value="<?php echo $dbc; ?>">
                        <label>Barangay: <i class="text-red">*</i></label>
                        <input type="text" class="form-control" name="barangay" value="<?php echo $dbb; ?>">
                        <label>Purok/Street: <i class="text-red">*</i></label>
                        <input type="text" class="form-control" name="street" value="<?php echo $dbs; ?>">
                        <label>Postal Code: <i class="text-red">*</i></label>
                        <input type="text" class="form-control" name="postal" value="<?php echo $dbpt; ?>">
                   
                    </div>
                    <div class="col-md-12">
                      <br>
                     
                    </div>
                  </div>
                  <hr>
              
                </div>
              
                <div class="col-md-12">
                   <h4 class=""><i class="fa fa-shopping-cart"></i> Cart</h4>
                  <table class="table table-bordered table-hover">
                    <thead style="background-color: #222d32;color:white;">
                      <tr>
                        <th width="5%">#</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                     
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
  
                       $ctotal = 0;
                       $cempty = false;
                       $i = 1;
                       $sql = "SELECT cc.id,p.name,cc.quantity,p.selling,p.id FROM tbl_client_cart AS cc INNER JOIN tbl_product AS p ON cc.product_id = p.id WHERE  cc.order_code = ?";
                       $qry = $connection->prepare($sql);
                       $qry->bind_param("s",$oc);
                       $qry->execute();
                       $qry->bind_result($id,$dbpn,$dbq,$dbp,$dbpid);
                       $qry->store_result();
                       while($qry->fetch()){
                         $sub = 0;
                         $sub = $dbp * $dbq;
                         $ctotal = $ctotal + $sub;
                         echo"<tr>";
                         echo"<td>";
                         echo $i++;
                         echo"</td>";
                         echo"<td>";
                         echo $dbpn;
                         echo "<input type='hidden' name='pid[]' value='".$id."'> ";
                         echo"</td>";
                          echo"<td class='text-right'>";
                         echo "&#8369;".number_format($dbp,2);
                         echo"</td>";
                         echo"<td class='text-center'>";
                         echo $dbq." pcs";
                         echo "<input type='hidden' name='quantity[]' value='".$dbq."'> ";

                           echo"</td>";
                            echo"<td class='text-right'>";
                          echo "&#8369;".number_format($sub,2);
                         
                         echo"</tr>";
                       }
                       if($qry->num_rows == 0){
                        $cempty = true;
                        echo '<tr><td colspan="6" class="text-center">Your cart is currently empty.</td></tr>';
                       }

                     ?>

                    </tbody>
                    <?php if($ctotal != 0){ ?>
                    <tfoot>
                      <tr><td></td><td></td><td></td><td></td><td class="text-right"><b>Total Amount:</b> &#8369;<?php echo number_format($ctotal,2); ?></td></tr>
                    </tfoot>
                    <?php } ?>
                  </table>
                </div>
              </div>
            </div>
            <div class="box-footer">
              <div class="row">
                <div class="col-md-6">
                  
                </div>
                <div class="col-md-6">
                   <div class="pull-right">
                
                    <label>Proof of Payment: <i class="text-red">*</i></label><br>
                    <img src="<?php echo $baseurl ?>client/dashboard/products/<?php echo $pop; ?>" width="200px" height="200px">
                    <br>
                    <a href="<?php echo $baseurl ?>client/dashboard/products/<?php echo $pop; ?>" class="btn btn-block btn-success" download> Download</a>
               
                  </div>
                 
                </div>
              </div>
              <br>
              <div class="pull-right">
                
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
<script type="text/javascript">
  const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  })
</script>

