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

$sql = "SELECT tax,shipping FROM tbl_order_settings WHERE id = 1";
$qry = $connection->prepare($sql);
$qry->execute();
$qry->bind_result($dbtax, $dbshipping);
$qry->store_result();
$qry->fetch ();

?>

<?php include('../header.php'); ?>
  <!-- =============================================== -->
  <style>
    .list-center{
      padding: 40px 0!important;
    }

    input[type=number]::-webkit-inner-spin-button {
        opacity: 1
    }
    .d-none{
      display: none!important;
    }
  </style>
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
      <!-- Main content -->
      <section class="invoice">
        <!-- title row -->
        <div class="row">
          <div class="col-md-12">
            <h2 class="page-header">
              <i class="fa fa-shopping-cart"></i> Shopping Cart
            </h2>
          </div>
          <!-- /.col -->
        </div>
       

        <!-- Table row -->
        <div class="row">
          <div class="col-md-12 table-responsive">
            
            <table class="table table-striped table-bordered table-hover">
              <thead>
              <tr>
                <th>Image</th>
                <th>Product</th>
                <th>Category</th>
                <th>Price</th>
                <th>Instock</th>
                <th>Quantity</th>
                <th>Subtotal</th>
                <th>Action</th>
              </tr>
              </thead>
              <tbody>
                
                <?php 
                  $oc = '';
                  $cart_total = 0;
                  $cempty = false;
                  $i = 1;
                  $sql = "SELECT cc.id,p.name,cc.quantity,p.selling,p.id,p.category,p.image_path,p.quantity FROM tbl_client_cart AS cc INNER JOIN tbl_product AS p ON cc.product_id = p.id WHERE cc.client_id = ? AND cc.order_code = ?";
                  $qry = $connection->prepare($sql);
                  $qry->bind_param("is",$_SESSION['dbu'],$oc);
                  $qry->execute();
                  $qry->bind_result($id,$dbpn,$dbq,$dbp,$dbpid,$dbcat,$dbip,$instock);
                  $qry->store_result();
                  while($qry->fetch()){
                    $sub = 0;
                    $sub = $dbp * $dbq;
                    $cart_total = $cart_total + $sub;
                ?>
                  <tr style="font-size: 20px;">
                    <td><img src="<?= $baseurl ?>employee/dashboard/products/<?= $dbip ?>" style="width: 100px;height:100px;border:1px solid black">
                    </td>
                    <td class="list-center"><?= $dbpn ?></td>
                    <td class="list-center"><?= $dbcat ?></td>
                    <td class="list-center text-right">&#8369; <?= number_format($dbp,2) ?></td>
                    <td class="list-center text-center"><?= $instock ?></td>
                    <td class="list-center text-center">
                      <form method='POST' action='update_quantity.php'  >
                        <input type="hidden" name="id" value="<?= $id ?>">
                        <input type="number" name="changeQuantity" onchange='this.form.submit()' class="text-center" value="<?= $dbq ?>" min="1" max="50">
                      </form>
                    </td>
                    <td class="list-center text-right">&#8369; <?= number_format($sub,2) ?></td>
                    <td class="list-center text-center">
                      <?php
                      echo '<a href="delete.php?id='.$id.'" ';?>onclick="return confirm('Are you sure?')"<?php echo 'class="btn btn-danger " ><i class="fa fa-trash"></i></a>'
                      ?>
                    </td>

                  </tr>
                      
                 <?php
                  }

                  if($qry->num_rows == 0){
                   $cempty = true;
                   echo '<tr><td colspan="8" style="font-size: 20px;" class="list-center text-center">Your cart is currently empty.</td></tr>';
                  }

                  ?>

              </tbody>
            </table>
            <form action="#" method="POST" id="paymentComplete">
              <?php

              $sql2 = "SELECT cc.id FROM tbl_client_cart AS cc INNER JOIN tbl_product AS p ON cc.product_id = p.id WHERE cc.client_id = ? AND cc.order_code = ?";
              $qry2 = $connection->prepare($sql2);
              $qry2->bind_param("is",$_SESSION['dbu'],$oc);
              $qry2->execute();
              $qry2->bind_result($id);
              $qry2->store_result();
              while($qry2->fetch()){
                echo "<input type='hidden' name='pid[]' value='".$id."'>";
              }
              ?>
              <button type="submit" name="btnComplete" id="btnComplete" style="display:none">test</button>
            </form>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
       
      </section>
      <!-- /.content -->
      <section class="invoice <?= ($sub == 0) ? 'd-none' : ''; ?> ">
        <div class="row ">
          
          <div class="col-md-8">
            <p class="lead" >Amount Due</p>

            <div class="table-responsive">
              <table class="table">
                <tr>
                  <th style="width:50%">Subtotal:</th>
                  <td>&#8369; <?= number_format($cart_total,2) ?></td>
                </tr>
                <tr>
                  <th>Tax</th>
                  <td><?=$dbtax?> %</td>
                </tr>
                <tr>
                  <th>Shipping:</th>
                  <td>&#8369;<?= number_format($dbshipping,2) ?></td>
                </tr>
                <tr>
                  <th>Total:</th>
                  <td>&#8369; <?php 
                  if($dbtax != 0){
                   $taxtodeci =  $dbtax / 100;
                   $taxsum = $cart_total * $taxtodeci;
                   $cart_total = $cart_total + $taxsum;
                  }if($dbshipping != 0){
                    $cart_total = $cart_total + $dbshipping;
                  }
                  
                  echo number_format($cart_total,2) 

                 ?></td>
                </tr>
              </table>
            </div>
          </div>
          <!-- /.col -->
          
          <!-- accepted payments column -->
          <div class="col-md-4" id="payment">
            <p class="lead">Payment Method:</p>

              <script src="https://www.paypal.com/sdk/js?client-id=AUQBopAKT2W6JHA_vOaEqyqorZm4ptUO1zPtbjmnQwzwRINZxhVGK-Z21m1Y5CoYAQxKFB7mwVRlmbnt&currency=PHP"> // Replace YOUR_CLIENT_ID with your sandbox client ID
            </script>

            <div id="paypal-button-container" class=""></div>
           

            <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
              Easily pay your products online thru paypal payment gateway.
            </p>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </section>
      
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
 
  paypal.Buttons({
    createOrder: function(data, actions) {
      return actions.order.create({
        purchase_units: [{"amount":{"currency_code":"PHP","value":<?= $cart_total ?>}}]
      });
    },
    onApprove: function(data, actions) {
      return actions.order.capture().then(function(details) {
        iscomplete();
        
      });
    }
  }).render('#paypal-button-container'); // Display payment options on your web page
 

 function iscomplete(){
  Swal.fire(
    'Transaction Successfully Completed',
    '',
    'success'
  );
  setTimeout(function(){ $('#btnComplete').trigger('click'); }, 1500);
  
 }
