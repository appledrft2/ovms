<?php 
session_start();
include('../../../includes/autoload.php');
if(isset($_SESSION['dbu'])){ 
  if($_SESSION['dbc'] != false){
      header("location:".$baseurl."client/dashboard");
  }else{
  	if(isset($_GET['id'])){

      $sql = "SELECT s.schedule_date,v.firstname,v.lastname FROM tbl_schedule AS s INNER JOIN tbl_employee AS v ON v.id = s.veterinarian_id WHERE s.id = ?";
      $qry = $connection->prepare($sql);
      $qry->bind_param('i',$_GET['id']);
      $qry->execute();
      $qry->bind_result($sched,$dbf,$dbl);
      $qry->store_result();
      $qry->fetch ();

      $activity = "Deleted Veterinarian: ".$dbf." ".$dbl." Schedule Date: ".$sched;
      $sqlx = "INSERT INTO tbl_logs(employee_id,activity) VALUES(?,?)";
      $qryx = $connection->prepare($sqlx);
      $qryx->bind_param("is",$_SESSION['dbu'],$activity);
      $qryx->execute();

  		$sql = "DELETE FROM tbl_schedule WHERE id=?";
  		$qry = $connection->prepare ($sql);
  		$qry->bind_param("i",$_GET['id']);
  		if($qry->execute()){
  			header('location:index.php?status=deleted');
  		}
  	}
  }
}else{
  header('location:'.$baseurl.'');
} 


?>