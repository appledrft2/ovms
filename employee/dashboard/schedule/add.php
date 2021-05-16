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
$pages ='appointment/schedule';
?>
<?php include('../header.php'); ?>
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
          <h1 class="col-md-6 text-left">
            <span class="text-left">Add Schedule</span>

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
          if($_GET['status'] == 'created'){
            echo '<div class="alert alert-success alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <p><i class="icon fa fa-check"></i>  Schedule Successfully Added.</p>
                     
                    </div>';
          }
          if($_GET['status'] == 'duplicate'){
            echo '<div class="alert alert-warning alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <p><i class="icon fa fa-calendar"></i>  Duplicate Date : Schedule date is already added.</p>
                     
                    </div>';
          }if($_GET['status'] == 'updated'){
            echo '<div class="alert alert-info alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <p><i class="icon fa fa-info"></i>  Appointment Successfully Updated.</p>
                     
                    </div>';
          }
        }
      ?>
      <div class="row">
        <div class="col-md-12">
        	<div class="box">
        		<div class="box-body">
        			<form method="POST" action="#">
        				<div class="form-row">
        					<div class="col-md-6">
        						<div class="form-group" style="margin-top:47px;">
                      <style>
                        .readonly2 {
                          pointer-events:none;background: #f2f2f2;
                        }
                      </style>
        							<label for="schedule">Veterinarian <i style="color:red">*</i></label>
                      <?php 

                      if($_SESSION['dbet'] == 'Veterinarian'){
                        echo '<select class="form-control readonly2"  name="veterinarian_id" readonly required>';  
                        echo '<option >Select Veterinarian</option>';
                        $sql = "SELECT id,firstname,lastname FROM tbl_employee WHERE employee_type = 'Veterinarian' ORDER BY timestamp ASC";
                        $qry = $connection->prepare($sql);
                        $qry->execute();
                        $qry->bind_result($id,$dbfn,$dbln);
                        $qry->store_result();
                        while($qry->fetch ()) {

                          if($_SESSION['dbu'] == $id){
                            echo '
                              <option value="'.$id.' " selected>Dr. '.$dbfn.' '.$dbln.'</option>
                             ';
                           }else{
                            echo '
                              <option value="'.$id.'">Dr. '.$dbfn.' '.$dbln.'</option>
                             ';
                           }

                        }

                      }else{
                        echo '<select class="form-control" name="veterinarian_id" >';
                        echo '<option selected disabled>Select Veterinarian</option>';
                        $sql = "SELECT id,firstname,lastname FROM tbl_employee WHERE employee_type = 'Veterinarian' ORDER BY timestamp ASC";
                        $qry = $connection->prepare($sql);
                        $qry->execute();
                        $qry->bind_result($id,$dbfn,$dbln);
                        $qry->store_result();
                        while($qry->fetch ()) {
                          echo '
                            <option value="'.$id.'">Dr. '.$dbfn.' '.$dbln.'</option>
                           ';
                        }
                      }

                      ?>
        							</select>


        						</div>
        						<div class="form-group">
        							<label for="schedule">Set Schedule <i style="color:red">*</i></label>
        							<input type="date" class="form-control" name="schedule_date" id="schedule"  required>
        						</div>
                    <div class="form-group">
                      <label for="schedule">Client Slot <i style="color:red">*</i></label>
                      <input type="number" class="form-control" name="slot" placeholder="No. of clients" min="1" value="5" required>
                    </div>
        						<div class="form-group">
        							<label for="schedule">Remarks</label>
        							<textarea class="form-control" rows="5" name="remarks" placeholder="Enter Remarks (optional)" ></textarea>
        						</div>
        					</div>
        					<div class="col-md-6">
        						<div class="box-body no-padding">
                      <style>
                         .fc-day-grid-event .fc-content {
                           white-space: normal; 
                           text-align: center;
                        }
                      </style>
        						  <!-- THE CALENDAR -->
        						  <div id="calendar"></div>
        						</div>
        					</div>
        				</div>
        			
        		</div>
        		<div class="box-footer">
        			<span style="float:right">
        				<a href="<?php echo $baseurl; ?>employee/dashboard/schedule" class="btn btn-default" > Go Back</a>

        				<button type="submit" name="btnConfirm" class="btn btn-warning">Confirm, Add New</button>
        				<button type="submit" name="btnSubmit" class="btn btn-info">Confirm Schedule</button>
                </form>
        			</span>
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
  function triggerClick(){
    $("#serviceimage").click();
  }
  function displayImage(e){
    if(e.files[0]){
      var reader = new FileReader();
      reader.onload = function(e){
        $('#serviceDisplay').attr('src',e.target.result);
      }
      reader.readAsDataURL(e.files[0]);
    }
  }
  var date = new Date().toISOString().slice(0,10);
  //To restrict future date
  var restrict = document.getElementById("schedule");
  restrict.setAttribute('min', date);


  $('#calendar').fullCalendar({
        header    : {
          left  : 'prev,next today',
          center: 'title',
          right : 'month,agendaWeek'
        },
        buttonText: {
          today: 'today',
          month: 'month',
          week : 'week',
          day  : 'day'
        },
        //Random default events
        events    : [
          <?php 
            if($_SESSION['dbet'] == 'Veterinarian'){
              $sql = "SELECT s.id,e.firstname,e.lastname,s.schedule_date FROM tbl_schedule AS s INNER JOIN tbl_employee AS e ON e.id = s.veterinarian_id WHERE s.veterinarian_id = ?";
              $qry = $connection->prepare($sql);
              $qry->bind_param('i',$_SESSION['dbu']);
              $qry->execute();
            }else{
              $sql = "SELECT s.id,e.firstname,e.lastname,s.schedule_date FROM tbl_schedule AS s INNER JOIN tbl_employee AS e ON e.id = s.veterinarian_id ORDER BY s.schedule_date DESC";
              $qry = $connection->prepare($sql);
              $qry->execute();
            }
            
            $qry->bind_result($id,$dbefn,$dbeln,$dbs);
            $qry->store_result();
            while($qry->fetch ()) {

          ?>
          {
            title          : <?= "'Dr. {$dbefn} {$dbeln}'" ?>,
            start          : new Date(<?php echo date_format (new DateTime($dbs), 'Y,m - 1,d'); ?>),
            backgroundColor: '#1295ad', //red
            borderColor    : '#1295ad', //red
            description: 'second description'
          },

        <?php } ?>
          
        ],

        editable  : false,
        droppable : false,
        displayEventTime: false,
      });


