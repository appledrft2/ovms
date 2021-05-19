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
$pages ='reports/index';



$sql = "SELECT id,invoicecode,total,payment,chnge,timestamp FROM tbl_stockout WHERE id = ?";
$qry = $connection->prepare($sql);
$qry->bind_param("i",$_GET['id']);
$qry->execute();
$qry->bind_result($stockout_id,$dbic, $dbt,$dbp, $dbch,$dbtimestamp);
$qry->store_result();
$qry->fetch ();
$dbtimestamp  = date_create($dbtimestamp);
?>
<?php include('../header.php'); ?>
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
          <h1 class="col-md-6 text-left">
            <span class="text-left">Invoice</span>

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
                <form id="printme">
                <center>
                  <img src="<?php echo $baseurl ?>/logo.jpg" width="100px" style="border:1px solid black"><br>
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
                    <label>Invoice #<?php echo $dbic; ?></label>
                    
                  </div>
                </div>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Product name</th>
                      <th>Category</th>
                      <th>Unit</th>
                      <th>Price</th>
                      <th>Quantity</th>
                      <th>Subtotal</th>
                      
                    </tr>
                  </thead>
                  <tbody id="tblprod">
                    <?php $sql = "SELECT p.name,p.category,p.unit,p.selling,sp.quantity FROM tbl_stockout_product as sp INNER JOIN tbl_product AS p ON sp.product_id = p.id WHERE sp.stockout_id = ?";
                                         $qry = $connection->prepare($sql);
                                         $qry->bind_param("i",$_GET['id']);
                                         $qry->execute();
                                         $qry->bind_result($dbpname,$dbpc, $dbpu,$dbpp,$dbspq);
                                         $qry->store_result();
                                         $subtotal = 0;
                                         while($qry->fetch ()){
                                           $subtotal = $dbpp * $dbspq;
                                           echo '<tr>
                                               <td>
                                                 '.$dbpname.'
                                               </td>
                                      
                                               
                                               <td>'.$dbpc.'</td>
                                               <td>'.$dbpu.'</td>
                                               <td>&#8369; '.number_format($dbpp,2).'</td>
                                               <td>'.$dbspq.'</td>
                                               <td class="text-center">&#8369; '.number_format($subtotal,2).'</td>

                                             </tr>';

                                         }

                                       ?>
                  </tbody >
                  <tfoot border="0">
                      
                      <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td >
                          
                           
                            <div class="pull-right">
                              <label class="pull-right">Total:</label><br>
                              
                              <label class="pull-right">Payment:</label><br>
                    
                              <label class="pull-right">Change:</label><br>
                            
                            </div>
                     

                        </td>
                        <td>
                          <div class="text-center">
                            <label style="font-weight:normal; border-top:1px solid black;">&#8369; <?php echo number_format($dbt,2) ?></label><br>
                            
                            <label style="font-weight:normal;">&#8369; <?php echo number_format($dbp,2) ?></label><br>
                          
                            <label style="font-weight:normal;">&#8369; <?php echo number_format($dbch,2) ?></label><br>
                          
                          </div>

                        </td>
                      </tr>
                    
                  </tfoot>
                </table>
              </form>
              </div>

              <div class="box-footer">
             
                <div class="pull-right">
                  <a href="<?php echo $baseurl; ?>employee/dashboard/reports" class="btn btn-default" > Go Back</a>
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
<script src="<?php echo $baseurl ?>template/plugins/sweetalert2.all.min.js"></script>
<!-- Select2 -->
<script src="<?php echo $baseurl ?>template/bower_components/select2/dist/js/select2.full.min.js"></script>
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
