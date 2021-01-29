<?php 

if(isset($_POST['vet_id'])){
	include('../../includes/autoload.php');
  $status = 'Pending';
  $type = 'Requested';
	$sql = "INSERT INTO tbl_appointment(client_id,veterinarian_id,status,type) VALUES(?,?,?,?)";
  $qry = $connection->prepare($sql);
  $qry->bind_param("iiss",$_POST['client_id'],$_POST['vet_id'],$status,$type);

  if($qry->execute()) {
    $last_id = mysqli_insert_id($connection);
    $i = 0;
    for($i=0;$i < count($_POST['pet_id']);$i++){
     $sql = "INSERT INTO tbl_appointment_pet(appointment_id,pet_id,service_id) VALUES(?,?,?)";
     $qry = $connection->prepare($sql);
     $qry->bind_param("iii",$last_id,$_POST['pet_id'][$i],$_POST['service_id'][$i]);
     if($qry->execute()){
      
     }
    
    }
    echo 'success';
  }else{
    echo 'error';
  }


}

?>