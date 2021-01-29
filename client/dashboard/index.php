<?php 
session_start();
include('../../includes/autoload.php');
if(isset($_POST['btnLogout'])){
  session_unset();
  header('location:'.$baseurl.'');
}
if(isset($_SESSION['dbu'])){ 
  if($_SESSION['dbc'] != true){
      header("location:".$baseurl."employee/dashboard");
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
            <span class="text-left">Overview</span>

          </h1>
          <h2 class="col-md-6 text-right">
            <span class="text-right"><i class="fa fa-calendar"></i> <?php echo date('D, M. d Y') ?></span>
          </h2>
        </div>
      </section>

    <!-- Main content -->
    <section class="content">
      <div class="box">
        <div class="row">
          <div class="col-md-6">
            <!-- THE CALENDAR -->
            <div id="calendar" style="width: 100%"></div>
            </div>
            <div class="col-md-6">
                <div class="row" id="tblappointments">
                    <div class="col-md-12"><h3>My Appointments</h3><br>
                      <button data-toggle="modal" data-target="#modal-default" class="btn btn-primary">Request Schedule</button><br><br>
                         <table id="table1" class="table table-bordered table-hover">
                           <thead>
                           <tr>
                            <th>Type</th>
                             <th>Date of Appointment</th>
                             <th>Status</th>
                             <th>Date Requested</th>
                             <th>Details</th>
                           </tr>
                           </thead>
                           <tbody>
                            <?php 
                            
                            $i = 0;
                            $sql = "SELECT id,type,appointment_date,status,timestamp FROM tbl_appointment WHERE client_id = ?";
                            $qry = $connection->prepare($sql);
                            $qry->bind_param("i",$_SESSION['dbu']);
                            $qry->execute();
                            $qry->bind_result($id,$dbt,$dba,$dbs,$dbtimestamp);
                            $qry->store_result();
                            while($qry->fetch ()) {
                                echo"<tr>";
                                echo"<td>";
                                echo $dbt;
                                echo"</td>";  
                                echo"<td>";
                                if($dba == ''){
                                  echo '-';
                                }else{
                                  echo $dba;
                                }
                                echo"</td>";  
                                echo"<td>";
                                echo $dbs;
                                echo"</td>";
                                echo"<td>";
                                echo $dbtimestamp;
                                echo"</td>";   
                                echo"<td>";
                                echo "<button id=".$id." class='btn btn-default btn-sm btn_details'><i class='fa fa-list'></i></button>";
                                echo"</td>";   
                                echo"</tr>";   
                              }
                            ?>
                          </tbody>
                        </table> 
                      
                    </div>
                </div>
            </div>
        </div>
      </div>
      <div class="modal fade" id="modal-default">
        <div class="modal-dialog ">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Request Schedule</h4>
            </div>
            
            <div class="modal-body">
              <form id="form1" action="#" method="POST">
              <div class="row">
                <div class="col-md-12">
                  <div class="box">
                  
                    <div class="box-body">
                      <p class="text-center">Select Pet</p>
                      <table class="table table-bordered">
                        <tr>
                          
                          <td width="50%">
                            Name
                          </td>
                          <td width="50%">Service</td>
                          <td width="10%">Action</td>
                        </tr>
                        <tbody id="tblpet">
                          <tr>
                
                            <td>
                              <select class="form-control" name='select_pet[]' required>
                               <option selected disabled value="">Select Pet</option>
                               <?php 
                               $sql = "SELECT id,Name FROM tbl_pet WHERE client_id = ?";
                               $qry = $connection->prepare($sql);
                               $qry->bind_param("i",$_SESSION['dbu']);
                               $qry->execute();
                               $qry->bind_result($id,$dbn);
                               $qry->store_result();
                               while($qry->fetch ()) {
                                   echo"<option value='".$id."'>";
                                   echo $dbn;
                                   echo"</option>";   
                                 }
                               ?>
                              </select>
                            </td>
                            <td>
                              <select class="form-control" name="select_service[]" required>
                               <option selected disabled value="">Select Service</option>
                               <?php 
                               $sql = "SELECT id,name FROM tbl_service";
                               $qry = $connection->prepare($sql);
                               $qry->execute();
                               $qry->bind_result($id2,$dbn2);
                               $qry->store_result();
                               while($qry->fetch ()) {
                                   echo"<option value='".$id2."'>";
                                   echo $dbn2;
                                   echo"</option>";
                                 }
                               ?>
                              </select>
                            </td>
                            <td>
                              <button disabled class=' btn btn-danger btn-sm'><i class='fa fa-remove'></i></button>
                            </td>
                          </tr>
                          
                        </tbody>
                        
                      </table>
                      <br>
                      <button id="morepet" class="pull-right btn btn-success btn-sm">add more</button>
                    </div>
                  </div>
                </div>
                
                <div class="col-md-12">
                  <div class="box">
                    <div class="box-body">
                      <p class="text-center">Select Veterinarian</p>
                      <table class="table table-bordered">
                        <tr>
                          
                          <td>
                            Name
                          </td>
                         
                          
                        </tr>
                        <tbody id="tblservice">
                          <tr>
                    
                            <td>
                              <select class="form-control" name="select_vet" required>
                               <option selected disabled value="">Select Veterinarian</option>
                               <?php 
                               $sql = "SELECT id,firstname,lastname FROM tbl_employee WHERE employee_type = 'Veterinarian'";
                               $qry = $connection->prepare($sql);
                               $qry->execute();
                               $qry->bind_result($id3,$dbf,$dbl);
                               $qry->store_result();
                               while($qry->fetch ()) {
                                   echo"<option value='".$id3."'>";
                                   echo "Dr. ".$dbf." ".$dbl;
                                   echo"</option>";
                                 }
                               ?>
                              </select>
                            </td>
                           
                          </tr>
                        </tbody>
                       
                      </table>
                     
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
              <button type="submit" id="btnconfirm" class="btn btn-primary">Confirm Request</button>
              </form>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
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
<?php include('fullcalendar.php'); ?>
<script type="text/javascript">

  $('#morepet').click(function(){
    $("#tblpet").append("<tr><td><select name='select_pet[]' class='form-control' required><option selected disabled value=''>Select Pet</option><?php 
                               $sql = "SELECT id,Name FROM tbl_pet WHERE client_id = ?";
                               $qry = $connection->prepare($sql);
                               $qry->bind_param("i",$_SESSION['dbu']);
                               $qry->execute();
                               $qry->bind_result($id4,$dbn);
                               $qry->store_result();
                               while($qry->fetch ()) {
                                   echo"<option value='".$id4."'>";
                                   echo $dbn;
                                   echo"</option>";   
                                 }
                               ?>
                              </select></td><td><select class='form-control' name='select_service[]' required><option selected disabled value=''>Select Service</option><?php 
                               $sql = "SELECT id,name FROM tbl_service";
                               $qry = $connection->prepare($sql);
                               $qry->execute();
                               $qry->bind_result($id5,$dbn2);
                               $qry->store_result();
                               while($qry->fetch ()) {
                                   echo"<option value='".$id5."'>";
                                   echo $dbn2;
                                   echo"</option>";
                                 }
                               ?>
                              </select></td><td><button class='delpet btn btn-danger btn-sm'><i class='fa fa-remove'></i></button></td></tr>");
    $('#form1').data('validator', null);
    $.validator.unobtrusive.parse($('#form1'));
  });
   $('#tblpet').on('click', '.delpet', function () { 
       $(this).closest('tr').remove();

  });
   $(document).on('click', '.btn_details', function () { 
       var id = $(this).attr('id');
       alert(id);
    });
  $(document).ready(function(){
    $( "#form1" ).submit(function( event ){
      event.preventDefault();
      var client_id = <?php echo $_SESSION['dbu']; ?>;
            var vet_id = $("select[name=select_vet]").val();
            var  pet_id= $("select[name=\'select_pet[]\']").map(function() {
                return $(this).val();
            }).toArray();
            var  service_id= $("select[name=\'select_service[]\']").map(function() {
                return $(this).val();
            }).toArray();

            $.ajax({
              url:'request_process.php',
              method:'POST',
              data:{
                  client_id:client_id,vet_id:vet_id,pet_id:pet_id,service_id:service_id
              },
             success:function(data){
                $('#table1').DataTable().destroy();
                $("#table1").load(location.href + " #table1");
                $("#form1").load(location.href + " #form1");
                $('#table1').DataTable({
                      'paging'      : true,
                      'lengthChange': true,
                      'searching'   : true,
                      'ordering'    : true,
                      'info'        : true,
                      'autoWidth'   : true
                    })

                $('#modal-default').modal('hide');

                alert('Appointment Successfully Requested');

             }
            });

    });
  });
</script>