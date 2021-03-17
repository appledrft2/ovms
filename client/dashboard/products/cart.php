<?php 
session_start();
include('../../../includes/autoload.php');
if(isset($_POST['btnLogout'])){
  session_unset();
  header('location:'.$baseurl.'');
}
if(isset($_SESSION['dbu'])){ 
  if($_SESSION['dbc'] != true){
      header("location:".$baseurl."employees/dashboard");
  }
}else{
  header('location:'.$baseurl.'');
}
$pages = 'product/cart';


$oc = 'none';
$sql = "SELECT id,fullname,phone,province,city,barangay,postal,street,message FROM tbl_delivery_address WHERE client_id = ? AND order_code = ?";
$qry = $connection->prepare($sql);
$qry->bind_param("is",$_SESSION['dbu'],$oc);
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
      <div class="row" >
        <div class="col-md-12">
          <div class="box">
            <div class="box-header"></div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-12" id="deladd">
                  <form method="POST" action="#">
                    <p class="form-inline"><input type="text" class="form-control"  readonly name="order_code" value="OR-<?php echo rand(199999,599999); ?>"></p>
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
                      <div class="pull-right">
                        <button type="submit" name="btnUpdateAddress" class="btn btn-primary" > Update Address</button>
                      </div>
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
                        <th>Action</th>  
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                       $oc = '';
                       $cempty = false;
                       $i = 1;
                       $sql = "SELECT cc.id,p.name,cc.quantity,p.selling,p.id FROM tbl_client_cart AS cc INNER JOIN tbl_product AS p ON cc.product_id = p.id WHERE cc.client_id = ? AND cc.order_code = ?";
                       $qry = $connection->prepare($sql);
                       $qry->bind_param("is",$_SESSION['dbu'],$oc);
                       $qry->execute();
                       $qry->bind_result($id,$dbpn,$dbq,$dbp,$dbpid);
                       $qry->store_result();
                       while($qry->fetch()){
                         $sub = 0;
                         $sub = $dbp * $dbq;
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
                         echo $dbq;
                         echo "<input type='hidden' name='quantity[]' value='".$dbq."'> ";

                           echo"</td>";
                            echo"<td class='text-right'>";
                          echo "&#8369;".number_format($sub,2);
                           echo"</td>";
                         echo"<td width='5%'>";
                         echo '
                           <a href="delete.php?id='.$id.'" ';?>onclick="return confirm('Are you sure?')"<?php echo 'class="btn btn-danger btn-sm" ><i class="fa fa-remove"></i></a>';
                         echo"</td>";
                         echo"</tr>";
                       }
                       if($qry->num_rows == 0){
                        $cempty = true;
                        echo '<tr><td colspan="6" class="text-center">Your cart is currently empty.</td></tr>';
                       }

                     ?>
                    </tbody>
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
                
                    <label>Upload Proof of Payment (.jpg/.png): <i class="text-red">*</i></label>
                    <input type="file" class="form-control" <?php if($cempty == true){ echo 'disabled';} ?> name="proof_of_pay" accept="image/*" >
                
               
                  </div>
                 
                </div>
              </div>
              <br>
              <div class="pull-right">
                <button type="submit" name="btnCheckout" class="btn btn-success" <?php if($cempty == true){ echo 'disabled';} ?> > Confirm Checkout</button>
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

<?php 
if(isset($_POST['btnUpdateAddress'])){
    $oc = 'none';
    $cid = $_SESSION['dbu'];
    $sql1 = "SELECT count(id) FROM tbl_delivery_address WHERE client_id = ? AND order_code = ?";
    $qry1 = $connection->prepare($sql1);
    $qry1->bind_param("is",$cid,$oc);
    $qry1->execute();
    $qry1->bind_result($id);
    $qry1->store_result();
    $qry1->fetch();

    if($id == 0){

      $sql = "INSERT INTO tbl_delivery_address(fullname,phone,province,city,barangay,street,postal,message,client_id,order_code) VALUES(?,?,?,?,?,?,?,?,?,?)";
      $qry = $connection->prepare($sql);
      $qry->bind_param("ssssssssis",$_POST['fullname'],$_POST['phone'],$_POST['province'],$_POST['city'],$_POST['barangay'],$_POST['street'],$_POST['postal'],$_POST['message'],$cid,$oc);
      $qry->execute();
    
    }else{

      $sql2 = "UPDATE tbl_delivery_address SET fullname=?,phone=?,province=?,city=?,barangay=?,street=?,postal=?,message=? WHERE client_id = ? AND order_code = ?";
      $qry2 = $connection->prepare($sql2);
      $qry2->bind_param("ssssssssis",$_POST['fullname'],$_POST['phone'],$_POST['province'],$_POST['city'],$_POST['barangay'],$_POST['street'],$_POST['postal'],$_POST['message'],$cid,$oc);
      $qry2->execute();
      
    }

    echo "<script>
       Toast.fire({
         icon: 'info',
         title: 'Delivery Address Successfully Updated'
       })</script>";
    echo '<script>$("#deladd").load(location.href + " #deladd");</script>';

    
}if(isset($_POST['btnCheckout'])){

  $order_code =  $_POST['order_code'];
  $client_id = $_SESSION['dbu'];
  $status = "Pending";
  $pop = 'image_path';
  $cart_count = count($_POST['pid']);


  $sql = "INSERT INTO tbl_order(status,proof_of_payment,client_id,order_code) VALUES(?,?,?,?)";
  $qry = $connection->prepare($sql);
  $qry->bind_param("ssis",$status,$pop,$client_id,$order_code);
  if($qry->execute()){


    $sql2 = "INSERT INTO tbl_delivery_address(fullname,phone,province,city,barangay,street,postal,message,client_id,order_code) VALUES(?,?,?,?,?,?,?,?,?,?)";
    $qry2 = $connection->prepare($sql2);
    $qry2->bind_param("ssssssssis",$_POST['fullname'],$_POST['phone'],$_POST['province'],$_POST['city'],$_POST['barangay'],$_POST['street'],$_POST['postal'],$_POST['message'],$client_id,$order_code);
    $qry2->execute();



    if($cart_count != 0){

      for($i = 0; $i <= $cart_count;$i++){

         $sql3 = "UPDATE tbl_client_cart SET order_code = ? WHERE id = ?";
         $qry3 = $connection->prepare($sql3);
         $qry3->bind_param('si',$order_code,$_POST['pid'][$i]);
         $qry3->execute();


      }
    }


  echo "<script>alert('Transaction Successfully Processed.')</script>";
  }



  

}
?>