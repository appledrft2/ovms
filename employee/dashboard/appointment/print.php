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

$from = date_create($_POST['dfrom']);
$to = date_create($_POST['dto']);

?>
<!DOCTYPE html>
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
  <link rel="icon" type="image/png" href="<?php echo $baseurl ?>/logo.jpg"/>
</head>
<body>
	<center>
	  <img src="http://localhost/ovms/logo.jpg" width="100px" style="border:1px solid black"><br>
	  <b style="text-transform: uppercase;">Bath & Bark Grooming and Veterinary Services</b>
	  <p>
	    Bauan-Batangas Road<br>
	    Poblacion, San Pascual, Philippines<br>
	    Contact No.: 09178827552
	  </p>
	  <h3>LIST OF COMPLETED APPOINTMENTS</h3>
	  <b><?php echo 'From '.date_format($from,'F d, Y').' To '.date_format($to,'F d, Y'); ?></b>
	</center>
	
	<table id="table1" width="100%" border="1" class="table table-bordered">
	  <thead style="color:black;">
	      <tr>
	        <th>Client</th>
	        <th>Type</th>
	        <th>Veterinarian</th>
	        <th>Date of Appointment</th>
	        <th>Status</th>
	        <th>Total</th>

	      </tr>
	    </thead>
	    <tbody>
	      <?php 
	      $total1 = 0;
	      $sql = "SELECT ap.id,cl.firstname,cl.middlename,cl.lastname,ap.type,ap.appointment_date,ap.status,ap.timestamp,em.firstname,em.middlename,em.lastname,ap.total FROM tbl_appointment as ap INNER JOIN tbl_client as cl ON ap.client_id = cl.id INNER JOIN tbl_employee as em ON ap.veterinarian_id = em.id WHERE ap.status = 'Completed' ORDER BY ap.appointment_date ASC";
	      $qry = $connection->prepare($sql);
	      $qry->execute();
	      $qry->bind_result($id,$dbf,$dbm,$dbl,$dbt,$dba,$dbs,$dbtimestamp,$dbf2,$dbm2,$dbl2,$dbtotal2);
	      $qry->store_result();
	      while($qry->fetch ()) {
	      	$total1 = $total1 + $dbtotal2;
	        $dba = date_create($dba);
	          echo"<tr>";
	          echo"<td>";
	          echo $dbf." ".$dbm." ".$dbl;
	          echo"</td>"; 
	          echo"<td>";
	          echo $dbt;
	          echo"</td>";
	          echo"<td>";
	          echo "Dr. ".$dbf2." ".$dbm2[0].". ".$dbl2;
	          echo"</td>";  
	          echo"<td class='text-center'>";
	          echo date_format($dba,'M d,Y');
	          echo"</td>";  
	          echo"<td>";
	          echo $dbs;
	          echo"</td>";
	          echo"<td class='text-right'>";
	          echo '&#8369; '.number_format($dbtotal2,2);
	          echo"</td>";
	          

	          echo"</tr>";   
	        }
	      ?>
	    </tbody>
	  	<tfoot>
	  		<tr>
	  			<td></td>
	  			<td></td>
	  			<td></td>
	  			<td></td>
	  			<td class="text-right"><b>Total:</b></td>
	  			<td><?php echo '&#8369; '.number_format($total1,2); ?></td>
	  		</tr>
	  	</tfoot>
	</table>
	
</body>
</html>
<?php if(!isset($_POST['dfrom']) || !isset($_POST['dto'])){
	echo '<meta http-equiv="refresh" content="0; URL=index.php">';
}else{

?>
<script type="text/javascript">
	window.onload = function() {
	    window.print();

	}
</script>

<?php echo '<meta http-equiv="refresh" content="0; URL=index.php">'; } ?>