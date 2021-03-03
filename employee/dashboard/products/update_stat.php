<?php 

if(isset($_POST['chngstatus'])){
  include('../../../includes/autoload.php');
  $sql = "UPDATE tbl_product SET status=? WHERE id=?";
  $qry = $connection->prepare($sql);
  $qry->bind_param("si",$_POST['chngstatus'],$_POST['id']);
  if($qry->execute()) {
        echo '<meta http-equiv="refresh" content="0; URL=index.php">';
  }

}
 
?>