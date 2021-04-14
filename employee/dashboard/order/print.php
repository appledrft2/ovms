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
	  <h3>LIST OF COMPLETED ORDERS</h3>
	  <b><?php echo 'From '.date_format($from,'F d, Y').' To '.date_format($to,'F d, Y'); ?></b>
	</center>
	
	<table id="table1" width="100%" border="1" class="table table-bordered">
	  <thead style="color:black;">
	    <tr>
	      <th>Order Code</th>
	      <th>Client Name</th>
	      <th>Total</th>	
	      <th>Date Processed</th>
	     
	    </tr>
	  </thead>
	  <tbody>
	    <?php 
	      $total = 0;
	      $sql = "SELECT o.order_code,c.firstname,c.middlename,c.lastname,o.total,o.timestamp FROM tbl_order AS o INNER JOIN tbl_client AS c ON c.id = o.client_id WHERE o.status = 'Completed' AND o.timestamp BETWEEN ? AND ? ORDER BY o.timestamp ASC";
	      $qry = $connection->prepare($sql);
	      $qry->bind_param("ss",$_POST['dfrom'],$_POST['dto']);
	      $qry->execute();
	      $qry->bind_result($dboc,$dbfn,$dbmn,$dbln, $dbt, $dbtimestamp);
	      $qry->store_result();
	      while($qry->fetch ()) {
	      	$total = $total + $dbt;
	        echo"<tr>";
	        echo"<td style='text-align: center;'>";
	        echo $dboc;
	        echo"</td>";
	        echo"<td style='text-align: center;'>";
	        echo $dbfn.' '.$dbmn.' '.$dbln;
	        echo"</td>";
	        echo"<td style='text-align: right;'>&#8369;";
	        echo number_format($dbt,2);
	        echo"</td>";
	        echo"<td style='text-align: right;'>";
	        echo $dbtimestamp;
	        echo"</td>";
	 
	        echo"</tr>";
	      }



	    ?>
	  </tbody>
	  <tfoot>
	  	<?php 

	  	if($total == 0){
	  		echo '<tr><td colspan="3" style="text-align:center;	">No Records Available</td></tr>';
	  	}else{

	  	 ?>
	  	<tr><td></td><td></td><td style='text-align: right;'><b>Total Amount: </b>&#8369;<?php echo number_format($total,2); ?></td><td></td></tr>
	  <?php } ?>
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