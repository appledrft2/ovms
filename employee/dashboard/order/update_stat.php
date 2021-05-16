<?php 
session_start();

if(isset($_POST['chngstatus'])){
  include('../../../includes/autoload.php');
  if($_POST['chngstatus'] == 'Completed'){
    $subtract = 0;
    $sql = "SELECT cc.product_id,cc.quantity,pr.quantity FROM tbl_client_cart AS cc INNER JOIN tbl_product AS pr ON pr.id = cc.product_id WHERE order_code = ?";
    $qry = $connection->prepare($sql);
    $qry->bind_param("s",$_POST['oc']);
    $qry->execute();
    $qry->bind_result($dbpid,$qty,$prqty);
    $qry->store_result();
    while($qry->fetch()){
      $subtract = $prqty - $qty;

      $sql3 = "UPDATE tbl_product SET quantity=? WHERE id=?";
      $qry3 = $connection->prepare($sql3);
      $qry3->bind_param("si",$subtract,$dbpid);
      $qry3->execute();
    }

    $sql4 = "UPDATE tbl_order SET status=? WHERE id=?";
    $qry4 = $connection->prepare($sql4);
    $qry4->bind_param("si",$_POST['chngstatus'],$_POST['id']);
    if($qry4->execute()) {
          echo '<meta http-equiv="refresh" content="0; URL=index.php">';
    }

  	
  }else{
  	$sql = "UPDATE tbl_order SET status=? WHERE id=?";
  	$qry = $connection->prepare($sql);
  	$qry->bind_param("si",$_POST['chngstatus'],$_POST['id']);
  	if($qry->execute()) {
  	      echo '<meta http-equiv="refresh" content="0; URL=index.php">';
  	}
  }


  $activity = "Order with Order Code: ".$_POST['oc']." is set to ".$_POST['chngstatus'];
  $sqlx = "INSERT INTO tbl_logs(employee_id,activity) VALUES(?,?)";
  $qryx = $connection->prepare($sqlx);
  $qryx->bind_param("is",$_SESSION['dbu'],$activity);
  $qryx->execute();

}
 
?>