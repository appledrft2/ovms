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

if(isset($_GET['id'])){
  $sql = "SELECT a.id,s.schedule_date,e.firstname,e.lastname,c.firstname,c.lastname,c.gender FROM tbl_appointment AS a INNER JOIN tbl_schedule AS s ON s.id = a.schedule_id INNER JOIN tbl_employee AS e ON a.veterinarian_id = e.id INNER JOIN tbl_client AS c ON c.id = a.client_id WHERE a.id=?";
  $qry = $connection->prepare($sql);
  $qry->bind_param("i",$_GET['id']);
  $qry->execute();
  $qry->bind_result($id,$sched,$dbef,$dbel,$dbcf,$dbcl,$dbcg);
  $qry->store_result();
  $qry->fetch ();

  $dbcg = ($dbcg == 'Male') ? 'Mr.' : 'Ms.';
  $sched = date("M d, Y", strtotime($sched));
}

?>
<html>
  <head>
    <title>Print</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?php echo $baseurl ?>template/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo $baseurl ?>template/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo $baseurl ?>template/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo $baseurl ?>template/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo $baseurl ?>template/dist/css/skins/_all-skins.min.css">
    <!-- Pace style -->
    <link rel="stylesheet" href="<?php echo $baseurl ?>template/plugins/pace/pace.min.css">
      <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo $baseurl ?>template/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

      <!-- fullCalendar -->
    <link rel="stylesheet" href="<?php echo $baseurl; ?>template/bower_components/fullcalendar/dist/fullcalendar.min.css">
    <link rel="stylesheet" href="<?php echo $baseurl; ?>template/bower_components/fullcalendar/dist/fullcalendar.print.min.css" media="print">

    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  </head>
  <body>
    
    <center>
      <img src="http://localhost/ovms/logo.jpg" width="100px" ><br>
      <b style="text-transform: uppercase;">Bath & Bark Grooming and Veterinary Services</b>
      <p>
        Bauan-Batangas Road<br>
        Poblacion, San Pascual, Philippines<br>
        Contact No.: 09178827552
      </p>
    </center>
    <div class="container">
      <div class="row">
        <div class="col-xs-12" style="border:2px solid grey ">
          <div class="row">
            <div class="col-xs-6">
              <div class="form-group">
                <h3>Appointment Details</h3>
                <div class="form-group">
                  <label>Booking No.:</label>
                  <p><?= $id; ?></p>
                </div>
                <div class="form-group">
                  <label>Appointment Date:</label>
                  <p><?= $sched; ?></p>
                </div>
                <div class="form-group">
                  <label>Attending Veterinarian:</label>
                  <p><?= 'Dr. '.$dbef.' '.$dbel; ?></p>
                </div>
              </div>
            </div>


            <div class="col-xs-6">
              <div class="form-group">
                <h3>Client Details</h3>
                <div class="form-group">
                  <label>Fullname:</label>
                  <p><?= $dbcg.' '.$dbcf.' '.$dbcl; ?></p>
                </div>
                <div class="form-group">
                  <label>Pets for checkup:</label>
                  <?php 

                  if(isset($_GET['id'])){
                    $sql = "SELECT p.name FROM tbl_pet AS p INNER JOIN tbl_appointment_pet AS ap ON p.id = ap.pet_id WHERE ap.appointment_id = ?";
                    $qry = $connection->prepare($sql);
                    $qry->bind_param("i",$_GET['id']);
                    $qry->execute();
                    $qry->bind_result($dbpn);
                    $qry->store_result();
                    while($qry->fetch ()){  
                      echo "<p>$dbpn</p>";

                    }

                  }

                  ?>

                </div>
              
              </div>
            </div>
          </div>

          
        </div>
        
      </div>
    </div>
  </body>
</html>