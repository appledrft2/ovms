<?php 
session_start();
include('../../includes/autoload.php');
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
$pages = 'dashboard/index';
?>
<?php include('header.php'); ?>
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
          <h1 class="col-md-6 text-left">
            <span class="text-left">Request Appointment</span>

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
             
              <div class="col-md-12">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th width="25%">Pet Name</th>
                      <th width="25%">Service</th>
                      <th width="20%">Price</th>
                      <th width="10%">Action</th>
                    </tr>
                  </thead>
                  <tbody id="tblservice">
                    <tr>
                      <td>
                       <select type="text" class="form-control  " name="pet_id[]"  required>
                         <option selected disabled value="">Select Pet</option>
                          <?php 
                           $sql = "SELECT id,name FROM tbl_pet WHERE client_id = ? ORDER BY name ASC";
                           $qry = $connection->prepare($sql);
                           $qry->bind_param('i',$_SESSION['dbu']);
                           $qry->execute();
                           $qry->bind_result($id,$dbn);
                           $qry->store_result();
                           while($qry->fetch ()) {
                             echo '
                               <option value="'.$id.'">'.$dbn.'</option>
                              ';
                           }
                         ?>
                       </select> 

                      </td>
                      <td>
                        
                        <select type="text" class="form-control selectservice " name="service_id[]" required>
                          <option selected disabled value="">Select Service</option>
                           <?php 
                            $sql = "SELECT id,name,price FROM tbl_service ORDER BY name ASC";
                            $qry = $connection->prepare($sql);
                            $qry->execute();
                            $qry->bind_result($id,$dbn,$dbp);
                            $qry->store_result();
                            while($qry->fetch ()) {
                              echo '
                                <option value="'.$id.'">'.$dbn.' (&#8369; '.number_format($dbp,2).')</option>
                               ';
                            }
                          ?>
                        </select> 
                      </td>
                      <td>
                        <input type="text" class="form-control price p0" name="price[]" placeholder="Price" readonly="">
                      </td>
                      <td><button type="button" class="btn btn-danger btn-sm" disabled><i class="fa fa-remove"></i></button></td>
                    </tr>
                  </tbody>

                  <tfoot>
                    <tr>
                      <td></td>
                      <td class="text-right"><b>Total:</b></td>
                      <td>
                        <input type="text" class="form-control" id="total" name="total" value="" readonly>
                      </td>
                      <td >
                        <button id="moreservice" type="button" class=" btn btn-success btn-sm"><i class="fa fa-plus-circle"></i>&nbsp;Add more</button>
                      </td>
                    </tr>
                   
                  </tfoot>
                </table>
              </div>

            </div>
            <div class="box-footer">
              <div class="pull-right">
                <a href="<?php echo $baseurl; ?>client/dashboard" class="btn btn-default" > Go Back</a>
                <button name="btnSave" class="btn btn-success" > Confirm Request</button>
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
  $('#moreservice').click(function(){
    var tblcounter = $('#tblservice tr').length; 

    $("#tblservice").append('<tr><td><select type="text" class="form-control  " name="pet_id[]" required> <option selected disabled value="">Select Pet</option> <?php $sql = "SELECT id,name FROM tbl_pet WHERE client_id = ? ORDER BY name ASC"; $qry = $connection->prepare($sql); $qry->bind_param('i',$_SESSION['dbu']); $qry->execute(); $qry->bind_result($id,$dbn); $qry->store_result(); while($qry->fetch ()) { echo ' <option value="'.$id.'">'.$dbn.'</option> '; } ?> </select> </td> <td> <select type="text" class="form-control selectservice " name="service_id[]" required> <option selected disabled value="">Select Service</option> <?php $sql = "SELECT id,name,price FROM tbl_service ORDER BY name ASC"; $qry = $connection->prepare($sql); $qry->execute(); $qry->bind_result($id,$dbn,$dbp); $qry->store_result(); while($qry->fetch ()) { echo ' <option value="'.$id.'">'.$dbn.' (&#8369; '.number_format($dbp,2).')</option> '; } ?> </select> </td> <td> <input type="text" class="form-control price p'+tblcounter+'" name="price[]" placeholder="Price" readonly=""> </td><td><button type="button" class="btn btn-danger btn-sm delservice" ><i class="fa fa-remove"></i></button></td> </tr>');
    
    tblcounter++;
  });
  $('#tblservice').on('click', '.delservice', function () { 
     $(this).closest('tr').remove();

     var rowCount = $('#tblservice tr').length;

     var total = price = 0;

     for(i = 0;i < rowCount;i++){
     
       price = parseFloat($('.p'+i).val());
       total = total + price;
     }

     $('#total').val(total.toFixed(2));
  });

  $(document).on('change','.selectservice',function(){

    var serviceid = $(this).val();
    var sdata = 0;
    $.ajax({
      async: false,
      global: false,
      url:'get_service.php',
      method:'POST',
      data:{
          serviceid:serviceid
      },
     success:function(data){
      sdata = data;
     }
    });
    sdata = parseFloat(sdata);
    $(this).closest('tr').find('.price').val(sdata.toFixed(2));

    var rowCount = $('#tblservice tr').length;

    var total = price = 0;

    for(i = 0;i < rowCount;i++){
 
      price = parseFloat($('.p'+i).val());
      total = total + price;
    }

    $('#total').val(total.toFixed(2));


  });
</script>

<?php 
if(isset($_POST['btnSave'])){
    $status = 'Pending';
    $type = 'Requested';
    $sql = "INSERT INTO tbl_appointment(client_id,status,type,total) VALUES(?,?,?,?)";
    $qry = $connection->prepare($sql);
    $qry->bind_param("isss",$_SESSION['dbu'],$status,$type,$_POST['total']);

    if($qry->execute()) {

      $last_id = mysqli_insert_id($connection);
      $i = 0;

      for($i=0;$i < count($_POST['pet_id']);$i++){
       $sql = "INSERT INTO tbl_appointment_pet(appointment_id,pet_id,service_id) VALUES(?,?,?)";
       $qry = $connection->prepare($sql);
       $qry->bind_param("iii",$last_id,$_POST['pet_id'][$i],$_POST['service_id'][$i]);
       $qry->execute();
      
      }
      echo '<meta http-equiv="refresh" content="0; URL=index.php?status=requested">';
    }else{
      echo '<meta http-equiv="refresh" content="0; URL=request.php?status=error">';
    }
}
?>