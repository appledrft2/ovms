<?php 
if(isset($_POST['appid'])){
	include('../../includes/autoload.php');
  $appid = $_POST['appid'];
  $sql = "SELECT ap.id,p.name,s.name,s.price FROM tbl_appointment_pet as ap INNER JOIN tbl_pet as p ON ap.pet_id = p.id INNER JOIN tbl_service AS s ON ap.service_id = s.id  WHERE ap.appointment_id = ?";
  $qry = $connection->prepare($sql);
  $qry->bind_param("i",$appid);
  $qry->execute();
  $qry->bind_result($id,$dbpn,$dbsn,$dbsp);
  $qry->store_result();
  while($qry->fetch()){
    
    echo "<div class='col-md-6'><input type='text' value='".$dbpn."' class='form-control' disabled></div>";
    echo "<div class='col-md-6'><input type='text' value='".$dbsn." (Php ".$dbsp.")' class='form-control' disabled></div>";
    
  }
}
?>