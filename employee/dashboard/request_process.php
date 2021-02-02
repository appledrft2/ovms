<?php 
if(isset($_POST['status'])){
	include('../../includes/autoload.php');
  $status = $_POST['status'];
  $date = $_POST['date'];
  $appid = $_POST['appid'];

	$sql = "UPDATE tbl_appointment SET status = ?,appointment_date = ? WHERE id = ?";
  $qry = $connection->prepare($sql);
  $qry->bind_param("ssi",$status,$date,$appid);

  if($qry->execute()) {
    echo 'success';
  }else{
    echo 'error';
  }

}

?>