</script>
<?php 
if(isset($_POST['btnSubmit']) || isset($_POST['btnConfirm'])){

    $sql = "INSERT INTO tbl_schedule(veterinarian_id,schedule_date,slot,comment) VALUES(?,?,?,?)";
    $qry = $connection->prepare($sql);
    $qry->bind_param("isis",$_POST['veterinarian_id'],$_POST['schedule_date'],$_POST['slot'],$_POST['remarks']);
    if($qry->execute()) { 

      $activity = "Added New Schedule Date: ".$_POST['schedule_date'];
      $sqlx = "INSERT INTO tbl_logs(employee_id,activity) VALUES(?,?)";
      $qryx = $connection->prepare($sqlx);
      $qryx->bind_param("is",$_SESSION['dbu'],$activity);
      $qryx->execute();

      if(isset($_POST['btnSubmit'])){
        echo '<meta http-equiv="refresh" content="0; URL=index.php?status=created">';
      }else{
        echo '<meta http-equiv="refresh" content="0; URL=add.php?status=created">';
      }


    }else{

      if (mysqli_errno($connection) == 1062) {

                echo '<meta http-equiv="refresh" content="0; URL=add.php?status=duplicate">';
      }else{
              echo '<meta http-equiv="refresh" content="0; URL=add.php?status=error">';
      }



    }

    
}
?>