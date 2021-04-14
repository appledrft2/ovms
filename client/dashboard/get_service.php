<?php 
if(isset($_POST['serviceid'])){

	include('../../includes/autoload.php');
  $serviceid = $_POST['serviceid'];
  $sql = "SELECT price FROM tbl_service WHERE id = ?";
  $qry = $connection->prepare($sql);
  $qry->bind_param("i",$serviceid);
  $qry->execute();
  $qry->bind_result($dbp);
  $qry->store_result();
  $qry->fetch();
  echo json_encode($dbp);
}
?>