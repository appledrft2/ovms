<?php 
session_start();
include('../../includes/autoload.php');
if(isset($_SESSION['dbu'])){ 
  if($_SESSION['dbc'] != true){
      header("location:".$baseurl."employees/dashboard");
  }else{
  	if(isset($_GET['id'])){
      $tr = 'true';
  		$sql = "UPDATE tbl_appointment SET iscancelled = ? WHERE id=?";
  		$qry = $connection->prepare ($sql);
  		$qry->bind_param("si",$tr,$_GET['id']);
  		if($qry->execute()){
  			header('location:index.php?status=cancelled');
  		}
  	}
  }
}else{
  header('location:'.$baseurl.'');
} 


?>