</script>

<?php


if(isset($_POST['btnComplete'])){
  
 

  $order_code =  "OR-".rand(199999,599999);
  $client_id = $_SESSION['dbu'];
  $status = "Completed";
  $cart_count = count($_POST['pid']);


  $sql = "INSERT INTO tbl_order(status,client_id,order_code,total) VALUES(?,?,?,?)";
  $qry = $connection->prepare($sql);
  $qry->bind_param("siss",$status,$client_id,$order_code,$cart_total);
  if($qry->execute()){

    $last_id = $qry->insert_id;

    if($cart_count != 0){
      for($i = 0; $i <= $cart_count;$i++){
         $sql3 = "SELECT p.id,cc.quantity,p.quantity FROM tbl_client_cart AS cc INNER JOIN tbl_product AS p ON cc.product_id = p.id WHERE cc.id=?";
         $qry3 = $connection->prepare($sql3);
         $qry3->bind_param('i',$_POST['pid'][$i]);
         $qry3->execute();
         $qry3->bind_result($prodid,$ccquant,$pquant);
         $qry3->store_result();
         $qry3->fetch();

         $newquant = $pquant - $ccquant;

         $sql4 = "UPDATE tbl_client_cart SET order_code = ? WHERE id = ?";
         $qry4 = $connection->prepare($sql4);
         $qry4->bind_param('si',$order_code,$_POST['pid'][$i]);
         $qry4->execute();

         $sql5 = "UPDATE tbl_product SET quantity = ? WHERE id = ?";
         $qry5 = $connection->prepare($sql5);
         $qry5->bind_param('si',$newquant,$prodid);
         $qry5->execute();


      }
    }
    echo '<meta http-equiv="refresh" content="0; URL='.$baseurl.'client/dashboard/order/view.php?id='.$last_id.'">';
 

  }


 



 

}

?>