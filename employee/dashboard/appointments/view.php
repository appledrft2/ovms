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
$pages = 'appointment/index';

if(isset($_GET['id'])){
  $sql = "SELECT a.id,s.schedule_date,e.firstname,e.lastname,a.status,c.firstname,c.lastname,c.gender,a.client_remarks,a.veterinarian_id FROM tbl_appointment AS a INNER JOIN tbl_schedule AS s ON s.id = a.schedule_id INNER JOIN tbl_employee AS e ON e.id = a.veterinarian_id INNER JOIN tbl_client AS c ON c.id = a.client_id WHERE a.id=?";
  $qry = $connection->prepare($sql);
  $qry->bind_param("i",$_GET['id']);
  $qry->execute();
  $qry->bind_result($id,$sched,$ef,$el,$dbstatus,$cf,$cl,$cg,$cremarks,$vet_id);
  $qry->store_result();
  $qry->fetch();

  $cg = ($cg == 'Male') ? 'Mr.' : 'Ms.';
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
            <span class="text-left">Appointment Details </span>

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
          if($_GET['status'] == 'completed'){
            echo '<div class="alert alert-success alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <p><i class="icon fa fa-check"></i>  Appointment Successfully Completed.</p>
                     
                    </div>';
          }if($_GET['status'] == 'error'){
            echo '<div class="alert alert-info alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <p><i class="icon fa fa-remove"></i>  There was an error.</p>
                     
                    </div>';
          }
        }
      ?>
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <form method="POST" id="printme" action="#">
              
            <div class="box-body">
             <center>
               <img src="<?php echo $baseurl ?>logo.jpg" width="100px" ><br>
               <b style="text-transform: uppercase;">Bath & Bark Grooming and Veterinary Services</b>
               <p>
                 Bauan-Batangas Road<br>
                 Poblacion, San Pascual, Philippines<br>
                 Contact No.: 09178827552
               </p>
             </center>
             
              <style>
                input.form-control:read-only {
                        background-color: #f8f8f8;
                    }
                textarea.form-control:read-only {
                        background-color: #f8f8f8;
                    }
              </style>
              <div class="col-md-6">

                <h4>Appointment Details</h4>

                <div class="form-group">
                  <label for="">Appointment No.</label>
                  <input type="text" class="form-control" value="<?= $id; ?>" readonly>
               
               
                  <label for="">Appointment Date</label>
                  <input type="text" class="form-control" value="<?= date("M d, Y", strtotime($sched)); ?>" readonly>
              
                
                  <label for="">Veterinarian</label>
                  <input type="text" class="form-control" value="Dr. <?= $ef.' '.$el; ?>" readonly>
                  <label for="">Status</label>
              
                  <?php if($dbstatus == 'Booked'): ?>
                    <div class="progress">
                      <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                     
                      <?= $dbstatus; ?>
                    </div>
                  <?php endif; ?>
                   <?php if($dbstatus == 'In Progress'): ?>
                    <div class="progress">
                      <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%">
                     
                      <?= $dbstatus; ?>
                    </div>
                  <?php endif; ?>
                  <?php if($dbstatus == 'Cancelled'): ?>
                    <div class="progress">
                      <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                      
                      <?= $dbstatus; ?>
                    </div>
                  <?php endif; ?>
                  <?php if($dbstatus == 'Completed'): ?>
                    <div class="progress">
                      <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                      
                      <?= $dbstatus; ?>
                    </div>
                  <?php endif; ?>
              </div>
                </div>
                
              </div>
              <div class="col-md-6">
                <h4>Client Details</h4>
                <label for="">Fullname</label>
                <input type="text" class="form-control" value="<?= $cg.' '.$cf.' '.$cl ?>" readonly>
                <?php if($dbstatus == 'Booked' || $dbstatus == 'Cancelled'): ?>
                <label for="">Pets</label>
                <?php
                  echo "<ol>"; 
                  $sql = "SELECT p.name FROM tbl_appointment_pet AS ap INNER JOIN tbl_pet AS p ON p.id = ap.pet_id WHERE ap.appointment_id = ?";
                  $qry = $connection->prepare($sql);
                  $qry->bind_param('i',$_GET['id']);
                  $qry->execute();
                  $qry->bind_result($petname);
                  $qry->store_result();
                  while($qry->fetch ()){
                    
                    echo "<li>$petname</li>";
                    
                  }
                  echo "</ol>";
                    
                ?>
              <?php endif;?>
                <label for="">Client Remarks</label>
                <textarea  class="form-control" rows="4" readonly><?= $cremarks; ?></textarea>
              </div>
              <?php if($dbstatus == 'In Progress' || $dbstatus == 'Completed'): ?>
              <div class="col-md-12">
                <style>
                  input[readonly] {
                    pointer-events: none;
                  }select[readonly] {
                    pointer-events: none;
                  }textarea[readonly] {
                    pointer-events: none;
                  }
                </style>
                <h4>Pet Diagnosis</h4>
                  <div class="row">

                    <?php
                      $isdisabled = ($dbstatus == 'Completed') ? "readonly" : "";

                      $sql = "SELECT ap.id,p.name,ap.diagnosis,ap.service_id,ap.service_diagnosis FROM tbl_appointment_pet AS ap INNER JOIN tbl_pet AS p ON p.id = ap.pet_id WHERE ap.appointment_id = ?";
                      $qry = $connection->prepare($sql);
                      $qry->bind_param('i',$_GET['id']);
                      $qry->execute();
                      $qry->bind_result($ap_id,$name,$gendiagnosis,$serv_id,$serv_diag);
                      $qry->store_result();
                      while($qry->fetch ()){
                        
                    ?>

                    <div class="col-md-6">
                      <div class="box">
                        <div class="box-body">

                          <h4><?= $name; ?></h4>
                          <div class="form-group">
                            <input type="hidden" name="ap_id[]" class="form-control" value="<?= $ap_id; ?>">
                            <label for="">General Diagnosis (Temp,Weight,etc.) <i style="color:red">*</i></label>
                            <textarea required name="gendiagnosis[]" <?= $isdisabled ?> class="form-control" rows="4"><?= $gendiagnosis ?></textarea>
                          </div>

                          <div class="form-group">
                            <table border="0" width="100%">
                              <tbody id="tblService<?= $ap_id; ?>">
                                <tr>
                                  <td>
                                    <div class="form-group" style="border-top:5px solid #f8f8f8;">
                                      <label for="" style="margin-top:10px;">Service Rendered <i class="text-red">*</i></label>
                                      <div class="row">
                                        <?php if($dbstatus != 'Completed'): ?>
                                        <div class="col-md-11">
                                        <?php else: ?>
                                          <div class="col-md-12">
                                        <?php endif; ?>
                                        <select <?= $isdisabled ?>  required name="servicerendered<?= $ap_id ?>[]" class="form-control">
                                          <option value=""  selected disabled >Select Service</option>
                                          <?php 
                                            $sql3 = "SELECT id,name,price FROM tbl_service";
                                            $qry3 = $connection->prepare($sql3);
                                            $qry3->execute();
                                            $qry3->bind_result($sid,$sname,$sprice);
                                            $qry3->store_result();
                                            while($qry3->fetch ()){
                                              $sprice = number_format($sprice,2);
                                              if($serv_id == $sid){
                                                echo "<option value='$sid' selected>$sname (&#8369; $sprice)</option>";
                                              }else{
                                                echo "<option value='$sid'>$sname (&#8369; $sprice)</option>";
                                              }
                                              
                                              
                                            }
                                              
                                          ?>
                                        </select>
                                      </div>
                                      <?php if($dbstatus != 'Completed'): ?>
                                      <div class="col-md-1">
                                        <button type="button" class="btn btn-danger" disabled style="position:relative;right:20px"><i class="fa fa-remove"></i></button>
                                      </div>
                                     <?php endif; ?>
                                      </div>
                                      <label for="">Service Diagnosis</label>
                                      <textarea required <?= $isdisabled ?>  name="servicediagnosis<?= $ap_id ?>[]" class="form-control" rows="4"><?= $serv_diag; ?></textarea>
                                      
                                    </div>
                                  </td>
                                </tr>

                                <?php

                                if($dbstatus == 'Completed'){

                                  $sql4 = "SELECT id,service_id,diagnosis FROM tbl_ap_service WHERE appointment_pet_id = ?";
                                  $qry4 = $connection->prepare($sql4);
                                  $qry4->bind_param('i',$ap_id);
                                  $qry4->execute();
                                  $qry4->bind_result($aps_id,$srid,$apsdiag);
                                  $qry4->store_result();
                                  while($qry4->fetch ()){

                                   ?>

                                   <tr>
                                     <td>
                                       <div class="form-group" style="border-top:5px solid #f8f8f8;">
                                         <label for="" style="margin-top:10px;">Service Rendered <i class="text-red">*</i></label>
                                         <div class="row">
                                           
                                         <div class="col-md-12">
                                           <select <?= $isdisabled ?>  required name="servicerendered<?= $ap_id ?>[]" class="form-control">
                                             <option value=""  selected disabled >Select Service</option>
                                             <?php 
                                               $sql3 = "SELECT id,name,price FROM tbl_service";
                                               $qry3 = $connection->prepare($sql3);
                                               $qry3->execute();
                                               $qry3->bind_result($sid,$sname,$sprice);
                                               $qry3->store_result();
                                               while($qry3->fetch ()){
                                                 $sprice = number_format($sprice,2);
                                                 if($srid == $sid){
                                                   echo "<option value='$sid' selected>$sname (&#8369; $sprice)</option>";
                                                 }else{
                                                   echo "<option value='$sid'>$sname (&#8369; $sprice)</option>";
                                                 }
                                                 
                                                 
                                               }
                                                 
                                             ?>
                                           </select>
                                         </div>
                                         
                                         </div>
                                         <label for="">Service Diagnosis</label>
                                         <textarea required <?= $isdisabled ?>  name="servicediagnosis<?= $ap_id ?>[]" class="form-control" rows="4"><?= $apsdiag; ?></textarea>
                                         
                                       </div>
                                     </td>
                                   </tr>




                                   <?php


                                  }



                                }





                                ?>

                              </tbody>
                              <tfoot>
                                <tr>
                              
                                  <td width="10%">
                                    
                                    <?php if($dbstatus == 'In Progress' && $_SESSION['dbet'] != 'Admin' && $vet_id == $_SESSION['dbu']): ?>
                                
                                      <button type="button" onclick="moreService(<?= $ap_id; ?>)" class="btn btn-success btn-sm" style="float:right;margin-top: 5px">Add More</button>
                                   
                                    <?php endif; ?>
                                  </td>
                                </tr>
                              </tfoot>
                            </table>  
                          </div>

                          
                        </div>
                      </div>
                    </div>


                    <?php 
                    }
                    ?>

                    
                    

                  </div>

                </div>
              <?php endif; ?>
              
                    
            

            </div>

            <div class="box-footer">
              <div class="pull-right">
                  <a id="printPageButton" href="<?php echo $baseurl; ?>employee/dashboard/appointments" class="btn btn-default" > Go Back</a>
                  
                  <?php if($vet_id == $_SESSION['dbu']): ?>
                  <?php if($dbstatus != 'Cancelled' && $dbstatus != 'Booked' && $dbstatus != 'Completed'): ?>
                    
                  <button  type="submit" name="btnUpdate" class="btn btn-primary" ><i class="fa fa-check"></i> Update Appointment</button>

                 <?php endif; ?>
                 <?php endif; ?>
                
                  

  
              </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
    <!-- Modal -->
    
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

   

  function moreService(ap){
    
   $("#tblService"+ap).append('<tr> <td> <div class="form-group" style="border-top:5px solid #f8f8f8;"> <label for="" style="margin-top:10px;">Service Rendered <i class="text-red">*</i></label> <div class="row"> <div class="col-md-11"> <select  required name="servicerendered'+ap+'[]" class="form-control"> <option value="" selected disabled >Select Service</option> <?php $sql3 = "SELECT id,name,price FROM tbl_service"; $qry3 = $connection->prepare($sql3); $qry3->execute(); $qry3->bind_result($sid,$sname,$sprice); $qry3->store_result(); while($qry3->fetch ()){ echo "<option value=".$sid.">$sname (&#8369; $sprice)</option>"; } ?> </select> </div> <div class="col-md-1"> <button type="button" class="btn btn-danger delservice" onclick="deleteRow(this)" style="position:relative;right:20px"><i class="fa fa-remove"></i></button> </div> </div> <label for="">Service Diagnosis</label> <textarea required  name="servicediagnosis'+ap+'[]" class="form-control" rows="4"></textarea> </div> </td> </tr>');

  };

  function deleteRow(btn) {
    var row = btn.parentNode.parentNode.parentNode;
    row.parentNode.removeChild(row);
  }


   
   

