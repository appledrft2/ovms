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
$pages = 'order/index';

$sqlo = "SELECT o.order_code,o.timestamp,c.firstname,c.lastname,o.total FROM tbl_order AS o INNER JOIN tbl_client AS c ON c.id = o.client_id WHERE o.id = ?";
$qryo = $connection->prepare($sqlo);
$qryo->bind_param("i",$_GET['id']);
$qryo->execute();
$qryo->bind_result($oc,$dbtimestamp,$dbf,$dbl,$dbt);
$qryo->store_result();
$qryo->fetch();

$dbfn = $dbf." ".$dbl; 


$dbtimestamp  = date_create($dbtimestamp);

$sql = "SELECT tax,shipping FROM tbl_order_settings WHERE id = 1";
$qry = $connection->prepare($sql);
$qry->execute();
$qry->bind_result($dbtax, $dbshipping);
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
            <span class="text-left">View Order</span>

          </h1>
          <h2 class="col-md-6 text-right">
            <span class="text-right"><i class="fa fa-calendar"></i> <?php echo date('D, M. d Y') ?></span>
          </h2>
        </div>
      </section>

    <!-- Main content -->
    <section class="content">
    
        <div class="row">
          <div class="col-md-6" style="float:none;margin:auto;">
            <div class="box">
              <div class="box-header"> 
                
               
              </div>
              <div class="box-body">
                <form id="printme" >
                <center>
                  <img src="<?php echo $baseurl ?>logo.jpg" width="100px" style="border:1px solid black"><br>
                  <b style="text-transform: uppercase;">Bath & Bark Grooming and Veterinary Services</b>
                  <p>
                    Bauan-Batangas Road<br>
                    Poblacion, San Pascual, Philippines<br>
                    Contact No.: 09178827552
                  </p>
                </center>
                <div class="row">
                  <div class="col-md-6">
                 
                    <label>Date: <?php echo date_format($dbtimestamp,"M d, Y"); ?></label><br>
                    <label>Invoice #<?php echo $oc; ?></label>
                    
                  </div>
                  <div class="col-md-6">
                 
                    <label>Client Name: <?php echo ucwords($dbfn) ?></label><br>
                    
                  </div>
                </div>
                <table class="table table-bordered">
                  <thead>
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
                            echo"<td class='text-center'>";
                          echo "&#8369;".number_format($sub,2);
                         
                         echo"</tr>";
                       }
                       if($qry->num_rows == 0){
                        $cempty = true;
                        echo '<tr><td colspan="6" class="text-center">Your cart is currently empty.</td></tr>';
                       }

                     ?>
                  </tbody >
                  <tfoot border="0">
                      
                      <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                    
                    
                        <td >
                          
                           
                            <div class="pull-right">
                              <label class="pull-right">Subtotal:</label><br>
                              
                              <label class="pull-right">Tax:</label><br>
                              <label class="pull-right">Shipping:</label><br>
                    
                              <label class="pull-right">Total:</label><br>
                            
                            </div>
                     

                        </td>
                        <td>
                          <div class="text-center">
                        
                            <label style="font-weight:normal;">&#8369; <?php echo number_format($ctotal,2) ?></label><br>
                            <label style="font-weight:normal;"><?= $dbtax ?> %</label><br>

                            <label style="font-weight:normal;">&#8369; <?php echo number_format($dbshipping,2) ?></label><br>
                          
                            <label style="font-weight:normal;">&#8369; <?php echo number_format($dbt,2) ?></label><br>
                          
                          </div>

                        </td>
                      </tr>
                    
                  </tfoot>
                </table>
              </form>
              </div>

              <div class="box-footer">
             
                <div class="pull-right">
                  <a href="<?php echo $baseurl; ?>employee/dashboard/order" class="btn btn-default" > Go Back</a>
                  <button type="button" name="btnSave" onClick="printdiv('printme')" class="btn btn-primary"> <i class="fa fa-print"></i> Print</button>
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
<script language="javascript">
  function printdiv(printpage) {
    var headstr = "<html><head><title></title></head><body>";
    var footstr = "</body>";
    var newstr = document.all.item(printpage).innerHTML;
    var oldstr = document.body.innerHTML;
    document.body.innerHTML = headstr + newstr + footstr;
    window.print();
    document.body.innerHTML = oldstr;
    return false;
  }
</script>