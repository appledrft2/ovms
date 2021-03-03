<?php 
if(isset($_POST['prodid'])){

	include('../../../includes/autoload.php');
  $prodid = $_POST['prodid'];
  $sql = "SELECT id,original,selling,quantity FROM tbl_product WHERE id = ?";
  $qry = $connection->prepare($sql);
  $qry->bind_param("i",$prodid);
  $qry->execute();
  $qry->bind_result($dbid,$dboriginal,$dbselling,$dbqty);
  $qry->store_result();
  $qry->fetch();
  $data = array($dbid, $dboriginal, $dbselling,$dbqty);
  echo json_encode($data);
}
?>