<?php 
if(isset($_POST['appid'])){
	include('../../includes/autoload.php');
  $appid = $_POST['appid'];
  $sql = "SELECT app.id,c.firstname,c.lastname,e.firstname,e.lastname FROM tbl_appointment as app INNER JOIN tbl_client as c ON app.client_id = c.id INNER JOIN tbl_employee as e ON app.veterinarian_id = e.id WHERE app.id = ?";
  $qry = $connection->prepare($sql);
  $qry->bind_param("i",$appid);
  $qry->execute();
  $qry->bind_result($id,$dbf,$dbl,$dbef,$dbel);
  $qry->store_result();
  while($qry->fetch()){

    echo "<input type='text' value='".$dbf." ".$dbl."' class='form-control' disabled>";
    echo "<label>Veterinarian:</label>";
    echo "<input type='text' value='Dr. ".$dbef." ".$dbel."' class='form-control' disabled>";
  }
}
?>