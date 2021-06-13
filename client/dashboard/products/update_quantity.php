<?php 

if(isset($_POST['changeQuantity'])){
  include('../../../includes/autoload.php');
  $quantity = 0;
  if($_POST['changeQuantity'] <= 0){
    $quantity = 1;
  }else{
    $quantity = $_POST['changeQuantity'];
  }
  $sql = "UPDATE tbl_client_cart SET quantity=? WHERE id=?";
  $qry = $connection->prepare($sql);
  $qry->bind_param("si",$quantity,$_POST['id']);
  if($qry->execute()) {
        echo '<meta http-equiv="refresh" content="0; URL=cart.php">';
  }

}
 
?>