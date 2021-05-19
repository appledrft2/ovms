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
$pages ='service_reports/index';



$sql = "SELECT a.id,a.total,a.timestamp,c.firstname,c.lastname,e.firstname,e.lastname FROM tbl_appointment AS a INNER JOIN tbl_client AS c ON c.id = a.client_id INNER JOIN tbl_employee AS e ON e.id = a.veterinarian_id WHERE a.id = ?";
$qry = $connection->prepare($sql);
$qry->bind_param("i",$_GET['id']);
$qry->execute();
$qry->bind_result($id,$dbt,$dbtimestamp,$cf,$cl,$ef,$el);
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
                  <img src="http://localhost/ovms/logo.jpg" width="100px" style="border:1px solid black"><br>
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
                    <label>Appointment #: <?php echo $id; ?></label>
                    
                  </div>
                  <div class="col-md-6">
                    <label for="">Veterinarian: Dr. <?= $ef.' '.$el ?></label>
                    <br>
                    <label for="">Client: <?= $cf.' '.$cl ?></label>
                  </div>
                </div>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Service Name</th>
                      <th class="text-center" width="15%">Subtotal</th>
                      
                    </tr>
                  </thead>
                  <tbody id="tblprod">
                    <?php 
                        $sql = "SELECT ap.id,s.name,s.price FROM tbl_appointment_pet AS ap INNER JOIN tbl_service AS s ON s.id = ap.service_id WHERE ap.appointment_id = ?";
                       $qry = $connection->prepare($sql);
                       $qry->bind_param("i",$_GET['id']);
                       $qry->execute();
                       $qry->bind_result($apid,$sname1,$sprice1);
                       $qry->store_result();
                       $subtotal = 0;
                       while($qry->fetch ()){
                         echo '<tr>';
                         echo '<td>';
                         echo $sname1;
                         echo '</td>';
                         echo '<td class="text-center">&#8369;';
                         echo number_format($sprice1,2);
                         echo '</td>';
                         echo '</tr>';

                         $sqlx = "SELECT aps.id,s.name,s.price FROM tbl_ap_service AS aps INNER JOIN tbl_service AS s ON s.id = aps.service_id WHERE aps.appointment_pet_id = ?";

                        $qryx = $connection->prepare($sqlx);
                        $qryx->bind_param("i",$apid);
                        $qryx->execute();
                        $qryx->bind_result($apsid,$sname,$sprice);
                        $qryx->store_result();
                        $subtotal = 0;
                        while($qryx->fetch ()){
                         
                        echo '<td>
                            '.$sname.'
                            </td>
                            <td class="text-center">&#8369;
                            '.number_format($sprice,2).'
                            </td>';


                          
                        }
                        echo '</tr>';
                       }

                     ?>
                  </tbody >
                  <tfoot border="0">
                      
                      <tr>
                      
                       
                        <td >
                          
                           
                            <div class="pull-right">
                              <label class="pull-right">Total:</label><br>
                              
                            
                            </div>
                     

                        </td>
                        <td>
                          <div class="text-center">
                            <label style="font-weight:normal; border-top:1px solid black;">&#8369; <?php echo number_format($dbt,2) ?></label><br>
                            
                           
                          
                          </div>

                        </td>
                      </tr>
                    
                  </tfoot>
                </table>
              </form>
              </div>

              <div class="box-footer">
             
                <div class="pull-right">
                  <a href="<?php echo $baseurl; ?>employee/dashboard/service_reports" class="btn btn-default" > Go Back</a>
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