</script>


<?php 

if(isset($_POST['btnUpdate'])){

    $service_total = 0;
    $pet_arr = count($_POST['ap_id']);

    
    for($i = 0;$i < $pet_arr;$i++){
 
      $aap_id = $_POST['ap_id'][$i];
      $test = "test";
      $serv_arr = count($_POST['servicerendered'.$_POST['ap_id'][$i]]);
      
      $sql = "UPDATE tbl_appointment_pet SET diagnosis=? WHERE id=?";
      $qry = $connection->prepare($sql);
      $qry->bind_param("si",$_POST['gendiagnosis'][$i],$_POST['ap_id'][$i]);
      $qry->execute(); 

      $sql = "SELECT price FROM tbl_service WHERE id=?";
      $qry = $connection->prepare($sql);
      $qry->bind_param("i",$_POST['servicerendered'.$_POST['ap_id'][$i]][0]);
      $qry->execute();
      $qry->bind_result($servprice);
      $qry->store_result();
      $qry->fetch();

      $service_total  = $service_total + $servprice;

      
      $sql = "UPDATE tbl_appointment_pet SET service_id=?,service_diagnosis=? WHERE id=?";
      $qry = $connection->prepare($sql);

      $qry->bind_param("isi",$_POST['servicerendered'.$_POST['ap_id'][$i]][0],$_POST['servicediagnosis'.$_POST['ap_id'][$i]][0],$_POST['ap_id'][$i]);
      $qry->execute();


      if($serv_arr > 1){

        for($x = 1; $x < $serv_arr;$x++){
            

            $sql = "SELECT price FROM tbl_service WHERE id=?";
            $qry = $connection->prepare($sql);
            $qry->bind_param("i",$_POST['servicerendered'.$_POST['ap_id'][$i]][$x]);
            $qry->execute();
            $qry->bind_result($servprice);
            $qry->store_result();
            $qry->fetch();

            $service_total  = $service_total + $servprice;

             $sqlx = "INSERT INTO tbl_ap_service(appointment_pet_id,service_id,diagnosis) VALUES(?,?,?)";
             $qryx = $connection->prepare($sqlx);
             $qryx->bind_param("iis",$_POST['ap_id'][$i],$_POST['servicerendered'.$_POST['ap_id'][$i]][$x],$_POST['servicediagnosis'.$_POST['ap_id'][$i]][$x]);
             $qryx->execute();



        }

      }
      
     
      

      

    }

    $setstatus = 'Completed';
    $sql = "UPDATE tbl_appointment SET status=?,total=?,processed_by=? WHERE id=?";
    $qry = $connection->prepare($sql);
    $qry->bind_param("ssi",$setstatus,$service_total,$_SESSION['dbu'],$_GET['id']);
    $qry->execute();

    $activity = "Updated Details of Appointment ID ".$_GET['id']; 
    $sqlx = "INSERT INTO tbl_logs(employee_id,activity) VALUES(?,?)";
    $qryx = $connection->prepare($sqlx);
    $qryx->bind_param("is",$_SESSION['dbu'],$activity);
    $qryx->execute();

    echo '<meta http-equiv="refresh" content="0; URL=view.php?id='.$_GET['id'].'&status=completed">';
    
  
}


?>