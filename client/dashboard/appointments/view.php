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
$pages = 'appointment/index';


?>
<?php include('../header.php'); ?>
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
          <h1 class="col-md-6 text-left">
            <span class="text-left">Print</span>

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
            <form method="POST" id="printme" action="#">
            <div class="box-body">
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
                              <style>
                                input.form-control:read-only {
                                        background-color: whitesmoke;
                                    }
                                textarea.form-control:read-only {
                                        background-color: whitesmoke;
                                    }
                              </style>
                              <div class="col-md-6">

                                <h4>Appointment Details</h4>

                                <div class="form-group">
                                  <label for="">Veterinarian</label>
                                  <input type="text" class="form-control" value="<?= $dbef.' '.$dbel ?>" readonly>
                                </div>
                                <div class="form-group">
                                  <label for="">Appointment Date</label>
                                  <input type="date" class="form-control" value="<?= $dbschedule ?>" readonly>
                                </div>
                                <div class="form-group">
                                  <label for="">Available Slots</label>
                                  <input type="number" min="0" class="form-control" value="<?= $dbslot ?>" readonly>
                                </div>

                              </div>
                              <div class="col-md-6">
                                <h4>&nbsp;</h4>
                                <div class="form-group">
                                  <label for="">Veterinarian Remarks</label>
                                  <textarea name=""  rows="5" class="form-control" placeholder="Veterinarian Remarks" readonly><?= $dbcomment; ?></textarea>
                                </div>
                              </div>

                              <div class="col-md-12"><hr style="border:1px solid grey"></div>

                              <div class="col-md-6">
                                <h4>Client Details</h4>
                                <div class="form-group">

                                  <div class="form-group">
                                    <label for="">Full Name</label>   
                                    <input type="text" class="form-control" value="James Reid" readonly>
                                  </div>

                                  <div class="form-group">
                                    <label for="">Patient <i style="color:red">*</i></label>
                                    <table border="0" width="100%">
                                      <tbody>
                                        <tr>
                                          <td width="95%">
                                            <select name="" class="form-control" required>
                                              <option value="" selected disabled>Select Pet</option>
                                              <option>sss</option>
                                            </select>
                                          </td>
                                          <td>
                                              <button type="button" style="margin-left:5px" class="btn btn-sm btn-danger" disabled><i class="fa fa-remove"></i></button>
                                          </td>
                                        </tr>
                                      </tbody>
                                      <tfoot>
                                        <tr>
                                          <td colspan="2">
                                            <div class="text-right" style="margin-top:5px">
                                              <button type="button" class="btn btn-success btn-sm">Add More</button>
                                            </div>
                                          </td>
                                        </tr>
                                      </tfoot>
                                    </table>
                                  </div>

                                </div>
                              </div>
                              <div class="col-md-6">
                                <h4>&nbsp;</h4>
                                <div class="form-group">
                                  <label for="">Client Remarks (optional)</label>
                                  <textarea name=""  rows="5" name="remarks" class="form-control" placeholder="Client Remarks" ></textarea>
                                </div>
                              </div>
                            </div>

            </div>
          </form>
            <div class="box-footer">
              <div class="pull-right">
                <a href="<?php echo $baseurl; ?>client/dashboard/appointments" class="btn btn-default" > Go Back</a>
                  <button type="button" name="btnSave" onClick="printdiv('printme')" class="btn btn-primary"> <i class="fa fa-print"></i> Print</button>
  
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