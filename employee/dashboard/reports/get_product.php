<?php 
if(isset($_POST['prodid'])){

	include('../../../includes/autoload.php');
  $prodid = $_POST['prodid'];
  $sql = "SELECT id,category,unit,selling,quantity FROM tbl_product WHERE id = ?";
  $qry = $connection->prepare($sql);
  $qry->bind_param("i",$prodid);
  $qry->execute();
  $qry->bind_result($dbid,$dbcat,$dbunit,$dbprice,$dbqty);
  $qry->store_result();
  $qry->fetch();
  $data = array($dbid,$dbcat,$dbunit,$dbprice,$dbqty);
  echo json_encode($data);
}
?>