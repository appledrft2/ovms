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
$pages = 'appointment/book';

if(isset($_GET['id'])){
  $sql = "SELECT s.id,e.id,s.comment,e.firstname,e.lastname,s.slot,s.schedule_date FROM tbl_schedule AS s INNER JOIN tbl_employee AS e ON e.id = s.veterinarian_id WHERE s.id=?";
  $qry = $connection->prepare($sql);
  $qry->bind_param("i",$_GET['id']);
  $qry->execute();
  $qry->bind_result($sched_id,$veterinarian_id,$dbcomment,$dbef,$dbel,$dbslot,$dbschedule);
  $qry->store_result();
  $qry->fetch ();


  $sql = "SELECT firstname,lastname FROM tbl_client WHERE id=?";
  $qry = $connection->prepare($sql);
  $qry->bind_param("i",$_SESSION['dbu']);
  $qry->execute();
  $qry->bind_result($dbcf,$dbcl);
  $qry->store_result();
  $qry->fetch ();

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
            <span class="text-left">Book Appointment</span>

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
            <div class="box-body">
              <form method="POST" action="#">
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
                      <input type="text" class="form-control" value="<?= $dbcf.' '.$dbcl; ?>" readonly>
                    </div>

                    <div class="form-group">
                      <label for="">Patient <i style="color:red">*</i></label>
                      <table border="0" width="100%">
                        <tbody id="tblpet">
                          <tr>
                            <td width="95%">
                              <select name="pet[]" class="form-control" required>
                                <option value="" selected disabled>Select Pet</option>
                                <?php 
                                $isdisabled = 0;
                                $sql = "SELECT id,name FROM tbl_pet WHERE client_id=?";
                                $qry = $connection->prepare($sql);
                                $qry->bind_param("i",$_SESSION["dbu"]);
                                $qry->execute();
                                $qry->bind_result($dbcpid,$dbcpn);
                                $qry->store_result();
                                while($qry->fetch ())
                                {
                                  echo "<option value=".$dbcpid.">".$dbcpn."</option>";
                                  $isdisabled++;
                                }
                                ?>
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
                                <button type="button" class="btn btn-primary btn-sm" <?php if($isdisabled <= 1){ echo 'disabled'; } ?> id="morepet">Add More</button>
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
                    <textarea rows="5" name="remarks" class="form-control" placeholder="Client Remarks" ></textarea>
                  </div>
                </div>
              </div>
              
            </div>
            <div class="box-footer">
              <div class="pull-right">
                <a href="<?php echo $baseurl; ?>client/dashboard/book" class="btn btn-default" > Go Back</a>
                <button name="btnSave" class="btn btn-primary" > Confirm Booking</button>
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
  $('#morepet').click(function(){
    $("#tblpet").append('<tr> <td width="95%"> <div style="margin-top:10px"><select name="pet[]" class="form-control" required> <option value="" selected disabled>Select Pet</option> <?php $isdisabled = 0; $sql = "SELECT id,name FROM tbl_pet WHERE client_id=?"; $qry = $connection->prepare($sql); $qry->bind_param("i",$_SESSION["dbu"]); $qry->execute(); $qry->bind_result($dbcpid,$dbcpn); $qry->store_result(); while($qry->fetch ()) { echo "<option value=".$dbcpid.">".$dbcpn."</option>"; $isdisabled++; } ?> </select> </td> <td> <button type="button" style="margin-left:5px;margin-top:10px" class="btn btn-sm btn-danger delpet"><i class="fa fa-remove"></i></button></div> </td> </tr>');

  });
   $('#tblpet').on('click', '.delpet', function () { 
       $(this).closest('tr').remove();
  });
</script>

<?php 
if(isset($_POST['btnSave'])){


  $status = 'Booked';
  $sql = "INSERT INTO tbl_appointment(client_id,schedule_id,veterinarian_id,client_remarks,status) VALUES(?,?,?,?,?)";
  $qry = $connection->prepare($sql);
  $qry->bind_param("iiiss",$_SESSION['dbu'],$sched_id,$veterinarian_id,$_POST['remarks'],$status);

  if($qry->execute()) {

    $last_id = mysqli_insert_id($connection);
    $pets = count($_POST['pet']);

    for($i=0;$i < $pets;$i++){

      $sql2 = "INSERT INTO tbl_appointment_pet(appointment_id,pet_id) VALUES(?,?)";
      $qry2 = $connection->prepare($sql2);
      $qry2->bind_param("ii",$last_id,$_POST['pet'][$i]);
      $qry2->execute();
    }

    $dbslot = $dbslot - 1;

    $sql3 = "UPDATE tbl_schedule SET slot = ?  WHERE id=?";
    $qry3 = $connection->prepare($sql3);
    $qry3->bind_param("si",$dbslot,$_GET['id']);
    $qry3->execute();

    echo '<meta http-equiv="refresh" content="0; URL=../appointments/index.php?status=created">';
  }else{
    echo '<meta http-equiv="refresh" content="0; URL=book.php?status=error">';
  }
    
}
?>