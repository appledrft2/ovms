<?php 
session_start();
include('../../../includes/autoload.php');
if(isset($_SESSION['dbu'])){ 
  if($_SESSION['dbc'] != false){
      header("location:".$baseurl."client/dashboard");
  }else{
  	if(isset($_GET['id'])){

      $sql = "DELETE FROM tbl_user WHERE user_id=?";
      $qry = $connection->prepare ($sql);
      $qry->bind_param("i",$_GET['id']);
      $qry->execute();

  		$sql = "DELETE FROM tbl_employee WHERE id=?";
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