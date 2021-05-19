<?php 

if(isset($_POST['chngstatus'])){
  include('../../../includes/autoload.php');
  $sql = "UPDATE tbl_client SET status=? WHERE id=?";
  $qry = $connection->prepare($sql);
  $qry->bind_param("si",$_POST['chngstatus'],$_POST['id']);
  if($qry->execute()) {

  	$sql2 = "UPDATE tbl_user SET status=? WHERE user_id=?";
  	$qry2 = $connection->prepare($sql2);
  	$qry2->bind_param("si",$_POST['chngstatus'],$_POST['id']);
  	$qry2->execute();

        echo '<meta http-equiv="refresh" content="0; URL=index.php">';
  }

}
 
?>