<?php 

if(isset($_GET['id'])){
	include('../../../includes/autoload.php');
	$sql = "DELETE FROM tbl_employee WHERE id=?";
	$qry = $connection->prepare ($sql);
	$qry->bind_param("i",$_GET['id']);
	if($qry->execute()){
		header('location:index.php?status=deleted');
	}
}

?>