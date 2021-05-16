<?php 
session_start();
include('../../../includes/autoload.php');
if(isset($_SESSION['dbu'])){ 
  if($_SESSION['dbc'] != false){
      header("location:".$baseurl."client/dashboard");
  }else{
  	if(isset($_GET['id'])){

      $sql = "SELECT name FROM tbl_service WHERE id = ?";
      $qry = $connection->prepare($sql);
      $qry->bind_param('i',$_GET['id']);
      $qry->execute();
      $qry->bind_result($dbn);
      $qry->store_result();
      $qry->fetch ();

      $activity = "Deleted Service: ".$dbn;
      $sqlx = "INSERT INTO tbl_logs(employee_id,activity) VALUES(?,?)";
      $qryx = $connection->prepare($sqlx);
      $qryx->bind_param("is",$_SESSION['dbu'],$activity);
      $qryx->execute();

  		$sql = "DELETE FROM tbl_service WHERE id=?";
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